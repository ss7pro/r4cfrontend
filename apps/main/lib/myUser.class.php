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
}
