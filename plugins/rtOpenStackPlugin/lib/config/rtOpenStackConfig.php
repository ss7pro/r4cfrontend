<?php
class rtOpenStackConfig
{
  private static $instance = array();

  private static $file = 'config/openstack.yml';

  private function __construct($options)
  {
    $this->options = $options;
  }

  public static function instance($preset)
  {
    if (!isset(self::$instance[$preset])) {

      $config = self::getConfiguration();
      $config = $config['presets'];

      if(!$preset) {
        throw new InvalidArgumentException('Config preset name is not set');
      }
      if (!isset($config[$preset])) {
        throw new InvalidArgumentException('Config for preset "' . $preset . '" is not defined');
      }
      self::$instance[$preset] = new self($config[$preset]);
    }
    return self::$instance[$preset];
  }

  public function getHost()
  {
    return $this->options['host'];
  }

  public function getPort()
  {
    return $this->options['port'];
  }

  public static function getConfiguration()
  {
    static $config = null;
    if($config === null) {
      $config = include(sfContext::getInstance()->getConfigCache()->checkConfig(self::$file));
      $config = sfYamlConfigHandler::flattenConfigurationWithEnvironment($config);
    }
    return $config;
  }
}
