<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * 
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormSchemaFormatterTable.class.php 5995 2007-11-13 15:50:03Z fabien $
 */
class sfWidgetFormSchemaFormatterTableNoEmbeddedLabel extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<tr>\n  <td>%field% %error% %help% %hidden_fields%</td>\n</tr>\n",
    $errorRowFormat  = "<tr><td>\n%errors%</td></tr>\n",
    $helpFormat      = '%help%',
    $decoratorFormat = "<table>\n  %content%</table>";
}
