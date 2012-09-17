<?php use_helper('Number'); ?>
<style type="text/css">
.align-right { text-align: right; }
.center { text-align: center; }
.bold { font-weight: bold; }
</style>
<table cellpadding="0" class="top wide">
  <tr>
    <td style="width: 40%;">

      <h3><?php echo mb_strtoupper(__('Seller'), sfConfig::get('sf_charset', 'utf-8')); ?></h3>
      <?php echo $invoice->getSellerName();?><br/>
      <?php echo $invoice->getSellerAddress();?><br/>
      <?php echo $invoice->getSellerCode();?><br/>
      <?php echo __('Tax ID'); ?>: <?php echo $invoice->getSellerNip();?><br/>
      <?php echo __('Account No.'); ?>: <?php echo $invoice->getSellerBank();?>
      <h3><?php echo mb_strtoupper(__('Buyer'), sfConfig::get('sf_charset', 'utf-8')); ?></h3>
      <?php echo $invoice->getBuyerName();?><br/>
      <?php echo $invoice->getBuyerAddress();?><br/>
      <?php echo $invoice->getBuyerCode();?><br/>
      <?php echo $invoice->getBuyerNip() ? __('Tax ID') . ': ' . $invoice->getBuyerNip() : '';?>

    </td>
    <td class="align-right" style="width: 60%;">

      <h1><?php echo __('VAT Invoice'); ?> <?php echo __('No'); ?>: <?php echo $invoice->getInvoiceId(); ?>/<?php echo date('Y'); ?></h1>
      <b><?php echo __($version); ?></b><br/><br/>
      <table class="wide" cellpadding="2">
        <tr>
          <th style="width: 70%" class="align-right"><?php echo __('Issue date'); ?>:</th>
          <td style="width: 30%" class="bold"><?php echo $invoice->getIssueAt();?> </td>
        </tr>
        <tr>
          <th class="align-right"><?php echo __('Sale date'); ?>: </th>
          <td class="bold"><?php echo $invoice->getSaleAt();?></td>
        </tr>
      </table>

    </td>
  </tr>
</table>

<table border="0.3" cellpadding="2" class="bordered">
<thead>
  <tr>
    <th style="width: 4%;" class="center"><?php echo __('No.');?></th>
    <th style="width: 35%;"><?php echo __('Description');?></th>
    <th style="width: 6%;" class="center"><?php echo __('Qty');?></th>
    <th style="width: 9%;" class="center"><?php echo __('Net Price');?></th>
    <th style="width: 9%;" class="center"><?php echo __('Gross Price');?></th>
    <th style="width: 9%;" class="center"><?php echo __('Net Cost');?></th>
    <th style="width: 9%;" class="center"><?php echo __('Tax Rate');?></th>
    <th style="width: 9%;" class="center"><?php echo __('Tax Cost');?></th>
    <th style="width: 10%;" class="center"><?php echo __('Gross Cost');?></th>
  </tr>
</thead>
<tbody>
  <?php foreach($invoice->getRcInvoiceItems() as $i => $item): ?>
  <tr>
    <td style="width: 4%;" class="center"><?php echo ++$i; ?></td>
    <td style="width: 35%;"><?php echo $item->getName(); ?></td>
    <td style="width: 6%;" class="center"><?php echo $item->getQty(); ?></td>
    <td style="width: 9%;" class="align-right"><?php echo format_currency($item->getNetPrice()); ?></td>
    <td style="width: 9%;" class="align-right"><?php echo format_currency($item->getPrice()); ?></td>
    <td style="width: 9%;" class="align-right"><?php echo format_currency($item->getNetto()); ?></td>
    <td style="width: 9%;" class="align-right"><?php echo $item->getTaxRate(); ?>%</td>
    <td style="width: 9%;" class="align-right"><?php echo format_currency($item->getTax()); ?></td>
    <td style="width: 10%;" class="align-right"><?php echo format_currency($item->getCost()); ?></td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

<br/>&nbsp;<br/>

<table cellpadding="0" class="wide">
  <tr>
    <td style="width: 30%;">

      <h4 class="center"><?php echo __('Payment information'); ?></h4>
      <table cellpadding="2" class="wide">
        <tr>
          <th class="align-right"><?php echo __('Status'); ?>: </th>
          <td class="bold"><?php echo __('Paid'); ?></td>
        </tr>
        <tr>
          <th class="align-right"><?php echo __('Form'); ?>: </th>
          <td class="bold"><?php echo __('Transfer'); ?></td>
        </tr>
        <tr>
          <th class="align-right"><?php echo __('Date'); ?>: </th>
          <td class="bold"><?php echo $invoice->getPaymentDate();?></td>
        </tr>
        <tr>
          <th class="align-right"><?php echo __('Total Payment'); ?>:</th>
          <td class="bold"><?php echo format_currency($invoice->getTotalCost()); ?> PLN</td>
        </tr>
      </table>

    </td>
    <td style="width: 40%;">
      &nbsp;
    </td>
    <td style="width: 30%;">

      <h4 class="center"><?php echo __('Summary'); ?></h4>
      <table cellpadding="2" class="wide">
        <tr>
          <th class="align-right"><?php echo __('Net Cost'); ?>:</th>
          <td class="bold"><?php echo format_currency($invoice->getTotalNetto()); ?></td>
        </tr>
        <tr>
          <th class="align-right"><?php echo __('Tax Cost'); ?>:</th>
          <td class="bold"><?php echo format_currency($invoice->getTotalTax()); ?></td>
        </tr>
        <tr>
          <th class="align-right"><?php echo __('Gross Cost'); ?>:</th>
          <td class="bold"><?php echo format_currency($invoice->getTotalCost()); ?></td>
        </tr>
      </table>

    </td>
  </tr>
</table>

<h1>&nbsp;</h1>

<table cellpadding="0" class="wide">
  <tr>
    <td class="center">
      <?php echo __('Issued by'); ?>
    </td>
    <td class="center">
      <?php echo __('Received by'); ?>
    </td>
  </tr>
</table>

