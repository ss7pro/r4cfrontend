<?php

/**
 * default actions.
 *
 * @package    solidpm
 * @subpackage default
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }

  public function executeError404(sfWebRequest $request)
  {
  }

  public function executeDisabled(sfWebRequest $request)
  {
  }
}
