<table class="wide">
  <thead>
    <tr>
      <th><?php echo __('Log id');?></th>
      <th><?php echo __('Date');?></th>
      <th><?php echo __('Status');?></th>
      <th><?php echo __('Data');?></th>
    </tr>
  </thead>
  <tbody>
    <?php $logs = $transaction->getLogs(); ?>
    <?php foreach($logs as $log): ?>
    <tr>
      <td><?php echo $log->getLogId();?></td>
      <td><?php echo $log->getCreatedAt();?></td>
      <td><?php echo __($log->getStatusLabel()) . ' (' . $log->getStatus() . ')';?></td>
      <td><a href="#" rel="tooltip" title="<?php echo $log->getMessage();?>"><?php echo __('View'); ?></a></td>
    </tr>
    <?php endforeach; ?>
    <?php if(!count($logs)): ?>
      <tr><td colspan="4"><?php echo __('No results');?></td></tr>
    <?php endif; ?>
  </tbody>
</table>
<script type="text/javascript">
$(function() { $('[rel="tooltip"]').tooltip(); });
</script>
