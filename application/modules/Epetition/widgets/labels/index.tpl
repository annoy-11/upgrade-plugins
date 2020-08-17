<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="epetition_gutter_labels sesbasic_bxs">
  <div class="epetition_profile_labels ">
    <?php if($this->subject->featured): ?>
      <p class="epetition_label_featured"><?php echo $this->translate("FEATURED"); ?></p>
    <?php endif; ?>
    <?php if($this->subject->sponsored): ?>
      <p class="epetition_label_sponsored"><?php echo $this->translate("SPONSORED"); ?></p>
    <?php endif; ?>
    <?php if($this->subject->verified): ?>
      <p class="epetition_label_verified"><?php echo $this->translate("VERIFIED"); ?></p>
    <?php endif; ?>
  </div>
</div>
