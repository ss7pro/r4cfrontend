<?php

class osClientCreateTask extends osBaseTask
{
  protected function configure()
  {
    parent::configure();

    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('username', sfCommandArgument::REQUIRED, 'User Name'),
      new sfCommandArgument('password', sfCommandArgument::REQUIRED, 'User Password'),
    ));

    // add your own options here
    $this->addOptions(array(
      //new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'client-create';
    $this->briefDescription = 'openstack - create client';
    $this->detailedDescription = <<<EOF
The [os:client-create|INFO] task create openstack client.
Call it with:

  [php symfony os:client-create... |INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $config = rtOpenStackConfig::getConfiguration('admin');
    $token = $config['auth_token'];
    $c =new rtOpenStackCommandClientCreate(array(
      'user' => $arguments['username'], 
      'pass' => $arguments['password'],
      'auth-token' => $token
    ));
    $r = $c->execute();
    print_r($r);

    echo "\n";
  }
}

