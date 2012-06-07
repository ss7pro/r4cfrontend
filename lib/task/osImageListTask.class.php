<?php

class osImageListTask extends osBaseTask
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
    $this->name             = 'image-list';
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


    $columns = array('id', 'name', 'status', 'progress', 'minRam', 'minDisk');
    $p = new SimpleCliPrinter($columns);

    $r = $c->call(new rtOpenStackCommandImageList());
    //var_dump($r['images']);
    $p->render($r['images']);
    echo "\n";
  }
}

