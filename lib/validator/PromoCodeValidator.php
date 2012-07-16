<?php
class PromoCodeValidator extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('code_field', 'code');
    $this->setMessage('invalid', 'This is not valid code.');
    $this->addMessage('notfound', 'The code was not found or already used.');
    $this->addMessage('expired', 'This code has been expired.');
  }

  protected function doClean($values)
  {
    if(isset($values[$this->getOption('code_field')]))
    {
      $code = RcPromoCodeQuery::create()
        ->filterByCode($values[$this->getOption('code_field')])
        ->filterByUsedAt(null, Criteria::ISNULL)
        ->findOne();

      if(!$code) {
        throw new sfValidatorErrorSchema($this, array(
          $this->getOption('code_field') => new sfValidatorError($this, 'notfound')
        ));
      }

      if($code->getUsedAt() !== null) {
        throw new sfValidatorErrorSchema($this, array(
          $this->getOption('code_field') => new sfValidatorError($this, 'invalid')
        ));
      }

      if($code->getExpiredAt() !== null && $code->getExpireAt('U') < time()) {
        throw new sfValidatorErrorSchema($this, array(
          $this->getOption('code_field') => new sfValidatorError($this, 'expired')
        ));
      }

      return array_merge($values, array('code_object' => $code));
    }
    return $values;
  }
}
