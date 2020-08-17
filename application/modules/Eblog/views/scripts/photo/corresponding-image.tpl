<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: corresposding-image.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(count($this->paginator) && !empty($this->paginator)){
          foreach($this->paginator as $item){ ?>
						<a data-url="<?php echo $item->photo_id; ?>" class="eblog_corresponding_image_album" href="<?php echo $item->getHref(); ?>">
            	<img src="<?php echo $item->getPhotoUrl('thumb.icon'); ?>"/>
            </a>		
   <?php  }
}
 ?>