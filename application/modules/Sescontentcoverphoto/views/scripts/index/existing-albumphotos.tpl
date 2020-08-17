<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontentcoverphoto
 * @package    Sescontentcoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: existing-albumphotos.tpl 2016-06-020 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->paginator->getTotalItemCount() > 0){ ?>
<?php foreach( $this->paginator as $photo ){ ?>
  <div class="sescontentcoverphoto_thumb">
    <a href="javascript:void(0);" id="sescontentcoverphoto_profile_upload_existing_photos_<?php echo $photo->photo_id; ?>" data-src="<?php echo $photo->photo_id; ?>" class="sescontentcoverphoto_thumb_img">
      <span style="background-image:url(<?php echo $photo->getPhotoUrl('thumb.normalmain'); ?>);"></span>
    </a>
  </div>
<?php } ?>
  <div id="sescontentcoverphoto_existing_album_see_more_page_<?php echo $this->album_id ; ?>"><?php echo ($this->paginator->count() == 0 ? '0' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? '0' : $this->page )) ;  ?></div>
<?php } ?>
<?php die; ?>