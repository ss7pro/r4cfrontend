<?php

/**
 * Payment form.
 *
 * @package    ready4cloud
 * @subpackage form
 * @author     Roman Tatar <romantatar@gmail.com>
 */
class PaymentForm extends RcPaymentForm
{
  public function configure()
  {
    parent::configure();

    $this->setOption('pos_id', 38713);
    $this->setOption('pos_auth_key', 'jV727n7');

    unset(
      $this['tenant_id'],
      $this['session_id'],
      $this['client_ip'],
      $this['desc'],
      $this['pos_id'],
      $this['created_at']
    );
    $this->localCSRFSecret = false;
    $this->widgetSchema->setNameFormat('%s');
    $this->validatorSchema->setOption('allow_extra_fields', true);
    $this->validatorSchema->setOption('filter_extra_fields', true);
  }

  protected function doUpdateObject($values)
  {
    parent::doUpdateObject($values);

    $obj = $this->getObject();
    $obj->setClientIp($this->getOption('client_ip'));
    $obj->setPosId($this->getOption('pos_id'));
    $obj->setDesc('Płatność za usługi, kwota: ' . $obj->getAmount());
  }

  public function getObjectArray()
  {
    $ret = parent::getObjectArray();
    $ret['pos_auth_key'] = $this->getOption('pos_auth_key');
    return $ret;
  }
}

