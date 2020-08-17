<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _composeSesadvpoll.tpl  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php
$gifCount = 0;
$viewer = Engine_Api::_()->user()->getViewer();
$module = Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesfeedgif');
$allowPoll  = 1;
$canUpload = Engine_Api::_()->authorization()->getPermission($viewer, 'sesadvpoll_poll', 'create');

if($module){
  $gifCount = count(Engine_Api::_()->getDbTable('images', 'sesfeedgif')->getImages(array('fetchAll' => 1, 'limit' => 10)));
}

$max_options = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesadvpoll.maxoptions', 15);
?>
<input type = "hidden" id="max" value="<?php echo $max_options ?>">
<script type="text/javascript">
    var gifCount = <?php echo $gifCount;  ?> ;
    var allowPoll = <?php echo $allowPoll;  ?> ;
    var canUpload = <?php echo $canUpload;  ?> ;
<?php
if($module){ ?>
	var  moduleEnblecheck = true;
<?php }else{ ?>
	var  moduleEnblecheck = false;
<?php }	?>
sesJqueryObject(document).ready(function(){
	var div = '<div class="gif_advpoll_content ses_emoji_container sesbasic_bxs'+ '_gif_advpoll_content notclose">'+
  '<div class="ses_emoji_container_arrow"></div>'+
  '<div class="ses_gif_container_inner sesbasic_clearfix">'+
    '<div class="ses_gif_holder">'+
      '<div class="sesbasic_loading_container empty_cnt" style="height:100%;"></div>'+
    '</div></div></div>';
    sesJqueryObject("body").append(div);
    
});
  var counter = 0;
  var text = 'image';
  var gif = 'gif';
  if(window.location.href.indexOf("messages/compose") > -1 || window.location.href.indexOf("messages/view/id") > -1) {
    var isMessagePage = true;
  }else{
    var isMessagePage = false;
  }
  <?php if($allowPoll && $canUpload){ ?>
	  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .
	  'application/modules/Sesadvpoll/externals/scripts/composer_sesadvpoll.js'); ?>
	  en4.core.runonce.add(function() {
		composeInstance.addPlugin(new Composer.Plugin.Sesadvpoll({
		  title: '<?php echo $this->string()->escapeJavascript($this->translate('Add Poll')) ?>',
		  lang : {
			'Add Poll' : '<?php echo $this->string()->escapeJavascript($this->translate('Add Poll')) ?>',
			'cancel' : '<?php echo $this->string()->escapeJavascript($this->translate('cancel')) ?>',
		  },
			}));
	  });
	<?php } ?>
  
  function checkValidationPagePoll(){
    var title = sesJqueryObject('#title').val().trim();
    var text = sesJqueryObject('#description').val().trim();
    var counterImage = 0;
    var counter = 0;
	var optiontextCounter = 0;
    sesJqueryObject( ".pollOptionInput" ).each(function( index ) {
	  var optiontext = sesJqueryObject(this).find('.option_text').val();
		
      var imgsrc = $('image'+eachcounter).getProperty('src');
      var Gifsrc = $('gif'+eachcounter).getProperty('src');
      if(imgsrc.length > 1 ||  Gifsrc.length > 1) {
        counterImage++;
      }else if(!optiontext.length>0){
        optiontextCounter++;
	  }
	  else{
        counter++;
      }
    });
      if( !title.length > 0){
		 var msg = '<?php echo $this->string()->escapeJavascript($this->translate('Title can not be null.')) ?>';
		 sesJqueryObject('.error_div').html(msg).addClass('sesact_poll_composer_error').css('dispay','block');
        return false;
      }else if(optiontextCounter>0){
		  var msg = '<?php echo $this->string()->escapeJavascript($this->translate('Option text can not be null. ')) ?>';
		 sesJqueryObject('.error_div').html(msg).addClass('sesact_poll_composer_error').css('dispay','block');
		   return false;
	  }
      else if(!text.length>0){
		  var msg = '<?php echo $this->string()->escapeJavascript($this->translate('Description can not be null.')) ?>';
		 sesJqueryObject('.error_div').html(msg).addClass('sesact_poll_composer_error').css('dispay','block');
        return false;
      }else if(counterImage > 0 && counter > 0){
		  var msg = '<?php echo $this->string()->escapeJavascript($this->translate('All options should be either text or text & image/gif.')) ?>';
		 sesJqueryObject('.error_div').html(msg).addClass('sesact_poll_composer_error').css('dispay','block');
        return false;
      }
	  return true;
  }
  function sesadvpollappend(){
    var optionsDiv =  '<div class= "pollOptionInput">' +
      '<input type= "text" name="optionsArray[]" class="option_text" placeholder="option" autofocus>' +
      '<div class="sesadvpoll_uploadmedia"><span class="sesadvpoll_add_photo"><a href="javascript:void(0)" title="<?php echo $this->string()->escapeJavascript($this->translate("Attach a Photo")); ?>"><input type= "file" name="optionsImage[]" class="'+text+counter+'"  onchange = "previewFile(this,'+counter+');"></a></span>';
      if(moduleEnblecheck == true && gifCount>0){
          optionsDiv += '<span class="sesact_post_tool_i tool_i_gif"><a href="javascript:;" class="sesadv_tooltip gif_poll_select poll_gif_content_a" id="'+counter+'" title="<?php echo $this->translate('Attach a GIF'); ?>">&nbsp;</a><input type= "hidden" name="optionsGif[]" class="inputgif"  class="'+gif+counter+'" onchange = "onloadgif(this,'+counter+');"></span>' ;
      }
      optionsDiv +='</div><span class="sesadvpoll_upload_img"><a href="javascript:void(0)" style = "display:none;" id="remove-image'+counter+'" class="fa fa-close remove-image"></a><img src="#"  class="uploadPreviewImage" style="display:none;" id="'+text+counter+'" ></span>';
      optionsDiv +=  '<span  class="sesadvpoll_upload_img"><a href="javascript:void(0)" style = "display:none;" id="remove-gif'+counter+'" class="fa fa-close remove-gif"></a><img src="#" class="uploadPreviewGif" style="display:none;" id="'+gif+counter+'"></span>' ;
    if(counter > 1){
      var rmstyle = 'display:block;';
    }else{
      var rmstyle = 'display:none;';
    }
    optionsDiv +=  '<p class="remove" title="<?php echo $this->translate("Remove Option"); ?>"  style="cursor: pointer; '+rmstyle+'"><i class="fa fa-times"></i></p>';
    optionsDiv +=  '</div>';
    sesJqueryObject('.sesact_poll_composer_option').append(optionsDiv);
    counter ++;
  }

  function addAnotherOption(){
    sesadvpollappend();
	var totaloption = sesJqueryObject('.pollOptionInput').length;
	if(totaloption >2){
		$$('.remove').show();
	}
	 if(sesJqueryObject("#max").val() == totaloption){
      sesJqueryObject("#addOptionLink").css("display","none");
    }
  }
  
  sesJqueryObject(document).on('click','.remove', function(){
    if(sesJqueryObject('.pollOptionInput').length > 2 ) {
      var parentNode = sesJqueryObject(this).parent();
      sesJqueryObject(parentNode).remove();
    }
    if(sesJqueryObject('.pollOptionInput').length ==  2 ){
      sesJqueryObject('.remove').css('display','none');
    }
  });
  function previewFile(input,counter) {
    var makeId = '#image'+counter;
    var makeRemoveClass = '#remove-image'+counter;
    var makeGifDiv = '.gif'+counter;

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
      sesJqueryObject("#"+counter).css("display","none");
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
  sesJqueryObject(document).on('click','._sesadvgif_gif > img',function(e) {
	if(sesJqueryObject(clickGifContentContainer).hasClass('poll_gif_content_a')){
	  pollGifFeedAttachment(this);  
	}
  });
  function pollGifFeedAttachment(that){
	  
            var code = sesJqueryObject(that).parent().parent().attr('rel');
			
            var image = sesJqueryObject(that).attr('src');
			
            composeInstance.plugins.each(function(plugin) {
              plugin.deactivate();
              sesJqueryObject('#compose-'+plugin.getName()+'-activator').parent().removeClass('active');
            });
            sesJqueryObject('#fancyalbumuploadfileids').val('');
            sesJqueryObject('.fileupload-cnt').html('');
            composeInstance.getTray().empty();
            sesJqueryObject('#compose-tray').show();
            sesJqueryObject('#compose-tray').html('<div class="sesact_composer_gif"><img src="'+image+'"><a class="remove_gif_image_feed notclose fa fa-close" href="javascript:;"></a></div>');
            sesJqueryObject('#image_id').val(code);
            sesJqueryObject('.gif_content').hide();  
            sesJqueryObject('.gif_comment_select').removeClass('active');
            
            //Feed Background Image Work
            if($('feedbgid') && sesJqueryObject('#image_id').val()) {
              $('hideshowfeedbgcont').style.display = 'none';
              sesJqueryObject('#feedbgid_isphoto').val(0);
              sesJqueryObject('.sesact_post_box').css('background-image', 'none');
              sesJqueryObject('#activity-form').removeClass('feed_background_image');
              sesJqueryObject('#feedbg_content').css('display','none');
            }
          }
         
//GIF Work
var pollOptionObject;
	sesJqueryObject(document).on('click','.gif_poll_select',function() {
		clickGifContentContainer = this;
		console.log('dsfg');
		pollOptionObject = this;
	  sesJqueryObject('.gif_advpoll_content').removeClass('from_bottom');
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
		sesJqueryObject('.gif_advpoll_content').css('top',topPositionOfParentDiv+'px');
		sesJqueryObject('.gif_advpoll_content').css('left',leftPositionOfParentDiv).css('z-index',100);
		sesJqueryObject('.gif_advpoll_content').show();
		var eTop = sesJqueryObject(this).offset().top; //get the offset top of the element
		var availableSpace = sesJqueryObject(document).height() - eTop;
		if(availableSpace < 400 && !sesJqueryObject('#ses_media_lightbox_container').length){
		  sesJqueryObject('.gif_advpoll_content').addClass('from_bottom');
		}

		if(sesJqueryObject(this).hasClass('active')){
		  sesJqueryObject(this).removeClass('active');
		  sesJqueryObject('.gif_advpoll_content').hide();
		  //complitionRequestTrigger();
		  return;
		}
		
		//sesJqueryObject(this).addClass('active');
		sesJqueryObject('.gif_advpoll_content').show();
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
        sesJqueryObject('.gif_advpoll_content').find('.ses_gif_container_inner').find('.ses_gif_holder').html(responseHTML);
        sesJqueryObject(that).addClass('complete');
        sesJqueryObject('.gif_advpoll_content').css('display','block');
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
	sesJqueryObject(pollOptionObject).closest('span').find('.inputgif').val(idOfImage);	sesJqueryObject(pollOptionObject).closest("div").parent().find('span:eq(3)').find('.uploadPreviewGif').attr("src",srcOfImage).css('display','block');
	sesJqueryObject(pollOptionObject).closest("div").parent().find('span:eq(3)').find('.remove-gif').css('display','block');
	sesJqueryObject(pollOptionObject).closest("div").find('span:eq(3)').css('display','block');
	var optionId = sesJqueryObject(pollOptionObject).attr('id');
	onloadgif(optionId);
    sesJqueryObject('.gif_advpoll_content').hide();
});
</script>
