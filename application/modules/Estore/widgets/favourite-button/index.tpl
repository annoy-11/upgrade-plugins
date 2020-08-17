<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if (!empty($this->viewer_id)): ?>
  <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'estore')->isFavourite(array('resource_id' => $this->subject->store_id,'resource_type' => $this->subject->getType())); ?>
  <?php $favouriteClass = (!$favouriteStatus) ? 'fa-heart-o' : 'fa-heart' ;?>
  <?php $favouriteText = ($favouriteStatus) ?  $this->translate('Favorited') : $this->translate('Add to Favourite');?>
  <div class="estore_sidebar_button">
    <a href='javascript:;' data-type='favourite_store_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>' data-status='<?php echo $favouriteStatus;?>' class="sesbasic_animation estore_link_btn sesbasic_animation estore_likefavfollow estore_favourite_view_<?php echo $this->subject->store_id ?> estore_favourite_store_view"><i class='fa <?php echo $favouriteClass ; ?>'></i><span style="display:none"><?php echo $this->subject->favourite_count; ?></span><span><?php echo $favouriteText; ?></span></a>
  </div>
<?php endif; ?>
