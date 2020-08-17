<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesjob_gutter_labels">
  <div class="sesjob_list_labels ">
    <?php if($this->subject->featured): ?>
      <p class="sesjob_label_featured"><?php echo $this->translate("FEATURED"); ?></p>
    <?php endif; ?>
    <?php if($this->subject->sponsored): ?>
      <p class="sesjob_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
    <?php endif; ?>
    <?php if($this->subject->hot): ?>
      <p class="sesjob_label_hot"><?php echo $this->translate("HOT"); ?></p>
    <?php endif; ?>
    <?php if($this->subject->verified): ?>
      <p class="sesjob_label_verified"><?php echo $this->translate("VERIFIED"); ?></p>
    <?php endif; ?>
  </div>
</div>
