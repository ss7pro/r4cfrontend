<?php
class rtOpenStackCommandClientTopup extends rtOpenStackCommand
{
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('tenant_id');
    $this->addRequired('amount');
    $this->addRequired('reference');

    $this->setPreset('topup');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/client/topup');
    $this->setParams(array(
      'client' => array(
        'tenant-id' => $this->get('tenant_id'),
      ),
      'topup' => array(
        'amount'    => round(floatval($this->get('amount')), 2),
        'reference' => $this->get('reference'),
      ),
    ));
  }
}
