<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: review-settings.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic-form'>
  <div>
      <?php if( count($this->subsubNavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subsubNavigation)->render(); ?>
      </div>
    <?php endif; ?>
    <div class="sesbasic-form-cont">
      <div class='settings sesbasic_admin_form'>
        <?php echo $this->form->render($this); ?>
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
    showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.review.summary', 1) ?>");
    allowReview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.review', 1) ?>");
    showReviewVotes("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.review.votes', 1) ?>");
  });
  
function showEditor(value) {
  if(value == 1) {
    if($('sesproduct_show_tinymce-wrapper'))
      $('sesproduct_show_tinymce-wrapper').style.display = 'block';
  } else {
    if($('sesproduct_show_tinymce-wrapper'))
    $('sesproduct_show_tinymce-wrapper').style.display = 'none';
  }
  
}
function showReviewVotes(value) {
  if(value == 1) {
    if($('sesproduct_review_first-wrapper'))
      $('sesproduct_review_first-wrapper').style.display = 'block';
     if($('sesproduct_review_second-wrapper'))
      $('sesproduct_review_second-wrapper').style.display = 'block';
    if($('sesproduct_review_third-wrapper'))
      $('sesproduct_review_third-wrapper').style.display = 'block';
  } else {
     if($('sesproduct_review_first-wrapper'))
      $('sesproduct_review_first-wrapper').style.display = 'none';
     if($('sesproduct_review_second-wrapper'))
      $('sesproduct_review_second-wrapper').style.display = 'none';
    if($('sesproduct_review_third-wrapper'))
      $('sesproduct_review_third-wrapper').style.display = 'none';
  }
  
}
function allowReview(value) {
  if(value == 1) {
    if($('sesproduct_allow_owner-wrapper'))
      $('sesproduct_allow_owner-wrapper').style.display = 'block';
	if($('sesproduct_show_pros-wrapper'))
      $('sesproduct_show_pros-wrapper').style.display = 'block';
	if($('sesproduct_show_cons-wrapper'))
      $('sesproduct_show_cons-wrapper').style.display = 'block';
	if($('sesproduct_review_title-wrapper'))
      $('sesproduct_review_title-wrapper').style.display = 'block';
	if($('sesproduct_review_summary-wrapper'))
      $('sesproduct_review_summary-wrapper').style.display = 'block';
	if($('sesproduct_show_tinymce-wrapper'))
      $('sesproduct_show_tinymce-wrapper').style.display = 'block';
	if($('sesproduct_show_recommended-wrapper'))
      $('sesproduct_show_recommended-wrapper').style.display = 'block';
	if($('sesproduct_allow_share-wrapper'))
      $('sesproduct_allow_share-wrapper').style.display = 'block';
	if($('sesproduct_show_report-wrapper'))
      $('sesproduct_show_report-wrapper').style.display = 'block';
  if($('sesproduct_rating_stars_one-wrapper'))
      $('sesproduct_rating_stars_one-wrapper').style.display = 'block';
  if($('sesproduct_rating_stars_two-wrapper'))
      $('sesproduct_rating_stars_two-wrapper').style.display = 'block';
  if($('sesproduct_rating_stars_three-wrapper'))
      $('sesproduct_rating_stars_three-wrapper').style.display = 'block';
  if($('sesproduct_rating_stars_four-wrapper'))
      $('sesproduct_rating_stars_four-wrapper').style.display = 'block';
  if($('sesproduct_rating_stars_five-wrapper'))
      $('sesproduct_rating_stars_five-wrapper').style.display = 'block';
  if($('sesproduct_review_votes-wrapper'))
      $('sesproduct_review_votes-wrapper').style.display = 'block';
    showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.review.summary', 1) ?>");
    showReviewVotes("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.review.votes', 1) ?>");
  } else {
    if($('sesproduct_allow_owner-wrapper'))
      $('sesproduct_allow_owner-wrapper').style.display = 'none';
	if($('sesproduct_show_pros-wrapper'))
      $('sesproduct_show_pros-wrapper').style.display = 'none';
	if($('sesproduct_show_cons-wrapper'))
      $('sesproduct_show_cons-wrapper').style.display = 'none';
	if($('sesproduct_review_title-wrapper'))
      $('sesproduct_review_title-wrapper').style.display = 'none';
	if($('sesproduct_review_summary-wrapper'))
      $('sesproduct_review_summary-wrapper').style.display = 'none';
	if($('sesproduct_show_tinymce-wrapper'))
      $('sesproduct_show_tinymce-wrapper').style.display = 'none';
	if($('sesproduct_show_recommended-wrapper'))
      $('sesproduct_show_recommended-wrapper').style.display = 'none';
	if($('sesproduct_allow_share-wrapper'))
      $('sesproduct_allow_share-wrapper').style.display = 'none';
	if($('sesproduct_show_report-wrapper'))
      $('sesproduct_show_report-wrapper').style.display = 'none';
  if($('sesproduct_rating_stars_one-wrapper'))
      $('sesproduct_rating_stars_one-wrapper').style.display = 'none';
  if($('sesproduct_rating_stars_two-wrapper'))
      $('sesproduct_rating_stars_two-wrapper').style.display = 'none';
  if($('sesproduct_rating_stars_three-wrapper'))
      $('sesproduct_rating_stars_three-wrapper').style.display = 'none';
  if($('sesproduct_rating_stars_four-wrapper'))
      $('sesproduct_rating_stars_four-wrapper').style.display = 'none';
  if($('sesproduct_rating_stars_five-wrapper'))
      $('sesproduct_rating_stars_five-wrapper').style.display = 'none';
   if($('sesproduct_review_votes-wrapper'))
      $('sesproduct_review_votes-wrapper').style.display = 'none';
  showReviewVotes(0);
	showEditor(0);
  }
}
</script>
