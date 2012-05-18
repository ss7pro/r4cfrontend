<?php

/**
 * RcAccount form.
 *
 * @package    ready4cloud
 * @subpackage form
 * @author     Roman Tatar <romantatar@gmail.com>
 */
class RcAccountForm extends BaseRcAccountForm
{
  public function configure()
  {
    unset(
      $this['default_address_id'],
      $this['invoice_address_id']
    );
  }
}
