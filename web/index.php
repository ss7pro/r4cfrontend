<?php

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('main', 'dev', true);
//$configuration = ProjectConfiguration::getApplicationConfiguration('main', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
