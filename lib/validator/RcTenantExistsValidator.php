<?php
class RcTenantExistsValidator extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('tenant_field', 'tenant_id');
    $this->setMessage('invalid', 'Tenant not exists.');
  }

  protected function doClean($values)
  {
    if(isset($values[$this->getOption('tenant_field')]))
    {
      $tenant = RcTenantQuery::create()
        ->filterByApiId($values[$this->getOption('tenant_field')])
        ->findOne();
      if(!$tenant)
      {
        throw new sfValidatorErrorSchema($this, array(
          $this->getOption('tenant_field') => new sfValidatorError($this, 'invalid')
        ));
      }
      return array_merge($values, array('tenant_object' => $tenant));
    }
    return $values;
  }
}
