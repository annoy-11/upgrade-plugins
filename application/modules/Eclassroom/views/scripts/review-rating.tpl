<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: review-rating.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<style>
/*Rating Star*/
.eclassroom_rating_star:before,
.eclassroom_rating_star_small:before,
.eclassroom_rating_star_small_half:before,
.eclassroom_rating_star_disable:before{
	font-family:fontawesome;
	display:inline-block;
	color:#FFC107;
}
.eclassroom_rating_star_small:before,
.eclassroom_rating_star:before{
	content:"\f005";
}
.eclassroom_rating_star_small_half:before,
.eclassroom_rating_star_half:before{
	content:"\f123";
}
.eclassroom_rating_star_disable:before{
	content:"\f006";
}
.eclassroom_rating_star{
	font-size:22px;
	height:24px;
	width:24px;
	display:inline-block;
	line-height:24px;
	text-align:center;
}
</style>
<?php $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('review_id');?>
<?php $editPrivacy = Engine_Api::_()->sesbasic()->getViewerPrivacy('eclassroom_review', 'edit');?>

<div class="form-wrapper eclassroom_form_rating_star">
  <div class="form-label"><label><?php echo $this->translate("Overall Rating"); ?></label></div>
  <div id="eclassroom_review_rating" class="sesbasic_rating_star eclassroom_rating_star_element" onmouseout="rating_out();">
    <span id="rate_1" class="eclassroom_rating_star eclassroom_rating_star_disable" onclick="rate(1);" onmouseout="rating_out()" onmouseover="rating_over(1);"></span>
    <span id="rate_2" class="eclassroom_rating_star eclassroom_rating_star_disable" onclick="rate(2);" onmouseout="rating_out()" onmouseover="rating_over(2);"></span>
    <span id="rate_3" class="eclassroom_rating_star eclassroom_rating_star_disable" onclick="rate(3);" onmouseout="rating_out()" onmouseover="rating_over(3);"></span>
    <span id="rate_4" class="eclassroom_rating_star eclassroom_rating_star_disable" onclick="rate(4);" onmouseout="rating_out()" onmouseover="rating_over(4);"></span>
    <span id="rate_5" class="eclassroom_rating_star eclassroom_rating_star_disable" onclick="rate(5);" onmouseout="rating_out()" onmouseover="rating_over(5);"></span>
    <span id="rating_text" class="sesbasic_rating_text"><?php echo $this->translate('click to rate');?></span>
  </div>
</div>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
<script type="text/javascript">
en4.core.runonce.add(function() {

  tinymce.init({
    mode: "specific_textareas",
    editor_selector: "eclassroom_review_tinymce",
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
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom_rating_stars_one',$this->translate('terrible')); ?>";
    else if(rating == 2)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom_rating_stars_two',$this->translate('poor')); ?>";
    else if(rating == 3)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom_rating_stars_three',$this->translate('average')); ?>";
    else if(rating == 4)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom_rating_stars_four',$this->translate('very good')); ?>";
    else if(rating == 5)
    text = "<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom_rating_stars_five',$this->translate('excellent')); ?>";
    else
    text = "<?php echo $this->translate('click to rate');?>";
    return text;
  }
  var rating_over = window.rating_over = function(rating) {
    $('rating_text').innerHTML = ratingText(rating);
    for(var x=1; x<=5; x++) {
      if(x <= rating)
      $('rate_'+x).set('class', 'eclassroom_rating_star');
      else
      $('rate_'+x).set('class', 'eclassroom_rating_star eclassroom_rating_star_disable');
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
	$('rate_'+x).set('class', 'eclassroom_rating_star eclassroom_rating_star_disable');
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
      $('rate_'+x).set('class', 'eclassroom_rating_star');
    }
    for(var x=parseInt(rating)+1; x<=5; x++) {
      $('rate_'+x).set('class', 'eclassroom_rating_star eclassroom_rating_star_disable');
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
    sesJqueryObject('#eclassroom_review_form input, #eclassroom_review_form select,#eclassroom_review_form checkbox,#eclassroom_review_form textarea,#eclassroom_review_form radio').each(
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
      }
    );
    return errorPresent ;
  }
      <?php if(empty($id)):?>
    sesJqueryObject(document).on('submit','#eclassroom_review_form',function(e){
      var validationFm = validateForm();
      if(!sesJqueryObject('#rate_value').val()){
	alert('<?php echo $this->translate("Please fill the red mark fields"); ?>');
	var errorFirstObject = sesJqueryObject('#eclassroom_review_rating').parent();
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
    var url = sesJqueryObject('#eclassroom_review_form').attr('action');
    sesJqueryObject.ajax({
      type:'POST',
      dataType:'html',
      url: url,
      data:formData,
      cache:false,
      contentType: false,
      processData: false,
      success:function(response){
        sesJqueryObject('body').append('<div id="eclassroom_review_content" style="display:none;"></div>');
        sesJqueryObject('#eclassroom_review_content').html(response);
        var reviewHtml = sesJqueryObject('#eclassroom_review_content').find('.eclassroom_reviews').html();
        //update cover rating
				if(sesJqueryObject('.eclassroom_cover_rating').length){
					pre_rate_cover = sesJqueryObject('#eclassroom_review_content').find('.rating_params').find('#total_rating_average').val();
					var ratingtext = sesJqueryObject('#eclassroom_review_content').find('.rating_params').find('#rating_text').val();
					window.set_rating_cover(ratingtext);
				}

        if(sesJqueryObject('.eclassroom_owner_review').length > 0) {
          var updatedHtmlQuery = sesJqueryObject('ul.eclassroom_review_listing li.eclassroom_owner_review').index();
          sesJqueryObject('.eclassroom_review_listing').children().eq(updatedHtmlQuery).html(reviewHtml);
          if(sesJqueryObject('.eclassroom_review_listing').find(".sesbasic_tip"))
            sesJqueryObject('.eclassroom_review_listing').find(".sesbasic_tip").remove();
        }
        else if(!sesJqueryObject('#eclassroom_review_rate').length){
	 			 sesJqueryObject('.eclassroom_review_listing').prepend('<li class="sesbasic_clearfix eclassroom_owner_review">'+reviewHtml+'</li>');
	 			 if(sesJqueryObject('.eclassroom_review_listing').find(".sesbasic_tip"))
            sesJqueryObject('.eclassroom_review_listing').find(".sesbasic_tip").remove();
        }
        var editPrivacy = '<?php echo $editPrivacy;?>';
        if(editPrivacy == 1) {
					var editFormHtml = sesJqueryObject('#eclassroom_review_content').find('#eclassroom_review_create_form').html();
					sesJqueryObject('#eclassroom_review_create_form').first().html(editFormHtml);
					sesJqueryObject('#eclassroom_create_button').hide();
					sesJqueryObject('#eclassroom_edit_button').show();
        }
        else
        	sesJqueryObject('#eclassroom_create_button').hide();

        sesJqueryObject('#eclassroom_review_content').remove();
        sesJqueryObject('#eclassroom_review_create_form').hide();
				sesJqueryObject('.eclassroom_review_listing ').show();
				sesJqueryObject('.eclassroom_review_listing').parent().find('.tip').hide();
				sesJqueryObject('.sesbasic_loading_cont_overlay').hide();
				var openObject = sesJqueryObject('.eclassroom_review_profile_btn');
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
