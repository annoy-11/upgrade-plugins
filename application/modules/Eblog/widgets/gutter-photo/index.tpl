<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="eblog_onear_photo_three">
	<?php if($this->title) { ?>
    <p class="about_title"><?php echo $this->translate($this->title);?></p>
  <?php } ?>
  <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' =>  ($this->photoviewtype == 'square') ? 'eblogs_gutter_photo_square' : 'eblogs_gutter_photo')) ?>
	<?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'eblogs_gutter_name')); ?>
</div>
