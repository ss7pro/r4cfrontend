<?php echo $form->renderFormTag(url_for('server/create')); ?>
<table>
  <tbody>
    <?php echo $form; ?>
  </tbody>
  <tfoot>
    <tr><td colspan="2">
    <input type="submit" value="<?php echo __('Create server'); ?>" />
    </td></tr>
  </tfoot>
</table>
</form>
