<?php

class osServerListTask extends osBaseTask
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
    $this->name             = 'server-list';
    $this->briefDescription = 'openstack - list servers';
    $this->detailedDescription = <<<EOF
The [os:test|INFO] task get servers details.
Call it with:

  [php symfony os:servers-detail -u user -p pass -n tenant-name|INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $this->auth($options);
    $c = new rtOpenStackCommandServers();
    print_r($r->execute());
    echo "\n";
  }
}
