<h1>Create</h1>
<?php echo form_tag('invoice/create?tenant_id=' . $tenant->getTenantId()); ?>
  <?php echo link_to('back', 'invoice/index'); ?>
  <input type="submit" value="generate new"/>
</form>
<h1>Invoices</h1>
<ul>
  <?php foreach($invoices as $i): ?>
    <li>
      <?php echo link_to($i, 'invoice/show?invoice_id=' . $i->getInvoiceId()); ?> | 
      <?php echo link_to('pdf', 'invoice/pdf?invoice_id=' . $i->getInvoiceId()); ?>
    </li>
  <?php endforeach; ?>
</ul>
