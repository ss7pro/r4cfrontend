<?php
class PaymentJson
{
  public function __construct(RcPayment $payment)
  {
    $trns = $payment->getRtPayuTransaction();
    $invoice = $payment->getRcInvoice();
    $this->payment_id = $payment->getPaymentId();
    $this->desc = $payment->getDesc();
    $this->amount = $payment->getAmount();
    $this->invoice_url = null;
    $this->status = $trns->getStatus();
    $this->trans_id = $trns->getTransId();
  }

  public function toArray()
  {
    return get_object_vars($this);
  }
}
