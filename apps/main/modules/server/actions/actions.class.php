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
  public function executeIndex(sfWebRequest $request) {
    $cmd = new rtOpenStackCommandServersDetail();
    $res = $cmd->execute();
    $this->servers = $res['servers'];
  }
}
