<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: featured-block.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesmember_featured_photos_popup sesbasic_bxs sesbasic_clearfix">
  <div class="sesmember_photo_update_popup_header"><?php echo $this->translate('Edit Featured Photos');?></div>
  <p><?php echo $this->translate('Choose up to 5 photos you\'d like to feature.');?></p>
  <div class="sesmember_featured_photos_popup_cont clearfix">
    <?php if(count($this->photos)):?>
      <?php $count = 1;?>
      <?php if(count($this->photos) == 5):?>
	<?php foreach($this->photos as $photo):
  	$photo = Engine_Api::_()->getItem('photo',$photo->photo_id);
    if(!$photo)
      	continue;
  ?>
	  <div id="block_<?php echo $count?>" class="sesmember_featured_photos_popup_blank_img">
	    <img src="<?php echo $photo->getPhotoUrl('thumb.normalmain');?>" />
	    <a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock('block_<?php echo $count?>', <?php echo $count?>);" title="<?php echo $this->translate('Remove');?>"></a>
	  </div>
	  <input type="hidden" id="featured_photo_<?php echo $count?>" value="<?php echo $photo->photo_id;?>" />
	  <?php $count++;?>
	<?php endforeach;?>
      <?php elseif(count($this->photos) == 4):?>
        <?php foreach($this->photos as $photo):
        $photo = Engine_Api::_()->getItem('photo',$photo->photo_id);
    if(!$photo)
      	continue;
        ?>
	  <div id="block_<?php echo $count?>" class="sesmember_featured_photos_popup_blank_img">
	    <img src="<?php echo $photo->getPhotoUrl('thumb.normalmain');?>" />
	    <a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock('block_<?php echo $count?>', <?php echo $count?>);" title="<?php echo $this->translate('Remove');?>"></a>
	  </div>
	  <input type="hidden" id="featured_photo_<?php echo $count?>" value="<?php echo $photo->photo_id;?>" />
	  <?php $count++;?>
	<?php endforeach;?>
	<div id="block_5" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_5" data-src='featured_image_5' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_5"></div>
	</div>
	<input type="hidden" id="featured_photo_5" value="" />
      <?php elseif(count($this->photos) == 3):?>
        <?php foreach($this->photos as $photo):
        $photo = Engine_Api::_()->getItem('photo',$photo->photo_id);
    if(!$photo)
      	continue;
        ?>
	  <div id="block_<?php echo $count?>" class="sesmember_featured_photos_popup_blank_img">
	    <img src="<?php echo $photo->getPhotoUrl('thumb.normalmain');?>" />
	    <a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock('block_<?php echo $count?>', <?php echo $count?>);" title="<?php echo $this->translate('Remove');?>"></a>
	  </div>
	  <input type="hidden" id="featured_photo_<?php echo $count?>" value="<?php echo $photo->photo_id;?>" />
	  <?php $count++;?>
	<?php endforeach;?>
	<div id="block_4" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_4" data-src='featured_image_4' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_4"></div>
	</div>
	<input type="hidden" id="featured_photo_4" value="" />
	<div id="block_5" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_5" data-src='featured_image_5' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_5"></div>
	</div>
	<input type="hidden" id="featured_photo_5" value="" />
      <?php elseif(count($this->photos) == 2):?>
        <?php foreach($this->photos as $photo):
        	$photo = Engine_Api::_()->getItem('photo',$photo->photo_id);
    if(!$photo)
      	continue;
        ?>
	  <div id="block_<?php echo $count?>" class="sesmember_featured_photos_popup_blank_img">
	   <img src="<?php echo $photo->getPhotoUrl('thumb.normalmain');?>" />
	   <a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock('block_<?php echo $count?>', <?php echo $count?>);" title="<?php echo $this->translate('Remove');?>"></a>
	  </div>
	  <input type="hidden" id="featured_photo_<?php echo $count?>" value="<?php echo $photo->photo_id;?>" />
	  <?php $count++;?>
	<?php endforeach;?>
        <div id="block_3" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_3" data-src='featured_image_3' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_3"></div>
	</div>
	<input type="hidden" id="featured_photo_3" value="" />
	<div id="block_4" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_4" data-src='featured_image_4' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_4"></div>
	</div>
	<input type="hidden" id="featured_photo_4" value="" />
	<div id="block_5" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_5" data-src='featured_image_5' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_5"></div>
	</div>
	<input type="hidden" id="featured_photo_5" value="" />
      <?php elseif(count($this->photos) == 1):?>
        <?php foreach($this->photos as $photo):
        	$photo = Engine_Api::_()->getItem('photo',$photo->photo_id);
    if(!$photo)
      	continue;
        ?>
	  <div id="block_<?php echo $count?>" class="sesmember_featured_photos_popup_blank_img">
	    <a href="javascript:void(0)" title="" id="featured_image_<?php echo $count?>" data-src='featured_image_<?php echo $count?>' class="fromExistingAlbumPhoto"><img src="<?php echo $photo->getPhotoUrl('thumb.normalmain');?>" /></a>
	    <a href="javascript:void(0);" class="fa fa-times" onclick="javascript:removeBlock('block_<?php echo $count?>', <?php echo $count?>);" title="<?php echo $this->translate('Remove');?>"></a>
	  </div>
	  <input type="hidden" id="featured_photo_<?php echo $count?>" value="<?php echo $photo->photo_id;?>" />
	  <?php $count++;?>
	<?php endforeach;?>
	<div id="block_2" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_2" data-src='featured_image_2' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_2"></div>
	</div>
	<input type="hidden" id="featured_photo_2" value="" />
        <div id="block_3" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_3" data-src='featured_image_3' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_3"></div>
	</div>
	<input type="hidden" id="featured_photo_3" value="" />
	<div id="block_4" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_4" data-src='featured_image_4' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_4"></div>
	</div>
	<input type="hidden" id="featured_photo_4" value="" />
	<div id="block_5" class="sesmember_featured_photos_popup_blank_img">
	  <a href="javascript:void(0)" title="" id="featured_image_5" data-src='featured_image_5' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	  <div id="hide_cancel_5"></div>
	</div>
	<input type="hidden" id="featured_photo_5" value="" />
      <?php endif;?>
    <?php else:?>
      <div id="block_1" class="sesmember_featured_photos_popup_blank_img">
	<a href="javascript:void(0)" title="" id="featured_image_1" data-src='featured_image_1' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	<div id="hide_cancel_1"></div>
      </div>
      <input type="hidden" id="featured_photo_1" value="" />
      <div id="block_2" class="sesmember_featured_photos_popup_blank_img">
	<a href="javascript:void(0)" title="" id="featured_image_2" data-src='featured_image_2' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	<div id="hide_cancel_2"></div>
      </div>
      <input type="hidden" id="featured_photo_2" value="" />
      <div id="block_3" class="sesmember_featured_photos_popup_blank_img">
	<a href="javascript:void(0)" title="" id="featured_image_3" data-src='featured_image_3' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	<div id="hide_cancel_3"></div>
      </div>
      <input type="hidden" id="featured_photo_3" value="" />
      <div id="block_4" class="sesmember_featured_photos_popup_blank_img">
	<a href="javascript:void(0)" title="" id="featured_image_4" data-src='featured_image_4' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	<div id="hide_cancel_4"></div>
      </div>		
      <input type="hidden" id="featured_photo_4" value="" />
      <div id="block_5" class="sesmember_featured_photos_popup_blank_img">
	<a href="javascript:void(0)" title="" id="featured_image_5" data-src='featured_image_5' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>
	<div id="hide_cancel_5"></div>
      </div>
      <input type="hidden" id="featured_photo_5" value="" />
    <?php endif;?>
  </div>
  <div class="sesmember_photo_update_popup_footer">
    <a href="javascript:void(0);" class="sesbasic_button" onclick="javascript:sessmoothboxclose();"><?php echo $this->translate('Cancel');?></a>
    <a href="javascript:void(0)" id="save_featured_photo" class="sesbasic_button"><?php echo $this->translate('Save');?></a>
  </div>
</div>

<script type="text/javascript">
  function showHtml() {
    sesJqueryObject('<div class="sesmember_photo_update_popup sesbasic_bxs" id="sesmember_popup_existing_upload" style="display:block; z-index:100;"><div class="sesmember_photo_update_popup_overlay"></div><div class="sesmember_photo_update_popup_container" id="sesmember_popup_container_existing"><div class="sesmember_photo_update_popup_header"><?php echo $this->translate("Select a photo") ?><a class="fa fa-close" href="javascript:;" onclick="hideProfileAlbumPhotoUpload()" title="<?php echo $this->translate("Close") ?>"></a></div><div class="sesmember_photo_update_popup_content"><div id="sesmember_album_existing_data"></div><div id="sesmember_profile_existing_img" style="display:none;text-align:center;"><img src="application/modules/Sesbasic/externals/images/loading.gif" alt="<?php echo $this->translate("Loading"); ?>" style="margin-top:10px;"  /></div></div></div></div>').appendTo('body');
  }
  var canPaginatePageNumber = 1;
  function existingAlbumPhotosGet(){
    sesJqueryObject('#sesmember_profile_existing_img').show();
    var URL = en4.core.staticBaseUrl+'sesmember/index/existing-photos/';
    var photoRequest = new Request.HTML({
      method: 'post',
      'url': URL ,
      'data': {
	format: 'html',
	page: canPaginatePageNumber,
	is_ajax: 1
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	document.getElementById('sesmember_album_existing_data').innerHTML = document.getElementById('sesmember_album_existing_data').innerHTML + responseHTML;
	sesJqueryObject('#sesmember_album_existing_data').slimscroll({
	  height: 'auto',
	  alwaysVisible :true,
	  color :'#000',
	  railOpacity :'0.5',
	  disableFadeOut :true,					 
	});
	sesJqueryObject('#sesmember_album_existing_data').slimScroll().bind('slimscroll', function(event, pos){
	  if(canPaginateExistingPhotos == '1' && pos == 'bottom' && sesJqueryObject('#sesmember_profile_existing_img').css('display') != 'block'){
	    sesJqueryObject('#sesmember_profile_existing_img').css('position','absolute').css('width','100%').css('bottom','5px');
	    existingAlbumPhotosGet();
	  }
	  });
	sesJqueryObject('#sesmember_profile_existing_img').hide();
      }
    });	
    photoRequest.send();
  }
  
  function hideProfileAlbumPhotoUpload(){
    canPaginatePageNumber = 1;
    sesJqueryObject('#sesmember_popup_existing_upload').remove();
    sesJqueryObject('#sesmember_popup_cam_upload').hide();
    sesJqueryObject('#sesmember_popup_existing_upload').hide();
  }
  
  function removeBlock(id, position) {
    document.getElementById(id).innerHTML = '<a href="javascript:void(0)" title="" id="featured_image_'+position+'"'+' data-src="featured_image_"'+position+ ' class="fromExistingAlbumPhoto"><i class="fa fa-plus"></i></a>';
    document.getElementById('featured_photo_'+position).value = '';
  }

function sessmoothboxcallback(){
	var isvalid = false;
	for(var i = 1; i<= 5; i++){
		if(sesJqueryObject('#featured_photo_'+i).val()){
			isvalid = true;	
		}
	}
	if(!isvalid)
		sesJqueryObject('#save_featured_photo').css('pointer-events','none').css('cursor','default');
}
</script>