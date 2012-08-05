<?php

/**
 * Processes the "remember me" cookie.
 * 
 * This filter should be added to the application filters.yml file **above**
 * the security filter:
 * 
 *    openstack_auth:
 *      class: rtOpenStackAuthFilter
 * 
 *    security: ~
 * 
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardRememberMeFilter.class.php 15757 2009-02-24 21:15:40Z Kris.Wallsmith $
 */
class rtOpenStackAuthFilter extends sfFilter
{
  /**
   * @see sfFilter
   */
  public function execute($filterChain)
  {
    if(
      $this->isFirstCall() &&
      $this->context->getUser()->isAnonymous() &&
      $token = $this->context->getRequest()->getHttpHeader('X-Auth-Token')
    )
    {
      $con = rtOpenStackClient::factory();
      $ses = $con->getSession();
      $cmd = new rtOpenStackCommandTokenGet(array('token' => $token));
      $res = $cmd->execute($con);
      if($ses->isAuthenticated() && $ses->getUserId())
      {
        // TODO: configure model and column in configuration
        if($profile = RcProfileQuery::create()->findOneByApiId($ses->getUserId()))
        {
          $this->context->getUser()->signIn($profile->getsfGuardUser());
        }
      }
    }

    $filterChain->execute();
  }
}
