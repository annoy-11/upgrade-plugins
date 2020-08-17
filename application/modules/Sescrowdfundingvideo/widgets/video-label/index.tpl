<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="sescrowdfundingvideo_view_labels">
  <?php if(in_array('featured',$this->option) && $this->subject->is_featured){ ?>
    <span class="sescrowdfundingvideo_label_featured"><?php echo $this->translate('Featured') ;?></span>
  <?php } ?>
  <?php if(in_array('sponsored',$this->option) && $this->subject->is_sponsored){ ?>
    <span class="sescrowdfundingvideo_label_sponsored"><?php echo $this->translate('Sponsored') ;?></span>
  <?php } ?>
  <?php if(in_array('hot',$this->option) && $this->subject->is_hot){ ?>
    <span class="sescrowdfundingvideo_label_hot"><?php echo $this->translate('Hot') ;?></span>
  <?php } ?>
  <?php if(in_array('offtheday',$this->option) && $this->subject->offtheday){ ?>
    <span class="sescrowdfundingvideo_label_highlighted"><?php echo $this->translate('Of The Day') ;?></span>
  <?php } ?>
</div>
