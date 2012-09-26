<?php
class PaymentJson
{
  public function __construct(RcPayment $payment)
  {
    $i18n = sfContext::getInstance()->getI18N();

    $trns = $payment->getRtPayuTransaction();
    $invoice = $payment->getRcInvoice();
    $this->payment_id = $payment->getPaymentId();
    $this->desc = $payment->getDesc();
    $this->amount = $payment->getPrice();
    $this->invoice_url = $payment->getInvoiceUrl();
    $this->status = $i18n->__($trns->getStatusLabel());
    $this->started_at = $payment->getCreatedAt('d M Y H:i');
    $this->recv_at = $trns->getRecvAt('U') ? $trns->getRecvAt('d M Y H:i') : '';
  }

  public function toArray()
  {
    return get_object_vars($this);
  }
}
