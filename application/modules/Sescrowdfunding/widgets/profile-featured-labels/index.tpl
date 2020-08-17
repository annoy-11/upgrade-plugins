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
<div class="sescf_profile_labels">
  <?php if($this->subject->featured): ?>
    <p class="sescf_label_featured"><?php echo $this->translate("FEATURED"); ?></p>
  <?php endif; ?>
</div>