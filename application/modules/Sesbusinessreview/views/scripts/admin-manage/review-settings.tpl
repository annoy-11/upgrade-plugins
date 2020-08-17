<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: review-settings.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/dismiss_message.tpl';?>
<div class='sesbasic-form sesbasic-categories-form'>
  <div>
    <?php
    $sesbusinessreview_adminmenu = Zend_Registry::isRegistered('sesbusinessreview_adminmenu') ? Zend_Registry::get('sesbusinessreview_adminmenu') : null;
    if(!empty($sesbusinessreview_adminmenu)) { ?>
    <?php if( count($this->subNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subNavigation)->render();?>
      </div>
    <?php endif; ?>
    <?php } ?>
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
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<style type="text/css">
.sesbasic_back_icon{
  background-image: url(<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/back.png);
}
</style>
<script>  
  window.addEvent('domready', function() {
    showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.review.summary', 1) ?>");
    allowReview("<?php echo Engine_Api::_()->getApi('core', 'sesbusinessreview')->allowReviewRating() ?>");
    if(document.getElementById('sesbusinessreview_review_votes'))
      showReviewVotes(document.getElementById('sesbusinessreview_review_votes').value);
  });
  function showReviewVotes(value){
    if(value == 1){
      document.getElementById('sesbusinessreview_review_first-wrapper').style.display = 'block';		
      document.getElementById('sesbusinessreview_review_second-wrapper').style.display = 'block';		
      document.getElementById('sesbusinessreview_review_third-wrapper').style.display = 'block';
    } else{
      document.getElementById('sesbusinessreview_review_first-wrapper').style.display = 'none';		
      document.getElementById('sesbusinessreview_review_second-wrapper').style.display = 'none';		
      document.getElementById('sesbusinessreview_review_third-wrapper').style.display = 'none';
    }
  } 
  function showEditor(value) {
    if(value == 1) {
      if($('sesbusinessreview_show_tinymce-wrapper'))
      $('sesbusinessreview_show_tinymce-wrapper').style.display = 'block';
    } else {
      if($('sesbusinessreview_show_tinymce-wrapper'))
      $('sesbusinessreview_show_tinymce-wrapper').style.display = 'none';
    }
  }
  function allowReview(value) {
    if(value == 1) {
      if($('sesbusinessreview_allow_owner-wrapper'))
      $('sesbusinessreview_allow_owner-wrapper').style.display = 'block';
      if($('sesbusinessreview_show_pros-wrapper'))
      $('sesbusinessreview_show_pros-wrapper').style.display = 'block';
      if($('sesbusinessreview_show_cons-wrapper'))
      $('sesbusinessreview_show_cons-wrapper').style.display = 'block';
      if($('sesbusinessreview_review_title-wrapper'))
      $('sesbusinessreview_review_title-wrapper').style.display = 'block';
      if($('sesbusinessreview_review_summary-wrapper'))
      $('sesbusinessreview_review_summary-wrapper').style.display = 'block';
      if($('sesbusinessreview_show_tinymce-wrapper'))
      $('sesbusinessreview_show_tinymce-wrapper').style.display = 'block';
      if($('sesbusinessreview_show_recommended-wrapper'))
      $('sesbusinessreview_show_recommended-wrapper').style.display = 'block';
      if($('sesbusinessreview_allow_share-wrapper'))
      $('sesbusinessreview_allow_share-wrapper').style.display = 'block';
      if($('sesbusinessreview_show_report-wrapper'))
      $('sesbusinessreview_show_report-wrapper').style.display = 'block';
      showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.review.summary', 1) ?>");
      if($('sesbusinessreview_rating_stars_one-wrapper'))
      $('sesbusinessreview_rating_stars_one-wrapper').style.display = 'block';
      if($('sesbusinessreview_rating_stars_two-wrapper'))
      $('sesbusinessreview_rating_stars_two-wrapper').style.display = 'block';
      if($('sesbusinessreview_rating_stars_three-wrapper'))
      $('sesbusinessreview_rating_stars_three-wrapper').style.display = 'block';
      if($('sesbusinessreview_rating_stars_four-wrapper'))
      $('sesbusinessreview_rating_stars_four-wrapper').style.display = 'block';
      if($('sesbusinessreview_rating_stars_five-wrapper'))
      $('sesbusinessreview_rating_stars_five-wrapper').style.display = 'block';
      
    } else {
      if($('sesbusinessreview_allow_owner-wrapper'))
      $('sesbusinessreview_allow_owner-wrapper').style.display = 'none';
      if($('sesbusinessreview_show_pros-wrapper'))
      $('sesbusinessreview_show_pros-wrapper').style.display = 'none';
      if($('sesbusinessreview_show_cons-wrapper'))
      $('sesbusinessreview_show_cons-wrapper').style.display = 'none';
      if($('sesbusinessreview_review_title-wrapper'))
      $('sesbusinessreview_review_title-wrapper').style.display = 'none';
      if($('sesbusinessreview_review_summary-wrapper'))
      $('sesbusinessreview_review_summary-wrapper').style.display = 'none';
      if($('sesbusinessreview_show_tinymce-wrapper'))
      $('sesbusinessreview_show_tinymce-wrapper').style.display = 'none';
      if($('sesbusinessreview_show_recommended-wrapper'))
      $('sesbusinessreview_show_recommended-wrapper').style.display = 'none';
      if($('sesbusinessreview_allow_share-wrapper'))
      $('sesbusinessreview_allow_share-wrapper').style.display = 'none';
      if($('sesbusinessreview_show_report-wrapper'))
      $('sesbusinessreview_show_report-wrapper').style.display = 'none';
      showEditor(0);
      if($('sesbusinessreview_rating_stars_one-wrapper'))
      $('sesbusinessreview_rating_stars_one-wrapper').style.display = 'none';
      if($('sesbusinessreview_rating_stars_two-wrapper'))
      $('sesbusinessreview_rating_stars_two-wrapper').style.display = 'none';
      if($('sesbusinessreview_rating_stars_three-wrapper'))
      $('sesbusinessreview_rating_stars_three-wrapper').style.display = 'none';
      if($('sesbusinessreview_rating_stars_four-wrapper'))
      $('sesbusinessreview_rating_stars_four-wrapper').style.display = 'none';
      if($('sesbusinessreview_rating_stars_five-wrapper'))
      $('sesbusinessreview_rating_stars_five-wrapper').style.display = 'none';
    }
  }
</script>
