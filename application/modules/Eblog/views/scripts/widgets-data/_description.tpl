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
  $truncation = $this->truncation;
  $allParams = $this->allParams;
  $desc = $this->showDes;
?>
<?php if(in_array($desc, $allParams['show_criteria'])) { ?>
  <div class="eblog_list_contant">
    <p class="eblog_list_des sesbasic_text_light">
      <?php echo $item->getDescription($truncation); ?>
    </p>
  </div>
<?php } ?>
