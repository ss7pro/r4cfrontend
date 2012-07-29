<?php
class rtPayuConnector
{
  public static function instance()
  {
    static $instance = null;
    if($instance === null) {
      $instance = new self();
    }
    return $instance;
  }

  public function getStatusByEvent(rtPayuTransactionEvent $e)
  {
    return $this->getStatus($e->getPosId(), $e->getSessionId());
  }

  public function getStatus($pos_id, $session_id)
  {
    $ts = time();
    $sig = $this->makeSig($pos_id, $session_id, $ts);
    $key = rtPayuConfig::instance()->getOption('sign_key', $pos_id);
    $params = array(
      'pos_id'     => $pos_id,
      'session_id' => $session_id,
      'ts'         => $ts,
      'sig'        => $sig,
    );
    $url = rtPayuConfig::instance()->getPaymentStatusUrl($pos_id);
    $browser = new sfWebBrowser();
    $browser->post($url, $params);

    $xml = $browser->getResponseXML();
    return new rtPayuTransactionMessage($xml);
  }

  private function makeSig($pos_id, $session_id, $ts)
  {
    $key = rtPayuConfig::instance()->getOption('sign_key', $pos_id);
    return md5($pos_id . $session_id . $ts . $key);
  }
}
