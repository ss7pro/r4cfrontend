<?php

class osServerListDetailTask extends osBaseTask
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
      //new sfCommandOption('tenant-id', 'i', sfCommandOption::PARAMETER_OPTIONAL, 'Tenand id'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'server-list-detail';
    $this->briefDescription = 'openstack - list servers with details';
    $this->detailedDescription = <<<EOF
The [os:test|INFO] task get servers details.
Call it with:

  [php symfony os:servers-detail -u user -p pass -n tenant-name|INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $c = new rtOpenStackClient();
    $this->auth($c, $options);
    var_export($c->call(new rtOpenStackCommandServersDetail()));
    echo "\n";
  }
}
