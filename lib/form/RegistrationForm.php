<?php 
/**
 * Main registration form
 */
class RegistrationForm extends BaseForm {

  public function configure() {
    $this->widgetSchema->setNameFormat('registration[%s]');
    //$this->getWidgetSchema()->setFormFormatterName('TableDownMsg');
    $this->embedForm('login', new RegistrationUserForm());
    $this->embedForm('profile', new RegistrationProfileForm());
    $this->embedForm('account_address', new RegistrationAddressForm());
    $this->embedForm('account', new RegistrationAccountForm());
    $this->embedForm('invoice_address', new RegistrationAddressForm());
  }

  public function save($con = null) {
    $values = $this->getValues();

    foreach($this->getEmbeddedForms() as $name => $form) {
      $form->updateObject($values[$name]);
    }

    $con = $con ? $con : Propel::getConnection();
    try {
      $con->beginTransaction();

      $user = $this->getEmbeddedForm('login')->getObject();
      $profile = $this->getEmbeddedForm('profile')->getObject();
      $account = $this->getEmbeddedForm('account')->getObject();
      $account_address = $this->getEmbeddedForm('account_address')->getObject();
      $invoice_address = $this->getEmbeddedForm('invoice_address')->getObject();
      
      $user->save($con);

      $profile->setsfGuardUser($user);
      $profile->setRcAccount($account);
      $account->setRcAddressRelatedByDefaultAddressId($account_address);
      $account->setRcAddressRelatedByInvoiceAddressId($invoice_address);

      $profile->save($con);


      $con->commit();
      return $user;
    } catch(Exception $e) {
      $con->rollBack();
      throw $e;
    }
  }
}
