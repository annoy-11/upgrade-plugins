<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: review-settings.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/dismiss_message.tpl';?>
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
  allowReview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.review', 1) ?>");
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.review', 1)): ?>
    showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.review.summary', 1) ?>");
    showReviewVotes("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.review.votes', 1) ?>");
  <?php endif; ?>
});
function showEditor(value) {
  if(value == 1) {
    if($('courses_show_tinymce-wrapper'))
      $('courses_show_tinymce-wrapper').style.display = 'block';
  } else {
    if($('courses_show_tinymce-wrapper'))
    $('courses_show_tinymce-wrapper').style.display = 'none';
  }
  
}
function showReviewVotes(value) {
  if(value == 1) {
    if($('courses_review_first-wrapper'))
      $('courses_review_first-wrapper').style.display = 'block';
     if($('courses_review_second-wrapper'))
      $('courses_review_second-wrapper').style.display = 'block';
    if($('courses_review_third-wrapper'))
      $('courses_review_third-wrapper').style.display = 'block';
  } else {
     if($('courses_review_first-wrapper'))
      $('courses_review_first-wrapper').style.display = 'none';
     if($('courses_review_second-wrapper'))
      $('courses_review_second-wrapper').style.display = 'none';
    if($('courses_review_third-wrapper'))
      $('courses_review_third-wrapper').style.display = 'none';
  }
  
}
function allowReview(value) {
  if(value == 1) {
    if($('courses_allow_owner_review-wrapper'))
      $('courses_allow_owner_review-wrapper').style.display = 'block';
	if($('courses_show_pros-wrapper'))
      $('courses_show_pros-wrapper').style.display = 'block';
	if($('courses_show_cons-wrapper'))
      $('courses_show_cons-wrapper').style.display = 'block';
	if($('courses_review_title-wrapper'))
      $('courses_review_title-wrapper').style.display = 'block';
	if($('courses_review_summary-wrapper'))
      $('courses_review_summary-wrapper').style.display = 'block';
	if($('courses_show_tinymce-wrapper'))
      $('courses_show_tinymce-wrapper').style.display = 'block';
	if($('courses_show_recommended-wrapper'))
      $('courses_show_recommended-wrapper').style.display = 'block';
	if($('courses_allow_share-wrapper'))
      $('courses_allow_share-wrapper').style.display = 'block';
	if($('courses_show_report-wrapper'))
      $('courses_show_report-wrapper').style.display = 'block';
  if($('courses_rating_stars_one-wrapper'))
      $('courses_rating_stars_one-wrapper').style.display = 'block';
  if($('courses_rating_stars_two-wrapper'))
      $('courses_rating_stars_two-wrapper').style.display = 'block';
  if($('courses_rating_stars_three-wrapper'))
      $('courses_rating_stars_three-wrapper').style.display = 'block';
  if($('courses_rating_stars_four-wrapper'))
      $('courses_rating_stars_four-wrapper').style.display = 'block';
  if($('courses_rating_stars_five-wrapper'))
      $('courses_rating_stars_five-wrapper').style.display = 'block';
  if($('courses_review_votes-wrapper'))
      $('courses_review_votes-wrapper').style.display = 'block';
    showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.review.summary', 1) ?>");
    showReviewVotes("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.review.votes', 1) ?>");
  } else {
    if($('courses_allow_owner_review-wrapper'))
      $('courses_allow_owner_review-wrapper').style.display = 'none';
	if($('courses_show_pros-wrapper'))
      $('courses_show_pros-wrapper').style.display = 'none';
	if($('courses_show_cons-wrapper'))
      $('courses_show_cons-wrapper').style.display = 'none';
	if($('courses_review_title-wrapper'))
      $('courses_review_title-wrapper').style.display = 'none';
	if($('courses_review_summary-wrapper'))
      $('courses_review_summary-wrapper').style.display = 'none';
	if($('courses_show_tinymce-wrapper'))
      $('courses_show_tinymce-wrapper').style.display = 'none';
	if($('courses_show_recommended-wrapper'))
      $('courses_show_recommended-wrapper').style.display = 'none';
	if($('courses_allow_share-wrapper'))
      $('courses_allow_share-wrapper').style.display = 'none';
	if($('courses_show_report-wrapper'))
      $('courses_show_report-wrapper').style.display = 'none';
  if($('courses_rating_stars_one-wrapper'))
      $('courses_rating_stars_one-wrapper').style.display = 'none';
  if($('courses_rating_stars_two-wrapper'))
      $('courses_rating_stars_two-wrapper').style.display = 'none';
  if($('courses_rating_stars_three-wrapper'))
      $('courses_rating_stars_three-wrapper').style.display = 'none';
  if($('courses_rating_stars_four-wrapper'))
      $('courses_rating_stars_four-wrapper').style.display = 'none';
  if($('courses_rating_stars_five-wrapper'))
      $('courses_rating_stars_five-wrapper').style.display = 'none';
   if($('courses_review_votes-wrapper'))
      $('courses_review_votes-wrapper').style.display = 'none';
  showReviewVotes(0);
	showEditor(0);
  }
}
</script>
