<h1>Step 1: Configure Super Cloud Server.</h1>
<p>
  Lorem ipsum ...
</p>

<?php if(!$sf_user->isAuthenticated()): ?>
<h1>Step 2: Register</h1>
<p>
  If not yet registred, Lorem ipsum ...
  <?php echo link_to('Register', '@registration');?></h3>
</p>
<?php endif; ?>


