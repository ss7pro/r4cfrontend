<?php

class osTestTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    // // add your own options here
    // $this->addOptions(array(
    //   new sfCommandOption('my_option', null, sfCommandOption::PARAMETER_REQUIRED, 'My option'),
    // ));

    $this->namespace        = 'os';
    $this->name             = 'test';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [os:test|INFO] task does things.
Call it with:

  [php symfony os:test|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $c = new OpenStackClient();
    $c->call(new OpenStackCommandAuth('fred', 'Abrakadabra.2', 'fred'));

    echo "Decoded response\n";
    var_export($c->getResponse());
    echo "\n";
  }
}

abstract class OpenStackCommand
{
  abstract public function getUri();
  abstract public function getMethod();
  abstract public function getParams();

  public function getHost() { return '178.239.138.10'; }
  public function getPort() { return 5000; }
  public function getUrl()  { return sprintf('http://%s:%d%s', $this->getHost(), $this->getPort(), $this->getUri()); }
  public function getHeaders() { return array(); }
}

class OpenStackCommandAuth extends OpenStackCommand
{
  public function __construct($username, $password, $tenant) {
    $this->username = $username;
    $this->password = $password;
    $this->tenant   = $tenant;
  }
  public function getUri() { return '/v2.0/tokens'; }
  public function getMethod() { return OpenStackClient::POST; }
  public function getParams() {
    return array(
      'auth' => array(
        'passwordCredentials' => array(
          'username' => $this->username,
          'password' => $this->password,
        )
      ),
      'tenantName' => $this->tenant
    );
  }
}

class OpenStackClient
{
  const GET = 'GET';
  const PUT = 'PUT';
  const POST = 'POST';
  const DELETE = 'DELETE';

  private $client = null;
  private $headers = array(
    'Content-Type' => 'application/json',
    'Accept' => 'application/json'
  );

  public function __construct()
  {
    $this->client = new sfWebBrowser();
  }

  public function call($url, $method = self::GET, array $params = null, array $headers = array())
  {
    if($url instanceof OpenStackCommand) {
      $this->call($url->getUrl(), $url->getMethod(), $url->getParams(), $url->getHeaders());
      return;
    }

    if($params !== null) {
      if($method == self::GET) {
        $url .= '?' . http_build_query($params);
        $params = '';
      } else {
        $params = json_encode($params);
      }
    }
    $headers['Content-Length'] = strlen($params);
    $headers = array_merge($this->headers, $headers);

    echo 'Request: ';
    var_export(array_merge(array($method => $url), $headers));
    echo "\n";
    echo $params;
    echo "\n";
    echo "\n";
    
    $this->client->call($url, $method, $params, $headers);
    
    echo 'Response: ';
    $rh = $this->client->getResponseHeaders();
    $rh[$this->getResponseCode()] = $this->getResponseMessage();
    var_export($rh);
    echo "\n";
    echo json_encode($this->client->getResponseText());
    echo "\n";
  }

  public function getResponseCode()
  {
    return $this->client->getResponseCode();
  }

  public function getResponseMessage()
  {
    return $this->client->getResponseMessage();
  }

  public function getResponseText()
  {
    return $this->client->getResponseText();
  }
  
  public function getResponseHeader($header)
  {
    return $this->client->getResponseHeader($header);
  }

  public function getResponse()
  {
    if($this->getResponseHeader('Content-Type') != 'application/json') {
      throw new InvalidArgumentException(trim($this->getResponseText()), $this->getResponseCode());
    }
    return json_decode($this->client->getResponseText(), true);
  }

  public function get($url, array $params = null, array $headers = array())
  {
    $this->call($url, self::GET, $params, $headers);
  }

  public function post($url, array $params = null, array $headers = array())
  {
    $this->call($url, self::POST, $params, $headers);
  }

  public function put($url, array $params = null, array $headers = array())
  {
    $this->call($url, self::PUT, $params, $headers);
  }

  public function delete($url, array $params = null, array $headers = array())
  {
    $this->call($url, self::DELETE, $params, $headers);
  }
}
