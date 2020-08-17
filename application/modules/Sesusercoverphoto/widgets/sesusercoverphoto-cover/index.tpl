<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesusercoverphoto/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesusercoverphoto/externals/scripts/slideshowmodernizr.js'); ?>
<?php if($this->sesmemberenable): ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<?php endif; ?>
<?php
if(isset($this->can_edit)){
	$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/jquery.drag-n-crop.css');
  //First, include the Webcam.js JavaScript Library 
  $base_url = $this->layout()->staticBaseUrl;
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/webcam.js');
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/jquery-ui.min.js'); 
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');
  $this->headScript()->appendFile($base_url . 'application/modules/Sesbasic/externals/scripts/jquery.drag-n-crop.js');
}

 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/member/membership.js'); 
?>
<script type="application/javascript">
var review_cover_data_rate_id;
var pre_rate_cover = "<?php echo $this->total_rating_average == '' ? 0 : $this->total_rating_average  ;?>";
<?php if(in_array('rating',$this->option) && $this->notshowRating){ ?>
  en4.core.runonce.add(function() {
		var canrated = "<?php echo $this->canCreateRating ? $this->canCreateRating  : 0 ;?>";
    var resource_id = <?php echo $this->subject->user_id;?>;
    var viewer = <?php echo $this->viewer->getIdentity();?>;
    new_text = '';
    var rating_over_cover = window.rating_over_cover = function(rating) {
      
			if( viewer == 0 ) {
        //$('rating_text').innerHTML = "<?php echo $this->translate('please login to rate');?>";
				return;
      }else if(canrated == 0){
					return;
			} else {						
				
      }
    }
    var set_rating_cover = window.set_rating_cover = function(rating_text) {
      var rating = pre_rate_cover;
      if (new_text != ''){
        $('rating_text_cover').innerHTML = new_text;
      }
      else{
				if(typeof rating_text == 'undefined'){
        	$('rating_text_cover').innerHTML = "<?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";
				}else{
					$('rating_text_cover').innerHTML = rating_text;
				}
      }
      for(var x=1; x<=parseInt(rating); x++) {
        $('rate_cover_'+x).set('class', 'fa fa-star');
      }

      for(var x=parseInt(rating)+1; x<=5; x++) {
        $('rate_cover_'+x).set('class', 'fa fa fa-star-o star-disable');
      }
      var remainder = Math.round(rating)-rating;
      if (remainder <= 0.5 && remainder !=0){
        var last = parseInt(rating)+1;
        $('rate_cover_'+last).set('class', 'fa fa-star-half-o');
      }
    }
		
    var rate_cover = window.rate_cover = function(rating) {
				review_cover_data_rate_id = rating;
				<?php if(!$this->notshowRating){ ?>
						return;
				<?php } ?>
				var elem = sesJqueryObject('.tab_layout_sesmember_member_reviews');
				 if(elem.find('a').length)
					elem.find('a').trigger('click');
					else
					elem.trigger('click');
					sesJqueryObject('.sesmember_review_profile_btn').find('a').trigger('click');
				return;
		}
    set_rating_cover();
  });
<?php } ?>
</script>
<?php if($this->type == 1){ ?>
<?php include APPLICATION_PATH . '/application/modules/Sesusercoverphoto/widgets/sesusercoverphoto-cover/_type1.tpl'; ?>
<?php }else if($this->type == 2){ ?>
<?php include APPLICATION_PATH . '/application/modules/Sesusercoverphoto/widgets/sesusercoverphoto-cover/_type2.tpl'; ?>
<?php }else if($this->type == 4){ ?>
<?php include APPLICATION_PATH . '/application/modules/Sesusercoverphoto/widgets/sesusercoverphoto-cover/_type3.tpl'; ?>
<?php } ?>
<?php if($this->is_fullwidth){ ?>
<script type="application/javascript">
sesJqueryObject(document).ready(function(){
	var htmlElement = document.getElementsByTagName("body")[0];
  htmlElement.addClass('sesusercoverphoto_cover_full');
	sesJqueryObject('#global_content').css('padding-top',0);
	sesJqueryObject('#global_wrapper').css('padding-top',0);	
});
</script>
<?php } ?>
<script type="application/javascript">
  function finishVideoNext() {
    sesJqueryObject('#sesusercovevideo_cover_video_id').play();
  }
</script>
<script type="application/javascript">
  sesJqueryObject(document).ready(function() {
    if(sesJqueryObject('#sesusercoverphoto_cover_video_id')) {
      if(Modernizr.touch) {
        sesJqueryObject('#sesusercoverphoto_cover_video_id').hide();
        sesJqueryObject('#sesusercoverphoto_cover_id').show();
      }
    }
  });
</script>
