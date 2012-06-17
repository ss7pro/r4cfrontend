<?php

/**
 * server actions.
 *
 * @package    cloud
 * @subpackage server
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class serverActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $cmd = new rtOpenStackCommandServersDetail();
    $res = $cmd->execute();
    $this->servers = $res['servers'];
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = new rtOpenStackServerCreateForm();
    if($request->isMethod(sfRequest::POST)) {
      $this->form->bindRequest($request);
      if($this->form->isValid()) {
        try {
          $this->form->save();
        } catch(Exception $e) {
          $this->getLogger()->err(get_class($e) . ': ' . $e->getMessage());
        }
        //TODO: ajax support
        $this->redirect('server/index');
      }
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->forward404Unless($server_id = $request->getParameter('id'));

    $cmd = new rtOpenStackCommandServers();
    $servers = $cmd->execute();
    $found = false;
    foreach($servers['servers'] as $s) {
      if($s['id'] == $server_id) {
        $found = true;
        break;
      }
    }
    $this->forward404Unless($found);

    try {
      $cmd = new rtOpenStackCommandServerDelete(array('id' => $server_id));
      $cmd->execute();
    } catch(Exception $e) {
      $this->getLogger()->err(get_class($e) . ': ' . $e->getMessage());
    }

    $this->redirect('server/index');
  }
}
