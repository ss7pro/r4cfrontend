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
}
