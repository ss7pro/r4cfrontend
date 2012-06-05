<?php
class rtOpenStackCommandServerCreate extends rtOpenStackCommand
{
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('name');
    $this->addRequired('flavor');
    $this->addRequired('image');

    $this->setPreset('server');
    $this->setMethod(sfRequest::POST);
    $this->setUri(sprintf('/v2/%s/servers', $this->get('tenant_id', $client->getSession()->getTokenTenantId())));
    $this->setParams(array(
      'server' => array(
        'name' => $this->get('name'),
        'imageRef' => $this->get('image'),
        'flavorRef' => $this->get('flavor'),
      )
    ));
  }
}

