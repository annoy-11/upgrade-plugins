<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: existing-albumphotos.tpl 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->paginator->getTotalItemCount() > 0){ ?>
<?php foreach( $this->paginator as $photo ){ ?>
      <div class="sesusercoverphoto_thumb">
        <a href="javascript:void(0);" id="sesusercoverphoto_profile_upload_existing_photos_<?php echo $photo->photo_id; ?>" data-src="<?php echo $photo->photo_id; ?>" class="sesusercoverphoto_thumb_img">
          <span style="background-image:url(<?php echo $photo->getPhotoUrl('thumb.normalmain'); ?>);"></span>
        </a>
      </div>
<?php } ?>
  <div id="sesusercoverphoto_existing_album_see_more_page_<?php echo $this->album_id ; ?>"><?php echo ($this->paginator->count() == 0 ? '0' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? '0' : $this->page )) ;  ?></div>
<?php } ?>
<?php die; ?>