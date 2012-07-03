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

      $tenant->setApiId($response['user']['tenantId']);
      $tenant->setApiName($response['user']['name']);

      $user->save($con);

      $con->commit();

      return array($user, $response);

    } catch(Exception $e) {
      $con->rollBack();
      //echo $e->getTraceAsString(); exit;
      throw $e;
    }
  }

  public function getAllErrors()
  {
    $errors = array('global' => array());
    foreach($this->getGlobalErrors() as $name => $error) {
      $errors['global'][$name] = (string)$error;
    }
    $errors['fields'] = $this->unnestErrors($this->getErrorSchema(), 'registration');
    return $errors;
  }

  protected function unnestErrors($errors, $prefix = '')
  {
    $newErrors = array();

    foreach ($errors as $name => $error)
    {
      if ($error instanceof ArrayAccess || is_array($error))
      {
        $newErrors = array_merge($newErrors, $this->unnestErrors($error, ($prefix ? $prefix . '[' . $name . ']' : $name)));
      }
      else
      {
        if ($error instanceof sfValidatorError)
        {
          $err = $this->translate($error->getMessageFormat(), $error->getArguments());
        }
        else
        {
          $err = $this->translate($error);
        }

        if (!is_integer($name))
        {
          $n = $prefix ? $prefix . '[' . $name . ']' : $name;
          $newErrors[$n] = (string)$err;
        }
        else
        {
          $newErrors[] = (string)$err;
        }
      }
    }

    return $newErrors;
  }

  public function translate($subject, $parameters = array())
  {
    if (false === $subject)
    {
      return false;
    }

    foreach ($parameters as $key => $value)
    {
      if (is_object($value) && method_exists($value, '__toString'))
      {
        $parameters[$key] = $value->__toString();
      }
    }

    return strtr($subject, $parameters);

  }

  public function getNamedErrorRowFormatInARow()
  {
    return "%name% %error%";
  }

  public function getErrorRowFormatInARow()
  {
    return "%error%";
  }

}
