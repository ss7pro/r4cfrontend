<?php

require_once dirname(__FILE__).'/../lib/rc_paymentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/rc_paymentGeneratorHelper.class.php';

/**
 * rc_payment actions.
 *
 * @package    ready4cloud
 * @subpackage rc_payment
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class rc_paymentActions extends autoRc_paymentActions
{
  public function executeShow(sfWebRequest $requiest)
  {
    $this->payment = $this->getRoute()->getObject();
  }

  public function executeInvoice(sfWebRequest $requiest)
  {
    $this->payment = $this->getRoute()->getObject();
    $invoice = $this->payment->getRcInvoice();
    if(!$invoice)
    {
      $service = new InvoiceService();
      $invoice = $service->fromPayment($this->payment);
      $this->payment->setRcInvoice($invoice);
      $this->payment->save();
    }
    $service = new PdfService();
    $pdf = $service->fromInvoice($invoice, 'COPY');

    $service->output($pdf, $invoice->getInvoiceId());
  }
}
