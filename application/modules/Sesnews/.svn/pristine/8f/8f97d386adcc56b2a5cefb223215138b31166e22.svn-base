<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesnews
 * @package    Sesnews
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: review-settings.tpl  2019-02-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesnews/views/scripts/dismiss_message.tpl';?>

<div class='clear sesbasic-form'>
  <div>
    <?php if( count($this->subnavigation) ): ?>
      <div class='sesbasic-admin-sub-tabs'>
        <?php echo $this->navigation()->menu()->setContainer($this->subnavigation)->render(); ?>
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
  showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesnews.review.summary', 1); ?>");
  allowReview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesnews.allow.review', 1); ?>");
});

function allowReview(value) {
	if(value == 1) {
		if($('sesnews_allow_owner-wrapper'))
		$('sesnews_allow_owner-wrapper').style.display = 'block';
		if($('sesnews_allow_reviewother-wrapper'))
		$('sesnews_allow_reviewother-wrapper').style.display = 'block';
		if($('sesnews_show_pros-wrapper'))
		$('sesnews_show_pros-wrapper').style.display = 'block';
		if($('sesnews_show_cons-wrapper'))
		$('sesnews_show_cons-wrapper').style.display = 'block';
		if($('sesnews_review_title-wrapper'))
		$('sesnews_review_title-wrapper').style.display = 'block';
		if($('sesnews_review_summary-wrapper'))
		$('sesnews_review_summary-wrapper').style.display = 'block';
		if($('sesnews_show_tinymce-wrapper'))
		$('sesnews_show_tinymce-wrapper').style.display = 'block';
		if($('sesnews_show_recommended-wrapper'))
		$('sesnews_show_recommended-wrapper').style.display = 'block';
		if($('sesnews_like_comment-wrapper'))
		$('sesnews_like_comment-wrapper').style.display = 'block';
		if($('sesnews_allow_share-wrapper'))
		$('sesnews_allow_share-wrapper').style.display = 'block';
		if($('sesnews_show_report-wrapper'))
		$('sesnews_show_report-wrapper').style.display = 'block';
	} else { 
		if($('sesnews_allow_owner-wrapper'))
		$('sesnews_allow_owner-wrapper').style.display = 'none';
		if($('sesnews_allow_reviewother-wrapper'))
		$('sesnews_allow_reviewother-wrapper').style.display = 'none';
		if($('sesnews_show_pros-wrapper'))
		$('sesnews_show_pros-wrapper').style.display = 'none';
		if($('sesnews_show_cons-wrapper'))
		$('sesnews_show_cons-wrapper').style.display = 'none';
		if($('sesnews_review_title-wrapper'))
		$('sesnews_review_title-wrapper').style.display = 'none';
		if($('sesnews_review_summary-wrapper'))
		$('sesnews_review_summary-wrapper').style.display = 'none';
		if($('sesnews_show_tinymce-wrapper'))
		$('sesnews_show_tinymce-wrapper').style.display = 'none';
		if($('sesnews_show_recommended-wrapper'))
		$('sesnews_show_recommended-wrapper').style.display = 'none';
		if($('sesnews_like_comment-wrapper'))
		$('sesnews_like_comment-wrapper').style.display = 'none';
		if($('sesnews_allow_share-wrapper'))
		$('sesnews_allow_share-wrapper').style.display = 'none';
		if($('sesnews_show_report-wrapper'))
		$('sesnews_show_report-wrapper').style.display = 'none';
	}
}
  
function showEditor(value) {
  if(value == 1) {
    if($('sesnews_show_tinymce-wrapper'))
      $('sesnews_show_tinymce-wrapper').style.display = 'block';
  } else {
    if($('sesnews_show_tinymce-wrapper'))
    $('sesnews_show_tinymce-wrapper').style.display = 'none';
  }
}
</script>
