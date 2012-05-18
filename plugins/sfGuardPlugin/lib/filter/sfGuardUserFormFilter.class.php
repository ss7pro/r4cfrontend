<?php

/**
 * sfGuardUser filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfGuardUserFormFilter.class.php 12896 2008-11-10 19:02:34Z fabien $
 */
class sfGuardUserFormFilter extends BasesfGuardUserFormFilter
{
  public function configure()
  {
    
    unset($this['algorithm'], $this['salt'], $this['password']);
/*
    $this->widgetSchema['sf_guard_user_group_list']->setLabel('Groups');
    $this->widgetSchema['sf_guard_user_permission_list']->setLabel('Permissions');
    $this->setWidget('created_at', new WaWidgetFormFilterDate());
    $this->setWidget('last_login', new WaWidgetFormFilterDate());

    $message = 'Please enter a date in the format dd/mm/yyyy.';
    $this->getValidator('created_at')->getOption('from_date')->setMessage('invalid', $message);
    $this->getValidator('created_at')->getOption('to_date')->setMessage('invalid', $message);
    $this->getValidator('last_login')->getOption('from_date')->setMessage('invalid', $message);
    $this->getValidator('last_login')->getOption('to_date')->setMessage('invalid', $message);
 */
  }
}
