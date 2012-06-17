<?php
class rtOpenStackServerCreateForm extends BaseForm
{
  public function setup()
  {
    $flavors = $this->getFlavorChoices();
    $images  = $this->getImageChoices();

    $this->setWidgets(array(
      'name' => new sfWidgetFormInputText(),
      'flavor'   => new sfWidgetFormChoice(array('choices' => array('' => 'Choose flavor') + $flavors)),
      'image'    => new sfWidgetFormChoice(array('choices' => array('' => 'Choose image')  + $images)),
    ));

    $this->setValidators(array(
      'name' => new sfValidatorString(array('required' => true, 'min_length' => 4, 'max_length' => 30)),
      'flavor'   => new sfValidatorChoice(array('choices' => array_keys($flavors))),
      'image'    => new sfValidatorChoice(array('choices' => array_keys($images))),
    ));

    $this->getWidgetSchema()->setNameFormat('os_server[%s]');
  }

  private function getFlavorChoices()
  {
    $com = new rtOpenStackCommandFlavorList();
    $res = $com->execute();
    $choices = array();
    foreach($res['flavors'] as $f) {
      $choices[$f['id']] = sprintf('%s (%s CPU / %s MB RAM / %s GB HDD)', $f['name'], $f['vcpus'], $f['ram'], $f['disk']);
    }
    return $choices;
  }

  private function getImageChoices()
  {
    $com = new rtOpenStackCommandImageList();
    $res = $com->execute();
    $choices = array();
    foreach($res['images'] as $i) {
      $choices[$i['id']] = sprintf('%s', $i['name']);
    }
    return $choices;
  }

  public function save()
  {
    $cmd = new rtOpenStackCommandServerCreate($this->getValues());
    $cmd->execute();
  }
}
