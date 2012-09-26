<?php



/**
 * Skeleton subclass for representing a row from the 'rc_payment' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.6.5-dev on:
 *
 * Fri Jul 20 22:58:57 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.lib.model
 */
class RcPayment extends BaseRcPayment
{
  public function getPrice()
  {
    return sprintf('%.2f', round($this->getAmount() / 100, 2));
  }

  public function getBuyerName()
  {
    return trim(sprintf('%s %s %s', $this->getCompanyName(), $this->getFirstName(), $this->getLastName()));
  }

  public function getStatus()
  {
    $transaction = $this->getRtPayuTransaction();
    return $transaction ? $transaction->getStatus() : 0;
  }

  public function getStatusLabel()
  {
    return RtPayuTransactionPeer::getStatusLabel($this->getStatus());
  }

  public function isPaid()
  {
    return $this->getStatus() == 99;
  }

  public function getInvoiceUrl()
  {
    if(!$this->getInvoiceId()) return null;
    return sprintf('/invoice/%d/%s', $this->getPaymentId(), $this->getToken());
  }

  public function getToken()
  {
    return sha1(sprintf('%d:%d:%s:%d', 
      $this->getPaymentId(), 
      $this->getTenantId(), 
      $this->getTenantApiId(), 
      $this->getInvoiceId()
    ));
  }

  public function validateToken($token)
  {
    return $this->getToken() == $token;
  }
} // RcPayment
