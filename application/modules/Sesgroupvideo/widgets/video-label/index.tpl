<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesgroupvideo_view_labels">
  <?php if(in_array('featured',$this->option) && $this->subject->is_featured){ ?>
    <span class="sesgroupvideo_label_featured"><?php echo $this->translate('Featured') ;?></span>
  <?php } ?>
  <?php if(in_array('sponsored',$this->option) && $this->subject->is_sponsored){ ?>
    <span class="sesgroupvideo_label_sponsored"><?php echo $this->translate('Sponsored') ;?></span>
  <?php } ?>
  <?php if(in_array('hot',$this->option) && $this->subject->is_hot){ ?>
    <span class="sesgroupvideo_label_hot"><?php echo $this->translate('Hot') ;?></span>
  <?php } ?>
  <?php if(in_array('offtheday',$this->option) && $this->subject->offtheday){ ?>
    <span class="sesgroupvideo_label_highlighted"><?php echo $this->translate('Of The Day') ;?></span>
  <?php } ?>
</div>
