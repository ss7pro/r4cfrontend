<table>
  <thead>
    <tr><th colspan="2"><?php echo __('Tenant information');?></td></tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo __('Tenant id');?></td>
      <td><?php echo $tenant->getTenantId();?></td>
    </tr>
    <tr>
      <td><?php echo __('Api id');?></td>
      <td><?php echo $tenant->getApiId();?></td>
    </tr>
    <tr>
      <td><?php echo __('Api name');?></td>
      <td><?php echo $tenant->getApiName();?></td>
    </tr>
    <tr>
      <td><?php echo __('Type');?></td>
      <td><?php echo $tenant->getType() ? __('Company') : __('Private');?></td>
    </tr>
    <tr>
      <td><?php echo __('Company name');?></td>
      <td><?php echo $tenant->getCompanyName();?></td>
    </tr>
    <tr>
      <td><?php echo __('Nip');?></td>
      <td><?php echo $tenant->getNip();?></td>
    </tr>
    <tr>
      <td><?php echo __('Www');?></td>
      <td><?php echo $tenant->getWww();?></td>
    </tr>
  </tbody>
</table>

