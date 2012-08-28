<?php 
/**
 * ProfileForm
 */
class ProfileForm extends BaseForm 
{
  public function configure()
  {
    $user = $this->getOption('user');
    $profile = null;
    $tenant = null;
    $account_addr = null;
    $invoice_addr = null;

    if($user)
    {
      if(!$user instanceof sfGuardUser) {
        throw new InvalidArgumentException('ProfileForm require "user" option to be instance of sfGuardUser');
      }
      $profile = $user->getProfile();
      $tenant  = $profile->getRcTenant();
      $account_addr = $tenant->getRcAddressRelatedByDefaultAddressId();
      $invoice_addr = $tenant->getRcAddressRelatedByInvoiceAddressId();
    } 

    $profile_fields = $this->getProfileFields();
    $tenant_fields = array(
      'type', 'company_name', 'nip', 'www'
    );
    $address_fields = array('street', 'post_code', 'city', 'phone');

    $this->widgetSchema->setNameFormat('account[%s]');

    $profile_form = new UserAdminForm($user);
    $profile_form->useFields($profile_fields);
    if(isset($profile_form['password'])) {
      $profile_form->getValidator('password')->setOption('required', true);
    }
    $this->embedForm('profile', $profile_form);

    $tenant_form = new RcTenantForm($tenant);
    $tenant_form->useFields($tenant_fields);
    $this->embedForm('tenant', $tenant_form);

    $account_address = new RcAddressForm($account_addr);
    $account_address->useFields($address_fields);
    $this->embedForm('account_address', $account_address);

    $invoice_address = new RcAddressForm($account_addr);
    $invoice_address->useFields($address_fields);
    $this->embedForm('invoice_address', $invoice_address);
  }

  protected function getProfileFields()
  {
    return array(
      'title', 'first_name', 'last_name'
    );
  }

  public function save($con = null)
  {
    $values = $this->getValues();
    $con = $con ? $con : Propel::getConnection();
    try {
      $con->beginTransaction();

      $user = $this->update($values);
      $user->save($con);

      $con->commit();
    } catch(Exception $e) {
      $con->rollBack();
      throw $e;
    }
  }

  protected function update($values)
  {
    foreach($this->getEmbeddedForms() as $name => $form) {
      $form->updateObject($values[$name]);
    }
    return $this->getEmbeddedForm('profile')->getObject();
  }
}
