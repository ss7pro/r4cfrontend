<h1>Tenants</h1>
<ul>
  <?php foreach($tenants as $t): ?>
    <li><?php echo link_to($t, 'invoice/create?tenant_id=' . $t->getTenantId()); ?></li>
  <?php endforeach; ?>
</ul>
