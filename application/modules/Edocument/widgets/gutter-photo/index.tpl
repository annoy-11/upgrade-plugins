<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="edocument_onear_photo_three">
	<p class="about_title"><?php echo $this->translate($this->title);?></p>
  <?php if($this->photoviewtype == 'square'): ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'edocuments_gutter_photo_square')) ?>
  <?php else: ?>
    <?php echo $this->htmlLink($this->owner->getHref(), $this->itemPhoto($this->owner),array('class' => 'edocuments_gutter_photo')) ?>
	<?php endif; ?>
	<?php echo $this->htmlLink($this->owner->getHref(), $this->owner->getTitle(), array('class' => 'edocuments_gutter_name')) ?>
</div>
