<?php
class rtOpenStackClient
{
  private $browser = null;
  private $session = null;

  private $headers = array(
    'Content-Type' => 'application/json',
    'Accept'       => 'application/json'
  );

  public function __construct(rtOpenStackSession $session = null)
  {
    $this->setSession($session !== null ? $session : new rtOpenStackSession());
    $this->setBrowser(new sfWebBrowser());
  }

  private static $instance = array();

  public static function factory($name = 'default')
  {
    if(!isset(self::$instance[$name])) {
      $session = new rtOpenStackSession($name);
      self::$instance[$name] = new self($session);
    }
    return self::$instance[$name];
  }

  public function getBrowser()
  {
    return $this->browser;
  }

  public function setBrowser(sfWebBrowser $browser)
  {
    $this->browser = $browser;
    $this->browser->setUserAgent('ready4cloud-client');
    return $this;
  }

  public function getSession()
  {
    return $this->session;
  }

  public function setSession(rtOpenStackSession $session)
  {
    $this->session = $session;
    return $this;
  }

  public function call(rtOpenStackCommand $c)
  {
    return $c->execute($this);
  }

  public function execute($url, $method = self::GET, array $params = array(), array $headers = array())
  {
    if (empty($params)) {
      $params = '';
    } else if (in_array($method, array(sfRequest::GET, sfRequest::HEAD))) {
      $url .= ((false !== strpos($url, '?')) ? '&' : '?') . http_build_query($params, '', '&');
      $params = '';
    } else {
      $params = $this->encode($params);
    }

    $headers['Content-Length'] = strlen($params);
    if($this->getSession()->isAuthenticated()) {
      $headers['X-Auth-Token'] = $this->getSession()->getTokenId();
    }
    $headers = array_merge($this->headers, $headers);

    $log = $method . ' ' . $url;
    try {
      $this->getBrowser()->call($url, $method, $params, $headers);
      $this->log($log . ': ' . $this->getResponseCode() . ' ' . $this->getResponseMessage());
    } catch(Exception $e) {
      $msg = ', ' . get_class($e) . ': ' . $e->getMessage() . '/';
      $this->log($log . ': ' . $this->getResponseCode() . ' ' . $this->getResponseMessage() . $msg, sfLogger::ERR);
      throw $e;
    }

    return $this->getResponse();
  }

  public function getResponse()
  {
    if($this->getResponseHeader('Content-Type') != 'application/json') {
      throw new InvalidArgumentException(trim($this->getResponseText()), $this->getResponseCode());
    }
    $response = $this->decode($this->getBrowser()->getResponseText());
    if(isset($response['error'])) {
      throw new InvalidArgumentException($response['error']['message'], $response['error']['code']);
    }
    return $response;
  }

  protected function encode($content)
  {
    return json_encode($content);
  }

  protected function decode($content)
  {
    return json_decode($content, true);
  }

  public function getResponseCode()
  {
    return $this->getBrowser()->getResponseCode();
  }

  public function getResponseMessage()
  {
    return rtWebResponse_Proxy::getStatusMessage($this->getBrowser()->getResponseCode());
  }

  public function getResponseText()
  {
    return $this->getBrowser()->getResponseText();
  }
  
  public function getResponseHeader($header)
  {
    return $this->getBrowser()->getResponseHeader($header);
  }

  public function getResponseHeaders()
  {
    return $this->getBrowser()->getResponseHeaders();
  }

  protected function log($msg, $level = sfLogger::INFO)
  {
    if(!sfContext::hasInstance()) return;
    sfContext::getInstance()->getLogger()->log('{' . get_class($this) . '} ' . $msg, $level);
  }
}

/**
 * privide access to message map
 */
class rtWebResponse_Proxy extends sfWebResponse
{
  public static function getStatusMessage($code) {
    return isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : '';
  }
}
