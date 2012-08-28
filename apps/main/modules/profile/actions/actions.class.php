<?php

/**
 * profile actions.
 *
 * @package    ready4cloud
 * @subpackage default
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions
{

  public function executeShow(sfWebRequest $request)
  {
    $profile = $this->getRoute()->getObject();
    $this->forward404Unless($profile->getApiId() == $this->getUser()->getOsUserId());

    $json = new RcProfileJson($profile);
    return $this->renderResponse(new JSONResponse($json->toArray()));
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $profile = $this->getRoute()->getObject();
    $this->forward404Unless($profile->getApiId() == $this->getUser()->getOsUserId());

    $user = $profile->getsfGuardUser();
    $form = new ProfileForm(array(), array('user' => $user), false);
    $form->bindJSONRequest($request);
    if($form->isValid())
    {
      try
      {
        $profile = $form->save();
        $json = new RcProfileJson($profile);
        return $this->renderResponse(new JSONResponse($json->toArray()));
      }
      catch(Exception $e)
      {
        $result = array('errors' => array(
          'global' => $e->getMessage()
        ));
        return $this->renderResponse(new JSONResponse($result, 400));
      }
    }
    return $this->renderResponse(new JSONResponse($form->getAllErrors(), 400));
  }

  public function executeIndexOld(sfWebRequest $request)
  {
  }

  public function executeEditForm(sfWebRequest $request)
  {
    $user = $this->getUser()->getGuardUser();
    $this->form = new ProfileEditForm(array(), array('user' => $user));
    if($request->isMethod(sfRequest::POST)) {
      $this->form->bindRequest($request);
      if($this->form->isValid()) {
        try {
          $this->form->save();
          $this->getUser()->setFlash('notice', 'Profile has ben updated sucessfully.');
        } catch(Exception $e) {
          $this->getLogger()->err(get_class($e) . ': ' . $e->getMessage());
          $this->getUser()->setFlash('error', 'An error appear during update process.');
        }
        $this->redirect('profile/editForm');
      }
    }
  }
}
