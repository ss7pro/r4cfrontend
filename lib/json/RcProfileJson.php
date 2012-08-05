<?php
class RcProfileJson
{
  public function __construct(RcProfile $profile)
  {
    $user = $profile->getsfGuardUser();
    $tenant = $profile->getRcTenant();
    $account_addr = $tenant->getRcAddressRelatedByDefaultAddressId();
    $invoice_addr = $tenant->getRcAddressRelatedByInvoiceAddressId();
    $profile_fields = array(
      'title', 'first_name', 'last_name', 'api_id'
    );
    $tenant_fields = array(
      'type', 'company_name', 'nip', 'www'
    );
    $address_fields = array('street', 'post_code', 'city', 'phone');

    $dst = 'account[profile][email]';
    $this->{$dst} = $user->getUsername();

    $arr = $profile->toArray(BasePeer::TYPE_FIELDNAME);
    foreach($profile_fields as $key) {
      $dst = 'account[profile][' . $key . ']';
      $this->{$dst} = $arr[$key];
    }

    $arr = $tenant->toArray(BasePeer::TYPE_FIELDNAME);
    foreach($tenant_fields as $key) {
      $dst = 'account[tenant][' . $key . ']';
      $this->{$dst} = $arr[$key];
    }
    $arr = $account_addr->toArray(BasePeer::TYPE_FIELDNAME);
    foreach($address_fields as $key) {
      $dst = 'account[account_address][' . $key . ']';
      $this->{$dst} = $arr[$key];
    }
    $arr = $invoice_addr->toArray(BasePeer::TYPE_FIELDNAME);
    foreach($address_fields as $key) {
      $dst = 'account[invoice_address][' . $key . ']';
      $this->{$dst} = $arr[$key];
    }
  }

  public function toArray()
  {
    return get_object_vars($this);
  }
}
