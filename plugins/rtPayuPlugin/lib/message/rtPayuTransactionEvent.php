<?php
class rtPayuTransactionEvent
{
  private $pos_id;
  private $session_id;
  private $ts;
  private $sig;

  public function __construct($pos_id, $session_id, $ts, $sig)
  {
    $this->pos_id = $pos_id;
    $this->session_id = $session_id;
    $this->ts = $ts;
    $this->sig = $sig;
  }

  public static function createFromRequest(sfRequest $r)
  {
    return new self(
      $r->getParameter('pos_id'),
      $r->getParameter('session_id'),
      $r->getParameter('ts'),
      $r->getParameter('sig')
    );
  }

  public function __toString()
  {
    $vars = get_object_vars($this);
    $vars['valid'] = $this->isValid();
    return json_encode($vars);
  }

  public function getPosId()
  {
    return $this->pos_id;
  }

  public function getSessionId()
  {
    return $this->session_id;
  }

  public function getTimestamp()
  {
    return $this->ts;
  }

  public function isValid()
  {
    return $this->sig == $this->makeSig();
  }

  private function makeSig()
  {
    $key = rtPayuConfig::instance()->getOption('verify_key', $this->pos_id);
    return md5($this->pos_id . $this->session_id . $this->ts . $key);
  }
}
