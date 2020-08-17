<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: load-fb-gallery.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
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
<div class="sesmdimp_albums_list sesbasic_clearfix">
  <form id="importsesmediaimporter">
  <ul class="sesbasic_clearfix" id="fb-content-data">
<?php } ?>
 <?php foreach($this->gallerydata['data'] as $album){ 
    // continue if album contain 0 photos
    if(($album['count']) == 0){
      continue;
    }
    $fields="id,height,images,width,link,name,picture";
    $album_link = "https://graph.facebook.com/{$album['cover_photo']['id']}/?access_token={$this->access_token}&fields={$fields}";
    $album_json = json_decode(file_get_contents_curl($album_link),true);
    if(isset($album_json['images'][3]['source'])){
      $cover = $album_json['images'][3]['source'];
    }else {
      $cover =  $album_json['images'][0]['source'];
    }
    if(!$cover){
      $cover = 'application/modules/Sesmediaimporter/externals/images/empty.png';
    }
 ?>
    <li class="sesmdimp_albums_list_photo">
      <div class="sesmdimp_albums_list_photo_inner">
        <div class="sesmdimp_albums_list_photo_img">
          <img src="<?php echo $cover; ?>" alt="<?php echo $album->name; ?>" />
         </div>
        <div class="sesmdimp_albums_list_photo_input" title="<?php echo $this->translate("Click to select"); ?>">
          <input type="checkbox" class="sesmediaimportercheckbox" id="album<?php echo $album['id'] ?>" value="<?php echo $album['id'] ?>" name="album_id[<?php echo $album['id'] ?>]" />
          <label class="fa fa-check" for="album<?php echo $album['id'] ?>"></label>
          <input type="hidden" name="album_count[<?php echo $album['id'] ?>]" value="<?php echo $album['count']; ?>">
          <input type="hidden" name="album_name[<?php echo $album['id'] ?>]" value="<?php echo $album['name']; ?>">
        </div>
        <span class="sesmdimp_albums_list_count fa fa-picture-o"><?php echo $this->translate(array('%s Photo', '%s Photos', $album['count']), $this->locale()->toNumber($album['count']))?></span>
      </div>
      <div class="sesmdimp_albums_list_title">
        <a href="javascript:;" class="selectfbphoto" data-href="sesmediaimporter/index/load-fb-photo?id=<?php echo $album['id'] ?>"><?php echo $album['name']; ?></a>
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
      'url': en4.core.baseUrl + 'sesmediaimporter/index/load-fb-gallery/',
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