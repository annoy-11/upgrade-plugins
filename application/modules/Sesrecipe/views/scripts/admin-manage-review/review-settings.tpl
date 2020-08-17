<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: review-settings.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesrecipe/views/scripts/dismiss_message.tpl';?>

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
  showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.review.summary', 1); ?>");
  allowReview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.allow.review', 1); ?>");
});

function allowReview(value) {
	if(value == 1) {
		if($('sesrecipe_allow_owner-wrapper'))
		$('sesrecipe_allow_owner-wrapper').style.display = 'block';
		if($('sesrecipe_allow_reviewother-wrapper'))
		$('sesrecipe_allow_reviewother-wrapper').style.display = 'block';
		if($('sesrecipe_show_pros-wrapper'))
		$('sesrecipe_show_pros-wrapper').style.display = 'block';
		if($('sesrecipe_show_cons-wrapper'))
		$('sesrecipe_show_cons-wrapper').style.display = 'block';
		if($('sesrecipe_review_title-wrapper'))
		$('sesrecipe_review_title-wrapper').style.display = 'block';
		if($('sesrecipe_review_summary-wrapper'))
		$('sesrecipe_review_summary-wrapper').style.display = 'block';
		if($('sesrecipe_show_tinymce-wrapper'))
		$('sesrecipe_show_tinymce-wrapper').style.display = 'block';
		if($('sesrecipe_show_recommended-wrapper'))
		$('sesrecipe_show_recommended-wrapper').style.display = 'block';
		if($('sesrecipe_like_comment-wrapper'))
		$('sesrecipe_like_comment-wrapper').style.display = 'block';
		if($('sesrecipe_allow_share-wrapper'))
		$('sesrecipe_allow_share-wrapper').style.display = 'block';
		if($('sesrecipe_show_report-wrapper'))
		$('sesrecipe_show_report-wrapper').style.display = 'block';
	} else { 
		if($('sesrecipe_allow_owner-wrapper'))
		$('sesrecipe_allow_owner-wrapper').style.display = 'none';
		if($('sesrecipe_allow_reviewother-wrapper'))
		$('sesrecipe_allow_reviewother-wrapper').style.display = 'none';
		if($('sesrecipe_show_pros-wrapper'))
		$('sesrecipe_show_pros-wrapper').style.display = 'none';
		if($('sesrecipe_show_cons-wrapper'))
		$('sesrecipe_show_cons-wrapper').style.display = 'none';
		if($('sesrecipe_review_title-wrapper'))
		$('sesrecipe_review_title-wrapper').style.display = 'none';
		if($('sesrecipe_review_summary-wrapper'))
		$('sesrecipe_review_summary-wrapper').style.display = 'none';
		if($('sesrecipe_show_tinymce-wrapper'))
		$('sesrecipe_show_tinymce-wrapper').style.display = 'none';
		if($('sesrecipe_show_recommended-wrapper'))
		$('sesrecipe_show_recommended-wrapper').style.display = 'none';
		if($('sesrecipe_like_comment-wrapper'))
		$('sesrecipe_like_comment-wrapper').style.display = 'none';
		if($('sesrecipe_allow_share-wrapper'))
		$('sesrecipe_allow_share-wrapper').style.display = 'none';
		if($('sesrecipe_show_report-wrapper'))
		$('sesrecipe_show_report-wrapper').style.display = 'none';
	}
}
  
function showEditor(value) {
  if(value == 1) {
    if($('sesrecipe_show_tinymce-wrapper'))
      $('sesrecipe_show_tinymce-wrapper').style.display = 'block';
  } else {
    if($('sesrecipe_show_tinymce-wrapper'))
    $('sesrecipe_show_tinymce-wrapper').style.display = 'none';
  }
}
</script>