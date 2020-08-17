<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmember/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>

<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.pluginactivated',0)): 
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php endif; ?>

<script type="application/javascript">

	function showfollowtext(value){
		if(value == 1){
      document.getElementById('sesmember_follow_followtext-wrapper').style.display = 'block';	
      document.getElementById('sesmember_follow_unfollowtext-wrapper').style.display = 'block';	
    } else{
      document.getElementById('sesmember_follow_followtext-wrapper').style.display = 'none';	
      document.getElementById('sesmember_follow_unfollowtext-wrapper').style.display = 'none';	
    }
	}
  function show_type(value){
    if(value == 1){
      document.getElementById('sesmember_approve_criteria-wrapper').style.display = 'block';	
      showCriteria(document.getElementById('sesmember_approve_criteria').value);
    } else{
      document.getElementById('sesmember_approve_criteria-wrapper').style.display = 'none';
      document.getElementById('sesmember_like_count-wrapper').style.display = 'none';
      document.getElementById('sesmember_view_count-wrapper').style.display = 'none';
    }
  } 
  
  function showCriteria(value){
    if(value == 1){
      document.getElementById('sesmember_like_count-wrapper').style.display = 'block';	
      document.getElementById('sesmember_view_count-wrapper').style.display = 'none';
    } else{
      document.getElementById('sesmember_like_count-wrapper').style.display = 'none';	
      document.getElementById('sesmember_view_count-wrapper').style.display = 'block';
    }
  } 

window.addEvent('domready', function() {
  if(document.getElementById('sesmember_follow_active'))
  showfollowtext(document.getElementById('sesmember_follow_active').value);
  if(document.getElementById('sesmember_user_approved'))
  show_type(document.getElementById('sesmember_user_approved').value);

});
</script>