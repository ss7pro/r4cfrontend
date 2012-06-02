<?php
class rtOpenStackCommandAuth extends rtOpenStackCommand
{
  public function __construct($username, $password, $tenant)
  {
    $this->setName('auth');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/v2.0/tokens');
    $this->setParams(array(
      'auth' => array(
        'passwordCredentials' => array(
          'username' => $username,
          'password' => $password,
        ),
        'tenantName' => $tenant
      ),
    ));
    parent::__construct();
  }

  public function handleResponse(rtOpenStackClient $client) { 
    $r = parent::handleResponse($client);
    if(isset($r['access'])) {
      $client->getSession()->setAccess($r['access']);
    }
    return $r;
  }
}

