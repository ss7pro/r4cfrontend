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
class RegistrationForm extends ProfileForm 
{
  public function configure()
  {
    parent::configure();

    $this->widgetSchema->setNameFormat('registration[%s]');

    $this->setWidget('captcha', new sfWidgetFormReCaptcha(array(
      'public_key' => sfConfig::get('app_recaptcha_private_key', '6LffzNMSAAAAAGDlUb8oV2G4QceRErUZfXNwGc9A'),
      'use_ssl' => false,
    )));

    if(sfConfig::get('app_recaptcha_enabled', true))
    {
      $this->setValidator('captcha', new sfValidatorReCaptcha(array(
        'private_key' => sfConfig::get('app_recaptcha_private_key', '6LffzNMSAAAAABpqXUCfmyfz6-M4Q71DeEfGHSxo'),
      )));
    }
    else
    {
      $this->setValidator('captcha', new sfValidatorPass());
    }
  }

  protected function getProfileFields()
  {
    return array(
      'username', 'password', 'password_again', 
      'title', 'first_name', 'last_name',
    );
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

  protected function update($values)
  {
    $user    = parent::update($values);
    $tenant  = $this->getEmbeddedForm('tenant')->getObject();
    $account = $this->getEmbeddedForm('account_address')->getObject();
    $invoice = $this->getEmbeddedForm('invoice_address')->getObject();

    $profile = $user->getProfile();
    $profile->setRcTenant($tenant);
    $tenant->setRcAddressRelatedByDefaultAddressId($account);
    $tenant->setRcAddressRelatedByInvoiceAddressId($invoice);

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

    return $user;
  }
}
