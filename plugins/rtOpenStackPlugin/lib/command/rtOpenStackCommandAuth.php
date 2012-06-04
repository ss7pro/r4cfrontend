<?php
class rtOpenStackCommandAuth extends rtOpenStackCommand
{
  public function __construct($username, $password, $tenantName = null, $tenantId = null)
  {
    $this->setPreset('auth');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/v2.0/tokens');
    $params = array(
      'auth' => array(
        'passwordCredentials' => array(
          'username' => $username,
          'password' => $password
        )
      )
    );
    if($tenantName) {
      $params['auth']['tenantName'] = $tenantName;
    }
    if($tenantId) {
      $params['auth']['tenantId'] = $tenantId;
    }
    $this->setParams($params);
  }

  public function handleResponse(rtOpenStackClient $client) { 
    $response = parent::handleResponse($client);
    if(isset($response['access'])) {
      $client->getSession()->setAccess($response['access']);
    }
    return $response;
  }
}

