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
      new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
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
    $params = array(
      'user' => 'fred',
      'pass' => 'Abrakadabra.2',
      'tenant-name' => 'fred',
    );

    $c = new rtOpenStackClient();
    print_r($c->call(new rtOpenStackCommandAuth($params)));
    //$tenant_id = $c->getSession()->getTokenTenantId();
    //print_r($c->call(new rtOpenStackCommandServersDetail($tenant_id)));
    //print_r($c->call(new rtOpenStackCommandCheckClient('fred')));
    //print_r($c->call(new rtOpenStackCommandClientCreate('romek.1@email.pl', 'romek')));
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
