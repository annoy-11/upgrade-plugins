<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php $width = is_numeric($this->width) ? $this->width.'px' : $this->width; ?>
<div class="sesforum_create_btn sesbasic_bxs">
  <?php if(!$this->viewer->getIdentity() && $this->postButton): ?>
    <a href="<?php echo $this->url(array(), 'user_login'); ?>" class="sesforum_button sesbasic_animation" style="width:<?php echo $width; ?>"><i class="fa fa-user"></i><span><?php echo $this->translate("Login to Post")?></span></a>
  <?php elseif($this->canPost): ?>
      <?php echo $this->htmlLink($this->sesforum->getHref(array(
          'action' => 'topic-create',
      )), $this->translate('Post New Topic'), array(
          'class' => 'sesforum_button sesbasic_icon_add sesbasic_animation', 
          'style' => 'width:'.$width.';',
      )) ?>
  <?php endif; ?>
</div>
