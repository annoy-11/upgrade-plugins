<?php

?>
<?php include APPLICATION_PATH .  '/application/modules/Seslink/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">
  var fetchLevelSettings =function(level_id){
    window.location.href= en4.core.baseUrl+'admin/seslink/level/index/id/'+level_id;
  }
</script>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>