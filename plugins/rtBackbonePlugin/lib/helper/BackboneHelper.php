<?php
use_helper('jQuery');
_underscore_add_javascript();
_backbone_add_javascript();

function _underscore_add_javascript()
{
  $underscore_dir  = sfConfig::get('sf_backbone_web_dir', '/rtBackbonePlugin') . '/js/';
  $underscore_path = $underscore_dir . 'underscore-' . sfConfig::get('sf_underscore_version', '1.3.3');
  if(sfConfig::get('sf_underscore_compressed', false))
  {
    $underscore_path .= '-min';
  }
  $underscore_path .= '.js';
  sfContext::getInstance()->getResponse()->addJavascript($underscore_path, 'first');
}

function _backbone_add_javascript()
{
  $backbone_dir  = sfConfig::get('sf_backbone_web_dir', '/rtBackbonePlugin') . '/js/';
  $backbone_path = $backbone_dir . 'backbone-' . sfConfig::get('sf_backbone_version', '0.9.2');
  if(sfConfig::get('sf_backbone_compressed', false))
  {
    $backbone_path .= '-min';
  }
  $backbone_path .= '.js';
  sfContext::getInstance()->getResponse()->addJavascript($backbone_path, 'first');
  sfContext::getInstance()->getResponse()->addJavascript($backbone_dir . 'paginated_collection.js', 'first');
}
