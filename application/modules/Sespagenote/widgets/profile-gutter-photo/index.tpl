<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagenote/externals/styles/style.css'); ?> 
<?php
	$allParams = $this->allParams;

  if( $this->note && $this->note->photo_id ):

    $ownerPhoto = $this->itemPhoto($this->owner, 'thumb.profile');
    $photoClass = 'sespagenotes_gutter_owner';
  endif;

  if( !isset($ownerPhoto) ):
    $ownerPhoto = $this->itemPhoto($this->owner);
  endif;
?>
<!--<?php if(!empty($this->note->featured) && in_array('featured' , $allParams['show_criteria'])) { ?>
<?php echo $this->translate("Featured"); ?>
<?php } ?>
<?php if(!empty($this->note->sponsored) && in_array('sponsored' , $allParams['show_criteria'])) { ?>
<?php echo $this->translate("Sponsored"); ?>
<?php } ?>-->
<?php if(in_array('ownerphoto', $allParams['show_criteria'])) { ?>
  <?php echo $this->htmlLink($this->owner->getHref(), $ownerPhoto, array('class' => $photoClass)); ?>
<?php } ?>
<?php if(in_array('by', $allParams['show_criteria'])) { ?>
	<?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'sespagenotes_gutter_name')); ?>
<?php } ?>
