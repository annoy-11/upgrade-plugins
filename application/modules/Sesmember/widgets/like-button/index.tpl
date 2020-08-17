<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if (!empty($this->viewer_id)): ?>
  <?php      
  $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->user_id, 'user');
  $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
  $likeText = ($likeUser) ?  $this->translate('UNLIKE') : $this->translate('LIKE') ;
  ?>
  <div class="sesmember_button">
    <a href='javascript:;' data-url='<?php echo $this->subject->getIdentity(); ?>' class='sesbasic_animation sesbasic_link_btn sesmember_button_like_user sesmember_button_like_user_<?php echo $this->subject->getIdentity(); ?>'><i class='fa <?php echo $likeClass ; ?>'></i><span><?php echo $likeText; ?></span></a>     
  </div>
<?php endif; ?>
