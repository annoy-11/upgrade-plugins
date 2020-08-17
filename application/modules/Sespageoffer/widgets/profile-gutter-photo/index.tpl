<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespageoffer/externals/styles/style.css'); ?> 
<?php
	$allParams = $this->allParams;

  if( $this->offer && $this->offer->photo_id ):

    $ownerPhoto = $this->itemPhoto($this->owner, 'thumb.profile');
    $photoClass = 'sespageoffers_gutter_owner';
  endif;

  if( !isset($ownerPhoto) ):
    $ownerPhoto = $this->itemPhoto($this->owner);
  endif;
?>
<div class="sespageoffer_gutter_main">
<?php if(in_array('ownerphoto', $allParams['show_criteria'])) { ?>
  <?php echo $this->htmlLink($this->owner->getHref(), $ownerPhoto, array('class' => $photoClass)); ?>
<?php } ?>
<?php if(in_array('by', $allParams['show_criteria'])) { ?>
	<?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'sespageoffers_gutter_name')); ?>
<?php } ?>
</div>
