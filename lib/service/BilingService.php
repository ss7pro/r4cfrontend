<?php
class BilingService
{
  public function topup(RcTenant $tenant, $amount, $reference = array())
  {
    $client = rtOpenStackClient::factory();
    $config = rtOpenStackConfig::getConfiguration('topup');
    $c = new rtOpenStackCommandAuth(array(
      'user'        => $config['user'],
      'pass'        => $config['pass'],
      'tenant-name' => $config['tenant_name'],
    ));
    $c->execute($client);

    if(!$client->getSession()->isAuthenticated()) {
      throw new InvalidArgumentException('Topup error: invalid username or password');
    }

    $c = new rtOpenStackCommandClientTopup(array(
      'tenant_id' => $tenant->getApiId(),
      'amount'    => $amount,
      'reference' => $reference,
    ));
    $c->execute($client);
  }

  public static function notify(rtPayuTransactionMessage $msg, RtPayuTransaction $trns)
  {
    if($msg->get('status') == 99)
    {
      $payment = $trns->getRcPayment();
      $tenant = $payment->getRcTenant();
      $amount = round($msg->get('amount') / 100, 2);

      $service = new self();
      $service->topup($tenant, $amount, array(
        'source'     => 'r4cfrontend',
        'payment_id' => $payment->getPaymentId(),
        'pos_id'     => $msg->get('pos_id'),
        'session_id' => $msg->get('session_id'),
        'trans_id'   => $msg->get('id'),
      ));

      if($payment->getInvoice())
      {
        $invoice_service = new InvoiceService();
        $invoice = $invoice_service->fromPayment($payment);
        $payment->setRcInvoice($invoice);
        $payment->save();
      }

      //TODO: send pdf via email
      //$service = new PdfService();
      //$pdf = $service->fromInvoice($invoice, 'ORIGINAL');
    }
  }
}
