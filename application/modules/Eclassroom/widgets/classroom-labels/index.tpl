<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<div class="eclassroom_view_sidebar_labels sesbasic_bxs sesbasic_clearfix">
  <?php if(in_array('verified',$this->option) && isset($this->subject->verified) && $this->subject->verified){ ?>
    <span class="label_verified" title="<?php echo $this->translate('Verified') ;?>"><?php echo $this->translate('Verified');?></span>
  <?php } ?>
  <?php if(in_array('featured',$this->option) && $this->subject->featured){ ?>
    <span class="eclassroom_label_featured" title="<?php echo $this->translate('Featured') ;?>"><?php echo $this->translate('Featured');?></span>
  <?php } ?>
  <?php if(in_array('sponsored',$this->option) && $this->subject->sponsored){ ?>
    <span class="eclassroom_label_sponsored" title="<?php echo $this->translate('Sponsored') ;?>"><?php echo $this->translate('Sponsored');?></span>
  <?php } ?>
  <?php if(in_array('hot',$this->option) && $this->subject->hot){ ?>
    <span class="eclassroom_label_hot" title="<?php echo $this->translate('Hot') ;?>"><?php echo $this->translate('Hot');?></span>
  <?php } ?>
</div>
