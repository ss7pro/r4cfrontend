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
      new sfCommandOption('env',         null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection',  null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      new sfCommandOption('user',         'u', sfCommandOption::PARAMETER_REQUIRED, 'User name'),
      new sfCommandOption('pass',         'p', sfCommandOption::PARAMETER_REQUIRED, 'Password'),
      new sfCommandOption('tenant-name',  'n', sfCommandOption::PARAMETER_OPTIONAL, 'Tenant name'),
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

    if(!isset($options['tenant-name'])) $options['tenant-name'] = 'fred';
    if(!isset($options['user'])) $options['user'] = 'fred';
    if(!isset($options['pass'])) $options['pass'] = 'Abrakadabra.2';

    $this->exec($arguments, $options);
  }

  protected function auth(rtOpenStackClient $client, $options)
  {
    $params = array(
      'user' => $options['user'], 
      'pass' => $options['pass'], 
      'tenant-name' => $options['tenant-name'],
    );
    $client->call(new rtOpenStackCommandAuth($params));
  }
}
