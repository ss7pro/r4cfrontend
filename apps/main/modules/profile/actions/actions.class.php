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
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeEdit(sfWebRequest $request)
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
          $this->getUser()->setFlash('notice', 'An error appear during update process.');
        }
        $this->redirect('@profilepage');
      }
    }
  }
}
