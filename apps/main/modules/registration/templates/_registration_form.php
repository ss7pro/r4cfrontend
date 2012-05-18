<?php echo $form->renderFormTag(url_for('@register')); ?>

<?php echo $form->renderGlobalErrors(); ?>
<?php echo $form->renderHiddenFields(); ?>

<h2>Login and Password</h2>
<?php echo $form['login']; ?>

<h2>Your Name</h2>
<?php echo $form['profile']; ?>

<h2>Your Company details</h2>
<?php echo $form['account']; ?>

<input type="submit" value="Register"/>

</form>

