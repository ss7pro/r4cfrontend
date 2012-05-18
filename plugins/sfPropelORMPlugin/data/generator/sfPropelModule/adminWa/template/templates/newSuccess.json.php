[?php $sf_request->setRequestFormat('html'); ?]
[?php ob_start(); ?]
<div id="sf_admin_container">
  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]
  <div id="sf_admin_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_header', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?] 
  </div>
  <div id="sf_admin_content">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?] 
  </div>
  <div id="sf_admin_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_footer', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration)) ?] 
  </div>
</div>
[?php echo json_encode(array(
  'content' => ob_get_clean(),
  'title' => <?php echo $this->getI18NString('new.title') ?>,
));
?]
[?php $sf_request->setRequestFormat('json'); ?]
