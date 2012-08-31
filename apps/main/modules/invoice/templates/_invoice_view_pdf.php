<?php use_helper('Number'); ?>
<style type="text/css">
.right { text-align: right; }
.center { text-align: center; }
.bold { font-weight: bold; }
.dates th { text-align: right; }
.dates td { font-weight: bold; }
</style>
<table cellpadding="0">
  <tr>
    <td style="width: 50%;">

      <h3><?php echo strtoupper(_('Seller')); ?></h3>
      <?php echo $invoice->getSellerName();?><br/>
      <?php echo $invoice->getSellerAddress();?><br/>
      <?php echo $invoice->getSellerCode();?><br/>
      <?php echo _('IDN'); ?>: <?php echo $invoice->getSellerNip();?><br/>
      <?php echo _('Bank'); ?>: <?php echo $invoice->getSellerBank();?>
      <h3><?php echo strtoupper(_('Buyer')); ?></h3>
      <?php echo $invoice->getBuyerName();?><br/>
      <?php echo $invoice->getBuyerAddress();?><br/>
      <?php echo $invoice->getBuyerCode();?><br/>
      <?php echo $invoice->getBuyerNip() ? _('IDN') . ': ' . $invoice->getBuyerNip() : '';?></td>
    <td class="right" style="width: 50%;">

      <h1>
        <?php echo _('VAT Invoice'); ?>
        <?php echo _('No'); ?>: #<?php echo $invoice->getInvoiceId(); ?>
      </h1>
      <table class="dates" cellpadding="2">
        <tr>
          <th style="width: 70%"><?php echo _('Issue date'); ?>:</th>
          <td style="width: 30%"><?php echo $invoice->getIssueAt();?> </td>
        </tr>
        <tr>
          <th class="right"><?php echo _('Sale date'); ?>: </th>
          <td><?php echo $invoice->getSaleAt();?></td>
        </tr>
      </table>

    </td>
  </tr>
</table>

<table border="0.3" cellpadding="2">
<thead>
  <tr>
    <th style="width: 5%; text-align: center;"><?php echo _('No.');?></th>
    <th style="width: 42%;"><?php echo _('Description');?></th>
    <th style="width: 5%; text-align: center;"><?php echo _('Qty');?></th>
    <th style="width: 10%; text-align: center;"><?php echo _('Unit Price');?></th>
    <th style="width: 10%; text-align: center;"><?php echo _('Net');?></th>
    <th style="width: 7%; text-align: center;"><?php echo _('Tax Rate');?></th>
    <th style="width: 10%; text-align: center;"><?php echo _('Tax');?></th>
    <th style="width: 11%; text-align: center;"><?php echo _('Gross');?></th>
  </tr>
</thead>
<tbody>
  <?php foreach($invoice->getRcInvoiceItems() as $i => $item): ?>
  <tr>
    <td style="width: 5%; text-align: center;"><?php echo ++$i; ?></td>
    <td style="width: 42%;"><?php echo $item->getName(); ?></td>
    <td style="width: 5%; text-align: center;"><?php echo $item->getQty(); ?></td>
    <td style="width: 10%; text-align: right;"><?php echo format_currency($item->getUnitPrice()); ?></td>
    <td style="width: 10%; text-align: right;"><?php echo format_currency($item->getNetto()); ?></td>
    <td style="width: 7%; text-align: right;"><?php echo $item->getTaxRate(); ?>%</td>
    <td style="width: 10%; text-align: right;"><?php echo format_currency($item->getTax()); ?></td>
    <td style="width: 11%; text-align: right;"><?php echo format_currency($item->getCost()); ?></td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

<table cellpadding="0">
  <tr>
    <td style="width: 30%;">

      <h4><?php echo _('Payment Information'); ?></h4>
      <table cellpadding="2">
        <tr>
          <th class="right"><?php echo _('Status'); ?>: </th>
          <td class="bold"><?php echo _('Paid'); ?></td>
        </tr>
        <tr>
          <th class="right"><?php echo _('Form'); ?>: </th>
          <td class="bold"><?php echo _('Transfer'); ?></td>
        </tr>
        <tr>
          <th class="right"><?php echo _('Date'); ?>: </th>
          <td class="bold"><?php echo $invoice->getPaymentDate();?></td>
        </tr>
        <tr>
          <th class="right"><?php echo _('Total'); ?>:</th>
          <td class="bold"><?php echo format_currency($invoice->getTotalCost()); ?> PLN</td>
        </tr>
      </table>

    </td>
    <td style="width: 50%;">
      &nbsp;
    </td>
    <td style="width: 20%;">

      <h4 class="center;"><?php echo _('Summary'); ?></h4>
      <table cellpadding="2">
        <tr>
          <th class="right"><?php echo _('Net'); ?>:</th>
          <td class="bold"><?php echo format_currency($invoice->getTotalNetto()); ?></td>
        </tr>
        <tr>
          <th class="right"><?php echo _('Tax'); ?>:</th>
          <td class="bold"><?php echo format_currency($invoice->getTotalTax()); ?></td>
        </tr>
        <tr>
          <th class="right"><?php echo _('Gross'); ?>:</th>
          <td class="bold"><?php echo format_currency($invoice->getTotalCost()); ?></td>
        </tr>
      </table>

    </td>
  </tr>
</table>

