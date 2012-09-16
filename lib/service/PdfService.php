<?php
class PdfService
{
  /**
   * @return sfTCPDF
   */
  public function fromInvoice(RcInvoice $invoice, $version = 'ORIGINAL')
  {
    $config = sfTCPDFPluginConfigHandler::loadConfig();
    $pdf = new sfTCPDF();
    $i18n = sfContext::getInstance()->getI18N();

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor(PDF_AUTHOR);

    $msg = 'Ready4Cloud #' . $invoice->getInvoiceId();
    $pdf->SetTitle($msg);
    $pdf->SetSubject($msg);
    $pdf->SetKeywords($msg);

    $title = $i18n->__('VAT Invoice') . ' ' . $i18n->__('No') . ': #' . $invoice->getInvoiceId();

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
    
    $html = $this->getPartial('global/invoice', array('invoice' => $invoice, 'version' => $version));

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1);

    return $pdf;
  }

  public function getPartial($template, $vars)
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
    return get_partial($template, $vars);
  }

  public function output(sfTCPDF $pdf, $id)
  {
    $pdf->Output('ready4cloud_invoice_' . $id . '.pdf', 'I');
     
    // Stop symfony process
    throw new sfStopException();
  }
}

