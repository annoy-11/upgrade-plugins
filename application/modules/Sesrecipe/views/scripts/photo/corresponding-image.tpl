<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: corresposding-image.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(count($this->paginator) && !empty($this->paginator)){
          foreach($this->paginator as $item){ ?>
						<a data-url="<?php echo $item->photo_id; ?>" class="sesrecipe_corresponding_image_album" href="<?php echo $item->getHref(); ?>">
            	<img src="<?php echo $item->getPhotoUrl('thumb.icon'); ?>"/>
            </a>		
   <?php  }
}
 ?>