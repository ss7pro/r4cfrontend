<?php
$menu = array(
  'Ready4cloud' => array(
    'url' => '@homepage'
  ),
  'Profil' => array(
    'url' => '@profilepage'
  ),
  'Serwery' => array(
    'url' => 'server/index'
  ),
  'Dyski' => array(
    'url' => 'drive/index'
  ),
  'Firewall' => array(
    'url' => 'firewall/index'
  ),
  'Loadbalancer' => array(
    'url' => 'loadbalance/index'
  ),
  'Platnosci' => array(
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
