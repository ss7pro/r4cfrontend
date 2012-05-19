<?php 
class RegistrationForm extends BaseForm {

  public function configure() {
    $this->widgetSchema->setNameFormat('registration[%s]');
    $this->embedForm('login', new UserRegistrationForm());
    $this->embedForm('profile', new RcUserProfileForm());
    $this->embedForm('address', new RcAddressForm());
    $this->embedForm('account', new RcAccountForm());
    $this->embedForm('company_address', new RcAddressForm());
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
      $company = $this->getEmbeddedForm('account')->getObject();
      $addr = $this->getEmbeddedForm('address')->getObject();
      $company_addr = $this->getEmbeddedForm('company_address')->getObject();
      
      $user->save($con);
      $profile->setsfGuardUser($user);
      $profile->save($con);
      $company->save($con);

      $con->commit();
      return $user;
    } catch(Exception $e) {
      $con->rollBack();
      throw $e;
    }
  }
}
