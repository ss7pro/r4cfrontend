<?php

require_once dirname(__FILE__).'/../lib/rc_paymentGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/rc_paymentGeneratorHelper.class.php';

/**
 * rc_payment actions.
 *
 * @package    ready4cloud
 * @subpackage rc_payment
 * @author     Roman Tatar <romantatar@gmail.com>
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class rc_paymentActions extends autoRc_paymentActions
{
  public function executeShow(sfWebRequest $requiest)
  {
    $this->payment = $this->getRoute()->getObject();
  }
}
