<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: load-flickr-gallery.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $randonNumber = 'sesmediaimporter'; ?>
<?php if(empty($this->is_ajax)){ ?>
<div class="sesmdimp_albums_list sesbasic_clearfix">
  <form id="importsesmediaimporter">
  <ul class="sesbasic_clearfix" id="fb-content-data">
<?php } ?>
 <?php foreach($this->gallerydata['galleries']['gallery'] as $album){ 
    // continue if album contain 0 photos
    $cover = $this->flickr->buildPhotoURLGallery($album);
 ?>
    <li class="sesmdimp_albums_list_photo">
      <div class="sesmdimp_albums_list_photo_inner">
        <div class="sesmdimp_albums_list_photo_img">
          <img src="<?php echo $cover; ?>" alt="<?php echo $album['title']; ?>" />
         </div>
        <div class="sesmdimp_albums_list_photo_input" title="<?php echo $this->translate("Click to select"); ?>">
          <input type="checkbox" class="sesmediaimportercheckbox" id="album<?php echo $album['id'] ?>" value="<?php echo $album['id'] ?>" name="album_id[<?php echo $album['id'] ?>]" />
          <label class="fa fa-check" for="album<?php echo $album['id'] ?>"></label>
          <input type="hidden" name="album_count[<?php echo $album['id'] ?>]" value="<?php echo $album['count_photos']+$album['count_videos']; ?>">
          <input type="hidden" name="album_name[<?php echo $album['id'] ?>]" value="<?php echo $album['title']['_content']; ?>">
        </div>
        <span class="sesmdimp_albums_list_count fa fa-picture-o"><?php echo $this->translate(array('%s Photo', '%s Photos', $album['count_photos']+$album['count_videos']), $this->locale()->toNumber($album['count_photos']+$album['count_videos']))?></span>
      </div>
      <div class="sesmdimp_albums_list_title">
        <a href="javascript:;" class="selectFlickrphoto" data-href="sesmediaimporter/index/load-flickr-photo?id=<?php echo $album['id'] ?>"><?php echo $album['title']['_content']; ?></a>
      </div>
    </li>
<?php } ?>
<?php if(empty($this->is_ajax)){ ?>
  </ul>
</form> 
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'sesbasic_animation sesbasic_link_btn')); ?> </div>
    <div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Sesbasic/externals/images/loading.gif" /></div>
</div>
<?php } ?>
<script type="application/javascript">
  function getFlAlbums(){
    document.getElementById("flickr_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    sesJqueryObject('.hidefb').hide();
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject.ajax({
          type: 'post',
          url:  en4.core.baseUrl+"sesmediaimporter/index/load-flickr-gallery",
          success: function( data ) {
            //Hide The Spinner
            sesJqueryObject('.hidefb').show();
              document.getElementById("fb-spinner").style.display = "none";
              //Put the Data in the Div
              sesJqueryObject('#flickr_album').html(data);
          }
      });
  }
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo (isset($this->gallerydata['galleries']['page']) && $this->gallerydata['galleries']['page'] != $this->gallerydata['galleries']['pages'] ? 'block' : 'none'); ?>";
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
      'url': en4.core.baseUrl + 'sesmediaimporter/index/load-flickr-gallery/',
      'data': {
        format: 'html',
				is_ajax : 1,
				page: "<?php echo isset($this->gallerydata['galleries']['page']) && $this->gallerydata['galleries']['page'] != $this->gallerydata['galleries']['pages'] ? $this->gallerydata['galleries']['page']+1 : '';  ?>"
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject('#fb-content-data').append(responseHTML);
				if($('loading_image_<?php echo $randonNumber; ?>'))
					document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
  }
</script>
<?php die; ?>