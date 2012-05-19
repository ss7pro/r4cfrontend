<?php

/**
 * RegistrationProfile form.
 *
 * @package    ready4cloud
 * @subpackage form
 * @author     Roman Tatar <romantatar@gmail.com>
 */
class RegistrationProfileForm extends BaseRcUserProfileForm {
  public function configure() {
    $this->setWidget('title', new WidgetFormTitleChoice());
    $this->setValidator('title', new ValidatorTitleChoice());
    $this->useFields(array('title', 'first_name', 'last_name'));
  }
}
