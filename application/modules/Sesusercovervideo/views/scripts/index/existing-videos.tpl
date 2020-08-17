<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _existing_videos.tpl 2016-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesusercovervideo_update_album_row sesbasic_clearfix">
  <?php foreach( $this->paginator as $video ) { ?>
    <?php $counterVideo = 0; ?>
      <div id="sesusercovervideo_video_content_<?php echo $video->video_id; ?>">
        <div class="sesusercovervideo_thumb">
        <a href="javascript:void(0);" id="sesusercovervideo_<?php echo $this->cover ?>_upload_existing_videos_<?php echo $video->video_id; ?>" data-src="<?php echo $video->video_id; ?>" class="sesusercovervideo_thumb_img">
          <?php $storage = Engine_Api::_()->storage()->get($video->photo_id, ''); ?>
          <span style="background-image:url(<?php echo $storage->storage_path; ?>);"></span>
        </a>
        </div>
        <?php $counterVideo++; ?>
      </div>
      <?php if(0 && $videos->count() != $videos->getCurrentPageNumber()){ ?>
        <div class="album_more_photos floatR clear">
          <a href="javascript:;" id="sesusercovervideo_<?php echo $this->cover ?>_existing_album_see_more_<?php echo $video->video_id; ?>" data-src="1">
            <?php echo $this->translate("See More"); ?> &raquo;
          </a>
        </div>
      <?php } ?>
      <div class="clear" style="text-align:center;display:none;" id="sesusercovervideo_existing_album_see_more_loading_<?php echo $video->video_id; ?>"><img src="application/modules/Core/externals/images/loading.gif" alt="Loading"  /></div>
  <?php } ?>
</div>
<br />
<?php  if($this->paginator->getTotalItemCount() == 0){  ?>
  <div class="tip">
    <span>
      <?php echo $this->translate("There are currently no videos.");?>
    </span>
  </div>    
<?php } ?>
<script type="application/javascript">
canPaginateExistingVideos = "<?php echo ($this->paginator->count() == 0 ? '0' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? '0' : '1' ))  ?>";
canPaginatePageNumber = "<?php echo $this->page + 1; ?>";
</script>
<?php die; ?>