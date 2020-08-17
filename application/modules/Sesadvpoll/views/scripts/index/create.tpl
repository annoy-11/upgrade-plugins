<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvpoll/externals/styles/styles.css');
  ?>
  <?php 
    $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/emoji.css');
  ?>

  <?php echo $this->form->render($this); ?>
  <?php  $viewUrl = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpoll.poll.manifest', 'sesadvpoll'); ?>

  <a href="javascript: void(0);" onclick="return addAnotherOption();" id="addOptionLink"><?php echo $this->translate("Add another option") ?></a>
  <?php $module = Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesfeedgif'); ?>
<?php $gifCount = 0; ?>
  <?php if($module){
   $gifCount = count(Engine_Api::_()->getDbTable('images', 'sesfeedgif')->getImages(array('fetchAll' => 1, 'limit' => 10))); }
?>
  <script type="text/javascript">
    var gifCount = <?php echo $gifCount ?> ;
	var viewUrl = '<?php echo $viewUrl ?>';
    //<!--
	<?php
if($module){ ?>
	var  moduleEnblecheck = true;
<?php }else{ ?>
	var  moduleEnblecheck = false;
<?php }	?>
    var counter = 0;
    var text = 'image';
    var gif = 'gif';
    var maxOptions = <?php echo $this->maxOptions ?>;
    var options = <?php echo Zend_Json::encode($this->options) ?>;
    sesJqueryObject(document).ready(function () {
      var maxOptions = <?php echo $this->maxOptions ?>;
      var options = <?php echo Zend_Json::encode($this->options) ?>;
        append();
        append();
      if(maxOptions >2){
        $('addOptionLink').inject($('options').getParent());
      }
    });
	function append(){
      var optionsDiv =  '<div class= "pollOptionInput">' +
        '<input type= "text" name="optionsArray[]" >' +
        '<div class="sesadvpoll_uploadmedia"><span class="sesadvpoll_add_photo"><a href="javascript:void(0)" title="<?php echo $this->translate('Attach a Photo'); ?>"><input type= "file" name="optionsImage[]" class="'+text+counter+'"  onchange = "previewFile(this,'+counter+');"></a></span>' ;
		if(moduleEnblecheck == true && gifCount> 0){
			 optionsDiv += '<span class="sesact_post_tool_i tool_i_gif"><a href="javascript:;" class="sesadv_tooltip gif_poll_select poll_gif_content_a" id="'+counter+'" title="<?php echo $this->translate('Attach a GIF'); ?>">&nbsp;</a><input type= "hidden" name="optionsGif[]" class="inputgif"  class="'+gif+counter+'" onchange = "onloadgif' +
		'(this,'+counter+');"></span>';
		}
		optionsDiv +='</div>' +
		'<span class="sesadvpoll_upload_img"><a href="javascript:void(0)" style = "display:none;" id="remove-image'+counter+'" class="fa fa-close ' +
        'remove-image"></a><img src="#" ' +
        'class="uploadPreviewImage" style="display:none;" id="'+text+counter+'" ></span>' +
        '<span class="sesadvpoll_upload_img"><a href="javascript:void(0)" style = "display:none;" id="remove-gif'+counter+'" class="fa fa-close remove-gif"></a>' +
        '<img src="#" class="uploadPreviewGif" style="display:none;" id="'+gif+counter+'" ></span>' ;
      if(counter > 1){
        var rmstyle = 'display:block;';
      }else{
        var rmstyle = 'display:none;';
      }
      optionsDiv +=  '<p class="remove" title="<?php echo $this->translate("Remove Option"); ?>" style="cursor: pointer; '+rmstyle+'"><i class="fa fa-times"></i></p>';
      optionsDiv +=  '</div>';
      var parent = $('options').getParent();
      console.log(optionsDiv);
    sesJqueryObject(parent).append(optionsDiv);
      counter ++;
    }
	//GIF Work
var pollOptionObject;
	sesJqueryObject(document).on('click','.gif_poll_select',function() {
		clickGifContentContainer = this;
		pollOptionObject = this;
	  sesJqueryObject('.gif_sesadvpoll_content').removeClass('from_bottom');
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
		sesJqueryObject('.gif_sesadvpoll_content').css('top',topPositionOfParentDiv+'px');
		sesJqueryObject('.gif_sesadvpoll_content').css('left',leftPositionOfParentDiv).css('z-index',100);
		sesJqueryObject('.gif_sesadvpoll_content').show();
		var eTop = sesJqueryObject(this).offset().top; //get the offset top of the element
		var availableSpace = sesJqueryObject(document).height() - eTop;
		if(availableSpace < 400 && !sesJqueryObject('#ses_media_lightbox_container').length){
		  sesJqueryObject('.gif_sesadvpoll_content').addClass('from_bottom');
		}

		if(sesJqueryObject(this).hasClass('active')){
		  sesJqueryObject(this).removeClass('active');
		  sesJqueryObject('.gif_sesadvpoll_content').hide();
		  //complitionRequestTrigger();
		  return;
		}
		
		//sesJqueryObject(this).addClass('active');
		sesJqueryObject('.gif_sesadvpoll_content').show();
		//complitionRequestTrigger();

    if(!sesJqueryObject('.ses_gif_holder').find('.empty_cnt').length)
      return;
	var that = this;
	var el = sesJqueryObject('._sesadvgif_gif');
    var url = en4.core.baseUrl+'sesadvpoll/index/gif/',
    requestComentGif = new Request.HTML({
      url : url,
      data : {
        format : 'html',
      },
      evalScripts : true,
      onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject('.gif_sesadvpoll_content').find('.ses_gif_container_inner').find('.ses_gif_holder').html(responseHTML);
        sesJqueryObject(that).addClass('complete');
        sesJqueryObject('.gif_sesadvpoll_content').css('display','block');
		
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
	sesJqueryObject('.gif_sesadvpoll_content').hide();
});
    // GIF Work End
    sesJqueryObject(document).ready(function(){
	var div = '<div class="gif_sesadvpoll_content ses_emoji_container sesbasic_bxs'+ '_gif_sesadvpoll_content notclose">'+
  '<div class="ses_emoji_container_arrow"></div>'+
  '<div class="ses_gif_container_inner sesbasic_clearfix">'+
    '<div class="ses_gif_holder">'+
      '<div class="sesbasic_loading_container empty_cnt" style="height:100%;"></div>'+
    '</div></div></div>';
    sesJqueryObject("body").append(div);
    
});
    function previewFile(input,counter) {
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
        };
            reader.readAsDataURL(input.files[0]);
        sesJqueryObject(makeId).css("display","block");
        sesJqueryObject(makeGifDiv).css("display","none");
        sesJqueryObject(makeClass).css("display","none");
        sesJqueryObject(makeClass).parent().parent().css("display","none");
        sesJqueryObject(makeRemoveClass).css("display","block");

      }
    }
    function onloadgif(counter) {
      var makeId = '#'+counter;
      var makeRemoveClass = '#remove-gif'+counter;
      var makeclassDiv = '.image'+counter;
      var makeClass = '.gif'+counter;
        sesJqueryObject(makeclassDiv).css("display","none");
        sesJqueryObject(makeclassDiv).parent().parent().css("display","none");
        sesJqueryObject(makeId).css("display","none");
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
    });
    sesJqueryObject(document).on('click', '.remove-gif', function(){
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
    });
    sesJqueryObject('#poll_edit_create').submit(function(e) {
      e.preventDefault();
      var counterImage = 0;
      var counter = 0;
      var textCounter = 0;
      var input = true;
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
       
        var inputVAl = sesJqueryObject(this).find('input').val().trim();
        if(inputVAl.length == 0){
          input = false;

        }
      });
      var title = sesJqueryObject('#title').val().trim();
      if(counterImage>0 && counter >0){
        sesJqueryObject('.errror_dummy_h2').css('display','block');
      }else if(title.length == 0){
          var textError = " <?php echo $this->translate("Poll Title is mandatory field.") ?> ";
        sesJqueryObject('.errror_dummy_h2').css('display','block').html(textError);
      }else if(input == false){
          var textError = " <?php echo $this->translate("Poll text can not be null") ?> ";
        sesJqueryObject('.errror_dummy_h2').css('display','block').html(textError);
      }else{
        var formData = new FormData(this);
        sesJqueryObject.ajax({
          url:sesJqueryObject(this).attr('action'),
          type: "POST",
          contentType:false,
          processData: false,
          cache: false,
          data: formData,
          success: function(data) {
            var response = jQuery.parseJSON(data);
            if(response.status == "true") {
                window.location.href = en4.core.baseUrl+viewUrl+'/view/'+response.id;
            }else{
              sesJqueryObject('.errror_dummy_h2').css('display','block').html(response.message);
            }
          }
        });
      }
    });
  </script>
<script type="text/javascript">
  $$('.core_main_sesadvpoll').getParent().addClass('active');
</script>
