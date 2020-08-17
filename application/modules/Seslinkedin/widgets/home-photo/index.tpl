<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslinkedin/externals/styles/styles.css'); ?>
<div class="seslinkedin_member_cover" style="background-image:url('<?php echo $this->photo; ?>');"></div>
<div class="seslinkedin_member_info">
   <div class="seslinkedin_member_photo">
     <?php echo $this->htmlLink($this->viewer()->getHref(), $this->itemPhoto($this->viewer(), 'thumb.cover')) ?>
   </div>
   <h3>
    <a href="<?php echo $this->viewer()->getHref(); ?>"><?php echo $this->translate('%1$s', $this->viewer()->getTitle()); ?></a>
   </h3>
</div>
<div class="seslinkedin_member_other_info">
  <div>
    <span class="_name sesbasic_text_light"><?php echo $this->translate('Connections'); ?></span>
    <span class="_count"><?php echo $this->friendCount; ?></span>
  </div>
  <div>
    <span class="_name sesbasic_text_light"><?php echo $this->translate("Who's viewed your profile"); ?></span>
    <span class="_count"><?php echo $this->viewer->view_count; ?></span>
  </div>
</div>
