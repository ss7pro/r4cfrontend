<?php

/**
 * registration actions.
 *
 * @package    cloud
 * @subpackage registration
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registrationActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    if($this->getUser()->isAuthenticated()) {
      $this->redirect('@homepage');
    }
    $this->form = new RegistrationForm();
    if($request->isMethod(sfRequest::POST)) {
      $this->form->bindRequest($request);
      if($this->form->isValid()) {
        try {
          list($user, $resp) = $this->form->save();
          $this->getUser()->signin($user);
        } catch(Exception $e) {
          $this->getLogger()->err(get_class($e) . ': ' . $e->getMessage());
          $this->getUser()->setFlash('error', 'An error appear during registration');
          $this->redirect('@homepage');
        }
        $this->getUser()->setFlash('notice', 'Account has been created successfully');
        $this->redirect('@profilepage');
      }
    }
  }

  public function executeRegister(sfWebRequest $request) {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->form = new RegistrationForm(array(), array(), false);
    $this->form->bindRequest($request);
    if($this->form->isValid()) {
      try {
        list($user, $resp) = $this->form->save();
        $result['response'] = $resp;
        $result['user'] = $user->toArray();
      } catch(Exception $e) {
        $this->getResponse()->setStatusCode(400);
        $result['errors'] = array('global' => $e->getMessage());
      }
    } else {
      $this->getResponse()->setStatusCode(400);
      $result['errors'] = $this->form->getAllErrors();
    }
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($result));
  }
}
