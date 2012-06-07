<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="<?php image_path('favicon.ico'); ?>" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>

    <header>
      <h1><?php echo link_to('Ready4Cloud', '@homepage'); ?></h1>
      <span class="right">
        <?php if($sf_user->isAuthenticated()):?>
          <?php echo __('Logged as') . ': "' . $sf_user . '"'; ?>&nbsp;|&nbsp;<?php echo link_to(__('Log out'), '@sf_guard_signout');?>
        <?php else: ?>
          <?php echo link_to(__('Register'), '@registration'); ?>&nbsp;|&nbsp;<?php echo link_to(__('Log in'), '@sf_guard_signin');?>
        <?php endif; ?>
      </span>
      <?php if(false && $sf_user->isAuthenticated()):?>
        <div class="left">
          <?php include_partial('global/menu'); ?>
        </div>
      <?php endif; ?>
      <div class="clear"></div>
    </header>

    <div id="content">
      <?php include_partial('global/flashes'); ?>
      <?php echo $sf_content ?>
    </div>

    <footer>
      Copyright &copy; 2012 Ready4Cloud&nbsp;
      <?php foreach(sfConfig::get('app_system_languages', array()) as $lang): ?>
        <?php echo link_to(image_tag('flag/' . $lang . '.png'), '@locale?lang=' . $lang); ?>
      <?php endforeach; ?>
    </footer>

  </body>
</html>
