<?php

/**
 * billing actions.
 *
 * @package    ready4cloud
 * @subpackage billing
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class billingActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executePromo_code(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new PromoCodeForm();
    try {
      $this->form->bindJSONRequest($request);
      $this->getResponse()->setContentType('application/json');

      if(!$this->form->isValid()) {
        $this->getResponse()->setStatusCode(400);
        return $this->renderText(json_encode(array('errors' => $this->form->getAllErrors())));
      }

      $code = $this->form->save();
    } catch(Exception $e) {
      $this->getLogger()->err(get_class($e) . ': ' . $e->getMessage());
      $this->getResponse()->setStatusCode(500);
      return $this->renderText(json_encode(array('errors' => array('message' => 'Unexpected error during charging'))));
    }

    return $this->renderText(json_encode(array(
      'tenant_id' => $this->form->getValue('tenant_id'),
      'token'     => $this->form->getValue('token'),
      'code'      => $code->getCode(),
      'value'     => $code->getValue(),
      'used_at'   => $code->getUsedAt(),
    )));
  }
  
}
