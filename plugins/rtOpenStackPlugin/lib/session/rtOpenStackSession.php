<?php
class rtOpenStackSession
{
  private $access = null;

  public function setAccess($access)
  {
    $this->access = $access;
  }

  public function getAccess()
  {
    return $this->access;
  }

  public function isAuthenticated()
  {
    return $this->getTokenId() && $this->isValid();
  }

  public function isValid()
  {
    if(empty($this->access)) return false;
    if(!($expires = $this->getTokenExpires())) return false;
    return time() > strtotime($expires);
  }

  public function getTokenExpires()
  {
    if(!($token = $this->getToken())) return null;
    return isset($token['expires']) ? $token['expires'] : null;
  }

  public function getTokenId()
  {
    if(!($token = $this->getToken())) return null;
    return isset($token['id']) ? $token['id'] : null;
  }

  public function getTokenTenant()
  {
    if(!($token = $this->getToken())) return null;
    return isset($token['tenant']) ? $token['tenant'] : null;
  }

  public function getTokenTenantId()
  {
    if(!($tenant = $this->getTokenTenant())) return null;
    return isset($tenant['id']) ? $tenant['id'] : null;
  }

  public function getToken()
  {
    return isset($this->access['token']) ? $this->access['token'] : null;
  }

  public function getUser()
  {
    return isset($this->access['user']) ? $this->access['user'] : null;
  }

  public function getServiceCatalog()
  {
    return isset($this->access['serviceCatalog']) ? $this->access['serviceCatalog'] : null;
  }
}
