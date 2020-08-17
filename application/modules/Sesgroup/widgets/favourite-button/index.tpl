<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if (!empty($this->viewer_id)): ?>
  <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesgroup')->isFavourite(array('resource_id' => $this->subject->group_id,'resource_type' => $this->subject->getType())); ?>
  <?php $favouriteClass = (!$favouriteStatus) ? 'fa-heart-o' : 'fa-heart' ;?>
  <?php $favouriteText = ($favouriteStatus) ?  $this->translate('Favorited') : $this->translate('Add to Favourite');?>
  <div class="sesgroup_sidebar_button">
    <a href='javascript:;' data-type='favourite_group_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>' data-status='<?php echo $favouriteStatus;?>' class="sesbasic_animation sesbasic_link_btn sesbasic_animation sesgroup_likefavfollow sesgroup_favourite_view_<?php echo $this->subject->group_id ?> sesgroup_favourite_group_view"><i class='fa <?php echo $favouriteClass ; ?>'></i><span style="display:none"><?php echo $this->subject->favourite_count; ?></span><span><?php echo $favouriteText; ?></span></a>
  </div>
<?php endif; ?>
