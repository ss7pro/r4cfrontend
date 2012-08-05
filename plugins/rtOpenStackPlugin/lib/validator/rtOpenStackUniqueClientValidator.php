<?php
class rtOpenStackUniqueClientValidator extends sfValidatorSchema
{
  public function __construct($options = array(), $messages = array())
  {
    parent::__construct(null, $options, $messages);
  }

  protected function configure($options = array(), $messages = array())
  {
    $this->addRequiredOption('field');
    $this->setMessage('invalid', 'This account already exist.');
  }

  protected function doClean($values)
  {
    $field = $this->getOption('field');
    if(isset($values[$field]))
    {
      $client = $values[$field];
      $config = rtOpenStackConfig::getConfiguration('admin');
      $cmd = new rtOpenStackCommandClientCheck(array(
        'client' => $client, 
        'auth-token' => $config['auth_token'],
      ));
      $res = $cmd->execute();
      if(isset($res['userId']))
      {
        throw new sfValidatorErrorSchema($this, array(
          'username' => new sfValidatorError($this, 'invalid')
        ));
      }
    }
    return $values;
  }
}
