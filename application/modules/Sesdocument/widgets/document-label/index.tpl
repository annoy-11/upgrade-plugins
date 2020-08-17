<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="sesdoc_view_labels">
  <?php if(in_array('verified',$this->option) && $this->subject->verified){ ?>
    <span class="sesdoc_label_new"><?php echo $this->translate('Verified') ;?></span>
  <?php } ?>
  <?php if(in_array('featured',$this->option) && $this->subject->featured){ ?>
    <span class="sesdoc_label_featured"><?php echo $this->translate('Featured') ;?></span>
  <?php } ?>
  <?php if(in_array('sponsored',$this->option) && $this->subject->sponsored){ ?>
    <span class="sesdoc_label_hot"><?php echo $this->translate('Sponsored') ;?></span>
  <?php } ?>
</div>
