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
    //$this->tenants = RcTenantQuery::create()->find();

    $this->getResponse()->setContentType('application/json');
    $tenant = $this->getUser()->getProfile()->getRcTenant();
    $payments = RcPaymentQuery::create()
      ->filterByRcTenant($tenant)
      ->leftJoinWithRtPayuTransaction()
      ->leftJoinWithRcInvoice()
      ->find();

    $data = array();
    foreach($payments as $pmt) {
      $p = new PaymentJson($pmt);
      $data[] = $p->toArray();
    }
    return $this->renderText(json_encode($data));
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->invoice = RcInvoiceQuery::create()->findPk($request->getParameter('invoice_id'));
    $this->forward404Unless($this->invoice);
  }

  public function executePdf(sfWebRequest $request)
  {
    $this->invoice = RcInvoiceQuery::create()->findPk($request->getParameter('invoice_id'));
    $this->forward404Unless($this->invoice);

    $config = sfTCPDFPluginConfigHandler::loadConfig();

    $pdf = new sfTCPDF();
     
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(PDF_AUTHOR);

    $msg = 'Ready4Cloud Invoice #' . $this->invoice->getInvoiceId();
    $pdf->SetTitle($msg);
    $pdf->SetSubject($msg);
    $pdf->SetKeywords($msg);

    $title = 'VAT Invoice No.: #' . $this->invoice->getInvoiceId();

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    $pdf->setFontSubsetting(true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    //$pdf->SetFont('dejavusans', '', 12, '', true);
    $pdf->SetFont(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN);
    
    $html = $this->getPartial('invoice_view_pdf');

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1);

    $pdf->Output('ready4cloud_invoice_' . $this->invoice->getInvoiceId() . '.pdf', 'I');
     
    // Stop symfony process
    throw new sfStopException();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->tenant = RcTenantQuery::create()->findPk($request->getParameter('tenant_id'));
    $this->forward404Unless($this->tenant);

    if($request->isMethod(sfRequest::POST))
    {
      $this->generateInvoice($this->tenant);
      $this->redirect('invoice/create?tenant_id=' . $this->tenant->getTenantId());
    }
    else
    {
      $this->invoices = RcInvoiceQuery::create()
        ->filterByRcTenant($this->tenant)
        ->find();
    }
  }

  private function generateInvoice($tenant)
  {
    $addr = $tenant->getRcAddressRelatedByInvoiceAddressId();

    $invoice = new RcInvoice();
    $invoice->setRcTenant($tenant);
    $invoice->setBuyerName((string)$tenant);
    $invoice->setBuyerAddress($addr->getStreet());
    $invoice->setBuyerAddress($addr->getPostCode() . ' ' . $addr->getCity());
    $invoice->setBuyerNip($tenant->getNip());

    $invoice->setSellerName('Ready4Cloud');
    $invoice->setSellerAddress('Legnicka 123');
    $invoice->setSellerCode('12-345 Wrocław');
    $invoice->setSellerNip('123-456-78-90');
    $invoice->setSellerBank('00 1234 5678 9000 0000 0000 1234');

    $invoice->setIssueAt(time());
    $invoice->setSaleAt(time());
    $invoice->setPaymentDate(time());

    $item = new RcInvoiceItem();
    $item->setName('Sample Service');
    $item->setQty(1);
    $item->setTaxRate(23);
    $item->setPrice(100.15);
    $item->calcCosts();
    $invoice->addRcInvoiceItem($item);

    $item = new RcInvoiceItem();
    $item->setName('Another Service');
    $item->setQty(2);
    $item->setTaxRate(23);
    $item->setPrice(199.99);
    $item->calcCosts();
    $invoice->addRcInvoiceItem($item);

    $invoice->save();
  }
}
