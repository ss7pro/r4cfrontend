<?php



/**
 * Skeleton subclass for representing a row from the 'rc_user_profile' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.6.5-dev on:
 *
 * pią, 18 maj 2012, 20:13:39
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class RcUserProfile extends BaseRcUserProfile {

  public function __toString() {
    $name = trim(sprintf('%s %s %s', $this->getTitle(), $this->getFirstName(), $this->getLastName()));
    if($name) return $name;
    return $this->getsfGuardUser()->getUsername();
  }
} // RcUserProfile
