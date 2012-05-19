<?php
class ValidatorTitleChoice extends sfValidatorChoice
{
  public function __construct($options = array(), $messages = array())
  {
    $options += array(
      'choices'  => array('', 'Mr', 'Ms', 'Mrs'),
      'required' => false
    );
    parent::__construct($options, $messages);
  }
}
