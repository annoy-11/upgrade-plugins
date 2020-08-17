<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataLabel.tpl  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesbusinessoffer_fs_labels">
  <?php if(isset($this->featuredActive) && !empty($item->featured)) { ?>
    <span class="featured_label" title="Featured"> <?php echo $this->translate('<i class="fa fa-star"></i>'); ?> </span>
  <?php } ?>
  <?php if(isset($this->hotActive) && !empty($item->hot)) { ?>
    <span class="hot_label" title="Hot"> <?php echo $this->translate('<i class="fa fa-star"></i>'); ?> </span>
  <?php } ?>
  <?php if(isset($this->newActive) && !empty($item->new)) { ?>
    <span class="new_label" title="New"> <?php echo $this->translate('<i class="fa fa-star"></i>'); ?> </span>
  <?php } ?>
</div>
