<div id="sf_admin_container">
<h1>Payment #<?php echo $payment->getPaymentId();?></h1>
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
