<?php

class osAuthTask extends osBaseTask
{
  protected function configure()
  {
    parent::configure();

    // add your own arguments here
    $this->addArguments(array(
      //new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    ));

    $this->addOptions(array(
      new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_OPTIONAL, 'Tenant name'),
      new sfCommandOption('tenant-id', 'i', sfCommandOption::PARAMETER_OPTIONAL, 'Tenand id'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'auth';
    $this->briefDescription = 'openstack - authentication test';
    $this->detailedDescription = <<<EOF
The [os:auth|INFO] test openstack authentication.
Call it with:

  [php symfony os:auth -u user -p pass -n tenant-name|INFO]
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
    var_export($c->call(new rtOpenStackCommandAuth($params)));
    echo "\n";
  }
}
