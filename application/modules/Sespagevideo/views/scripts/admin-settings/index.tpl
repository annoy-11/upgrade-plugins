<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>


<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <div class='sesbasic-form-cont'>
	    <div class='clear'>
			  <div class='settings sesbasic_admin_form'>
			    <?php echo $this->form->render($this); ?>
			  </div>
			</div>
		</div>
  </div>
</div>


<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagevideo.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php }else{ ?>
<script type="application/javascript">
  window.addEvent('domready', function() {
      rating_video("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagevideo.video.rating', 1); ?>");
  });
	function rating_video(value){
		if(value == 1){
      if(document.getElementById('sespagevideo_ratevideo_own-wrapper'))
      	document.getElementById('sespagevideo_ratevideo_own-wrapper').style.display = 'block';
      if(document.getElementById('sespagevideo_ratevideo_again-wrapper'))
        document.getElementById('sespagevideo_ratevideo_again-wrapper').style.display = 'block';
      if(document.getElementById('sespagevideo_ratevideo_show-wrapper'))
        document.getElementById('sespagevideo_ratevideo_show-wrapper').style.display = 'none';	
		} else{
      if(document.getElementById('sespagevideo_ratevideo_show-wrapper'))
        document.getElementById('sespagevideo_ratevideo_show-wrapper').style.display = 'block';
      if(document.getElementById('sespagevideo_ratevideo_own-wrapper'))
        document.getElementById('sespagevideo_ratevideo_own-wrapper').style.display = 'none';
      if(document.getElementById('sespagevideo_ratevideo_again-wrapper'))
        document.getElementById('sespagevideo_ratevideo_again-wrapper').style.display = 'none';
		}
	} 
  
  if(document.getElementById('sespagevideo_video_rating-wrapper')) {
    if(document.getElementById('sespagevideo_video_rating').value == 1) {
      document.getElementById('sespagevideo_ratevideo_own-wrapper').style.display = 'block';		
      document.getElementById('sespagevideo_ratevideo_again-wrapper').style.display = 'block';
      document.getElementById('sespagevideo_ratevideo_show-wrapper').style.display = 'none';
    } 
  } else{
      document.getElementById('sespagevideo_ratevideo_show-wrapper').style.display = 'block';
      document.getElementById('sespagevideo_ratevideo_own-wrapper').style.display = 'none';
      document.getElementById('sespagevideo_ratevideo_again-wrapper').style.display = 'none';
	}

function proximity(value){
	if(value == 1)
		$('sespagevideo_search_type-wrapper').style.display='block';
	else
		$('sespagevideo_search_type-wrapper').style.display='none';
}
window.addEvent('domready', function() {
	proximity($('sespagevideo_enable_location').value);
	console.log($('sespagevideo_enable_location').value);
});

</script>

<?php  } ?>
