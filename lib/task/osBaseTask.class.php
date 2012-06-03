<?php

abstract class osBaseTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'main'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      new sfCommandOption('user', 'u', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
      new sfCommandOption('pass', 'p', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'base';
    $this->briefDescription = 'openstack abstract task';
    $this->detailedDescription = <<<EOF
The [os:base|INFO] do nothing, this is openstack abstract task.
Call it with:
  [php symfony os:base|INFO]
EOF;
  }

  abstract protected function exec($arguments = array(), $options = array());

  protected function execute($arguments = array(), $options = array())
  {
    // initialize task
    sfContext::createInstance($this->configuration);
    $dbm = new sfDatabaseManager($this->configuration);
    $this->con = $dbm->getDatabase($options['connection'])->getConnection();
    $this->exec($arguments, $options);
  }
}
