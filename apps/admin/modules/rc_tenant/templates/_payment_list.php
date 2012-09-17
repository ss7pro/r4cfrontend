<?php use_helper('Number', 'Date'); ?>
<table class="wide">
  <thead>
    <tr>
      <th>Id</th>
      <th>Date</th>
      <th>Description</th>
      <th>Amount</th>
      <th>Status</th>
      <th>Invoice</th>
      <th class="wide5">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($payments as $p): ?>
    <tr class="payment-row payment-status-<?php echo strval($p->getStatus()); ?>">
      <td><?php echo $p->getPaymentId(); ?></td>
      <td><?php echo format_datetime($p->getCreatedAt(), 'f'); ?></td>
      <td><?php echo $p->getDesc(); ?></td>
      <td><?php echo format_currency($p->getPrice(), sfConfig::get('app_currency_symbol', 'zł')); ?></td>
      <td><?php echo __($p->getStatusLabel()) . ' (' . $p->getStatus() . ')';?></td>
      <td><?php echo $p->getInvoiceId() ? image_tag('tick.png') : ''; ?></td>
      <td class="wide5">
        <div class="btn-group">
          <a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#"><?php echo __('Actions'); ?><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><?php echo link_to(__('Show payment details'), '@rc_payment_show?payment_id=' . $p->getPaymentId(), array('target' => '_blank')); ?></li>
            <?php if($p->getInvoiceId()): ?>
              <li><?php echo link_to(__('Get invoice copy'), '@rc_payment_invoice?type=copy&payment_id=' . $p->getPaymentId(), array()); ?></li>
              <li><?php echo link_to(__('Get invoice original'), '@rc_payment_invoice?payment_id=' . $p->getPaymentId(), array()); ?></li>
              <li><?php echo link_to(__('Send invoice to customer'), '@rc_payment_invoice_send?payment_id=' . $p->getPaymentId(), array('class' => 'invoice_send', 'data-email' => $p->getEmail())); ?></li>
            <?php elseif($p->isPaid()): ?>
              <li><?php echo link_to(__('Generate invoice'), '@rc_payment_invoice_create?payment_id=' . $p->getPaymentId(), array('class' => 'invoice_create')); ?></li>
            <?php endif; ?>
          </ul>
        </div>
      </td>
    </tr>
    <?php endforeach; ?>
  </body>
</table>
<script type="text/javascript">
$(function(){
  $('a.invoice_create').click(function(e) {
    e.preventDefault();
    $.post(this.href, function(data) {
      window.location.reload();
    }).error(function(xhr, status, msg){
      window.location.reload();
    });
  });
});
</script>

