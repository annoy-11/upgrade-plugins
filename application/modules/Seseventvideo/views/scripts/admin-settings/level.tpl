<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: level.tpl 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>

<?php include APPLICATION_PATH .  '/application/modules/Seseventvideo/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">
  var fetchLevelSettings = function(level_id) {
    window.location.href = en4.core.baseUrl + 'admin/seseventvideo/settings/level/id/' + level_id;
    //alert(level_id);
  }
</script>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
		<?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='settings sesbasic-form-cont sesbasic_admin_form'>
      <?php echo $this->form->render($this) ?>
    </div>
	</div>
</div>
<script type="application/javascript">
function setVideoType(value){
	if(value == 1) {
   document.getElementById('video_approve_type-wrapper').style.display = 'block';		
	}else{
		 document.getElementById('video_approve_type-wrapper').style.display = 'none';	
	}
}
if(document.getElementById('video_approve').value == 1) {
   document.getElementById('video_approve_type-wrapper').style.display = 'block';		
}else{
	 document.getElementById('video_approve_type-wrapper').style.display = 'none';	
}
</script>