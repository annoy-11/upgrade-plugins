<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox	
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<h2><?php echo $this->translate('Shoutbox Plugin') ?></h2>

<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>

<div class="sesbasic_search_reasult">
  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesshoutbox', 'controller' => 'manage'), $this->translate("Back to Manage Shoutbox") , array('class'=>'sesbasic_icon_back buttonlink')); ?>
</div>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<style type="text/css">
  .settings div.form-label label.required:after{
    content:" *";
    color:#f00;
  }
</style>
<script>
<?php if(empty($this->shoutbox_id)) { ?>
  window.addEvent('domready',function() {
    chooseEditors(0);
  });
<?php } else { ?>
  window.addEvent('domready',function() {
    chooseEditors('<?php echo $this->shoutbox->editors ?>');
  });
<?php } ?>

function chooseEditors(value) {
  if(value == 1) {
    if($('text_limit-wrapper'))
      $('text_limit-wrapper').style.display = 'none';
    if($('postcontentbutton-wrapper'))
      $('postcontentbutton-wrapper').style.display = 'none';
  } else { 
    if($('text_limit-wrapper'))
      $('text_limit-wrapper').style.display = 'block';
    if($('postcontentbutton-wrapper'))
      $('postcontentbutton-wrapper').style.display = 'block';
  }
}
</script>
