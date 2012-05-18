<?php
$menu = array(
  'Start' => array(
    'url' => 'home/index'
  ),
  'Serwery' => array(
    'url' => 'server/index'
  )
);
?>
<ul id="menu">
<?php foreach($menu as $name => $m): ?>
  <li><?php echo link_to($name, $m['url']);?></li>
<?php endforeach; ?>
</ul>
<div class="clear"></div>
