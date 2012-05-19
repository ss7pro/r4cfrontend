<?php

/**
 * sfGuardUser form for registration.
 *
 * @package    form
 */
class UserRegistrationForm extends BasesfGuardUserForm
{
  public function configure()
  {
    $this->useFields(array('username', 'password'));

    $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['password']->setAttribute('autocomplete', 'off');
    $this->validatorSchema['password']->setOption('required', true);
    
    $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
    $this->widgetSchema['password_again']->setAttribute('autocomplete', 'off');
    $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];

    $this->widgetSchema->moveField('password_again', 'after', 'password');

    $this->widgetSchema->setLabels(array(
      'username' => 'Login Email',
    ));

    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'Both password must be equal.')));
  }
}
