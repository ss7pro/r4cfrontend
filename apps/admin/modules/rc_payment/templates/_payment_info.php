<table>
  <thead>
    <tr><th colspan="2"><?php echo __('Payment information');?></td></tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo __('Payment id');?></td>
      <td><?php echo $payment->getPaymentId();?></td>
    </tr>
    <tr>
      <td><?php echo __('Created');?></td>
      <td><?php echo $payment->getCreatedAt();?></td>
    </tr>
    <tr>
      <td><?php echo __('Tenant');?></td>
      <td><?php echo $payment->getRcTenant();?></td>
    </tr>
    <tr>
      <td><?php echo __('Invoice');?></td>
      <td><?php echo $payment->getRcInvoice();?></td>
    </tr>
    <tr>
      <td><?php echo __('Amount');?></td>
      <td><?php echo $payment->getAmount();?></td>
    </tr>
    <tr>
      <td><?php echo __('First name');?></td>
      <td><?php echo $payment->getFirstName();?></td>
    </tr>
    <tr>
      <td><?php echo __('Last name');?></td>
      <td><?php echo $payment->getLastName();?></td>
    </tr>
    <tr>
      <td><?php echo __('Email');?></td>
      <td><?php echo $payment->getEmail();?></td>
    </tr>
    <tr>
      <td><?php echo __('Phome');?></td>
      <td><?php echo $payment->getPhone();?></td>
    </tr>
    <tr>
      <td><?php echo __('Invoice request');?></td>
      <td><?php echo $payment->getInvoice() ? 'Y' : 'N';?></td>
    </tr>
    <tr>
      <td><?php echo __('Company name');?></td>
      <td><?php echo $payment->getCompanyName();?></td>
    </tr>
    <tr>
      <td><?php echo __('Street');?></td>
      <td><?php echo $payment->getStreet();?></td>
    </tr>
    <tr>
      <td><?php echo __('Post code');?></td>
      <td><?php echo $payment->getPostCode();?></td>
    </tr>
    <tr>
      <td><?php echo __('City');?></td>
      <td><?php echo $payment->getCity();?></td>
    </tr>
    <tr>
      <td><?php echo __('Nip');?></td>
      <td><?php echo $payment->getNip();?></td>
    </tr>
    <tr>
      <td><?php echo __('Description');?></td>
      <td><?php echo $payment->getDesc();?></td>
    </tr>
    <tr>
      <td><?php echo __('Client IP');?></td>
      <td><?php echo $payment->getClientIp();?></td>
    </tr>
  </tbody>
</table>

