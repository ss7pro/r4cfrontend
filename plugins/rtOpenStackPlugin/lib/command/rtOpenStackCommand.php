<?php
abstract class rtOpenStackCommand
{
  private
    $name,
    $config,
    $method,
    $uri,
    $params = array(),
    $headers = array();

  public function __construct()
  {
    $config = sfConfig::get('app_openstack_plugin_servers', array());
    $name = $this->getName();
    if(!$name) throw new InvalidArgumentException('Config name is not set');
    if(!isset($config[$name])) throw new InvalidArgumentException('Config for "' . $name . '" is not defined');
    $this->config = $config[$name];
  }

  public function getUri()
  {
    return $this->uri;
  }

  public function setUri($uri)
  {
    $this->uri = $uri;
  }

  public function getMethod()
  {
    return $this->method;
  }

  public function setMethod($method)
  {
    $this->method = $method;
  }

  public function getName()
  {
    return $this->name;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getParams() 
  {
    return $this->params;
  }

  public function setParams(array $params)
  {
    $this->params = $params;
  }

  public function getHost()
  {
    return $this->config['host'];
  }
  
  public function getPort()
  {
    return $this->config['port'];
  }
    
  public function getHeaders()
  {
    return $this->headers;
  }

  public function setHeaders(array $headers)
  {
    $this->headers = $headers;
  }

  public function getUrl()
  {
    return sprintf('http://%s:%d%s', $this->getHost(), $this->getPort(), $this->getUri());
  }
  
  public function exec(rtOpenStackClient $client)
  {
    $client->exec($this->getUrl(), $this->getMethod(), $this->getParams(), $this->getHeaders());
    return $this->handleResponse($client);
  }

  public function handleResponse(rtOpenStackClient $client)
  { 
    return $client->getResponse();
  }
}
