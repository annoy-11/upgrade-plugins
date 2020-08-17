<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>

<div class="sesbusiness_mainphoto_block sesbasic_bxs">
  <?php if(isset($this->photoActive)):?>
    <div class="_mainphoto">
      <div id="sesbusiness_cover_mainphotoinner_main" class="sesbusiness_cover_mainphotoinner">
        <img src="<?php echo $this->business->getPhotoUrl(); ?>" id="sesbusiness_photo_id_main" alt="<?php echo $this->business->getTitle(); ?>">
      </div>
      <?php if(Engine_Api::_()->authorization()->isAllowed('businesses', $this->viewer(), 'upload_mainphoto')):?>
        <div class="sesbusiness_profile_mainphoto_change_btn">
          <a href="javascript:;" class="sesbusiness_profile_mainphoto_change_toggle" title='<?php echo $this->translate("Upload Profile Photo"); ?>'>
            <i class="fa fa-camera"></i>
          </a>
          <div class="sesbasic_option_box sesbusiness_cover_main_change_options">
            <i></i>
            <input type="file" id="uploadPhotoFilesesbusiness<?php echo $this->identity; ?>" name="art_cover" onchange="uploadCoverArtMain(this,'photo');"  style="display:none" />
            <a id="uploadWebCamPhoto" href="javascript:;"><i class="fa fa-camera"></i><?php echo $this->translate("Take Photo"); ?></a>
            <a id="photoChangesesbusiness<?php echo $this->identity; ?>" data-src="<?php echo $business->photo_id; ?>" href="javascript:;"><i class="fa fa-plus"></i>
            <?php echo (isset($business->photo_id) && $business->photo_id != 0 && $business->photo_id != '') ? $this->translate('Change Photo') : $this->translate('Upload Photo'); ?></a>
            <a id="photoRemovesesbusiness<?php echo $this->identity; ?>" style="display:<?php echo (isset($this->business->photo_id) && $this->business->photo_id != 0 && $this->business->photo_id != '') ? 'block' : 'none' ; ?>;" data-src="<?php echo $this->business->photo_id; ?>" href="javascript:;"><i class="fa fa-trash"></i><?php echo $this->translate('Remove Photo'); ?></a>
          </div>
        </div>
      <?php endif;?>
    </div>
  <?php endif;?>
  <div class="_cont">
    <?php if(isset($this->titleActive)):?>
      <h2><a href="javascript:;"><?php echo $this->business->getTitle();?><?php if(isset($this->verifiedLabelActive) && $this->business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?></a></h2>
    <?php endif;?>
    <?php if(isset($this->businessUrlActive)):?>
      <p class="sesbasic_text_light _data">@<?php echo $this->business->custom_url;?></p>
    <?php endif;?>
  </div>
  <?php if(isset($this->tabActive)):?>
    <div class="_vtabs"></div>
  <?php endif;?>
</div>
<script type="text/javascript">
sesJqueryObject(document).on('click','#photoChangesesbusiness<?php echo $this->identity; ?>',function(){
    document.getElementById('uploadPhotoFilesesbusiness<?php echo $this->identity; ?>').click();	
  });
	sesJqueryObject(document).on('click','.sesbusiness_profile_mainphoto_change_toggle',function(){
		if(sesJqueryObject(this).hasClass('open')){
			sesJqueryObject(this).removeClass('open');
		}else{
			sesJqueryObject('.sesbusiness_profile_mainphoto_change_toggle').removeClass('open');
			sesJqueryObject(this).addClass('open');
		}
			return false;
	});
	sesJqueryObject(document).click(function(){
		sesJqueryObject('.sesbusiness_profile_mainphoto_change_toggle').removeClass('open');
	});
  
  function uploadCoverArtMain(input,type){
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')){
      uploadFileToServer<?php echo $this->identity; ?>(input.files[0],type);
    }
  }
  function uploadFileToServer<?php echo $this->identity; ?>(files,type){
    if(type == 'photo') {
      sesJqueryObject('#sesbusiness_cover_mainphotoinner_main').append('<div class="sesbusiness_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
      uploadURL = en4.core.staticBaseUrl+'sesbusiness/profile/upload-photo/id/<?php echo $this->business->business_id ?>';
    }
    
    var formData = new FormData();
    formData.append('Filedata', files);
    
    var jqXHR=sesJqueryObject.ajax({
    url: uploadURL,
    type: "POST",
    contentType:false,
    processData: false,
        cache: false,
        data: formData,
        success: function(response){
          response = sesJqueryObject.parseJSON(response);
          if(type == 'photo') {
            uploadPhoto(response);
            if(typeof uploadmainPhoto == "function"){
                uploadmainPhoto(response);
            }
          }
        }
    }); 
  }
  sesJqueryObject('#photoRemovesesbusiness<?php echo $this->identity; ?>').click(function(){
    sesJqueryObject(this).css('display','none');
    sesJqueryObject('#sesbusiness_cover_mainphotoinner_main').append('<div id="sesbusiness_cover_loading" class="sesbasic_loading_cont_overlay" style="display:block;"></div>');
    uploadURL = en4.core.staticBaseUrl+'sesbusiness/profile/remove-photo/id/<?php echo $this->business->business_id ?>';
    var jqXHR=sesJqueryObject.ajax({
          url: uploadURL,
          type: "POST",
          contentType:false,
          processData: false,
          cache: false,
      success: function(response){
         uploadremovemain(response);
         console.log(uploadmainRemovePhoto);
         if(typeof uploadmainRemovePhoto == "function"){
                uploadmainRemovePhoto(response);
            }
          //silence
       }
      }); 
    });
  function uploadremovemain(response){
    sesJqueryObject('#photoChangesesbusiness<?php echo $this->identity; ?>').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Upload Photo'));
    response = sesJqueryObject.parseJSON(response);
    sesJqueryObject('#sesbusiness_photo_id_main').attr('src', response.file);
    sesJqueryObject('#sesbusiness_cover_loading').remove();  
    sesJqueryObject('#photoRemovesesbusiness<?php echo $this->identity; ?>').css('display','none');
  }
  function uploadPhoto(response){
    sesJqueryObject('#uploadPhotoFilesesbusiness<?php echo $this->identity; ?>').val('');
    sesJqueryObject('.sesbusiness_cover_loading').remove();
    sesJqueryObject('#sesbusiness_photo_id_main').attr('src', response.file);
    sesJqueryObject('#photoChangesesbusiness<?php echo $this->identity; ?>').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));
    sesJqueryObject('#photoRemovesesbusiness<?php echo $this->identity; ?>').css('display','block');  
  }
  
  
  if(sesJqueryObject('.sesbusiness_photo_update_popup').length == 0){
      sesJqueryObject('<div class="sesbusiness_photo_update_popup sesbasic_bxs" id="sesbusiness_popup_cam_upload" style="display:none"><div class="sesbusiness_photo_update_popup_overlay"></div><div class="sesbusiness_photo_update_popup_container sesbusiness_photo_update_webcam_container sesbusiness_fg_color"><div class="sesbusiness_photo_update_popup_header"><?php echo $this->translate("Click to Take Cover Photo") ?><da class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesbusiness_photo_update_popup_webcam_options"><div id="sesbusiness_camera" style="background-color:#ccc;"></div><div class="centerT sesbusiness_photo_update_popup_btns"><button class="capturePhoto" onclick="take_snapshot()" style="margin-right:3px;" ><?php echo $this->translate("Take Cover Photo") ?></button><button onclick="hideProfilePhotoUpload()" ><?php echo $this->translate("Cancel") ?></button></div></div></div></div><div class="sesbusiness_photo_update_popup sesbasic_bxs" id="sesbusiness_popup_existing_upload" style="display:none"><div class="sesbusiness_photo_update_popup_overlay"></div><div class="sesbusiness_photo_update_popup_container" id="sesbusiness_popup_container_existing"><div class="sesbusiness_select_photo_popup_header sesbusiness_photo_update_popup_header"><?php echo $this->translate("Select a cover photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfilePhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesbusiness_photo_update_popup_content"><div id="sesbusiness_existing_data"></div><div id="sesbusiness_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
      
      var contentTypeSesbusiness;
      sesJqueryObject(document).on('click','#uploadWebCamPhoto',function(){
        sesJqueryObject('#sesbusiness_popup_cam_upload').show();
        contentTypeSesbusiness =  'photo';
        <!-- Configure a few settings and attach camera -->
        if(contentTypeSesbusiness == 'photo') {
          sesJqueryObject('.sesbusiness_photo_update_popup_header').html('<?php echo $this->translate("Click to Take Photo") ?>');
          sesJqueryObject('.capturePhoto').html('<?php echo $this->translate("Take Photo") ?>');
          sesJqueryObject('.sesbusiness_select_photo_popup_header').html('<?php echo $this->translate("Select a photo") ?>');
        }
        Webcam.set({
            width: 320,
            height: 240,
            image_format:'jpeg',
            jpeg_quality: 90
        });
        Webcam.attach('#sesbusiness_camera');
      });
      function hideProfilePhotoUpload(){
        if(typeof Webcam != 'undefined')
         Webcam.reset();
        canPaginateBusinessNumber = 1;
        sesJqueryObject('#sesbusiness_popup_cam_upload').hide();
        sesJqueryObject('#sesbusiness_popup_existing_upload').hide();
        if(typeof Webcam != 'undefined'){
            sesJqueryObject('.slimScrollDiv').remove();
            sesJqueryObject('.sesbusiness_photo_update_popup_content').html('<div id="sesbusiness_existing_data"></div><div id="sesbusiness_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="Loading" style="margin-top:10px;"  /></div>');
        }
  }
  <!-- Code to handle taking the snapshot and displaying it locally -->
  function take_snapshot() {
    // take snapshot and get image data
    Webcam.snap(function(data_uri) {
      Webcam.reset();
      sesJqueryObject('#sesbusiness_popup_cam_upload').hide();
      // upload results
       Webcam.upload( data_uri, en4.core.staticBaseUrl+'sesbusiness/profile/upload-'+contentTypeSesbusiness+'/id/<?php echo $this->business->business_id ?>' , function(code, text) {
              response = sesJqueryObject.parseJSON(text);
              sesJqueryObject('#sesbusiness_cover_loading').remove();
              sesJqueryObject('#sesbusiness_'+contentTypeSesbusiness+'_id').attr('src', response.file);
              
              sesJqueryObject('#'+contentTypeSesbusiness+'Changesesbusiness').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change '+contentTypeSesbusiness == "cover"?"Cover":""+' Photo'));
              
              sesJqueryObject('#sesbusiness_'+contentTypeSesbusiness+'_id_main').attr('src', response.file);
              sesJqueryObject('#photoChangesesbusiness_<?php echo $this->business->business_id; ?>').html('<i class="fa fa-plus"></i>'+en4.core.language.translate('Change Photo'));              sesJqueryObject('#photoRemovesesbusiness_<?php echo $this->business->business_id; ?>').css('display','block');
              
              sesJqueryObject('#'+contentTypeSesbusiness+'Removesesbusiness').css('display','block');
              
          } );
    });
  }
  
  }
  
</script>




<?php if(isset($this->tabActive)):?>
  <script type="text/javascript">
    if (matchMedia('only screen and (min-width: 767px)').matches) {
      sesJqueryObject(document).ready(function(){
        if(sesJqueryObject('.layout_core_container_tabs').length>0){
          var tabs = sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').get(0).outerHTML;
          sesJqueryObject('.layout_core_container_tabs').find('.tabs_alt').remove();
          sesJqueryObject('._vtabs').html(tabs);
          var elem = sesJqueryObject('ul#main_tabs li.active');
          sesJqueryObject(elem).find('a').trigger('click');
        }
      });
      sesJqueryObject(document).on('click','ul#main_tabs li > a',function(){
        if(sesJqueryObject(this).parent().hasClass('more_tab'))
        return;
        var index = sesJqueryObject(this).parent().index() + 1;
        var divLength = sesJqueryObject('.layout_core_container_tabs > div');
        for(i=0;i<divLength.length;i++){
          sesJqueryObject(divLength[i]).hide();
        }
        sesJqueryObject('.layout_core_container_tabs').children().eq(index).show();
      });
      sesJqueryObject(document).on('click','.tab_pulldown_contents ul li',function(){
        var totalLi = sesJqueryObject('ul#main_tabs > li').length;
        var index = sesJqueryObject(this).index();
        var divLength = sesJqueryObject('.layout_core_container_tabs > div');
        for(i=0;i<divLength.length;i++){
         sesJqueryObject(divLength[i]).hide();
        }
        sesJqueryObject('.layout_core_container_tabs').children().eq(index+totalLi).show();
      });
    }
		sesJqueryObject(document).ready(function(e){
			sesJqueryObject('#main_tabs').children().eq(0).find('a').trigger('click');
		});
</script>
<style type="text/css">
@media (min-width: 767px){
	.layout_core_container_tabs .tabs_alt {display:none;}
}
</style>
<?php endif;?>
