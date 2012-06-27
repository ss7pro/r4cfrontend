<?php
class rtOpenStackCommandTenant extends rtOpenStackCommand
{
  /**
   * @param rtOpenStackClient $client
   */
  public function configure(rtOpenStackClient $client)
  {
    $this->setPreset('auth');
    $this->setMethod(sfRequest::POST);
    $this->setUri('/v2.0/tenants');
  }

  /**
   * @param rtOpenStackClient $client
   */
  public function handleResponse(rtOpenStackClient $client)
  { 
    $response = parent::handleResponse($client);
    $session = $client->getSession();
    if(isset($response['tenants'])) {
      $session->setTenants($response['tenants']);
    }
    return $response;
  }
}

