<?php

class myUser extends sfGuardSecurityUser
{
  public function __toString()
  {
    return (string)$this->getProfile();
  }

  public function getEmail()
  {
    return $this->getProfile()->getEmail();
  }

  public function getOsSession()
  {
    return rtOpenStackClient::factory()->getSession();
  }

  public function getOsUserId()
  {
    $session = $this->getOsSession();
    return $session->getUserId();
  }
}
