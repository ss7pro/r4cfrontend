<h1><?php echo _('Server List'); ?></h1>

<table>
<thead>
<tr>
  <th>id</th>
  <th>name</th>
  <th>progress</th>
  <th>status</th>
  <th>falvor</th>
  <th>image</th>
  <th>created</th>
  <th>updated</th>
</tr>
</thead>
<tbody>
<?php foreach($servers as $s): ?>
<tr>
  <td><?php echo $s['id'];?></td>
  <td><?php echo $s['name'];?></td>
  <td><?php echo $s['progress'];?></td>
  <td><?php echo $s['status'];?></td>
  <td><?php echo $s['flavor']['id'];?></td>
  <td><?php echo $s['image']['id'];?></td>
  <td><?php echo $s['created'];?></td>
  <td><?php echo $s['updated'];?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<pre>
<?php //print_r($servers->getRawValue()); ?>
</pre>
