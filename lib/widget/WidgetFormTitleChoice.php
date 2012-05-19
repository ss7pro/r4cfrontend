<?php
class WidgetFormTitleChoice extends sfWidgetFormChoice
{
  public function __construct($options = array(), $attributes = array())
  {
    $options += array(
      'choices' => array('' => '', 'Mr' => 'Mr', 'Ms' => 'Ms', 'Mrs' => 'Mrs'),
    );
    parent::__construct($options, $attributes);
  }
}
