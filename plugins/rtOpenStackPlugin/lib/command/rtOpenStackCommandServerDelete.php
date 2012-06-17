<?php
class rtOpenStackCommandServerDelete extends rtOpenStackCommand
{
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('id');

    $this->setPreset('server');
    $this->setMethod(sfRequest::DELETE);
    $this->setUri(sprintf('/v2/%s/servers/%s', $this->get('tenant_id', $client->getSession()->getTokenTenantId()), $this->get('id')));
  }
}

