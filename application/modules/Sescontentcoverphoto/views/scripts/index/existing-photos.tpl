<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _existing_photos.tpl 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php foreach( $this->paginator as $album ) {
  $counterAlbum = 0;
?>
  <div class="sescontentcoverphoto_update_album_row sesbasic_clearfix">
    <div id="sescontentcoverphoto_photo_content_<?php echo $album->album_id; ?>">
    <?php $photos = Engine_Api::_()->sescontentcoverphoto()->getPhotoSelect(array('album_id'=>$album->album_id,'pagNator'=>true)); 
    $photos->setItemCountPerPage($this->limit);
    $photos->setCurrentPageNumber(1);
    if($photos->getTotalItemCount() > 0) {
      foreach($photos as $photo){ ?>
        <?php if($counterAlbum == 0){ ?>
          <span class="sescontentcoverphoto_name"><?php echo $album->title; ?></span>
        <?php } ?>
        <div class="sescontentcoverphoto_thumb">
          <a href="javascript:void(0);" id="sescontentcoverphoto_<?php echo $this->cover ?>_upload_existing_photos_<?php echo $photo->photo_id; ?>" data-src="<?php echo $photo->photo_id; ?>" class="sescontentcoverphoto_thumb_img">
            <span style="background-image:url(<?php echo $photo->getPhotoUrl('thumb.normalmain'); ?>);"></span>
          </a>
        </div>
        <?php $counterAlbum++; 
      } ?>
        </div>
      <?php if($photos->count() != $photos->getCurrentPageNumber()){ ?>
        <div class="album_more_photos floatR clear">
          <a href="javascript:;" id="sescontentcoverphoto_<?php echo $this->cover ?>_existing_album_see_more_<?php echo $album->album_id; ?>" data-src="1">
            <?php echo $this->translate("See More"); ?> &raquo;
          </a>
        </div>
      <?php } ?>
      <div class="clear" style="text-align:center;display:none;" id="sescontentcoverphoto_existing_album_see_more_loading_<?php echo $album->album_id; ?>">
        <img src="application/modules/Core/externals/images/loading.gif" alt="Loading"  />
      </div>
    <?php }  ?>
  </div>
<?php } ?>
<br />
<?php  if($this->paginator->getTotalItemCount() == 0){  ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are currently no albums.");?>
    </span>
  </div>    
<?php } ?>
<script type="application/javascript">
canPaginateExistingPhotos = "<?php echo ($this->paginator->count() == 0 ? '0' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? '0' : '1' ))  ?>";
canPaginatePageNumber = "<?php echo $this->page + 1; ?>";
</script>
<?php die; ?>