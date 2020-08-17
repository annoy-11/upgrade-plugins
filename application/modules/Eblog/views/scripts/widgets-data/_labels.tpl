<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $item = $this->item;
  $allParams = $this->allParams;
?>
<?php if(in_array('featuredLabel', $allParams['show_criteria']) || in_array('sponsoredLabel', $allParams['show_criteria'])): ?>
  <div class="eblog_list_labels ">
    <?php if(in_array('sponsoredLabel', $allParams['show_criteria']) && $item->sponsored == 1):?>
        <p class="eblog_label_sponsored"><?php echo $this->translate('Sponsored');?></p>
      <?php endif;?>
      <?php if(in_array('featuredLabel', $allParams['show_criteria']) && $item->featured == 1):?>
        <p class="eblog_label_featured"><?php echo $this->translate('Featured');?></p>
      <?php endif;?>
  </div>
<?php endif;?>
