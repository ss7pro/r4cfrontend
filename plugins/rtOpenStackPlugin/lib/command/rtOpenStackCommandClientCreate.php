<?php
class rtOpenStackCommandClientCreate extends rtOpenStackCommand
{
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('user');
    $this->addRequired('pass');
    $this->addRequired('auth-token');
    
    $this->setPreset('client');
    $this->setHeader('X-Auth-Token', $this->get('auth-token'));
    $this->setMethod(sfRequest::POST);
    $this->setUri('/client/add');
    $this->setParams(array(
      'client' => array(
        'name'     => $this->get('user'),
        'password' => $this->get('pass'),
      )
    ));
  }
}
