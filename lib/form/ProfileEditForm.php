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

    $profile_fields = array(
      'username', 'title', 'first_name', 'last_name',
      'type', 'company_name', 'nip', 'www'
    );
    $address_fields = array('street', 'post_code', 'city', 'phone');

    
    $profile_form = new UserAdminForm($user);
    $profile_form->useFields($profile_fields);
    $this->embedForm('profile', $profile_form);

    $account_address = new RcAddressForm($profile->getRcAddressRelatedByDefaultAddressId());
    $account_address->useFields($address_fields);
    $this->embedForm('account_address', $account_address);

    $invoice_address = new RcAddressForm($profile->getRcAddressRelatedByInvoiceAddressId());
    $invoice_address->useFields($address_fields);
    $this->embedForm('invoice_address', $invoice_address);

    $this->getWidgetSchema()->setNameFormat('registration[%s]');
    $this->getWidgetSchema()->setFormFormatterName('TableNoEmbeddedLabel');
  }

  public function save($con = null)
  {
    $values = $this->getValues();

    foreach($this->getEmbeddedForms() as $name => $form) {
      $form->updateObject($values[$name]);
    }

    $con = $con ? $con : Propel::getConnection();
    try {
      $con->beginTransaction();

      $user = $this->getEmbeddedForm('profile')->getObject();
      $account_address = $this->getEmbeddedForm('account_address')->getObject();
      $invoice_address = $this->getEmbeddedForm('invoice_address')->getObject();
      
      $profile = $user->getProfile();
      $profile->setRcAddressRelatedByDefaultAddressId($account_address);
      $profile->setRcAddressRelatedByInvoiceAddressId($invoice_address);

      $user->save($con);
      $profile->save($con);

      $con->commit();
      return $user;
    } catch(Exception $e) {
      $con->rollBack();
      throw $e;
    }
  }
}
