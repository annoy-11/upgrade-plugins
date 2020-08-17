<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit-category.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php  include APPLICATION_PATH .  '/application/modules/Epetition/views/scriptfile.tpl';?>

  <?php if( count($this->navigation) ): ?>
<div class='sesbasic-admin-navgation'>
  <?php include APPLICATION_PATH .  '/application/modules/Epetition/views/scripts/dismiss_message.tpl';?>

</div>
<?php endif; ?>
<div class="clear sesbasic-form">
	<div>
  	<div class="sesbasic-form-cont">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'epetition', 'controller' => 'categories', 'action' => 'index'), $this->translate("Back to Categories"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
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