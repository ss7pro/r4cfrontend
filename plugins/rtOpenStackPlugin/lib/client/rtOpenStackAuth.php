<?php
class rtOpenStackAuth
{
  public static function checkPassword($username, $password, sfGuardUser $user)
  {
    $params = array(
      'user' => $username, 
      'pass' => $password, 
      'tenant-name' => $username,
    );
    $c = new rtOpenStackClient();
    try {
      $r = $c->call(new rtOpenStackCommandAuth($params));
      return $c->getResponseCode() == 200 && $c->getSession()->isAuthenticated();
    } catch(Exception $e) {
      //TODO: log error;
      return false;
    }
  }
}
