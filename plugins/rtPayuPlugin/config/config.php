<?php

if(in_array('rtPayu', sfConfig::get('sf_enabled_modules', array())))
{
  $this->dispatcher->connect('routing.load_configuration', array('rtPayuConfig', 'listenToRoutingLoadConfigurationEvent'));
}

