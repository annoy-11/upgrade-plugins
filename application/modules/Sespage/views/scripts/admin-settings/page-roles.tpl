<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: page-roles.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>
<div class='settings sesbasic_admin_form'>
  <?php echo $this->form->render($this); ?>
</div>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<script type="text/javascript">
  sesJqueryObject(document).on('change','#memberrole_id',function(){
      window.location.href =   en4.core.baseUrl + 'admin/sespage/settings/page-roles/member_roles/'+sesJqueryObject(this).val();
  });
 sesJqueryObject('<div class="sesbasic_search_reasult"><a href="admin/sespage/settings/page-roles-create" class="buttonlink sesbasic_icon_add smoothbox">Create New Page Role</a></div>').insertAfter('.form-description');
 sesJqueryObject(document).on('click','.smoothbox',function(){
  Smoothbox.open(sesJqueryObject(this).attr('url'));
	parent.Smoothbox.close;
	return false;  
 })
</script>