<?php
class rtOpenStackSession
{
  const ATTR_NS   = 'plugin/rtOpenStackSession';

  private $access  = null;
  private $tenants = null;
  private $name    = null;
  private $user    = null;

  public function __construct($name = 'default')
  {
    $this->name = $name;
    $this->user = $this->getsfUser();
    if($this->user) {
      if($this->user->hasAttribute($this->name, self::ATTR_NS)) {
        $this->access = $this->user->getAttribute($this->name, null, self::ATTR_NS);
      }
    }
  }

  public function setAccess(array $access)
  {
    if($this->user) {
      $this->user->setAttribute($this->name, $access, self::ATTR_NS);
    }
    $this->access = $access;
  }

  public function getTenants()
  {
    return $this->tenants;
  }

  public function setTenants(array $tenants)
  {
    $this->tenants = $tenants;
  }

  public function getAccess()
  {
    return $this->access;
  }

  private function getsfUser()
  {
    if(!sfContext::hasInstance()) return null;
    return sfContext::getInstance()->getUser();
  }

  public function isAuthenticated()
  {
    return $this->getTokenId() && $this->isValid();
  }

  public function isValid()
  {
    if(empty($this->access)) return false;
    if(!($expires = $this->getTokenExpires())) return false;
    return strtotime($expires) > time();
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
    return isset($this->access['serviceCatalog']) ? $this->access['serviceCatalog'] : array();
  }

  public function getEndpoints()
  {
    $result = array();
    foreach($this->getServiceCatalog() as $cat)
    {
      $t = $cat['type'];
      foreach($cat['endpoints'] as $ep)
      {
        $r = $ep['region'];
        $result[$t][$r] = $ep;
      }
    }
    return $result;
  }

  public function getEndpoint($type, $region = null)
  {
    $enspoints = $this->getEndpoints();
    if($region === null)
    {
      return $endpoints[$type];
    }
    return $endpoints[$type][$region];
  }
}
