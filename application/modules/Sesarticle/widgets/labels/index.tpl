<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesarticle_gutter_labels">
  <div class="sesarticle_list_labels ">
    <?php if($this->subject->featured): ?>
      <p class="sesarticle_label_featured"><?php echo $this->translate("FEATURED"); ?></p>
    <?php endif; ?>
    <?php if($this->subject->sponsored): ?>
      <p class="sesarticle_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
    <?php endif; ?>
    <?php if($this->subject->verified): ?>
      <p class="sesarticle_label_verified"><?php echo $this->translate("VERIFIED"); ?></p>
    <?php endif; ?>
  </div>
</div>