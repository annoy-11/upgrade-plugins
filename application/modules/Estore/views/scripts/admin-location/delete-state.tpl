
<form method="post" class="global_form_popup">
  <div>
    <h3><?php echo $this->translate("Delete State?") ?></h3>
    <p>
      <?php echo $this->translate("Are you sure that you want to delete this state? It will not be recoverable after being deleted.") ?>
    </p>
    <br />
    <p>
      <input type="hidden" name="id" value="<?php echo $this->state?>"/>
      <button type='submit'><?php echo $this->translate("Delete") ?></button>
      <?php echo $this->translate("or") ?> <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'>
      <?php echo $this->translate("cancel") ?></a>
    </p>
  </div>
</form>