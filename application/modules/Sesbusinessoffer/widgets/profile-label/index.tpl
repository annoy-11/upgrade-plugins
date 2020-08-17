<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbusinessoffer_view_labels">
  <?php if(in_array('featured',$this->option) && $this->subject->featured){ ?>
    <span class="sesbusinessoffer_label_featured"><?php echo $this->translate('Featured') ;?></span>
  <?php } ?>
  <?php if(in_array('hot',$this->option) && $this->subject->hot){ ?>
    <span class="sesbusinessoffer_label_hot"><?php echo $this->translate('Hot') ;?></span>
  <?php } ?>
  <?php if(in_array('new',$this->option) && $this->subject->new){ ?>
    <span class="sesbusinessoffer_label_new"><?php echo $this->translate('New') ;?></span>
  <?php } ?>
</div>
