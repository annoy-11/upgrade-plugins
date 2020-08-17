<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: load-flickr-photo.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $randonNumber = 'sesmediaimporter'; ?>
<?php if(empty($this->is_ajax)){ ?>
<div class="sesmdimp_photos_list sesbasic_clearfix">
<form id="importsesmediaimporter">
<ul class="sesbasic_clearfix" id="fl-content-data">
<?php } ?>
 <?php foreach($this->gallerydata['photos']['photo'] as $photo){
      $photoURL = $this->flickr->buildPhotoURL($photo);
  ?>
    <li class="sesmdimp_photos_list_photo">
      <div class="sesmdimp_photos_list_photo_inner">
        <div class="sesmdimp_photos_list_photo_img">
          <img src="<?php echo $photoURL; ?>" />
         </div>
        <div class="sesmdimp_photos_list_photo_input" title="<?php echo $this->translate("Click to select"); ?>">
          <input type="checkbox" class="sesmediaimportercheckbox" id="photo<?php echo $photo['id']; ?>" value="<?php echo $photo['id']; ?>" name="photos[<?php echo $photo['id']; ?>]" />
          <label class="fa fa-check" for="photo<?php echo $photo['id']; ?>"></label>
          <input type="hidden" name="photos_url[<?php echo $photo['id']; ?>]" value="<?php echo $photoURL; ?>">
        </div>
      </div>	
    </li>
<?php } ?>

<?php if(empty($this->is_ajax)){ ?>    
  </ul>
</form> 
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'sesbasic_animation sesbasic_link_btn')); ?> </div>
    <div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /></div>
</div>
<script type="application/javascript">
function getSelectedTabFlickr(){
  var parentElem =  sesJqueryObject('ul#sesmediaimporter_flickr_select').find('li.sesbasic_tab_selected'); 
  if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_flickr_getPhotos')){
      var type = 'getPhotos';
   }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_flickr_sets')){
      var type = 'getSets';
   }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_flickr_favorite')){
      var type = 'getFavourites';
   }else if(sesJqueryObject(parentElem).hasClass('sesmediaimporter_flickr_galleries')){
      var type = 'getGalleriesPhoto';  
   }
   return type;
}
function getFlAlbums(param){
    document.getElementById("flickr_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    sesJqueryObject('.hidefb').hide();
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject.ajax({
          type: 'post',
          url:  en4.core.baseUrl+"sesmediaimporter/index/load-flickr-photo",
          data: {
             type: getSelectedTabFlickr(),
             id: "<?php echo !empty($this->album_id) ? $this->album_id : 0; ?>",
          },
          success: function( data ) {
            //Hide The Spinner
            sesJqueryObject('.hidefb').show();
              document.getElementById("fb-spinner").style.display = "none";
              //Put the Data in the Div
              sesJqueryObject('#flickr_album').html(data);
          }
      });
  }
</script>
<?php } ?>

<script type="application/javascript">
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo (isset($this->gallerydata['photos']['page']) && $this->gallerydata['photos']['pages'] > 0 && $this->gallerydata['photos']['page'] != $this->gallerydata['photos']['pages'] ? 'block' : 'none'); ?>";
			if(sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'none'){
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').remove();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').remove();
			}	
  }
  viewMoreHide_<?php echo $randonNumber; ?>();
	 function viewMore_<?php echo $randonNumber; ?> (){
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl+'<?php echo "sesmediaimporter/index/load-flickr-photo?type="; ?>'+getSelectedTabFlickr(),
      'data': {
        format: 'html',
				is_ajax : 1,
				page: "<?php echo (isset($this->gallerydata['photos']['page']) && $this->gallerydata['photos']['page'] != $this->gallerydata['photos']['pages']) ? ($this->gallerydata['photos']['page'] + 1) : '' ;  ?>"
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject('#fl-content-data').append(responseHTML);
				if($('loading_image_<?php echo $randonNumber; ?>'))
					document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
  }
</script>
<?php die; ?>