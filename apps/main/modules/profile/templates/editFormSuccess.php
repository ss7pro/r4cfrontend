<h1><?php echo __('Edit profile');?></h1>
<?php echo $form->renderFormTag(url_for('profile/editForm')); ?>
<table>
  <tbody>
    <?php echo $form; ?>
  </tbody>
  <tfoot>
    <tr><td colspan="2">
      <input type="submit" value="<?php echo __('Save changes');?>" />
    </td></tr>
  </tfoot>
</table>
</form>
