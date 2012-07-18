<?php

class osClientTopupTask extends osBaseTask
{
  protected function configure()
  {
    parent::configure();

    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('tenant_id', sfCommandArgument::REQUIRED, 'Tenant id'),
      new sfCommandArgument('amount', sfCommandArgument::REQUIRED, 'amount'),
    ));

    $this->addOptions(array(
      //new sfCommandOption('tenant-id', 'i', sfCommandOption::PARAMETER_OPTIONAL, 'Auth Tenand id'),
      //new sfCommandOption('tenant-index', 'k', sfCommandOption::PARAMETER_OPTIONAL, 'Auth Tenand index', 0),
    ));

    $this->namespace        = 'os';
    $this->name             = 'client-topup';
    $this->briefDescription = 'openstack - client topup';
    $this->detailedDescription = <<<EOF
The [os:auth|INFO] test openstack client topup.
Call it with:

  [php symfony os:client-topup -u user -p pass [-n tenant-name] tenant_id amount|INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $this->auth('topup');

    $c = new rtOpenStackCommandClientTopup(array(
      'tenant_id' => $arguments['tenant_id'],
      'amount' => $arguments['amount'],
      'reference' => array('source' => 'r4cfrontend'),
    ));
    $r = $c->execute();

    print_r($r);
    echo "\n";
  }
}
