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
      new sfCommandOption('tenant-id', 'i', sfCommandOption::PARAMETER_OPTIONAL, 'Auth Tenand id'),
      new sfCommandOption('tenant-index', 'k', sfCommandOption::PARAMETER_OPTIONAL, 'Auth Tenand index', 0),
    ));

    $this->namespace        = 'os';
    $this->name             = 'auth';
    $this->briefDescription = 'openstack - authentication test';
    $this->detailedDescription = <<<EOF
The [os:auth|INFO] test openstack authentication.
Call it with:

  [php symfony os:auth -u user -p pass [-n tenant-name] [-i tenant-id] [-k tenant-index]|INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $session = rtOpenStackClient::factory()->getSession();
    $p = array(
      'user' => $options['user'], 
      'pass' => $options['pass'], 
      'tenant-name' => $options['tenant-name'],
    );
    if($options['tenant-id']) {
      $p['tenant-id'] = $options['tenant-id'];
    } else if($options['tenant-name']) {
      $p['tenant-name'] = $options['tenant-name'];
    }
    $c = new rtOpenStackCommandAuth($p);
    $r = $c->execute();
    //print_r($r);
    //echo "\n";

    if(!$options['tenant-id'] && !$options['tenant-name']) 
    {
      $c = new rtOpenStackCommandTenant();
      $tenants = $c->execute();
      //print_r($tenants);
      //echo "\n";
      $tenantId = $tenants['tenants'][$options['tenant-index']]['id'];

      $c = new rtOpenStackCommandToken(array(
        'token' => $session->getTokenId(),
        'tenant-id' => $tenantId,
      ));
      $r = $c->execute();
      //print_r($r);
      //echo "\n";
    }

    print_r($session->getEndpoints());
    echo "\n";
  }
}
