<?php

class osClientCheckTask extends osBaseTask
{
  protected function configure()
  {
    parent::configure();

    // add your own arguments here
    $this->addArguments(array(
      new sfCommandArgument('username', sfCommandArgument::REQUIRED, 'User Name'),
    ));

    // add your own options here
    $this->addOptions(array(
      //new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'client-check';
    $this->briefDescription = 'openstack - check client';
    $this->detailedDescription = <<<EOF
The [os:client-check|INFO] task check openstack client.
Call it with:

  [php symfony os:client-check... |INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $config = rtOpenStackConfig::getConfiguration('admin');
    $token = $config['auth_token'];
    $c =new rtOpenStackCommandClientCheck(array(
      'client' => $arguments['username'], 
      'auth-token' => $token
    ));
    $r = $c->execute();
    print_r($r);

    echo "\n";
  }
}

