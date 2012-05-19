<div id="register">
<?php echo $form->renderFormTag(url_for('@registration')); ?>

<?php echo $form->renderGlobalErrors(); ?>
<?php echo $form->renderHiddenFields(); ?>

<div class="left">
<fieldset>
  <h3><?php echo __('Account');?></h3>
  <?php echo $form['login']; ?>
  <?php echo $form['profile']; ?>
  <h3><?php echo __('Address'); ?></h3>
  <?php echo $form['account_address']; ?>
</fieldset>
</div>

<div class="right">
<fieldset>
  <h3><?php echo __('Company Details'); ?></h3>
  <?php echo $form['account']; ?>
  <h3><?php echo __('Company Address'); ?></h3>
  <?php echo $form['invoice_address']; ?>
</fieldset>
</div>

<div class="clear"></div>

<div class="center">
  <input type="submit" value="<?php echo __('Register'); ?>"/>
</div>

</form>
</div>
