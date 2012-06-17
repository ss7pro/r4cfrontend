<?php

/**
 * Base project form.
 * 
 * @package    cloud
 * @subpackage form
 * @author     Roman Tatar <romantatar@gmail.com> 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
  public function bindRequest(sfWebRequest $request) {
    return $this->bind(
      $request->getParameter($this->getName()), 
      $request->getFiles($this->getName())
    );
  }
}
