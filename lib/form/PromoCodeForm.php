<?php
class PromoCodeForm extends BaseForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'tenant_id'  => new sfWidgetFormInputText(),
      'code'       => new sfWidgetFormInputText(),
      'token'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'tenant_id'  => new sfValidatorString(array('max_length' => 32, 'required' => true)),
      'code'       => new sfValidatorString(array('max_length' => 16, 'required' => true)),
      'token'      => new sfValidatorString(array('max_length' => 32, 'required' => true)),
    ));

    $this->localCSRFSecret = false;

    $this->getValidatorSchema()->setPostValidator(new PromoCodeValidator(array('code_field' => 'code')));
    $this->mergePostValidator(new RcTenantExistsValidator(array('tenant_field' => 'tenant_id')));
    $this->getValidatorSchema()->setOption('allow_extra_fields', true);
    $this->getValidatorSchema()->setOption('filter_extra_fields', false);
  }

  public function getRcPromoCode()
  {
    return $this->getValue('code_object');
  }

  public function getRcTenant()
  {
    return $this->getValue('tenant_object');
  }

  public function save($con = null)
  {
    $con = $con ? $con : Propel::getConnection();
    try {
      $con->beginTransaction();

      $tenant = $this->getRcTenant();
      $code = $this->getRcPromoCode();
      $code->setUsedAt(time());
      $code->setRcTenant($tenant);

      $code->save($con);

      $client = rtOpenStackClient::factory();
      $config = rtOpenStackConfig::getConfiguration('topup');
      $c = new rtOpenStackCommandAuth(array(
        'user'        => $config['user'],
        'pass'        => $config['pass'],
        'tenant-name' => $config['tenant_name'],
      ));
      $c->execute($client);

      if(!$client->getSession()->isAuthenticated()) {
        throw new InvalidArgumentException('Invalid username or password');
      }

      $c = new rtOpenStackCommandClientTopup(array(
        'tenant_id' => $tenant->getApiId(),
        'amount'    => $code->getValue(),
        'reference' => array('source' => 'r4cfrontend'),
      ));
      $c->execute($client);

      $con->commit();
    } catch(Exception $e) {
      $con->rollBack();
      throw $e;
    }
    return $code;
  }
}
