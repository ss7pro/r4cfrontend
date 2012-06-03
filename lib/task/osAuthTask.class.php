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
      new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
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
    $c = new rtOpenStackClient();
    var_export($c->call(new rtOpenStackCommandAuth($options['user'], $options['pass'], $options['tenant-name'])));
    echo "\n";
  }
}
