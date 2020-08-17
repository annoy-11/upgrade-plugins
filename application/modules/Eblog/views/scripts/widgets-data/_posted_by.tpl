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

<?php if(in_array('by', $allParams['show_criteria'])){ ?>
  <?php if($this->viewType == 1) { ?>
    <div class="eblog_stats_list sesbasic_text_light">
      <span><?php echo $this->translate("Posted by") ?> <?php echo $this->htmlLink($item->getOwner()->getHref(),$item->getOwner()->getTitle() ) ?></span>
    </div>
  <?php } else if($this->viewType == 2) { ?>
    <div class="eblog_stats_list admin_img sesbasic_text_light">
      <span>
        <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?>
        <?php echo $this->translate("by") ?> <?php echo $this->htmlLink($item->getOwner()->getHref(),$item->getOwner()->getTitle() ) ?>
      </span>
    </div>
  <?php } else if($this->viewType == 3) { ?>
    <div class="eblog_list_stats _owner sesbasic_text_light">
      <span>
        <?php echo $this->translate("Posted by") ?> <?php echo $this->htmlLink($item->getOwner()->getParent(), $this->itemPhoto($item->getOwner()->getParent(), 'thumb.icon')); ?><?php echo $this->htmlLink($item->getOwner()->getHref(),$item->getOwner()->getTitle() ) ?>
      </span>
    </div>

  <?php } ?>
<?php } ?>
