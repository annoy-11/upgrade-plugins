<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-photo.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'sesarticle', array('article' => $this->article));	
?>
	<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
	<div class="sesbasic_dashboard_form">
    <div class="sesarticle_edit_photo_article">
      <?php echo $this->form->render() ?> 
    </div> 
	</div>
<?php if(!$this->is_ajax) { ?>
	</div>
</div>
<?php } ?>


<script type="application/javascript">
sesJqueryObject(document).on('submit','#EditPhoto',function(e){
	if(sesJqueryObject('#Filedata-label').find('label').hasClass('required') && sesJqueryObject('#Filedata').val() === ''){
		var objectError = sesJqueryObject('#Filedata');
		alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
		var errorFirstObject = sesJqueryObject(objectError).parent().parent();
		sesJqueryObject('html, body').animate({
		scrollTop: errorFirstObject.offset().top
		}, 2000);
		return false;
	}
});
</script>