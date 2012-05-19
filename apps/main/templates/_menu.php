<?php
$menu = array(
  __('Ready4Cloud') => array(
    'url' => '@homepage'
  ),
  __('My Profile') => array(
    'url' => '@profilepage'
  ),
  __('Servers') => array(
    'url' => 'server/index'
  ),
  __('Disks') => array(
    'url' => 'drive/index'
  ),
  __('Firewall') => array(
    'url' => 'firewall/index'
  ),
  __('Load Balancer') => array(
    'url' => 'loadbalance/index'
  ),
  __('Payments') => array(
    'url' => 'payment/index'
  ),
);
?>
<ul id="menu">
<?php foreach($menu as $name => $m): ?>
  <li><?php echo link_to($name, $m['url']);?></li>
<?php endforeach; ?>
</ul>
<div class="clear"></div>
