<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if (!empty($this->viewer_id)): ?>
  <?php      
  $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->crowdfunding_id, 'crowdfunding');
  $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
  $likeText = ($likeUser) ?  $this->translate('Unlike') : $this->translate('Like') ;
  ?>
  <div class="sescf_sidebar_button sesbasic_bxs">
    <button data-url="<?php echo $this->subject->crowdfunding_id ; ?>" class="sesbasic_animation sescrowdfunding_like_sescrowdfunding_view sescrowdfunding_like_sescrowdfunding_<?php echo $this->subject->crowdfunding_id ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $likeText;?></span></button>
  </div>
<?php endif; ?>
