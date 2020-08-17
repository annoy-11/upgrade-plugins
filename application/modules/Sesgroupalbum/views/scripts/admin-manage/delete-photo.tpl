<?php

?>
  <form method="post" class="global_form_popup">
    <div>
      <h3><?php echo $this->translate("Delete Photo ?") ?></h3>
      <p>
        <?php echo " Are you sure that you want to delete this photo ? It will not be recoverable after being deleted. " ?>
      </p>
      <br />
      <p>
        <input type="hidden" name="confirm" value="<?php echo $this->album_id?>"/>
        <button type='submit'><?php echo $this->translate("Delete") ?></button>
        <?php echo $this->translate("or") ?>
        <a href='javascript:void(0);' onclick='javascript:parent.Smoothbox.close()'>
        <?php echo $this->translate("cancel") ?></a>
      </p>
    </div>
  </form>

<?php if( @$this->closeSmoothbox ): ?>
<script type="text/javascript">
  TB_close();
</script>
<?php endif; ?>
