<?php

class osTestTask extends osBaseTask
{
  protected function configure()
  {
    parent::configure();

    // add your own arguments here
    $this->addArguments(array(
      //new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    ));

    // add your own options here
    $this->addOptions(array(
      //new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'test';
    $this->briefDescription = 'openstack - custom test api';
    $this->detailedDescription = <<<EOF
The [os:test|INFO] task test openstack api.
Call it with:

  [php symfony os:test... |INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $c = new rtOpenStackClient();
    $this->auth($c, $options);
    //print_r($c->call(new rtOpenStackCommandCheckClient(array(
    //  'client' => 'fred'
    //))));
    //print_r($c->call(new rtOpenStackCommandClientCreate(array(
    //  'user' => 'romek-1@email.pl', 
    //  'pass' => 'romek'
    //))));
    //print_r($c->call(new rtOpenStackCommandFlavorList()));
    print_r($c->call(new rtOpenStackCommandImageList()));

    echo "\n";
  }
}

