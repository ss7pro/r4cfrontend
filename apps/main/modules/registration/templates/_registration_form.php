<div id="register">
<?php echo $form->renderFormTag(url_for('@registration')); ?>

<?php echo $form->renderGlobalErrors(); ?>
<?php echo $form->renderHiddenFields(); ?>

<div class="left">
<fieldset>
  <h3>Account</h3>
  <?php echo $form['login']; ?>
  <?php echo $form['profile']; ?>
  <h3>Address</h3>
  <?php echo $form['address']; ?>
</fieldset>
</div>

<div class="right">
<fieldset>
  <h3>Company Details</h3>
  <?php echo $form['account']; ?>
  <h3>Company Address</h3>
  <?php echo $form['company_address']; ?>
</fieldset>
</div>

<div class="clear"></div>

<div class="center">
  <input type="submit" value="Register"/>
</div>

</form>
</div>
