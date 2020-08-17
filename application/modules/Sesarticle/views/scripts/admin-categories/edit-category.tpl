<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-category.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesarticle/views/scripts/dismiss_message.tpl';?>
<?php 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<div class="clear sesbasic-form">
	<div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
  	<div class="sesbasic-form-cont">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesarticle', 'controller' => 'categories', 'action' => 'index'), $this->translate("Back to Categories"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
      <br /><br />
      <div class='clear'>
        <div class='settings sesbasic_admin_form'>
          <?php echo $this->form->render($this); ?>
        </div>
      </div>
		</div>
  </div>
</div>
<script type="application/javascript">
sesJqueryObject("#category_name").keyup(function(){
		var Text = sesJqueryObject(this).val();
		Text = Text.toLowerCase();
		Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
		sesJqueryObject("#slug").val(Text);        
});

</script>