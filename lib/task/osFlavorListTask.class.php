<?php

class osFlavorListTask extends osBaseTask
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
      //new sfCommandOption('tenant-name', 'n', sfCommandOption::PARAMETER_REQUIRED, 'The connection name'),
    ));

    $this->namespace        = 'os';
    $this->name             = 'flavor-list';
    $this->briefDescription = 'openstack - custom test api';
    $this->detailedDescription = <<<EOF
The [os:test|INFO] task test openstack api.
Call it with:

  [php symfony os:test... |INFO]
EOF;
  }

  protected function exec($arguments = array(), $options = array())
  {
    $c = new rtOpenStackClient();
    $this->auth($c, $options);

    $columns = array('id', 'name', 'vcpus', 'ram', 'disk', 'swap');
    $p = new SimpleCliPrinter($columns);
    $result = $c->call(new rtOpenStackCommandFlavorList());
    //var_dump($result['flavors']);
    $p->render($result['flavors']);
    echo "\n";
  }
}

