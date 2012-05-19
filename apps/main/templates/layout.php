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
      <span class="right">
        <?php if($sf_user->isAuthenticated()):?>
          <?php echo $sf_user; ?>&nbsp;<?php echo link_to(__('Log out'), '@sf_guard_signout');?>
        <?php else: ?>
          <?php echo link_to(__('Register'), '@registration'); ?>&nbsp;<?php echo link_to(__('Log in'), '@sf_guard_signin');?>
        <?php endif; ?>
      </span>
      <h1><?php echo link_to('Ready4Cloud', '@homepage'); ?></h1>
      <?php if($sf_user->isAuthenticated()):?>
        <?php include_partial('global/menu'); ?>
      <?php endif; ?>
    </header>

    <div id="content">
      <?php include_partial('global/flashes'); ?>
      <?php echo $sf_content ?>
    </div>

    <footer>
      Copyright &copy; 2012 Ready4Cloud
    </fotter>

  </body>
</html>
