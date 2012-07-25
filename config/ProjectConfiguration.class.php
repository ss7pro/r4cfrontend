<?php

require_once '/opt/symfony-1.4.18/lib/autoload/sfCoreAutoload.class.php';
#require_once '/opt/symfony-1.4.17/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  const APP = 'main';
  const ENV = 'prod';

  public function setup()
  {
    $this->dispatcher->connect('component.method_not_found', array('ResponseContent', 'listenToComponentMethodNotFoundEvent'));

    $this->enablePlugins('sfPropelORMPlugin');
    $this->enablePlugins('sfGuardPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
    $this->enablePlugins('sfJqueryReloadedPlugin');
    $this->enablePlugins('sfWebBrowserPlugin');
    $this->enablePlugins('rtOpenStackPlugin');
    $this->enablePlugins('rtPayuPlugin');
    $this->enablePlugins('sfAdminDashPlugin');
  }
}
