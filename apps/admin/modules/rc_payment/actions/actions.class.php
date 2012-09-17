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
  public function executeShow(sfWebRequest $request)
  {
    $this->payment = $this->getRoute()->getObject();
  }

  public function executeInvoice_send(sfWebRequest $request)
  {
    $this->payment = $this->getRoute()->getObject();
    $this->forward404Unless(false); //TODO: implement;
  }

  public function executeInvoice_create(sfWebRequest $request)
  {
    $payment = $this->getRoute()->getObject();
    try
    {
      $invoice = $payment->getRcInvoice();
      if(!$invoice)
      {
        $service = new InvoiceService();
        $invoice = $service->fromPayment($payment);
        $payment->setRcInvoice($invoice);
        $payment->save();
        $this->getUser()->setFlash('notice', 'Invoice created sucessfully');
      }
    }
    catch(Exception $e)
    {
      $this->getUser()->setFlash('error', 'Error appear during invoice creation');
      $msg = get_class($e) . ': ' . $e->getMessage();
      $this->getLogger()->err($msg);
      return $this->renderResponse(new JSONResponse(array('status' => 'FAIL', 'message' => $msg), 500));
    }

    return $this->renderResponse(new JSONResponse(array('status' => 'OK')));
  }

  public function executeInvoice(sfWebRequest $request)
  {
    $payment = $this->getRoute()->getObject();
    $invoice = $payment->getRcInvoice();
    $this->forward404Unless($invoice);

    $type = trim(strtoupper($request->getParameter('type', 'ORIGINAL')));

    $service = new PdfService();
    $pdf = $service->fromInvoice($invoice, $type);

    $service->output($pdf, $invoice->getInvoiceId());
  }
}
