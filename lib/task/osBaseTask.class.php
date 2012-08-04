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
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', ProjectConfiguration::APP),
      new sfCommandOption('env',         null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', ProjectConfiguration::ENV),
      new sfCommandOption('connection',  null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
      new sfCommandOption('user',         'u', sfCommandOption::PARAMETER_REQUIRED, 'Auth User Name'),
      new sfCommandOption('pass',         'p', sfCommandOption::PARAMETER_REQUIRED, 'Auth Password'),
      new sfCommandOption('tenant-name',  'n', sfCommandOption::PARAMETER_OPTIONAL, 'Auth Tenant Name'),
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

    try {
      $this->exec($arguments, $options);
    } catch(Exception $e) {
      echo get_class($e) . ': ' . $e->getMessage() . "\n";
      echo $e->getTraceAsString();
      throw $e;
    }
  }

  protected function auth($options = null, rtOpenStackClient $client = null)
  {
    $section = 'admin';
    if($options === null) {
      $options = array();
    } else if(is_string($options)) {
      $section = $options;
      $options = array();
    }

    $config = rtOpenStackConfig::getConfiguration($section);
    $params = array(
      'user'        => isset($options['user'])        ? $options['user']        : $config['user'], 
      'pass'        => isset($options['pass'])        ? $options['pass']        : $config['pass'], 
      'tenant-name' => isset($options['tenant-name']) ? $options['tenant-name'] : $config['tenant_name'],
    );

    $client = $client ? $client : rtOpenStackClient::factory();
    $c = new rtOpenStackCommandAuth($params);
    return $c->execute($client);
  }
}
