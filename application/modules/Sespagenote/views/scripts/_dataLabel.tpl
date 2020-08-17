<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _dataLabel.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sespagenote_fs_labels">
  <?php if(isset($this->featuredActive) && !empty($item->featured)) { ?>
    <span class="featured_label" title="Featured"> <?php echo $this->translate('<i class="fa fa-star"></i>'); ?> </span>
  <?php } ?>
  <?php if(isset($this->sponsoredActive) && !empty($item->sponsored)) { ?>
    <span class="sponsored_label" title="Sponsored"> <?php echo $this->translate('<i class="fa fa-star"></i>'); ?> </span>
  <?php } ?>
</div>
