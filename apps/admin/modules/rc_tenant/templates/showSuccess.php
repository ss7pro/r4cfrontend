<div id="sf_admin_container">
<h1>Tenant: <?php echo $tenant;?></h1>
<?php include_partial('global/flashes'); ?>
<div class="row">
  <div class="span4">
    <?php include_partial('rc_tenant/tenant_info', array('tenant' => $tenant)); ?>
    <?php include_partial('rc_tenant/address', array('address' => $tenant->getRcAddressRelatedByDefaultAddressId(), 'title' => 'Contact address')); ?>
    <?php include_partial('rc_tenant/address', array('address' => $tenant->getRcAddressRelatedByInvoiceAddressId(), 'title' => 'Invoice address')); ?>
  </div>
  <div class="span9">
    <?php include_partial('rc_tenant/payment_list', array('payments' => $tenant->getPayments())); ?>
  </div>
</div>
</div>
