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
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enablereadtime', 1) && in_array('readtime', $allParams['show_criteria']) && !empty($item->readtime)) { ?>
  <div class="eblog_stats_list sesbasic_text_light eblog_read_time">
    <span><i class="fa fa-clock-o"></i><?php echo $item->readtime ?>. <?php echo $this->translate("read"); ?></span>
  </div>
<?php } ?>
