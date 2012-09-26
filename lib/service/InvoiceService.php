<?php
class InvoiceService
{
  /**
   * @return RcInvoice
   */
  public function fromPayment(RcPayment $payment)
  {
    $tenant = $payment->getRcTenant();
    $invoice = $this->create();

    $invoice->setRcTenant($tenant);
    $invoice->setBuyerName($payment->getBuyerName());
    $invoice->setBuyerAddress($payment->getStreet());
    $invoice->setBuyerCode($payment->getPostCode() . ' ' . $payment->getCity());
    $invoice->setBuyerNip($payment->getNip());

    $item = new RcInvoiceItem();
    $item->setName($payment->getDesc());
    $item->setQty(1);
    $item->setTaxRate(23);
    $item->setPrice($payment->getPrice());
    $item->calcCosts();
    $invoice->addRcInvoiceItem($item);

    return $invoice;
  }

  /**
   * @return RcInvoice
   */
  public function fromTenant(RcTenant $tenant)
  {
    $invoice = $this->create();

    $addr = $tenant->getRcAddressRelatedByInvoiceAddressId();

    $invoice->setRcTenant($tenant);
    $invoice->setBuyerName((string)$tenant);
    $invoice->setBuyerAddress($addr->getStreet());
    $invoice->setBuyerCode($addr->getPostCode() . ' ' . $addr->getCity());
    $invoice->setBuyerNip($tenant->getNip());

    return $invoice;
  }

  /**
   * @return RcInvoice
   */
  public function create()
  {
    $invoice = new RcInvoice();

    $invoice->setSellerName(sfConfig::get('app_invoice_seller_name', ''));
    $invoice->setSellerAddress(sfConfig::get('app_invoice_seller_address', ''));
    $invoice->setSellerCode(sfConfig::get('app_invoice_seller_post', ''));
    $invoice->setSellerNip(sfConfig::get('app_invoice_seller_nip', ''));
    $invoice->setSellerBank(sfConfig::get('app_invoice_seller_bank', ''));

    $invoice->setIssueAt(time());
    $invoice->setSaleAt(time());
    $invoice->setPaymentDate(time());

    return $invoice;
  }
}
