  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $<?php echo $this->getSingularName() ?> = $form->save();
      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $<?php echo $this->getSingularName() ?>)));
      $this->processFormSuccess($request, $form, $<?php echo $this->getSingularName() ?>);
    }
    else
    {
      $this->processFormError($request, $form);
    }
  }

  protected function processFormSuccess(sfWebRequest $request, sfForm $form, $<?php echo $this->getSingularName() ?>)
  {
    $notice = 'The item was saved successfully.';
    if ($request->hasParameter('_save_and_add'))
    {
      $this->getUser()->setFlash('notice', $notice.' You can add another one below.');
      $this->redirect('@<?php echo $this->getUrlForAction('new') ?>');
    }
    else
    {
      $this->getUser()->setFlash('notice', $notice);
      $this->redirect(array('sf_route' => '<?php echo $this->getUrlForAction('edit') ?>', 'sf_subject' => $<?php echo $this->getSingularName() ?>));
    }
  }

  protected function processFormError(sfWebRequest $request, sfForm $form)
  {
    $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
  }

  public function redirect($url, $statusCode = 302)
  {
    if($this->getRequest()->getParameter('sf_format') == 'json')
    {
      $url = $this->getController()->genUrl($url, true);
      $url = str_replace('&amp;', '&', $url);  // see #8083
      $response = $this->getResponse();
      $response->clearHttpHeaders();
      $response->setStatusCode(200);
      $response->setContentType('application/json; charset=utf-8');
      $response->setContent(json_encode(array('code' => $statusCode, 'redirect' => $url)));
      $response->send();
      throw new sfStopException();
    }
    return parent::redirect($url, $statusCode);
  }

