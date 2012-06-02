<?php
class rtOpenStackCommandServersDetail extends rtOpenStackCommand
{
  public function __construct($tenant_id)
  {
    $this->setName('server');
    $this->setMethod(sfRequest::GET);
    $this->setUri(sprintf('/v2/%s/servers/detail', $tenant_id));
    parent::__construct();
  }
}
