<?php
class rtOpenStackCommandClientCreate extends rtOpenStackCommand
{
  public function __construct($username, $password)
  {
    $this->setPreset('client');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/client/add');
    $this->setParams(array(
      'client' => array(
        'name'     => $username,
        'password' => $password,
      )
    ));
  }
}
