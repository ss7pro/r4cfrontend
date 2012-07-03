<?php

/**
 * RcTenant form.
 *
 * @package    ready4cloud
 * @subpackage form
 * @author     Roman Tatar <romantatar@gmail.com>
 */
class RcTenantForm extends BaseRcTenantForm
{
  public function configure()
  {
    $types = array(0 => 'Private account', 1 => 'Company account');
    $this->setWidget('type', new sfWidgetFormChoice(array('choices' => $types, 'expanded' => true)));
    $this->setValidator('type', new sfValidatorChoice(array('choices' => array_keys($types))));

    $this->widgetSchema->setLabels(array(
      'type' => 'Account type',
    ));
  }
}
