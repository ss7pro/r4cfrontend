<table class="wide">
  <thead>
    <tr><th colspan="2"><?php echo __(isset($title) ? $title : 'Address');?></th></tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo __('Street'); ?></td>
      <td><?php echo $address->getStreet(); ?></td>
    </tr>
    <tr>
      <td><?php echo __('Post code'); ?></td>
      <td><?php echo $address->getPostCode(); ?></td>
    </tr>
    <tr>
      <td><?php echo __('City'); ?></td>
      <td><?php echo $address->getCity(); ?></td>
    </tr>
    <tr>
      <td><?php echo __('Phone'); ?></td>
      <td><?php echo $address->getPhone(); ?></td>
    </tr>
  </tbody>
</table>
