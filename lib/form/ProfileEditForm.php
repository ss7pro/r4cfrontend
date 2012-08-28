<?php 
/**
 * Profile edit form
 */
class ProfileEditForm extends BaseForm 
{
  public function configure()
  {
    $user = $this->getOption('user');
    if(!$user instanceof sfGuardUser) {
      throw new InvalidArgumentException('ProfileEditForm require "user" option as instance of sfGuardUser');
    }
    $profile = $user->getProfile();
    $tenant  = $profile->getRcTenant();

    $profile_fields = array(
      'title', 'first_name', 'last_name',
    );
    $tenant_fields = array(
      'type', 'company_name', 'nip', 'www'
    );
    $address_fields = array(
      'street', 'post_code', 'city', 'phone'
    );
    
    $profile_form = new UserAdminForm($user);
    $profile_form->useFields($profile_fields);
    $this->embedForm('profile', $profile_form);

    $tenant_form = new RcTenantForm($tenant);
    $tenant_form->useFields($tenant_fields);
    $this->embedForm('tenant', $tenant_form);

    $account_address = new RcAddressForm($tenant->getRcAddressRelatedByDefaultAddressId());
    $account_address->useFields($address_fields);
    $this->embedForm('account_address', $account_address);

    $invoice_address = new RcAddressForm($tenant->getRcAddressRelatedByInvoiceAddressId());
    $invoice_address->useFields($address_fields);
    $this->embedForm('invoice_address', $invoice_address);

    $this->getWidgetSchema()->setNameFormat('profile[%s]');
    $this->getWidgetSchema()->setFormFormatterName('TableNoEmbeddedLabel');
  }

  public function save($con = null)
  {
    $values = $this->getValues();

    $con = $con ? $con : Propel::getConnection();
    try {
      $con->beginTransaction();

      foreach($this->getEmbeddedForms() as $name => $form) {
        $form->updateObject($values[$name]);
      }

      $user = $this->getEmbeddedForm('profile')->getObject();
      $profile = $user->getProfile();
      $tenant = $this->getEmbeddedForm('tenant')->getObject();
      $account_address = $this->getEmbeddedForm('account_address')->getObject();
      $invoice_address = $this->getEmbeddedForm('invoice_address')->getObject();
      
      $profile->save($con);
      $account_address->save($con);
      $invoice_address->save($con);

      $con->commit();
      return $user;
    } catch(Exception $e) {
      $con->rollBack();
      throw $e;
    }
  }
}
