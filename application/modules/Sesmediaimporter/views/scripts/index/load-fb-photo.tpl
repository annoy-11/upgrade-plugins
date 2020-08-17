<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: load-fb-photo.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
  function file_get_contents_curl($url){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
  }
?>
<?php $randonNumber = 'sesmediaimporter'; ?>
<?php if(empty($this->is_ajax)){ ?>
<div class="sesmdimp_photos_list sesbasic_clearfix">
<form id="importsesmediaimporter">
<ul class="sesbasic_clearfix" id="fb-content-data">
<?php } ?>
 <?php foreach($this->gallerydata['data'] as $photo){ 
 
    $fields="id,height,images,width,link,name,picture";
    $album_link = "https://graph.facebook.com/{$photo['id']}/?access_token={$this->access_token}&fields={$fields}";
    $album_json = json_decode(file_get_contents_curl($album_link),true);
    if(isset($album_json['images'][4]['source'])){
      $cover = $album_json['images'][4]['source'];
    }else {
      $cover =  $album_json['images'][0]['source'];
    }
    
    if(!$cover){
      $cover = 'application/modules/Sesmediaimporter/externals/images/empty.png';
    }
 ?>
    <li class="sesmdimp_photos_list_photo">
      <div class="sesmdimp_photos_list_photo_inner">
        <div class="sesmdimp_photos_list_photo_img">
          <img src="<?php echo $cover; ?>" />
         </div>
        <div class="sesmdimp_photos_list_photo_input" title="<?php echo $this->translate("Click to select"); ?>">
          <input type="checkbox" class="sesmediaimportercheckbox" id="photo<?php echo $photo['id']; ?>" value="<?php echo $photo['id']; ?>" name="photos[<?php echo $photo['id']; ?>]" />
          <label class="fa fa-check" for="photo<?php echo $photo['id']; ?>"></label>
          <input type="hidden" name="photos_url[<?php echo $photo['id']; ?>]" value="<?php echo $album_json['images'][0]['source']; ?>">
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
function getFbAlbums(param){
    document.getElementById("facebook_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    sesJqueryObject('.hidefb').hide();
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject.ajax({
          type: 'post',
          url: '<?php if(empty($this->typeSeelect)) { echo "sesmediaimporter/index/load-fb-photo?id={$this->album_id}"; }else{ echo "sesmediaimporter/index/load-fb-type-photo?type={$this->typeSeelect}"; } ?>',
          data: {
             extra_params: param
          },
          success: function( data ) {
            //Hide The Spinner
            sesJqueryObject('.hidefb').show();
              document.getElementById("fb-spinner").style.display = "none";
              //Put the Data in the Div
              sesJqueryObject('#facebook_album').html(data);
          }
      });
  }
</script>
<?php } ?>

<script type="application/javascript">
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo (isset($this->gallerydata['paging']['next']) ? 'block' : 'none'); ?>";
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
      'url': en4.core.baseUrl+'<?php if(empty($this->typeSeelect)) { echo "sesmediaimporter/index/load-fb-photo?id={$this->album_id}"; } else{ echo "sesmediaimporter/index/load-fb-type-photo?type={$this->typeSeelect}"; } ?>',
      'data': {
        format: 'html',
				is_ajax : 1,
				after: "<?php echo isset($this->gallerydata['paging']['cursors']['after']) ? $this->gallerydata['paging']['cursors']['after'] : '';  ?>"
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