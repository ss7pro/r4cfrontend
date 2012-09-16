<div id="sf_admin_container">
<h1>Payment #<?php echo $payment->getPaymentId();?></h1>
<?php include_partial('global/flashes'); ?>
<div class="btn-bar btn-toolbar">
  <div class="btn-group">
    <a class="btn" href="<?php echo url_for('@rc_payment')?>">&laquo; back</a>
  </div>
  <div class="btn-group">
    <a class="btn" href="<?php echo url_for('@rc_payment_invoice?payment_id=' . $payment->getPaymentId())?>"><?php echo __('PDF Invoice');?></a>
  </div>
</div>
<div class="row">
  <div class="span4">
    <?php include_partial('rc_payment/payment_info', array('payment' => $payment)); ?>
  </div>
  <div class="span4">
    <?php include_partial('rc_payment/transaction_info', array('transaction' => $payment->getRtPayuTransaction())); ?>
    <?php include_partial('rc_payment/transaction_log', array('transaction' => $payment->getRtPayuTransaction())); ?>
  </div>
  <div class="span4">
    <?php include_partial('rc_tenant/tenant_info', array('tenant' => $payment->getRcTenant())); ?>
  </div>
</div>
</div>
