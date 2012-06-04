<?php
class rtOpenStackCommandClientCreate extends rtOpenStackCommand
{
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('user');
    $this->addRequired('pass');

    $this->setPreset('client');
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
