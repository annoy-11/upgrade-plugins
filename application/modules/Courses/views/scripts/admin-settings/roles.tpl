<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: roles.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this); ?>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type="text/javascript">
  sesJqueryObject(document).on('change','#memberrole_id',function(){
      window.location.href =   en4.core.baseUrl + 'admin/courses/settings/roles/member_roles/'+sesJqueryObject(this).val();
  });
 sesJqueryObject('<div class="sesbasic_search_reasult"><a href="admin/courses/settings/roles-create" class="buttonlink sesbasic_icon_add smoothbox">Create Course Role</a></div>').insertAfter('.form-description');
 sesJqueryObject(document).on('click','.smoothbox',function(){
  Smoothbox.open(sesJqueryObject(this).attr('url'));
	parent.Smoothbox.close;
	return false;  
 })
</script>
 
