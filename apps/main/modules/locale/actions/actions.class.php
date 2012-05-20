<?php

/**
 * locale actions.
 *
 * @package    ready4cloud
 * @subpackage locale
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class localeActions extends sfActions
{
  public function executeSet(sfWebRequest $request)
  {
    $culture = $request->getParameter('lang');
    $this->forward404Unless(in_array($culture, sfConfig::get('app_system_languages', array())));
    $this->getUser()->setCulture($culture);
    $this->redirect($request->getReferer() ? $request->getReferer() : '@homepage');
    return sfView::NONE;
  }
}
