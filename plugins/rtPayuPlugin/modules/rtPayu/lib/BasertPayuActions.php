<?php
class BasertPayuActions extends sfActions
{
  public function executeNotify(sfWebRequest $request)
  {
    $event = rtPayuTransactionEvent::createFromRequest($request);
    $this->getLogger()->log('PAYMENT NOTIFY: ' . (string)$event);

    if(!$event->isValid()) return $this->renderText('FAIL');

    //TODO: fetch transaction status here and store in log

    return $this->renderText('OK');
  }
}
