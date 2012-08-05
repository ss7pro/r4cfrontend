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
  public function bindRequest(sfWebRequest $request)
  {
    if($name = $this->getName()) {
      return $this->bind(
        $request->getParameter($name), 
        $request->getFiles($name)
      );
    } else {
      return $this->bind(
        $request->getParameterHolder()->getAll(), 
        $request->getFiles()
      );
    }
  }

  public function bindJSONRequest(sfWebRequest $request)
  {
    $data = json_decode($request->getContent(), true);
    if(is_array($data))
    {
      $url = '';
      foreach($data as $key => $val)
      {
        if($url) $url .= '&';
        $url .= $key . '=' . rawurlencode($val);
      } 
      parse_str($url, $data);
    }
    return $this->bind($data);
  }

  public function getObjectArray()
  {
    $prefix = $this->getName();
    $ret = self::objectToArray($this->getObject(), $prefix);
    foreach($this->getEmbeddedForms() as $name => $form) {
      $ret += self::objectToArray($form->getObject(), $prefix . '[' . $name . ']');
    }
    return $ret;
  }

  private static function objectToArray($object, $prefix = null)
  {
    foreach($object->toArray(BasePeer::TYPE_FIELDNAME) as $key => $value) {
      $key = $prefix ? $prefix . '[' . $key . ']' : $key;
      $ret[$key] = $value;
    }
    return $ret;
  }

  public function getAllErrors()
  {
    $errors = array('global' => array());
    foreach($this->getGlobalErrors() as $name => $error) {
      $errors['global'][$name] = (string)$error;
    }
    $errors['fields'] = $this->flatenErrors($this->getErrorSchema(), $this->getName());
    return $errors;
  }

  protected function flatenErrors($errors, $prefix = '') 
  {
    $result = array();
    if ($errors instanceof ArrayAccess || is_array($errors))
    {
      foreach ($errors as $name => $error)
      {
        if(is_integer($name))
        {
          $tmp = $this->flatenErrors($error, $prefix);
        }
        else
        {
          $name = $prefix ? $prefix . '[' . $name . ']' : $name;
          $tmp = $this->flatenErrors($error, $name);
        }
        //$result = array_merge($result, $tmp);
        $result += $tmp;
      }
    }
    else if ($errors instanceof sfValidatorError)
    {
      $result[$prefix] = $this->translate($errors->getMessageFormat(), $errors->getArguments());
    }
    else
    {
      $result[$prefix] = $this->translate($errors);
    }
    return $result;
  }

  public function translate($subject, $parameters = array())
  {
    if (false === $subject)
    {
      return false;
    }

    foreach ($parameters as $key => $value)
    {
      if (is_object($value) && method_exists($value, '__toString'))
      {
        $parameters[$key] = $value->__toString();
      }
    }

    return strtr($subject, $parameters);
  }
}
