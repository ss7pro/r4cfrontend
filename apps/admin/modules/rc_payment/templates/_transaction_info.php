<table>
  <thead>
    <tr><th colspan="2"><?php echo __('Transaction status');?></td></tr>
  </thead>
  <tbody>
    <tr>
      <td><?php echo __('Id');?></td>
      <td><?php echo $transaction->getTransactionId();?></td>
    </tr>
    <tr>
      <td><?php echo __('Pos id');?></td>
      <td><?php echo $transaction->getPosId();?></td>
    </tr>
    <tr>
      <td><?php echo __('Session id');?></td>
      <td><?php echo $transaction->getSessionId();?></td>
    </tr>
    <tr>
      <td><?php echo __('Trans id');?></td>
      <td><?php echo $transaction->getTransId();?></td>
    </tr>
    <tr>
      <td><?php echo __('Pay type');?></td>
      <td><?php echo $transaction->getPayType();?></td>
    </tr>
    <tr>
      <td><?php echo __('Status');?></td>
      <td><?php echo __($transaction->getStatusLabel()) . ' (' . $transaction->getStatus() . ')';?></td>
    </tr>
    <tr>
      <td><?php echo __('Created');?></td>
      <td><?php echo $transaction->getCreateAt();?></td>
    </tr>
    <tr>
      <td><?php echo __('Init');?></td>
      <td><?php echo $transaction->getInitAt();?></td>
    </tr>
    <tr>
      <td><?php echo __('Sent');?></td>
      <td><?php echo $transaction->getSentAt();?></td>
    </tr>
    <tr>
      <td><?php echo __('Recv');?></td>
      <td><?php echo $transaction->getRecvAt();?></td>
    </tr>
    <tr>
      <td><?php echo __('Cancel');?></td>
      <td><?php echo $transaction->getCancelAt();?></td>
    </tr>
  </tbody>
</table>

