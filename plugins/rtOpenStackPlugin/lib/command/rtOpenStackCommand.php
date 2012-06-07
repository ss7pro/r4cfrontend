<?php
abstract class rtOpenStackCommand
{
  private
    $_preset,
    $_method,
    $_uri,
    $_params = array(),
    $_headers = array(),
    $_options = array(),
    $_require = array();

  public final function __construct(array $options = array())
  {
    $this->_options = $options;
  }

  abstract public function configure(rtOpenStackClient $client);

  public function get($name, $default = null)
  {
    return isset($this->_options[$name]) ? $this->_options[$name] : $default;
  }

  public function set($name, $value)
  {
    $this->_options[$name] = $value;
    return $this;
  }

  public function addRequired($name)
  {
    $this->_require[$name] = true;
  }

  public function getUri()
  {
    return $this->_uri;
  }

  public function setUri($uri)
  {
    $this->_uri = $uri;
  }

  public function getMethod()
  {
    return $this->_method;
  }

  public function setMethod($method)
  {
    $this->_method = $method;
  }

  public function getPreset()
  {
    return $this->_preset;
  }

  public function setPreset($preset)
  {
    $this->_preset = $preset;
  }

  public function getParams() 
  {
    return $this->_params;
  }

  public function setParams(array $params)
  {
    $this->_params = $params;
  }

  public function getHeaders()
  {
    return $this->_headers;
  }

  public function setHeader($name, $value)
  {
    $this->_headers[$name] = $value;
  }

  public function setHeaders(array $headers)
  {
    $this->_headers = $headers;
  }

  public function generateUrl()
  {
    $config = rtOpenStackConfig::instance($this->getPreset());
    return sprintf('http://%s:%d%s', $config->getHost(), $config->getPort(), $this->getUri());
  }

  public function execute(rtOpenStackClient $client = null)
  {
    $client = $client ? $client : rtOpenStackClient::factory();

    $this->configure($client);

    $diff = array_diff(array_keys($this->_require), array_keys(array_filter($this->_options)));
    if(!empty($diff)) {
      throw new InvalidArgumentException("Required options not set: " . implode(', ', $diff));
    }

    $client->execute($this->generateUrl(), $this->getMethod(), $this->getParams(), $this->getHeaders());

    return $this->handleResponse($client);
  }

  public function handleResponse(rtOpenStackClient $client)
  { 
    return $client->getResponse();
  }
}
