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
      $this['client_ip'],
      $this['desc'],
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
    $trns->setPosId($this->getOption('pos_id'));

    parent::doUpdateObject($values);

    $obj = $this->getObject();
    $tenant = RcTenantQuery::create()->findOneByApiId($obj->getTenantApiId());
    $obj->setRcTenant($tenant);
    $obj->setRtPayuTransaction($trns);
    $obj->setClientIp($this->getOption('client_ip'));
    $obj->setDesc('Płatność za usługi, kwota: ' . sprintf("%.2f", $obj->getAmount() / 100));
  }

  public function getObjectArray()
  {
    $ret = parent::getObjectArray();
    $trns = $this->getObject()->getRtPayuTransaction();
    $ret['pos_auth_key'] = $this->getOption('pos_auth_key');
    $ret['pay_type_url'] = $this->getOption('pay_type_url');
    $ret['payment_url'] = $this->getOption('payment_url');
    $ret['session_id'] = $trns->getSessionId();
    $ret['pos_id'] = $trns->getPosId();
    return $ret;
  }
}

