<?php
abstract class ResponseContent
{
  abstract public function renderResponse(sfResponse $response);

  public static function listenToComponentMethodNotFoundEvent(sfEvent $event)
  {
    // is renderResponse() method?
    if($event['method'] != 'renderResponse') return false;

    // is only one argument?
    if(count($event['arguments']) != 1) return false;

    // is ResponseContent type argument?
    $object = $event['arguments'][0];
    if(!($object instanceof ResponseContent)) return false;

    // yes, lets call it ;)
    $response = $event->getSubject()->getResponse();
    $event->setReturnValue($object->renderResponse($response));

    // notify dispatcher
    return true;
  }
}
