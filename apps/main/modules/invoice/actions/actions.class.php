<?php

/**
 * invoice actions.
 *
 * @package    ready4cloud
 * @subpackage invoice
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class invoiceActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $tenant = $this->getUser()->getProfile()->getRcTenant();
    $payments = RcPaymentQuery::create()
      ->filterByRcTenant($tenant)
      ->leftJoinWithRtPayuTransaction()
      ->leftJoinWithRcInvoice()
      ->orderByPaymentId(Criteria::DESC)
      ->find();

    $data = array();
    foreach($payments as $pmt) {
      $p = new PaymentJson($pmt);
      $data[] = $p->toArray();
    }
    return $this->renderResponse(new JSONResponse($data));
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->payment = RcPaymentQuery::create()->findPk($request->getParameter('payment_id'));
    $this->forward404Unless($this->payment);
    $this->forward404Unless($this->payment->validateToken($request->getParameter('token')));

    $this->invoice = $this->payment->getRcInvoice();
    $this->forward404Unless($this->invoice);

    sfConfig::set('sf_web_debug', false);

    if($request->getRequestFormat() == 'pdf')
    {
      $request->setRequestFormat('html');
      $service = new PdfService();
      $pdf = $service->fromInvoice($this->invoice, 'ORIGINAL');
      $request->setRequestFormat('pdf');
      $service->output($pdf, $this->invoice->getInvoiceId());
    }

    $this->setLayout('invoice');
  }
}
