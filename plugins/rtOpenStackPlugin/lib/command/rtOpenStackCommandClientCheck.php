<?php
class rtOpenStackCommandClientCheck extends rtOpenStackCommand
{
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('client');
    $this->addRequired('auth-token');

    $this->setPreset('client');
    $this->setHeader('X-Auth-Token', $this->get('auth-token'));
    $this->setMethod(sfRequest::POST);
    $this->setUri('/client/check');
    $this->setParams(array(
      'client' => array(
        'name' => $this->get('client')
      )
    ));
  }
}
