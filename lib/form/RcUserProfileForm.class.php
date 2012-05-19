<?php

/**
 * RcUserProfile form.
 *
 * @package    ready4cloud
 * @subpackage form
 * @author     Roman Tatar <romantatar@gmail.com>
 */
class RcUserProfileForm extends BaseRcUserProfileForm
{
  public function configure()
  {
    $this->setWidget('title', new WidgetFormTitleChoice());
    $this->setValidator('title', new ValidatorTitleChoice());
  }
}
