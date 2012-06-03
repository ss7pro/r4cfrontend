<?php

class osServersDetailTask extends osBaseTask
{
  protected function configure()
  {
    parent::configure();

    // add your own arguments here
    $this->addArguments(array(
      //new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    ));

    // // add your own options here
    $this->addOptions(array(
      new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'servers-detail';
    $this->briefDescription = 'openstack - servers detail test';
    $this->detailedDescription = <<<EOF
The [os:test|INFO] task get servers details.
Call it with:

  [php symfony os:servers-detail -u user -p pass -n tenant-name|INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $c = new rtOpenStackClient();
    $c->call(new rtOpenStackCommandAuth($options['user'], $options['pass'], $options['tenant-name']));
    $tenant_id = $c->getSession()->getTokenTenantId();
    var_export($c->call(new rtOpenStackCommandServersDetail($tenant_id)));
    echo "\n";
  }
}
