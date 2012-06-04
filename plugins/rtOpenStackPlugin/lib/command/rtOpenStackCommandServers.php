<?php
class rtOpenStackCommandServers extends rtOpenStackCommand
{
  /**
   * @param rtOpenStackClient $client
   */
  public function configure(rtOpenStackClient $client)
  {
    $this->setPreset('server');
    $this->setMethod(sfRequest::GET);
    $this->setUri(sprintf('/v2/%s/servers', $this->get('tenant_id', $client->getSession()->getTenantId())));
  }
}
