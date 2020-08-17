<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _label.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)):?>
<div class="sesjob_grid_labels">
  <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
  <p class="sesjob_label_featured" title="Featured"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
  <?php endif;?>
  <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
    <p class="sesjob_label_sponsored" title="Sponsored"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
  <?php endif;?>
  <?php if(isset($this->hotLabelActive) && $item->hot == 1):?>
    <p class="sesjob_label_hot" title="Hot"><?php echo $this->translate('<i class="fa fa-star"></i>');?></p>
  <?php endif;?>
</div>
<?php endif;?>
<?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
<div class="sesjob_grid_verified_label" title="<?php echo $this->translate('VERIFIED');?>"><i class="fa fa-check"></i></div>
<?php endif;?>
