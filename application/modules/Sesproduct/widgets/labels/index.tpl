<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesproduct_gutter_labels">
  <div class="sesproduct_list_labels ">
    <?php if($this->subject->featured): ?>
      <span class="sesproduct_label_featured"><?php echo $this->translate('Featured');?></span>
    <?php endif; ?>
    <?php if($this->subject->sponsored): ?>
      <span class="sesproduct_label_sponsored"><?php echo $this->translate('Sponsored');?></span>
    <?php endif; ?>
    <?php if($this->subject->verified): ?>
      <span class="sesproduct_label_hot"><?php echo $this->translate('Verified');?></span>
    <?php endif; ?>
  </div>
</div>
