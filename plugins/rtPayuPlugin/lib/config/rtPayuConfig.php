<?php
class rtPayuConfig extends sfParameterHolder
{
  const FILE_NAME = 'config/payu.yml';

  public function getOption($name) {
    $curr = $this->get('current');
    $pos = $this->get('pos');
    return $pos[$curr][$name];
  }

  public function getPayTypeUrl()
  {
    $url = $this->getOption('url');
    $pos = $this->getOption('pos_id');
    $enc = $this->getOption('encoding');
    $sig = substr($this->getOption('sign_key'), 0, 2);
    return sprintf('%s/paygw/%s/js/%s/%s/paytype.js', $url, $enc, $pos, $sig);
  }

  public function getPaymentUrl()
  {
    $url = $this->getOption('url');
    $enc = $this->getOption('encoding');
    return sprintf('%s/paygw/%s/NewPayment', $url, $enc);
  }

  public function getPosOption($pos_id, $name)
  {
    foreach($this->get('pos') as $pos)
    {
      if($pos['pos_id'] == $pos_id) return $pos[$name];
    }
    return null;
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
