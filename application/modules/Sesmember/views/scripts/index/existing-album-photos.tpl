<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: existing-album-photos.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if($this->paginator->getTotalItemCount() > 0){ ?>
<?php foreach( $this->paginator as $photo ){ ?>
      <div class="sesmember_thumb">
        <a href="javascript:void(0);" id="sesmember_profile_upload_existing_photos_<?php echo $photo->photo_id; ?>" data-src="<?php echo $photo->photo_id; ?>" class="sesmember_thumb_img">
          <span style="background-image:url(<?php echo $photo->getPhotoUrl('thumb.normalmain'); ?>);"></span>
        </a>
      </div>
<?php } ?>
  <div id="sesmember_existing_album_see_more_page_<?php echo $this->album_id ; ?>"><?php echo ($this->paginator->count() == 0 ? '0' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? '0' : $this->page )) ;  ?></div>
<?php } ?>
<?php die; ?>