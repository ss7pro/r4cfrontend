<?php

/**
 * RegistrationAddress form.
 *
 * @package    ready4cloud
 * @subpackage form
 * @author     Roman Tatar <romantatar@gmail.com>
 */
class RegistrationAddressForm extends BaseRcAddressForm
{
  public function configure()
  {
    $this->useFields(array('street', 'post_code', 'city', 'phone'));
  }
}
