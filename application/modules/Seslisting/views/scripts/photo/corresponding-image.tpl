<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: corresponding-image.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(count($this->paginator) && !empty($this->paginator)){
          foreach($this->paginator as $item){ ?>
						<a data-url="<?php echo $item->photo_id; ?>" class="seslisting_corresponding_image_album" href="<?php echo $item->getHref(); ?>">
            	<img src="<?php echo $item->getPhotoUrl('thumb.icon'); ?>"/>
            </a>		
   <?php  }
}
 ?>
