<?php use_helper('Number'); ?>
<div class="invoice-view">
<table class="wide">
  <tr>
    <td>

      <table class="wide info">
        <tr>
          <td>
            <h3><?php echo strtoupper(_('Seller')); ?></h3>
            <?php echo $invoice->getSellerName();?><br/>
            <?php echo $invoice->getSellerAddress();?><br/>
            <?php echo $invoice->getSellerCode();?><br/>
            <?php echo _('IDN'); ?>: <?php echo $invoice->getSellerNip();?><br/>
            <?php echo _('Bank'); ?>: <?php echo $invoice->getSellerBank();?>
          </td>
        </tr>
        <tr>
          <td>
            <h3><?php echo strtoupper(_('Buyer')); ?></h3>
            <?php echo $invoice->getBuyerName();?><br/>
            <?php echo $invoice->getBuyerAddress();?><br/>
            <?php echo $invoice->getBuyerCode();?><br/>
            <?php echo $invoice->getBuyerNip() ? _('IDN') . ': ' . $invoice->getBuyerNip() : '';?>
          </td>
        </tr>
      </table>
    
    </td>
    <td>

      <h1 class="right">
        <?php echo _('VAT Invoice'); ?>
        <?php echo _('No'); ?>: #<?php echo $invoice->getInvoiceId(); ?>
      </h1>
      <div class="clear"></div>
      <table class="right">
        <tr>
          <th><?php echo _('Issue date'); ?></th>
          <td><?php echo $invoice->getIssueAt();?></td>
        </tr>
        <tr>
          <th><?php echo _('Sale date'); ?></th>
          <td><?php echo $invoice->getSaleAt();?></td>
        </tr>
        <tr>
          <th><?php echo _('Payment date'); ?></th>
          <td><?php echo $invoice->getSaleAt();?></td>
        </tr>
      </table>

    </td>
  </tr>
</table>

<br/>

<table class="wide bordered">
<thead>
  <tr>
    <th><?php echo _('No.');?></th>
    <th><?php echo _('Description');?></th>
    <th><?php echo _('Quantity');?></th>
    <th><?php echo _('Unit Price');?></th>
    <th><?php echo _('Net');?></th>
    <th><?php echo _('Tax Rate');?></th>
    <th><?php echo _('Tax');?></th>
    <th><?php echo _('Gross');?></th>
  </tr>
</thead>
<tbody>
  <?php foreach($invoice->getRcInvoiceItems() as $i => $item): ?>
  <tr>
    <td class="center"><?php echo ++$i; ?></td>
    <td><?php echo $item->getName(); ?></td>
    <td class="center"><?php echo $item->getQty(); ?></td>
    <td class="align-right"><?php echo format_currency($item->getUnitPrice()); ?></td>
    <td class="align-right"><?php echo format_currency($item->getNetto()); ?></td>
    <td class="align-right"><?php echo $item->getTaxRate(); ?>%</td>
    <td class="align-right"><?php echo format_currency($item->getTax()); ?></td>
    <td class="align-right"><?php echo format_currency($item->getCost()); ?></td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

<br/>&nbsp;<br/>

<table class="summary right">
  <tr>
    <th><?php echo _('Net'); ?></th>
    <td><?php echo format_currency($invoice->getTotalNetto()); ?></td>
  </tr>
  <tr>
    <th><?php echo _('Tax'); ?></th>
    <td><?php echo format_currency($invoice->getTotalTax()); ?></td>
  </tr>
  <tr>
    <th><?php echo _('Gross'); ?></th>
    <td><?php echo format_currency($invoice->getTotalCost()); ?></td>
  </tr>
</table> 
<div class="clear"></div>
</div>
