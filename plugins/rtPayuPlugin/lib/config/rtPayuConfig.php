<?php
class rtPayuConfig extends sfParameterHolder
{
  const FILE_NAME = 'config/payu.yml';

  public function getOption($name, $pos_id = null) {
    $pos_id = $pos_id ? $pos_id : $this->get('current');
    $config = $this->get('pos');
    return $config[$pos_id][$name];
  }

  public function getPayTypeUrl($pos_id = null)
  {
    $url = $this->getOption('url', $pos_id);
    $pos = $this->getOption('pos_id', $pos_id);
    $enc = $this->getOption('encoding', $pos_id);
    $sig = substr($this->getOption('sign_key', $pos_id), 0, 2);
    return sprintf('%s/paygw/%s/js/%s/%s/paytype.js', $url, $enc, $pos, $sig);
  }

  public function getPaymentUrl($pos_id = null)
  {
    $url = $this->getOption('url', $pos_id);
    $enc = $this->getOption('encoding', $pos_id);
    return sprintf('%s/paygw/%s/NewPayment', $url, $enc);
  }

  public function getPaymentStatusUrl($pos_id = null)
  {
    $url = $this->getOption('url', $pos_id);
    $enc = $this->getOption('encoding', $pos_id);
    return sprintf('%s/paygw/%s/Payment/get/xml', $url, $enc);
  }

  public static function instance()
  {
    static $instance = null;
    if($instance === null) {
      $instance = new self();
      $instance->add(self::load());
    }
    return $instance;
  }

  public static function load()
  {
    static $config = null;
    if($config === null) {
      $config = include(sfContext::getInstance()->getConfigCache()->checkConfig(self::FILE_NAME));
      $config = sfYamlConfigHandler::flattenConfigurationWithEnvironment($config);
    }
    return $config;
  }

  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $r = $event->getSubject();
    $r->prependRoute('rt_payu_notify', new sfRoute(sfConfig::get('app_rt_payment_plugin_route_url', '/payment/notify'), array('module' => 'rtPayu', 'action' => 'notify'), array('sf_method' => 'POST')));
  }
}
