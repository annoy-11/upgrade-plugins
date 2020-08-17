<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/emoji.css');
  ?>
  <?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgrouppoll/externals/styles/styles.css');
  ?>
<?php $gifCount = 0; ?>
<?php $module = Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesfeedgif'); ?>
<?php if($module){
 $gifCount = count(Engine_Api::_()->getDbTable('images', 'sesfeedgif')->getImages(array('fetchAll' => 1, 'limit' => 10)));
}
?>
<?php echo $this->form->render($this) ?>
<?php 
		
      $optionsDiv = '<input type="textarea" name="options" id="options">';
      $optionsDiv .= '<input type="hidden" name="is_image_delete" id="is_image_delete" value="0">';
      $counter = 0;
      $text = 'image';
      $gif = 'gif';
      if(count($this->poll_options) > 2){
      $rmstyle = 'display:block;';
      }else{
      $rmstyle = 'display:none;';
      }
     foreach($this->poll_options as $options){
        $pollOptionId = $options['poll_option_id'];
        $pollOption = $options['poll_option'];
        $imageType=$options['image_type'];
        if($options['file_id'] && $options['image_type']==1){
          $imageUrl =Engine_Api::_()->storage()->get($options['file_id'],'')->map();
          $imagestyle = "display:block";
        }else{
          $imageUrl = "";
          $imagestyle = "display:none";
        }
        if($options['file_id'] && $options['image_type']==2){
          $gifUrl = Engine_Api::_()->storage()->get($options['file_id'],'')->map();
          $gifStyle = "display:block";
        }else{
          $gifUrl = "";
          $gifStyle = "display:none";
        }
        if($options['file_id'] && ($options['image_type']==2 || $options['image_type']==1)){
            $InputStyle = "display:none";
        }else{
            $InputStyle = "display:block";
        }
$optionsDiv .=  '<div class="pollOptionInput" id="'.$pollOptionId.'"><input type="hidden" name="optionIds[]" value="'.$pollOptionId.'"><input type="text"  class = "option_text" name="optionsArray[]" value="'.$pollOption.'"><div class="sesgrouppoll_uploadmedia"><span class="sesgrouppoll_add_photo"  style="'.$InputStyle.'"><a href="javascript:void(0)" title="'.$this->translate('Attach a Photo').'"><input type="file" name="optionsImage[]"    style="'.$InputStyle.'" class="'.$text.$counter.'"  onchange ="previewFile(this,'.$counter.')"></a></span>';
		if($module && $gifCount>0){
		$optionsDiv .= '<span class="sesact_post_tool_i tool_i_gif"><a href="javascript:;" style="'.$InputStyle.'" class="sesadv_tooltip gif_poll_select poll_gif_content_a" id="'.$counter.'" title="'.$this->translate('Attach a GIF').'">&nbsp;</a><input type= "hidden" name="optionsGif[]" style="'.$InputStyle.'" class="'.$gif.$counter.' inputgif" onchange ="onloadgif(this,'.$counter.')"></span>';
		}
        $optionsDiv .= '</div><span class="sesgrouppoll_upload_img"><a href="javascript:void(0)" style = "'.$imagestyle.';" id="remove-image'.$counter.'" class="fa fa-close remove-image"></a><img src="'.$imageUrl.'"  imageType = "'.$imageType.'" class="uploadPreviewImage" style="'.$imagestyle.'" id="'.$text.$counter.'" ></span><span class="sesgrouppoll_upload_img"><a href="javascript:void(0)" style = "'.$gifStyle.'" id="remove-gif'.$counter.'" class="fa fa-close remove-gif"></a><img   src="'.$gifUrl.'"   imageType = "'.$imageType.'" class="uploadPreviewGif" style="'.$gifStyle.'" id="'.$gif.$counter.'" ></span>' ;
        $optionsDiv .=  '<p class="remove"  style="cursor: pointer; '.$rmstyle.'"><i class="fa fa-times"></i></p>';
        $optionsDiv .=  '</div>';
        $counter ++;
      }
      $jsondiv = ($optionsDiv);
?>
<div id="edit_content_html" style="display:none;"><?php echo $jsondiv; ?></div>
<input type="hidden" value="">
<a href="javascript: void(0);" onclick="return addAnotherOption();" id="addOptionLink"><?php echo $this->translate("Add another option") ?></a>
<script type="text/javascript">
    var gifCount = <?php echo $gifCount ?> ;
    <?php if($module){ ?>
	var  moduleEnblecheck = true;
<?php }else{ ?>
	var  moduleEnblecheck = false;
<?php }	?>
  var counter = <?php echo $counter ?>;
  var text = 'image';
  var gif = 'gif';
  var maxOptions = <?php echo $this->maxOptions ?>;
  var options = <?php echo Zend_Json::encode($this->options) ?>;
  sesJqueryObject(document).ready(function () {
    var parent = $('options').getParent();
    var optionhtml = sesJqueryObject('#optionHtml').val();
    sesJqueryObject(parent).html(sesJqueryObject('#edit_content_html').html());
    // checkImage();
    // return;
    sesJqueryObject('#edit_content_html').remove();
    var maxOptions = <?php echo $this->maxOptions ?>;
    var options = <?php echo Zend_Json::encode($this->options) ?>;
    $('addOptionLink').inject($('options').getParent());
  });
    function previewFile(input,counter) {
    sesJqueryObject('.errror_dummy_h2').css('display','none');
    var makeId = '#image'+counter;
    var makeRemoveClass = '#remove-image'+counter;
    var makeGifDiv = '#'+counter;
    var makeClass = '.image'+counter;
    if (input.files && input.files[0]) {
      var type = input.files[0].type;
      var type_reg = /^image\/(jpg|png|jpeg)$/;
      if (!type_reg.test(type)) {
        alert('This file type is unsupported.');
        input.value = '';
        return false;
      }
      var reader = new FileReader();
      reader.onload = function (e) {
        sesJqueryObject(makeId).attr('src', e.target.result)
        .width(150)
        .height(200);
        sesJqueryObject(makeId).attr('imagetype',1);
      };
      reader.readAsDataURL(input.files[0]);
      sesJqueryObject(makeId).css("display","block");
	  console.log(sesJqueryObject(makeGifDiv));
      sesJqueryObject(makeGifDiv).css("display","none");
      sesJqueryObject(makeClass).css("display","none");
      sesJqueryObject(makeClass).parent().parent().css("display","none");
      sesJqueryObject(makeRemoveClass).css("display","block");
    }
  }
    function onloadgif(counter) {
        sesJqueryObject('.errror_dummy_h2').css('display','none');
        var makeId = '#gif'+counter;
        var makeRemoveClass = '#remove-gif'+counter;
        var makeclassDiv = '#'+counter;
        var makeClass = '.image'+counter;
        sesJqueryObject(makeclassDiv).css("display","none");
        sesJqueryObject(makeclassDiv).parent().parent().css("display","none");
        sesJqueryObject(makeId).css("display","block");
        sesJqueryObject(makeClass).css("display","none");
        sesJqueryObject(makeRemoveClass).css("display","block");
    }
    function addAnotherOption(){
    append();
    sesJqueryObject('.remove').css('display','block');
    $('addOptionLink').inject($('options').getParent());
    if( maxOptions && sesJqueryObject('.pollOptionInput').length >= maxOptions ) {
      $('addOptionLink').destroy();
    }
  }
    var pollOptionObject;
	sesJqueryObject(document).on('click','.gif_poll_select',function() {
		clickGifContentContainer = this;
		pollOptionObject = this;
	  sesJqueryObject('.gif_grouppoll_content').removeClass('from_bottom');
	  var topPositionOfParentDiv =  sesJqueryObject(this).offset().top + 35;
	  topPositionOfParentDiv = topPositionOfParentDiv;
	  if(sesJqueryObject(this).hasClass('activity_gif_content_a') && typeof sesadvancedactivityDesign != 'undefined' && sesadvancedactivityDesign == 2){
		var leftSub = 55;  
	  }else
		var leftSub = 264;
		var leftPositionOfParentDiv =  sesJqueryObject(this).offset().left - leftSub;
		leftPositionOfParentDiv = leftPositionOfParentDiv+'px';
		if(sesJqueryObject('#ses_media_lightbox_container').length || sesJqueryObject('#ses_media_lightbox_container_video').length)
		  topPositionOfParentDiv = topPositionOfParentDiv + offsetY;
		sesJqueryObject('.gif_grouppoll_content').css('top',topPositionOfParentDiv+'px');
		sesJqueryObject('.gif_grouppoll_content').css('left',leftPositionOfParentDiv).css('z-index',100);
		sesJqueryObject('.gif_grouppoll_content').show();
		var eTop = sesJqueryObject(this).offset().top; //get the offset top of the element
		var availableSpace = sesJqueryObject(document).height() - eTop;
		if(availableSpace < 400 && !sesJqueryObject('#ses_media_lightbox_container').length){
		  sesJqueryObject('.gif_grouppoll_content').addClass('from_bottom');
		}

		if(sesJqueryObject(this).hasClass('active')){
		  sesJqueryObject(this).removeClass('active');
		  sesJqueryObject('.gif_grouppoll_content').hide();
		  //complitionRequestTrigger();
		  return;
		}
		
		//sesJqueryObject(this).addClass('active');
		sesJqueryObject('.gif_grouppoll_content').show();
		//complitionRequestTrigger();

    if(!sesJqueryObject('.ses_gif_holder').find('.empty_cnt').length)
      return;
	var that = this;
	var el = sesJqueryObject('._sesadvgif_gif');
    var url = en4.core.baseUrl+'sesgrouppoll/index/gif/',
    requestComentGif = new Request.HTML({
      url : url,
      data : {
        format : 'html',
      },
      evalScripts : true,
      onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject('.gif_grouppoll_content').find('.ses_gif_container_inner').find('.ses_gif_holder').html(responseHTML);
        sesJqueryObject(that).addClass('complete');
        sesJqueryObject('.gif_grouppoll_content').css('display','block');
		
        //complitionRequestTrigger();
        jqueryObjectOfSes(".sesbasic_custom_scroll").mCustomScrollbar({
          theme:"minimal-dark"
        });
      }
    });
    requestComentGif.send();
});
    sesJqueryObject(document).on('click','._sesadvgif_gif_polloption',function(){
        var srcOfImage = sesJqueryObject(this).find('img').attr('src');
        var idOfImage = sesJqueryObject(this).find('img').attr('data-url');
        sesJqueryObject(pollOptionObject).closest('span').find('.inputgif').val(idOfImage);
        sesJqueryObject(pollOptionObject).closest("div").parent().find('span:eq(3)').find('.uploadPreviewGif').attr("src",srcOfImage).css('display','block');
        sesJqueryObject(pollOptionObject).closest("div").parent().find('span:eq(3)').find('.remove-gif').css('display','block');
        sesJqueryObject(pollOptionObject).closest("div").find('span:eq(3)').css('display','block');
        var optionId = sesJqueryObject(pollOptionObject).attr('id');
        onloadgif(optionId);
        sesJqueryObject('.gif_grouppoll_content').hide();
    });
    sesJqueryObject(document).ready(function(){
	var div = '<div class="gif_grouppoll_content ses_emoji_container sesbasic_bxs'+ '_gif_grouppoll_content notclose">'+
  '<div class="ses_emoji_container_arrow"></div>'+
  '<div class="ses_gif_container_inner sesbasic_clearfix">'+
    '<div class="ses_gif_holder">'+
      '<div class="sesbasic_loading_container empty_cnt" style="height:100%;"></div>'+
    '</div></div></div>';
    sesJqueryObject("body").append(div);
    
});
    sesJqueryObject(document).on('click', '.remove', function(){
        if(sesJqueryObject('.pollOptionInput').length > 2 ) {
          var parentNode = sesJqueryObject(this).parent();
          sesJqueryObject(parentNode).remove();
        }
        if(sesJqueryObject('.pollOptionInput').length ==  2 ){
          sesJqueryObject('.remove').css('display','none');
        }
      });
    sesJqueryObject(document).on('click', '.remove-image', function(){
        sesJqueryObject('.errror_dummy_h2').css('display','none');
        var removeId = sesJqueryObject(this).attr('id');
        var counter =  removeId.substr(12);
        var inputClassImage = ".image"+counter;
        var inputClassGif = "#"+counter;
        var imageId = "#image"+counter;
        sesJqueryObject(inputClassImage).val('');
        sesJqueryObject(inputClassImage).parent().parent().css('display','block');
        sesJqueryObject(inputClassImage).css('display','block');
        sesJqueryObject(inputClassGif).css('display','block');
        sesJqueryObject("#"+removeId).css('display','none');
        sesJqueryObject(imageId).css('display', 'none');
        sesJqueryObject(imageId).attr('src', '');
        sesJqueryObject(imageId).attr('imagetype', 0);
      });
    sesJqueryObject(document).on('click', '.remove-gif', function(){
    sesJqueryObject('.errror_dummy_h2').css('display','none');
    var removeId = sesJqueryObject(this).attr('id');
    var counter =  removeId.substr(10);
    var inputClassGif = "#"+counter;
    var inputClassImage = ".image"+counter;
    var gifId = "#gif"+counter;
    sesJqueryObject(inputClassGif).val('');
    sesJqueryObject(inputClassGif).css('display','block');
    sesJqueryObject(inputClassImage).parent().parent().css('display','block');
    sesJqueryObject(inputClassImage).css('display','block');
    sesJqueryObject("#"+removeId).css('display','none');
    sesJqueryObject(gifId).css('display', 'none');
    sesJqueryObject(gifId).attr('src', '');
    sesJqueryObject(gifId).attr('imagetype', 0);
  });
  // -->
  function append(){
    var optionsDiv = "";
      optionsDiv +=  '<div class= "pollOptionInput">' +
      '<input type="hidden" name="optionIds[]" value="">'+
      '<input type= "text" name="optionsArray[]" class = "option_text" >' +
      '<div class="sesgrouppoll_uploadmedia"><span class="sesgrouppoll_add_photo"><a href="javascript:void(0)" title="<?php echo $this->translate('Attach a Photo');?>"><input type= "file" name="optionsImage[]" class="'+text+counter+'"  onchange = "previewFile(this,'+counter+');"></a></span>' ;
      if(moduleEnblecheck && gifCount>0){
          optionsDiv += '<span class="sesact_post_tool_i tool_i_gif"><a href="javascript:;" style="display:block" class="sesadv_tooltip gif_poll_select poll_gif_content_a" id="'+counter+'">&nbsp;</a><input type= "hidden" name="optionsGif[]" class="'+gif+counter+'" onchange = "onloadgif(this,'+counter+');"></span>';
      }
      optionsDiv += '</div><span class="sesgrouppoll_upload_img"><a href="javascript:void(0)" style = "display:none;" id="remove-image'+counter+'" class="fa fa-close remove-image"></a>' +
                    '<img src="" class="uploadPreviewImage" imageType ="0" style="display:none;" id="'+text+counter+'" ></span>';
      optionsDiv += '<span class="sesgrouppoll_upload_img"><a href="javascript:void(0)" style = "display:none;" id="remove-gif'+counter+'" class="fa fa-close remove-gif"></a>' +
                    '<img src="" class="uploadPreviewGif" imageType ="0" style="display:none;" id="'+gif+counter+'" ></span>' ;
    if(counter > 1){
      optionsDiv +=  '<p class="remove" title="<?php echo $this->translate("Remove Option"); ?>" style="cursor: pointer;"><i class="fa fa-times"></p>';
    }
    optionsDiv +=  '</div>';
    var parent = $('options').getParent();
    sesJqueryObject(parent).append(optionsDiv);
    counter ++;
    }
    // function checkImage(){
    //   pollOptionInput
    // }
  var count = 0;
  sesJqueryObject('#poll_edit_create').submit(function(e){
    e.preventDefault();
      var counterImage = 0;
      var counter = 0;
      var textCounter = 0;
    sesJqueryObject( ".pollOptionInput" ).each(function( index ) {
	if(moduleEnblecheck && gifCount > 0){
	var imgsrc = sesJqueryObject(this).find('span:eq(2)').find('.uploadPreviewImage').attr('src');
      var Gifsrc = sesJqueryObject(this).closest("div").find('span:eq(3)').find('.uploadPreviewGif').attr('src');
      if(imgsrc.length > 1 ||  Gifsrc.length > 1) {
        counterImage++;
      }else{
        counter++;
      }
	}else{
	var imgsrc = sesJqueryObject(this).find('span:eq(1)').find('.uploadPreviewImage').attr('src');
		if(imgsrc.length > 1) {
			counterImage++;
		}else{
			counter++;
		}
	}
      
      count++;
    });
    if(count == counter){
      sesJqueryObject('#is_image_delete').val(1);
    }
    sesJqueryObject( ".option_text" ).each(function( index ) {
      if(sesJqueryObject(this).val().trim ().length == 0){
        textCounter ++;
      }
    });
    if(counterImage>0 && counter >0){
      sesJqueryObject('.errror_dummy_h2').css('display','block');
    }else if(textCounter > 0) {
      sesJqueryObject('.errror_dummy_h2').css('display','block').html('option text is mandatory.');
    }
  else{
       var formData = new FormData(this);
      sesJqueryObject.ajax({
        url:sesJqueryObject(this).attr('action'),
        type: "POST",
        contentType:false,
        processData: false,
        cache: false,
        data: formData,
        success: function(data) {
		 console.log(data);
         var response = jQuery.parseJSON(data);
          if(response.status) {
            window.location.href = en4.core.baseUrl+'<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.poll.manifest', 'grouppoll'); ?>/view/'+response.id;
          }else{
            sesJqueryObject('.errror_dummy_h2').css('display','block').html(response.message);
          }
        }
      }); 
    }
  });
</script>
