<?php
class rtPayuTransactionMessage
{
  private $data = array();
  private $status;

  public function __construct($xml)
  {
    if(!isset($xml->status)) throw new InvalidArgumentException('Invalid response structure');
    if(!isset($xml->trans))  throw new InvalidArgumentException('Invalid response structure');
    $this->status = $xml->status;
    foreach($xml->trans->children() as $name => $node)
    {
      $this->data[$name] = (string)$node;
    }
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function get($name)
  {
    return @$this->data[$name];
  }

  public function __toString()
  {
    return json_encode(array_merge(
      $this->data, 
      array('valid' => $this->isValid(), 'status' => $this->status)
    ));
  }

  public function isValid()
  {
    return $this->get('sig') == $this->makeSig();
  }

  private static $sig_fields = array(
    'pos_id', 'session_id', 'order_id', 'status', 'amount', 'desc', 'ts'
  );

  private function makeSig()
  {
    $key = rtPayuConfig::instance()->getOption('verify_key', $this->get('pos_id'));
    $str = '';
    foreach(self::$sig_fields as $field)
    {
      $str .= $this->get($field);
    }
    return md5($str . $key);
  }
}
