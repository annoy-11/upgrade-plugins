<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: load-instagram-photo.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $randonNumber = 'sesmediaimporter'; ?>
<?php if(empty($this->is_ajax)){ ?>
<div class="sesmdimp_photos_list sesbasic_clearfix">
<form id="importsesmediaimporter">
<ul class="sesbasic_clearfix" id="in-content-data">
<?php } ?>
 <?php foreach($this->gallerydata['data'] as $photo){
  if($photo['type'] != 'image')
    continue;
   ?>
    <li class="sesmdimp_photos_list_photo">
      <div class="sesmdimp_photos_list_photo_inner">
        <div class="sesmdimp_photos_list_photo_img">
          <img src="<?php echo $photo['images']['standard_resolution']['url']; ?>" />
         </div>
        <div class="sesmdimp_photos_list_photo_input" title="<?php echo $this->translate("Click to select"); ?>">
          <input type="checkbox" class="sesmediaimportercheckbox" id="photo<?php echo $photo['id']; ?>" value="<?php echo $photo['id']; ?>" name="photos[<?php echo $photo['id']; ?>]" />
          <label class="fa fa-check" for="photo<?php echo $photo['id']; ?>"></label>
          <input type="hidden" name="photos_url[<?php echo $photo['id']; ?>]" value="<?php echo $photo['images']['standard_resolution']['url']; ?>">
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
function getInAlbums(param){
    document.getElementById("instagram_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    sesJqueryObject('.hidefb').hide();
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject.ajax({
          type: 'post',
          url:  en4.core.baseUrl+"sesmediaimporter/index/load-instagram-gallery",
          data: {
             extra_params: param
          },
          success: function( data ) {
            //Hide The Spinner
            sesJqueryObject('.hidefb').show();
              document.getElementById("fb-spinner").style.display = "none";
              //Put the Data in the Div
              sesJqueryObject('#instagram_album').html(data);
          }
      });
  }
</script>
<?php } ?>

<script type="application/javascript">
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo (isset($this->gallerydata['pagination']['next_url']) ? 'block' : 'none'); ?>";
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
      'url': en4.core.baseUrl+'<?php echo "sesmediaimporter/index/load-instagram-gallery"; ?>',
      'data': {
        format: 'html',
				is_ajax : 1,
				after: "<?php echo isset($this->gallerydata['pagination']['next_max_id']) ? $this->gallerydata['pagination']['next_max_id'] : '';  ?>"
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject('#in-content-data').append(responseHTML);
				if($('loading_image_<?php echo $randonNumber; ?>'))
					document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
  }
</script>
<?php die; ?>