<?php
class UserAdminForm extends sfGuardUserAdminForm
{
  public function configure()
  {
    parent::configure();

    $this->setWidget('title', new WidgetFormTitleChoice());
    $this->setValidator('title', new ValidatorTitleChoice());

    $types = array(0 => 'Private account', 1 => 'Company account');
    $this->setWidget('type', new sfWidgetFormChoice(array('choices' => $types, 'expanded' => true)));
    $this->setValidator('type', new sfValidatorChoice(array('choices' => array_keys($types))));

    $this->widgetSchema->setLabels(array(
      'username' => 'Login email',
      'type' => 'Account type',
    ));

    $this->validatorSchema->setPostValidator(new sfValidatorPropelUnique(array('model' => 'sfGuardUser', 'column' => array('username')), array('invalid' => 'Account with this email already exist.')));
    $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_again', array(), array('invalid' => 'The two passwords must be the same.')));
  }

  public function updateObject($values = null)
  {
    parent::updateObject($values);

    // update profile values
    if (!is_null($profile = $this->getProfile()))
    {
      $values = $values !== null ? $values : $this->getValues();
      unset($values[$this->getPrimaryKey()]);
      $profile->fromArray($values, BasePeer::TYPE_FIELDNAME);
    }

    return $this->object;
  }
}
