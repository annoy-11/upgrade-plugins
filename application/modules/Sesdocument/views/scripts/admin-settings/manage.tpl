
<?php include APPLICATION_PATH .  '/application/modules/Sesdocument/views/scripts/dismiss_message.tpl';
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
?>

<div class='clear'>
  <div class=' sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="application/javascript">


</script>
