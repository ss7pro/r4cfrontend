<!DOCTYPE html>
<html>
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>

    <header>
      <?php include_component('sfAdminDash', 'header'); ?>
    </header>

    <div id="cs_content">
      <?php echo $sf_content ?>
      <div class="clear"></div>
    </div>

    <footer>
      <?php include_partial('sfAdminDash/footer'); ?>
    </footer>

  </body>
</html>
