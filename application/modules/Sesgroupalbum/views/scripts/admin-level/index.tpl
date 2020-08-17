<?php

?>

<h2>
  <?php echo $this->translate('Group Albums Extension') ?>
</h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'settings', 'action' => 'contact-us'),'admin_default',true); ?>" class="request-btn">Feature Request</a>
</div>
<script type="text/javascript">
  var fetchLevelSettings = function(level_id) {
    var url = '<?php echo $this->url(array('id' => null)) ?>';
    window.location.href = url + '/index/id/' + level_id;
  }
</script>

<?php if( count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php
      // Render the menu
      //->setUlClass()
      echo $this->navigation()->menu()->setContainer($this->navigation)->render()
    ?>
  </div>
<?php endif; ?>
<div class="settings sesbasic_admin_form">
  <div class='settings'>
    <?php echo $this->form->render($this) ?>
</div>
</div>
