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
    $this->auth($options);
    $columns = array('id', 'name', 'vcpus', 'ram', 'disk', 'swap');
    $p = new SimpleCliPrinter($columns);
    $c = new rtOpenStackCommandFlavorList();
    $r = $c->execute();
    $p->render($r['flavors']);
    echo "\n";
  }
}

