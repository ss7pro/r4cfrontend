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
    if($name = $this->getName()) {
      return $this->bind(array($name => $data));
    } else {
      return $this->bind($data);
    }
  }

  public function getAllErrors()
  {
    $errors = array('global' => array());
    foreach($this->getGlobalErrors() as $name => $error) {
      $errors['global'][$name] = (string)$error;
    }
    $errors['fields'] = $this->unnestErrors($this->getErrorSchema(), $this->getName());
    return $errors;
  }

  protected function unnestErrors($errors, $prefix = '')
  {
    $newErrors = array();

    foreach ($errors as $name => $error)
    {
      if ($error instanceof ArrayAccess || is_array($error))
      {
        $newErrors = array_merge($newErrors, $this->unnestErrors($error, ($prefix ? $prefix . '[' . $name . ']' : $name)));
      }
      else
      {
        if ($error instanceof sfValidatorError)
        {
          $err = $this->translate($error->getMessageFormat(), $error->getArguments());
        }
        else
        {
          $err = $this->translate($error);
        }

        if (!is_integer($name))
        {
          $n = $prefix ? $prefix . '[' . $name . ']' : $name;
          $newErrors[$n] = (string)$err;
        }
        else
        {
          $newErrors[] = (string)$err;
        }
      }
    }

    return $newErrors;
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

  public function getNamedErrorRowFormatInARow()
  {
    return "%name% %error%";
  }

  public function getErrorRowFormatInARow()
  {
    return "%error%";
  }
}
