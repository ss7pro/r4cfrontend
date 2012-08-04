<?php 
/**
 * Main registration form
 *
 * Array
 * (
 *     [user] => Array
 *     (
 *         [tenantId] => ecf89d114d57410ca23ea9cafd79d537
 *         [password] => $6$rounds=40000$Yvd2kM9K4uum/AQQ$0rQPrJuRfXCnx4U6w/GK9/mLk1//QoP58tOD/eVMc7bglAaGrdgqFeBSkq8I464eN4zyLaVA8GW/q3Ywb2r0T/
 *         [enabled] => 1
 *         [id] => a4f2cb6c641c4497ac222294be8d49c1
 *         [name] => aa
 *     )
 * )
 *
 */
class RegistrationForm extends BaseForm 
{
  public function configure()
  {
    $profile_fields = array(
      'username', 'password', 'password_again', 
      'title', 'first_name', 'last_name',
    );
    $tenant_fields = array(
      'type', 'company_name', 'nip', 'www'
    );
    $address_fields = array('street', 'post_code', 'city', 'phone');

    $this->widgetSchema->setNameFormat('registration[%s]');

    $profile_form = new UserAdminForm();
    $profile_form->useFields($profile_fields);
    $profile_form->getValidator('password')->setOption('required', true);
    $this->embedForm('profile', $profile_form);

    $tenant_form = new RcTenantForm();
    $tenant_form->useFields($tenant_fields);
    $this->embedForm('tenant', $tenant_form);

    $account_address = new RcAddressForm();
    $account_address->useFields($address_fields);
    $this->embedForm('account_address', $account_address);

    $invoice_address = new RcAddressForm();
    $invoice_address->useFields($address_fields);
    $this->embedForm('invoice_address', $invoice_address);

    $this->setWidget('captcha', new sfWidgetFormReCaptcha(array(
      'public_key' => sfConfig::get('app_recaptcha_private_key', '6LffzNMSAAAAAGDlUb8oV2G4QceRErUZfXNwGc9A'),
      'use_ssl' => false,
    )));

    $this->setValidator('captcha', new sfValidatorReCaptcha(array(
      'private_key' => sfConfig::get('app_recaptcha_private_key', '6LffzNMSAAAAABpqXUCfmyfz6-M4Q71DeEfGHSxo'),
    )));
  }

  public function bindRequest(sfWebRequest $request)
  {
    $params = $request->getParameter($this->getName()); 
    $params['captcha'] = array(
      'recaptcha_challenge_field' => $request->getParameter('recaptcha_challenge_field'),
      'recaptcha_response_field'  => $request->getParameter('recaptcha_response_field'),
    );
    $request->setParameter($this->getName(), $params);
    parent::bindRequest($request);
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
      $tenant = $this->getEmbeddedForm('tenant')->getObject();
      $account_address = $this->getEmbeddedForm('account_address')->getObject();
      $invoice_address = $this->getEmbeddedForm('invoice_address')->getObject();

      $profile = $user->getProfile();
      $profile->setRcTenant($tenant);
      $tenant->setRcAddressRelatedByDefaultAddressId($account_address);
      $tenant->setRcAddressRelatedByInvoiceAddressId($invoice_address);

      $config = rtOpenStackConfig::getConfiguration();
      $cmd = new rtOpenStackCommandClientCreate(array(
        'user' => $values['profile']['username'],
        'pass' => $values['profile']['password'],
        'auth-token' => $config['admin']['auth_token'],
      ));
      $response = $cmd->execute();

      if(empty($response['user']) || empty($response['user']['tenantId'])) {
        throw new DomainException('Invalid Api response: ' . json_encode($response));
      }

      $profile->setApiId($response['user']['id']);
      $tenant->setApiId($response['user']['tenantId']);
      $tenant->setApiName($response['user']['name']);

      $user->save($con);

      $con->commit();

      return array($user, $response);

    } catch(Exception $e) {
      $con->rollBack();
      throw $e;
    }
  }
}
