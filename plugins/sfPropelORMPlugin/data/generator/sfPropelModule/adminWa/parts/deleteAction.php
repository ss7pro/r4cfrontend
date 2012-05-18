  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    try
    {
      $this->getRoute()->getObject()->delete();
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    }
    catch(PropelException $e)
    {
      if(!Misc::isConstraintViolation($e)) throw $e;
      $this->getUser()->setFlash('error', 'You can not delete an object, because of existing dependencies.');
    }

    $this->redirect('@<?php echo $this->getUrlForAction('list') ?>');
  }
