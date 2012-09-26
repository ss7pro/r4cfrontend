<style type="text/css">
.invoice-view { width: 800px; margin: 0 auto; }
.invoice-view .wide { width: 100%; }
.invoice-view table.bordered { border-collapse: collapse; }
.invoice-view table.bordered th,
.invoice-view table.bordered td { border: 1px solid #CCC; }
</style>
<div class="invoice-view">
  <?php include_partial('global/invoice', array('invoice' => $invoice, 'version' => 'ORIGINAL')); ?>
</div>
