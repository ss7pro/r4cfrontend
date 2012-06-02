<?php

class osTestTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    // // add your own options here
    $this->addOptions(array(
       new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'main'),
       new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'test';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [os:test|INFO] task does things.
Call it with:

  [php symfony os:test|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $c = new rtOpenStackClient();
    print_r($c->call(new rtOpenStackCommandAuth('fred', 'Abrakadabra.2', 'fred')));
    //$tenant_id = $c->getSession()->getTokenTenantId();
    //print_r($c->call(new rtOpenStackCommandServersDetail($tenant_id)));
    //print_r($c->call(new rtOpenStackCommandCheckClient('fred')));
    print_r($c->call(new rtOpenStackCommandClientCreate('romek.1@email.pl', 'romek')));
    echo "\n";
  }
}

/*
class OpenStackCommandTenants extends OpenStackCommand
{
  public function __construct() {}
  public function getPort()   { return 8090; }
  public function getUri()    { return '/v2.0/tenants'; }
  public function getMethod() { return OpenStackClient::GET; }
  public function getParams() { return array(); }
}

class OpenStackCommandInfo extends OpenStackCommand
{
  public function __construct() {}
  public function getPort()   { return 8090; }
  public function getUri()    { return '/v1.1'; }
  public function getMethod() { return OpenStackClient::GET; }
  public function getParams() { return array(); }
}

class OpenStackCommandTokensEndpoints extends OpenStackCommand
{
  public function __construct($token) {
    $this->token = $token;
  }
  public function getUri()    { return '/v2.0/tokens/' . $this->token . '/endpoints'; }
  public function getMethod() { return OpenStackClient::GET; }
  public function getParams() { return array(); }
}

class OpenStackCommandVersions extends OpenStackCommand
{
  public function __construct() {}
  public function getPort()   { return 8090; }
  public function getUri()    { return '/'; }
  public function getMethod() { return OpenStackClient::GET; }
  public function getParams() { return array(); }
}
 */
