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

    $conf = rtPayuConfig::instance();
    $this->setOption('pos_id', $conf->getOption('pos_id'));
    $this->setOption('pos_auth_key', $conf->getOption('pos_auth_key'));
    $this->setOption('pay_type_url', $conf->getPayTypeUrl());
    $this->setOption('payment_url', $conf->getPaymentUrl());

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
    $trns = new RtPayuTransaction();

    parent::doUpdateObject($values);

    $obj = $this->getObject();

    $obj->setRtPayuTransaction($trns);
    $obj->setClientIp($this->getOption('client_ip'));
    $obj->setPosId($this->getOption('pos_id'));
    $obj->setDesc('Płatność za usługi, kwota: ' . $obj->getAmount());
  }

  public function getObjectArray()
  {
    $ret = parent::getObjectArray();
    $ret['pos_auth_key'] = $this->getOption('pos_auth_key');
    $ret['pay_type_url'] = $this->getOption('pay_type_url');
    $ret['payment_url'] = $this->getOption('payment_url');
    return $ret;
  }
}

