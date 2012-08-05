<?php
class rtOpenStackCommandTokenGet extends rtOpenStackCommand
{
  /**
   * @param rtOpenStackClient $client
   */
  public function configure(rtOpenStackClient $client)
  {
    $this->addRequired('token');

    $this->setPreset('auth');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/v2.0/tokens');
    $params = array(
      'auth' => array(
        'token' => array(
          'id' => $this->get('token'),
        ),
      )
    );
    $this->setParams($params);
  }

  /**
   * @param rtOpenStackClient $client
   */
  public function handleResponse(rtOpenStackClient $client)
  { 
    $response = parent::handleResponse($client);
    if(isset($response['access'])) {
      $session = $client->getSession();
      $session->setAccess($response['access']);
    }
    return $response;
  }
}
