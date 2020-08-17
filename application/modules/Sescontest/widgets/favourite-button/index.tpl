<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if (!empty($this->viewer_id)): ?>
  <?php $favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sescontest')->isFavourite(array('resource_id' => $this->subject->contest_id,'resource_type' => $this->subject->getType())); ?>
  <?php $favouriteClass = (!$favouriteStatus) ? 'fa-heart' : 'fa-heart-o' ;?>
  <?php $favouriteText = ($favouriteStatus) ?  $this->translate('Favorited') : $this->translate('Add to Favorites');?>
  <div class="sescontest_sidebar_button">
    <a href='javascript:;' data-type='favourite_contest_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>' data-status='<?php echo $favouriteStatus;?>' class="sesbasic_animation sesbasic_link_btn sescontest_likefavfollow sescontest_favourite_view_<?php echo $this->subject->contest_id ?> secontest_favourite_contest_view"><i class='fa <?php echo $favouriteClass ; ?>'></i><span><?php echo $favouriteText; ?></span></a>
  </div>
<?php endif; ?>
