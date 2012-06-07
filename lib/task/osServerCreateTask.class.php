<?php

class osServerCreateTask extends osBaseTask
{
  protected function configure()
  {
    parent::configure();

    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('name', sfCommandArgument::REQUIRED, 'The server name'),
      new sfCommandArgument('image', sfCommandArgument::REQUIRED, 'Flavor Id'),
      new sfCommandArgument('flavor', sfCommandArgument::REQUIRED, 'Image Id'),
    ));

    // // add your own options here
    $this->addOptions(array(
      //new sfCommandOption('tenant-id', 'i', sfCommandOption::PARAMETER_OPTIONAL, 'Tenand id'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'server-create';
    $this->briefDescription = 'openstack - create server';
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
    var_export($c->call(new rtOpenStackCommandServerCreate($arguments)));
    echo "\n";
  }
}
