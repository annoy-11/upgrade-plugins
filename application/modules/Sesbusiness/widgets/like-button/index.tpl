<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php if (!empty($this->viewer_id)): ?>
  <?php $likeStatus = Engine_Api::_()->sesbusiness()->getLikeStatus($this->subject->business_id,$this->subject->getType()); ?>
  <?php $likeClass = (!$likeStatus) ? 'fa fa-thumbs-up' : 'fa fa-thumbs-down' ;?>
  <?php $likeText = ($likeStatus) ?  $this->translate('Unlike') : $this->translate('Like');?>
  <div class="sesbusiness_sidebar_button">
    <a href='javascript:;' data-type='like_business_button_view' data-url='<?php echo $this->subject->getIdentity(); ?>' data-status='<?php echo $likeStatus;?>' class="sesbasic_animation sesbasic_link_btn sesbusiness_likefavfollow sesbusiness_like_view_<?php echo $this->subject->getIdentity(); ?> sesbusiness_like_business_view"><i class='fa <?php echo $likeClass ; ?>'></i><span style="display:none"><?php echo $this->subject->like_count; ?></span><span><?php echo $likeText; ?></span></a>
  </div>
<?php endif; ?>
