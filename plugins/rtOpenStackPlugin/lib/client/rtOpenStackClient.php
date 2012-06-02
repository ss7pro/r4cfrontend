<?php
class rtOpenStackClient
{
  private $browser = null;
  private $session = null;

  private $headers = array(
    'Content-Type' => 'application/json',
    'Accept'       => 'application/json'
  );

  public function __construct()
  {
    $this->setBrowser(new sfWebBrowser());
    $this->setSession(new rtOpenStackSession());
  }

  public function getBrowser()
  {
    return $this->browser;
  }

  public function setBrowser(sfWebBrowser $browser)
  {
    $this->browser = $browser;
  }

  public function getSession()
  {
    return $this->session;
  }

  public function setSession(rtOpenStackSession $session)
  {
    $this->session = $session;
  }

  public function call(rtOpenStackCommand $c)
  {
    return $c->exec($this);
  }

  public function exec($url, $method = self::GET, array $params = null, array $user_headers = array())
  {
    if(!empty($params)) {
      if($method == sfRequest::GET) {
        $url .= '?' . http_build_query($params);
        $params = '';
      } else {
        $params = $this->encode($params);
      }
    }

    $headers = $this->headers;
    if(is_string($params)) {
      $headers['Content-Length'] = strlen($params);
    }
    if($this->getSession()->isAuthenticated()) {
      $headers['X-Auth-Token'] = $this->getSession()->getTokenId();
    }
    $headers = array_merge($headers, $user_headers);

    $log = $method . ' ' . $url;
    try {
      $this->getBrowser()->call($url, $method, $params, $headers);
      $this->log($log . ': ' . $this->getResponseCode());
    } catch(Exception $e) {
      $this->log($log . ':' . $this->getResponseCode() . ' ' . $this->getResponseMessage() . ' (' . get_class($e) . ' ' . $e->getMessage() . ')', sfLogger::ERR);
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

  public function get($url, array $params = null, array $headers = array())
  {
    return $this->exec($url, sfRequest::GET, $params, $headers);
  }

  public function post($url, array $params = null, array $headers = array())
  {
    return $this->exec($url, sfRequest::POST, $params, $headers);
  }

  public function put($url, array $params = null, array $headers = array())
  {
    return $this->exec($url, sfRequest::PUT, $params, $headers);
  }

  public function delete($url, array $params = null, array $headers = array())
  {
    return $this->exec($url, sfRequest::DELETE, $params, $headers);
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
