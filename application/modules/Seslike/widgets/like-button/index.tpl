<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslike/externals/styles/styles.css'); ?>
<?php if (!empty($this->viewer_id)): ?>
  <?php      
  $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($this->subject->getIdentity(), $this->subject->getType());
  $likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
  $likeText = ($likeUser) ?  $this->translate('Unlike') : $this->translate('Like') ;
  ?>
  <div class="seslike_button_widget">
    <a href="javascript:;" data-id="<?php echo $this->subject->getIdentity() ; ?>" data-type="<?php echo $this->subject->getType() ; ?>" data-url="<?php echo $this->subject->getIdentity() ; ?>" class="<?php if($likeUser) { ?> button_active <?php } ?> sesbasic_animation sesbasic_link_btn seslike_like_content_view  seslike_like_<?php echo $this->subject->getType() ?>_<?php echo $this->subject->getIdentity() ?>"><i class="fa <?php echo $likeClass;?>"></i><span><?php echo $likeText;?></span></a>
  </div>
<?php endif; ?>
