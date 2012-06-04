<?php
class rtOpenStackCommandAuth extends rtOpenStackCommand
{
  /**
   * @param rtOpenStackClient $client
   */
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('user');
    $this->addRequired('pass');

    $this->setPreset('auth');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/v2.0/tokens');
    $params = array(
      'auth' => array(
        'passwordCredentials' => array(
          'username' => $this->get('user'),
          'password' => $this->get('pass')
        )
      )
    );
    if ($this->get('tenant-name')) {
      $params['auth']['tenantName'] = $this->get('tenant-name');
    }
    if ($this->get('tenant-id')) {
      $params['auth']['tenantId'] = $this->get('tenant-id');
    }
    $this->setParams($params);
  }

  /**
   * @param rtOpenStackClient $client
   */
  public function handleResponse(rtOpenStackClient $client)
  { 
    $response = parent::handleResponse($client);
    if(isset($response['access'])) {
      $client->getSession()->setAccess($response['access']);
    }
    return $response;
  }
}

