<?php
class rtOpenStackCommandImageList extends rtOpenStackCommand
{
  public function configure(rtOpenStackClient $client)
  {
    $this->setPreset('server');
    $this->setMethod(sfRequest::GET);
    $this->setUri(sprintf('/v2/%s/images/detail', $this->get('tenant_id', $client->getSession()->getTokenTenantId())));
  }
}
