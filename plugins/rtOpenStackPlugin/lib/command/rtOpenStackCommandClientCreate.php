<?php
class rtOpenStackCommandClientCreate extends rtOpenStackCommand
{
  public function __construct($username, $password)
  {
    $this->setName('client');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/client/add');
    $this->setParams(array(
      'client' => array(
        'name'     => $username,
        'password' => $password,
      )
    ));
    parent::__construct();
  }
}
