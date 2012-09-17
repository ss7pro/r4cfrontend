<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="alert alert-success">
    <button class="close" data-dismiss="alert" type="button">×</button>
    <b><?php echo __('Well done!') ?></b> <?php echo __($sf_user->getFlash('notice')) ?>
  </div>
<?php endif; ?>
<?php if ($sf_user->hasFlash('error')): ?>
  <div class="alert alert-error">
    <button class="close" data-dismiss="alert" type="button">×</button>
    <b><?php echo __('Warning!') ?></b> <?php echo __($sf_user->getFlash('error')) ?>
  </div>
<?php endif; ?>
