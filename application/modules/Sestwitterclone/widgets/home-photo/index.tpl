<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sestwitterclone/externals/styles/styles.css'); ?>
<div class="sestwitterclone_member_cover" style="background-image:url('<?php echo $this->photo; ?>');"></div>
<div class="sestwitterclone_member_info">
   <div class="sestwitterclone_member_photo">
     <a href="<?php echo $this->viewer()->getHref(); ?>">
        <?php echo $this->itemPhoto($this->viewer, 'thumb.profile', true); ?>
     </a>
   </div>
   <h3>
    <a href="<?php echo $this->viewer()->getHref(); ?>"><?php echo $this->translate('%1$s', $this->viewer()->getTitle()); ?></a>
   </h3>
</div>
<div class="sestwitterclone_member_other_info">
  <div>
    <span class="_name sesbasic_text_light"><?php echo $this->translate('Posts'); ?></span>
    <span class="_count"><?php echo $this->postCount; ?></span>
  </div>
  <div>
    <span class="_name sesbasic_text_light"><?php echo $this->translate("Following"); ?></span>
    <span class="_count"><?php echo $this->followCount; ?></span>
  </div>
  <div>
    <span class="_name sesbasic_text_light"><?php echo $this->translate("Followers"); ?></span>
    <span class="_count"><?php echo $this->followCount; ?></span>
  </div>
</div>
