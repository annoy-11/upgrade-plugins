<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<div class="estore_view_sidebar_labels sesbasic_bxs sesbasic_clearfix">
  <?php if(in_array('verified',$this->option) && isset($this->subject->verified) && $this->subject->verified){ ?>
    <span class="label_verified" title="<?php echo $this->translate('Verified') ;?>"><?php echo $this->translate('Verified');?></span>
  <?php } ?>
  <?php if(in_array('featured',$this->option) && $this->subject->featured){ ?>
    <span class="estore_label_featured" title="<?php echo $this->translate('Featured') ;?>"><?php echo $this->translate('Featured');?></span>
  <?php } ?>
  <?php if(in_array('sponsored',$this->option) && $this->subject->sponsored){ ?>
    <span class="estore_label_sponsored" title="<?php echo $this->translate('Sponsored') ;?>"><?php echo $this->translate('Sponsored');?></span>
  <?php } ?>
  <?php if(in_array('hot',$this->option) && $this->subject->hot){ ?>
    <span class="estore_label_hot" title="<?php echo $this->translate('Hot') ;?>"><?php echo $this->translate('Hot');?></span>
  <?php } ?>
</div>
