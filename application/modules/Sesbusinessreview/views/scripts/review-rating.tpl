<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: review-rating.tpl  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');?>
<?php $editPrivacy = Engine_Api::_()->sesbasic()->getViewerPrivacy('businessreview', 'edit');?>

<div class="form-wrapper sesbusinessreview_form_rating_star">
  <div class="form-label"><label><?php echo $this->translate("SESBUSINESSOverall Rating"); ?></label></div>
  <div id="sesbusinessreview_review_rating" class="sesbasic_rating_star sesbusinessreview_rating_star_element" onmouseout="rating_out();">
    <span id="rate_1" class="sesbusinessreview_rating_star sesbusinessreview_rating_star_disable" onclick="rate(1);" onmouseout="rating_out()" onmouseover="rating_over(1);"></span>
    <span id="rate_2" class="sesbusinessreview_rating_star sesbusinessreview_rating_star_disable" onclick="rate(2);" onmouseout="rating_out()" onmouseover="rating_over(2);"></span>
    <span id="rate_3" class="sesbusinessreview_rating_star sesbusinessreview_rating_star_disable" onclick="rate(3);" onmouseout="rating_out()" onmouseover="rating_over(3);"></span>
    <span id="rate_4" class="sesbusinessreview_rating_star sesbusinessreview_rating_star_disable" onclick="rate(4);" onmouseout="rating_out()" onmouseover="rating_over(4);"></span>
    <span id="rate_5" class="sesbusinessreview_rating_star sesbusinessreview_rating_star_disable" onclick="rate(5);" onmouseout="rating_out()" onmouseover="rating_over(5);"></span>
    <span id="rating_text" class="sesbasic_rating_text"><?php echo $this->translate('SESBUSINESSclick to rate');?></span>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<script type="text/javascript">
en4.core.runonce.add(function() {
  tinymce.init({
    mode: "specific_textareas",
    editor_selector: "sesbusinessreview_review_tinymce",
    plugins: "table,fullscreen,media,preview,paste,code,image,textcolor",
    theme: "modern",
    menubar: false,
    statusbar: false,
    toolbar1: "",
    toolbar2: "",
    toolbar3: "",
    element_format: "html",
    height: "225px",
    convert_urls: false,
    language: "en",
    directionality: "ltr"
  });  
  function ratingText(rating){
    var text = '';
    if(rating == 1)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview_rating_stars_one',$this->translate('SESBUSINESSterrible')); ?>";
    else if(rating == 2)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview_rating_stars_two',$this->translate('SESBUSINESSpoor')); ?>";
    else if(rating == 3)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview_rating_stars_three',$this->translate('SESBUSINESSaverage')); ?>";
    else if(rating == 4)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview_rating_stars_four',$this->translate('SESBUSINESSvery good')); ?>";
    else if(rating == 5)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview_rating_stars_five',$this->translate('SESBUSINESSexcellent')); ?>";
    else 
    text = "<?php echo $this->translate('SESBUSINESSclick to rate');?>";
    return text;
  }
  var rating_over = window.rating_over = function(rating) {
    $('rating_text').innerHTML = ratingText(rating);
    for(var x=1; x<=5; x++) {
      if(x <= rating) 
      $('rate_'+x).set('class', 'sesbusinessreview_rating_star');
      else 
      $('rate_'+x).set('class', 'sesbusinessreview_rating_star sesbusinessreview_rating_star_disable');
    }
  }
  var rating_out = window.rating_out = function() {
    var star_value = document.getElementById('rate_value').value;
    $('rating_text').innerHTML = ratingText(star_value);
    if(star_value != '') {
      set_rating(star_value);
    }
    else {
      for(var x=1; x<=5; x++) {	
	$('rate_'+x).set('class', 'sesbusinessreview_rating_star sesbusinessreview_rating_star_disable');
      }
    }
  }
  var rate = window.rate = function(rating) {
    document.getElementById('rate_value').value = rating;
    $('rating_text').innerHTML = ratingText(rating);
    set_rating(rating);
  }
  var set_rating = window.set_rating = function(rating) {
    for(var x=1; x<=parseInt(rating); x++) {
      $('rate_'+x).set('class', 'sesbusinessreview_rating_star');
    }
    for(var x=parseInt(rating)+1; x<=5; x++) {
      $('rate_'+x).set('class', 'sesbusinessreview_rating_star sesbusinessreview_rating_star_disable');
    }
    $('rating_text').innerHTML = ratingText(rating);
  }
  window.addEvent('domready', function() {
    var ratingCount = $('rate_value').value;
    if(ratingCount > 0)
    var val = ratingCount;
    else
    var val = 0;
    set_rating(ratingCount);
  });
  //Ajax error show before form submit
  var error = false;
  var objectError ;
  var counter = 0;
  function validateForm(){
    var errorPresent = false;
    counter = 0;
    sesJqueryObject('#sesbusinessreview_review_form input, #sesbusinessreview_review_form select,#sesbusinessreview_review_form checkbox,#sesbusinessreview_review_form textarea,#sesbusinessreview_review_form radio').each(
	function(index){
      var input = sesJqueryObject(this);
      if(sesJqueryObject(this).closest('div').parent().css('display') != 'none' && sesJqueryObject(this).closest('div').parent().find('.form-label').find('label').first().hasClass('required') && sesJqueryObject(this).prop('type') != 'hidden' && sesJqueryObject(this).closest('div').parent().attr('class') != 'form-elements'){	
        if(sesJqueryObject(this).prop('type') == 'checkbox'){
          value = '';
          if(sesJqueryObject('input[name="'+sesJqueryObject(this).attr('name')+'"]:checked').length > 0) { 
            value = 1;
          };
          if(value == '')
          error = true;
          else
          error = false;
        }else if(sesJqueryObject(this).prop('type') == 'select-multiple'){
          if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }else if(sesJqueryObject(this).prop('type') == 'select-one' || sesJqueryObject(this).prop('type') == 'select' ){
          if(sesJqueryObject(this).val() === '')
          error = true;
          else
          error = false;
        }else if(sesJqueryObject(this).prop('type') == 'radio'){
          if(sesJqueryObject("input[name='"+sesJqueryObject(this).attr('name').replace('[]','')+"']:checked").val() === '')
          error = true;
          else
          error = false;
        }else if(sesJqueryObject(this).prop('type') == 'textarea'){
          if(sesJqueryObject(this).css('display') == 'none'){
            var	content = tinymce.get(sesJqueryObject(this).attr('id')).getContent();
            if(!content)
            error= true;
            else
            error = false;
          }else	if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }else{
          if(sesJqueryObject(this).val() === '' || sesJqueryObject(this).val() == null)
          error = true;
          else
          error = false;
        }
        if(error){
          if(counter == 0){
            objectError = this;
          }
          counter++
        }
	  if(error)
	  errorPresent = true;
	  error = false;
      }
    });
    return errorPresent ;
  }
  <?php if(!empty($id)):?>
    sesJqueryObject(document).on('submit','#sesbusinessreview_review_form',function(e){
      var validationFm = validateForm();
      if(!sesJqueryObject('#rate_value').val()){
        alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
        var errorFirstObject = sesJqueryObject('#sesbusinessreview_review_rating').parent();
        sesJqueryObject('html, body').animate({
        scrollTop: errorFirstObject.offset().top
        }, 2000);
        return false;
      }
      else if(validationFm) {
        alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
        if(typeof objectError != 'undefined'){
        var errorFirstObject = sesJqueryObject(objectError).parent().parent();
        sesJqueryObject('html, body').animate({
        scrollTop: errorFirstObject.offset().top
        }, 2000);
      }
      return false;	
      }else{
	sendDataToServer(this);
	return false;	
      }			
    });
    <?php endif;?>
  });
  function sendDataToServer(object){
    //submit form 
    sesJqueryObject('.sesbasic_loading_cont_overlay').show();
    var formData = new FormData(object);
    formData.append('is_ajax', 1);
    formData.append('user_id', '<?php echo $this->viewer_id;?>');
    var form = sesJqueryObject(object);
    var url = sesJqueryObject('#sesbusinessreview_review_form').attr('action');
    sesJqueryObject.ajax({
      type:'POST',
      dataType:'html',
      url: url,
      data:formData,
      cache:false,
      contentType: false,
      processData: false,
      success:function(response){
        sesJqueryObject('body').append('<div id="sesbusinessreview_review_content" style="display:none;"></div>');
        sesJqueryObject('#sesbusinessreview_review_content').html(response);
        var reviewHtml = sesJqueryObject('#sesbusinessreview_review_content').find('.sesbusinessreview_reviews').html();
        //update cover rating
        if(sesJqueryObject('.sesbusinessreview_cover_rating').length){
          pre_rate_cover = sesJqueryObject('#sesbusinessreview_review_content').find('.rating_params').find('#total_rating_average').val();
            var ratingtext = sesJqueryObject('#sesbusinessreview_review_content').find('.rating_params').find('#rating_text').val();
            window.set_rating_cover(ratingtext);
        }	
        if(sesJqueryObject('.sesbusinessreview_owner_review').length > 0) {
          var updatedHtmlQuery = sesJqueryObject('ul.sesbusinessreview_review_listing li.sesbusinessreview_owner_review').index();
          sesJqueryObject('.sesbusinessreview_review_listing').children().eq(updatedHtmlQuery).html(reviewHtml);
        }
        else if(!sesJqueryObject('#sesbusinessreview_review_rate').length){
          sesJqueryObject('.sesbusinessreview_review_listing').prepend('<li class="sesbasic_clearfix sesbusinessreview_owner_review">'+reviewHtml+'</li>');
        }
        var editPrivacy = '<?php echo $editPrivacy;?>';
        if(editPrivacy == 1) {
          var editFormHtml = sesJqueryObject('#sesbusinessreview_review_content').find('#sesbusinessreview_review_create_form').html();
          sesJqueryObject('#sesbusinessreview_review_create_form').first().html(editFormHtml);
          sesJqueryObject('#sesbusinessreview_create_button').hide();
          sesJqueryObject('#sesbusinessreview_edit_button').show();
        }
        else
        sesJqueryObject('#sesbusinessreview_create_button').hide();
        sesJqueryObject('#sesbusinessreview_review_content').remove();
        sesJqueryObject('#sesbusinessreview_review_create_form').hide();
        sesJqueryObject('.sesbusinessreview_review_listing ').show();
        sesJqueryObject('.sesbusinessreview_review_listing').parent().find('.tip').hide();
        sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
        var openObject = sesJqueryObject('.sesbusinessreview_review_profile_btn');
        sesJqueryObject('html, body').animate({
            scrollTop: openObject.offset().top
        }, 2000);
        en4.core.runonce.trigger();
      },
      error: function(data){
      //silence
      }
    });
  }
</script>