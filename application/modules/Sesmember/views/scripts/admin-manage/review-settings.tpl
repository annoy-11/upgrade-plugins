<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: review-settings.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmember/views/scripts/dismiss_message.tpl';?>
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
<style type="text/css">
.sesbasic_back_icon{
  background-image: url(<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/back.png);
}
</style>
<script>  
  window.addEvent('domready', function() {
    showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.summary', 1) ?>");
    allowReview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.allow.review', 1) ?>");
    if(document.getElementById('sesmember_review_votes'))
      showReviewVotes(document.getElementById('sesmember_review_votes').value);
  });
  function showReviewVotes(value){
    if(value == 1){
      document.getElementById('sesmember_review_first-wrapper').style.display = 'block';		
      document.getElementById('sesmember_review_second-wrapper').style.display = 'block';		
      document.getElementById('sesmember_review_third-wrapper').style.display = 'block';
    } else{
      document.getElementById('sesmember_review_first-wrapper').style.display = 'none';		
      document.getElementById('sesmember_review_second-wrapper').style.display = 'none';		
      document.getElementById('sesmember_review_third-wrapper').style.display = 'none';
    }
  } 
  function showEditor(value) {
    if(value == 1) {
      if($('sesmember_show_tinymce-wrapper'))
      $('sesmember_show_tinymce-wrapper').style.display = 'block';
    } else {
      if($('sesmember_show_tinymce-wrapper'))
      $('sesmember_show_tinymce-wrapper').style.display = 'none';
    }
  }
  function allowReview(value) {
    if(value == 1) {
      if($('sesmember_allow_owner-wrapper'))
      $('sesmember_allow_owner-wrapper').style.display = 'block';
      if($('sesmember_show_pros-wrapper'))
      $('sesmember_show_pros-wrapper').style.display = 'block';
      if($('sesmember_show_cons-wrapper'))
      $('sesmember_show_cons-wrapper').style.display = 'block';
      if($('sesmember_review_title-wrapper'))
      $('sesmember_review_title-wrapper').style.display = 'block';
      if($('sesmember_review_summary-wrapper'))
      $('sesmember_review_summary-wrapper').style.display = 'block';
      if($('sesmember_show_tinymce-wrapper'))
      $('sesmember_show_tinymce-wrapper').style.display = 'block';
      if($('sesmember_show_recommended-wrapper'))
      $('sesmember_show_recommended-wrapper').style.display = 'block';
      if($('sesmember_allow_share-wrapper'))
      $('sesmember_allow_share-wrapper').style.display = 'block';
      if($('sesmember_show_report-wrapper'))
      $('sesmember_show_report-wrapper').style.display = 'block';
      showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.review.summary', 1) ?>");
      if($('sesmember_rating_stars_one-wrapper'))
      $('sesmember_rating_stars_one-wrapper').style.display = 'block';
      if($('sesmember_rating_stars_two-wrapper'))
      $('sesmember_rating_stars_two-wrapper').style.display = 'block';
      if($('sesmember_rating_stars_three-wrapper'))
      $('sesmember_rating_stars_three-wrapper').style.display = 'block';
      if($('sesmember_rating_stars_four-wrapper'))
      $('sesmember_rating_stars_four-wrapper').style.display = 'block';
      if($('sesmember_rating_stars_five-wrapper'))
      $('sesmember_rating_stars_five-wrapper').style.display = 'block';
      
    } else {
      if($('sesmember_allow_owner-wrapper'))
      $('sesmember_allow_owner-wrapper').style.display = 'none';
      if($('sesmember_show_pros-wrapper'))
      $('sesmember_show_pros-wrapper').style.display = 'none';
      if($('sesmember_show_cons-wrapper'))
      $('sesmember_show_cons-wrapper').style.display = 'none';
      if($('sesmember_review_title-wrapper'))
      $('sesmember_review_title-wrapper').style.display = 'none';
      if($('sesmember_review_summary-wrapper'))
      $('sesmember_review_summary-wrapper').style.display = 'none';
      if($('sesmember_show_tinymce-wrapper'))
      $('sesmember_show_tinymce-wrapper').style.display = 'none';
      if($('sesmember_show_recommended-wrapper'))
      $('sesmember_show_recommended-wrapper').style.display = 'none';
      if($('sesmember_allow_share-wrapper'))
      $('sesmember_allow_share-wrapper').style.display = 'none';
      if($('sesmember_show_report-wrapper'))
      $('sesmember_show_report-wrapper').style.display = 'none';
      showEditor(0);
      if($('sesmember_rating_stars_one-wrapper'))
      $('sesmember_rating_stars_one-wrapper').style.display = 'none';
      if($('sesmember_rating_stars_two-wrapper'))
      $('sesmember_rating_stars_two-wrapper').style.display = 'none';
      if($('sesmember_rating_stars_three-wrapper'))
      $('sesmember_rating_stars_three-wrapper').style.display = 'none';
      if($('sesmember_rating_stars_four-wrapper'))
      $('sesmember_rating_stars_four-wrapper').style.display = 'none';
      if($('sesmember_rating_stars_five-wrapper'))
      $('sesmember_rating_stars_five-wrapper').style.display = 'none';
    }
  }
</script>