<div class="invoice-view">
<?php include_partial('invoice_view_pdf', array('invoice' => $invoice)); ?>
</div>
<?php echo link_to('pdf', 'invoice/pdf?invoice_id=' . $invoice->getInvoiceId()); ?>
