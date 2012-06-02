<?php
class rtOpenStackCommandCheckClient extends rtOpenStackCommand
{
  public function __construct($client)
  {
    $this->setName('client');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/check/client');
    $this->setParams(array(
      'client' => array(
        'name' => $client
      )
    ));
    parent::__construct();
  }
}
