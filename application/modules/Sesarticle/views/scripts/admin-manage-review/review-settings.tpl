<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: review-settings.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesarticle/views/scripts/dismiss_message.tpl';?>

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
  showEditor("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.review.summary', 1); ?>");
  allowReview("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesarticle.allow.review', 1); ?>");
});

function allowReview(value) {
	if(value == 1) {
		if($('sesarticle_allow_owner-wrapper'))
		$('sesarticle_allow_owner-wrapper').style.display = 'block';
		if($('sesarticle_allow_reviewother-wrapper'))
		$('sesarticle_allow_reviewother-wrapper').style.display = 'block';
		if($('sesarticle_show_pros-wrapper'))
		$('sesarticle_show_pros-wrapper').style.display = 'block';
		if($('sesarticle_show_cons-wrapper'))
		$('sesarticle_show_cons-wrapper').style.display = 'block';
		if($('sesarticle_review_title-wrapper'))
		$('sesarticle_review_title-wrapper').style.display = 'block';
		if($('sesarticle_review_summary-wrapper'))
		$('sesarticle_review_summary-wrapper').style.display = 'block';
		if($('sesarticle_show_tinymce-wrapper'))
		$('sesarticle_show_tinymce-wrapper').style.display = 'block';
		if($('sesarticle_show_recommended-wrapper'))
		$('sesarticle_show_recommended-wrapper').style.display = 'block';
		if($('sesarticle_like_comment-wrapper'))
		$('sesarticle_like_comment-wrapper').style.display = 'block';
		if($('sesarticle_allow_share-wrapper'))
		$('sesarticle_allow_share-wrapper').style.display = 'block';
		if($('sesarticle_show_report-wrapper'))
		$('sesarticle_show_report-wrapper').style.display = 'block';
	} else { 
		if($('sesarticle_allow_owner-wrapper'))
		$('sesarticle_allow_owner-wrapper').style.display = 'none';
		if($('sesarticle_allow_reviewother-wrapper'))
		$('sesarticle_allow_reviewother-wrapper').style.display = 'none';
		if($('sesarticle_show_pros-wrapper'))
		$('sesarticle_show_pros-wrapper').style.display = 'none';
		if($('sesarticle_show_cons-wrapper'))
		$('sesarticle_show_cons-wrapper').style.display = 'none';
		if($('sesarticle_review_title-wrapper'))
		$('sesarticle_review_title-wrapper').style.display = 'none';
		if($('sesarticle_review_summary-wrapper'))
		$('sesarticle_review_summary-wrapper').style.display = 'none';
		if($('sesarticle_show_tinymce-wrapper'))
		$('sesarticle_show_tinymce-wrapper').style.display = 'none';
		if($('sesarticle_show_recommended-wrapper'))
		$('sesarticle_show_recommended-wrapper').style.display = 'none';
		if($('sesarticle_like_comment-wrapper'))
		$('sesarticle_like_comment-wrapper').style.display = 'none';
		if($('sesarticle_allow_share-wrapper'))
		$('sesarticle_allow_share-wrapper').style.display = 'none';
		if($('sesarticle_show_report-wrapper'))
		$('sesarticle_show_report-wrapper').style.display = 'none';
	}
}
  
function showEditor(value) {
  if(value == 1) {
    if($('sesarticle_show_tinymce-wrapper'))
      $('sesarticle_show_tinymce-wrapper').style.display = 'block';
  } else {
    if($('sesarticle_show_tinymce-wrapper'))
    $('sesarticle_show_tinymce-wrapper').style.display = 'none';
  }
}
</script>