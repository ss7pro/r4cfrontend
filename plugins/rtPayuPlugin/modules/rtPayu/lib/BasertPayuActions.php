<?php
class BasertPayuActions extends sfActions
{
  public function executeNotify(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    try
    {
      $event = rtPayuTransactionEvent::createFromRequest($request);
      $this->getLogger()->notice('PAYMENT STATUS NOTIFY EVENT: ' . $event);

      if(!$event->isValid()) throw new InvalidArgumentException('Can not verify signature (' . $event->getPosId() . ', ' . $event->getSessionId() . ')');

      $trns = RtPayuTransactionQuery::create()
        ->filterByPosId($event->getPosId())
        ->findOneBySessionId($event->getSessionId());

      if(!$trns) throw new InvalidArgumentException('Transaction not exists (' . $event->getPosId() . ', ' . $event->getSessionId() . ')');
    }
    catch(Exception $e)
    {
      $this->getLogger()->err('PAYMENT STATUS NOTIFY ERROR: ' . . get_class($e) . ': ' . $e->getMessage());
      return $this->renderText('FAIL');
    }

    try
    {
      $msg = rtPayuConnector::instance()->getStatusByEvent($event);

      $log = new RtPayuTransactionLog();
      $log->setRtPayuTransaction($trns);
      $log->setStatus($msg->get('status'));
      $log->setMessage((string)$msg);
      $log->save();

      if(!$msg->isValid()) throw new InvalidArgumentException('Status response has invalid signature');

      $callback = sfConfig::get('app_rt_payu_plugin_notify_callback');
      if(is_callable($callback))
      {
        call_user_func_array($callback, array($msg, $trns));
      }

      $trns->setTransId($msg->get('id'));
      $trns->setPayType($msg->get('pay_type'));
      $trns->setStatus($msg->get('status'));
      $trns->setCreateAt($msg->get('create'));
      $trns->setInitAt($msg->get('init'));
      $trns->setSentAt($msg->get('sent'));
      $trns->setRecvAt($msg->get('recv'));
      $trns->setCancelAt($msg->get('cancel'));
      $trns->save();

      $this->getLogger()->notice('PAYMENT STATUS OK: (' . $msg->get('pos_id') . ', ' . $msg->get('session_id') . ')');
    }
    catch(Exception $e)
    {
      $this->getLogger()->err('PAYMENT STATUS ERROR: ' . get_class($e) . ': ' . $e->getMessage());
      return $this->renderText('FAIL');
    }

    return $this->renderText('OK');
  }
}
