<?php
class RcTenantAdminForm extends RcTenantForm
{
  public function configure()
  {
    parent::configure();

    unset(
      $this['default_address_id'],
      $this['invoice_address_id'],
      $this['api_id'],
      $this['api_name']
    );

    $default_addr = $this->getObject()->getRcAddressRelatedByDefaultAddressId();
    $default_form = new RcAddressForm($default_addr);
    $this->embedForm('default_address', $default_form);

    $invoice_addr = $this->getObject()->getRcAddressRelatedByInvoiceAddressId();
    $invoice_form = new RcAddressForm($invoice_addr);
    $this->embedForm('invoice_address', $invoice_form);
  }
}
