<?php
class rtOpenStackCommandServers extends rtOpenStackCommand
{
  private $tenant_id;

  public function __construct($tenant_id = null)
  {
    $this->tenanat_id = $tenant_id;
  }

  /**
   * @param rtOpenStackClient $client
   */
  public function configure(rtOpenStackClient $client)
  {
    if (!$this->tenant_id) {
      $this->tenant_id = $client->getSession()->getTenantId();
    }
    $this->setPreset('server');
    $this->setMethod(sfRequest::GET);
    $this->setUri(sprintf('/v2/%s/servers', $this->tenant_id));
  }
}
