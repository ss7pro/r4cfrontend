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
    $this->getLogger()->log(json_encode(array($this->form->getName(), $this->form->getValues())));
    if($this->form->isValid())
    {
      $con = Propel::getConnection();
      try
      {
        $con->beginTransaction();
        $payment = $this->form->save($con);
        $con->commit();
        $response = array();
        $result['status'] = 'OK';
        $result['response'] = $this->form->getObjectArray();
        return $this->renderResponse(new JSONResponse($result));
      }
      catch(Exception $e)
      {
        $con->rollBack();
        $result['errors'] = array('global' => $e->getMessage());
        return $this->renderResponse(new JSONResponse($result, 400));
      }
    }
    $result['errors'] = $this->form->getAllErrors();
    return $this->renderResponse(new JSONResponse($result, 400));
  }

  public function executeReport(sfWebRequest $request)
  {
    $params = $request->getRequestParameters();
    $this->getLogger()->notice('PAYMENT REPORT: ' . json_encode($params));
  }

  public function executeSuccess(sfWebRequest $request)
  {
    return $this->renderText('PAYMENT SUCCESS');
  }

  public function executeError(sfWebRequest $request)
  {
    return $this->renderText('PAYMENT ERROR');
  }
}
