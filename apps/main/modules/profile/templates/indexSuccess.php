<h1><?php echo __('Profile page');?></h1>
<h3><?php echo __('Account');?></h3>
<?php echo link_to(__('Edit profile'), 'profile/edit'); ?>
<h3><?php echo __('Servers');?></h3>
<?php echo link_to(__('Manage servers'), 'server/index'); ?>
<h3><?php echo __('Disks');?></h3>
<?php echo link_to(__('Manage disks'), 'disk/index'); ?>
<h3><?php echo __('Firewall');?></h3>
<?php echo link_to(__('Manage firewall'), 'firewall/index'); ?>
<h3><?php echo __('Loadbalancer');?></h3>
<?php echo link_to(__('Manage loadbalancer'), 'loadbalance/index'); ?>
<h3><?php echo __('Payments');?></h3>
<?php echo link_to(__('Show payments'), 'payment/index'); ?>
