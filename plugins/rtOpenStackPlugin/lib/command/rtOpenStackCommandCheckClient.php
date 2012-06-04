<?php
class rtOpenStackCommandCheckClient extends rtOpenStackCommand
{
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('client');

    $this->setPreset('client');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/check/client');
    $this->setParams(array(
      'client' => array(
        'name' => $this->get('client')
      )
    ));
  }
}
