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
      new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_OPTIONAL, 'Tenant name'),
      new sfCommandOption('tenant-id', 'i', sfCommandOption::PARAMETER_OPTIONAL, 'Tenand id'),
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
    $params = array(
      'user' => $options['user'], 
      'pass' => $options['pass'], 
      'tenant-name' => $options['tenant-name'],
      'tenant-id' => $options['tenant-id'],
    );
    $c = new rtOpenStackClient();
    $c->call(new rtOpenStackCommandAuth($params));
    var_export($c->call(new rtOpenStackCommandServersDetail()));
    echo "\n";
  }
}
