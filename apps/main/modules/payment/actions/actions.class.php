<?php

/**
 * payment actions.
 *
 * @package    ready4cloud
 * @subpackage payment
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class paymentActions extends sfActions
{
  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new PaymentForm();
    $client_ip = $request->getRemoteAddress();
    $this->form->setOption('client_ip', $client_ip);

    $this->form->bindJSONRequest($request);
    $result = array('status' => 'FAIL');
    $this->getLogger()->notice('NEW PAYMENT: ' . json_encode($this->form->getValues()));
    if($this->form->isValid())
    {
      try
      {
        $this->form->save();
        $result['response'] = $this->form->getObjectArray();
        return $this->renderResponse(new JSONResponse($result));
      }
      catch(Exception $e)
      {
        $result['errors'] = array('global' => $e->getMessage());
        return $this->renderResponse(new JSONResponse($result, 400));
      }
    }
    $result['errors'] = $this->form->getAllErrors();
    return $this->renderResponse(new JSONResponse($result, 400));
  }
}
