<?php

/**
 * RegistrationAccount form.
 *
 * @package    ready4cloud
 * @subpackage form
 * @author     Roman Tatar <romantatar@gmail.com>
 */
class RegistrationAccountForm extends BaseRcAccountForm
{
  public function configure()
  {
    $this->useFields(array('name', 'nip', 'www', 'email'));
  }
}
