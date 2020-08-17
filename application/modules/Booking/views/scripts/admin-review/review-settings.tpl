<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: review-settings.tpl  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Booking/views/scripts/dismiss_message.tpl';?>
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
<script>  
  window.addEvent('domready', function() {
    showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.review.summary', 1) ?>");
	allowReview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.allow.review', 1) ?>");
  });
  
function showEditor(value) {
  if(value == 1) {
    if($('sesproduct_review_show_tinymce-wrapper'))
      $('sesproduct_review_show_tinymce-wrapper').style.display = 'block';
  } else {
    if($('sesproduct_review_show_tinymce-wrapper'))
    $('sesproduct_review_show_tinymce-wrapper').style.display = 'none';
  }
  
}
function showReviewVotes(value) {
  if(value == 1) {
    if($('estore_review_first-wrapper'))
      $('estore_review_first-wrapper').style.display = 'block';
     if($('estore_review_second-wrapper'))
      $('estore_review_second-wrapper').style.display = 'block';
    if($('estore_review_third-wrapper'))
      $('estore_review_third-wrapper').style.display = 'block';
  } else {
     if($('estore_review_first-wrapper'))
      $('estore_review_first-wrapper').style.display = 'none';
     if($('estore_review_second-wrapper'))
      $('estore_review_second-wrapper').style.display = 'none';
    if($('estore_review_third-wrapper'))
      $('estore_review_third-wrapper').style.display = 'none';
  }
  
}
function allowReview(value) {
  if(value == 1) {
    if($('sesproduct_review_allow_owner-wrapper'))
      $('sesproduct_review_allow_owner-wrapper').style.display = 'block';
	if($('sesproduct_review_show_pros-wrapper'))
      $('sesproduct_review_show_pros-wrapper').style.display = 'block';
	if($('sesproduct_review_show_cons-wrapper'))
      $('sesproduct_review_show_cons-wrapper').style.display = 'block';
	if($('sesproduct_review_review_title-wrapper'))
      $('sesproduct_review_review_title-wrapper').style.display = 'block';
	if($('sesproduct_review_review_summary-wrapper'))
      $('sesproduct_review_review_summary-wrapper').style.display = 'block';
	if($('sesproduct_review_show_tinymce-wrapper'))
      $('sesproduct_review_show_tinymce-wrapper').style.display = 'block';
	if($('sesproduct_review_show_recommended-wrapper'))
      $('sesproduct_review_show_recommended-wrapper').style.display = 'block';
	if($('sesproduct_review_allow_share-wrapper'))
      $('sesproduct_review_allow_share-wrapper').style.display = 'block';
	if($('sesproduct_review_show_report-wrapper'))
      $('sesproduct_review_show_report-wrapper').style.display = 'block';
	showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.review.summary', 1) ?>");
  } else {
    if($('sesproduct_review_allow_owner-wrapper'))
      $('sesproduct_review_allow_owner-wrapper').style.display = 'none';
	if($('sesproduct_review_show_pros-wrapper'))
      $('sesproduct_review_show_pros-wrapper').style.display = 'none';
	if($('sesproduct_review_show_cons-wrapper'))
      $('sesproduct_review_show_cons-wrapper').style.display = 'none';
	if($('sesproduct_review_review_title-wrapper'))
      $('sesproduct_review_review_title-wrapper').style.display = 'none';
	if($('sesproduct_review_review_summary-wrapper'))
      $('sesproduct_review_review_summary-wrapper').style.display = 'none';
	if($('sesproduct_review_show_tinymce-wrapper'))
      $('sesproduct_review_show_tinymce-wrapper').style.display = 'none';
	if($('sesproduct_review_show_recommended-wrapper'))
      $('sesproduct_review_show_recommended-wrapper').style.display = 'none';
	if($('sesproduct_review_allow_share-wrapper'))
      $('sesproduct_review_allow_share-wrapper').style.display = 'none';
	if($('sesproduct_review_show_report-wrapper'))
      $('sesproduct_review_show_report-wrapper').style.display = 'none';
	showEditor(0);
  }
}
</script>
