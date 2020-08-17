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
  $showin = $this->showin;
?>
<?php if(in_array('category', $allParams['show_criteria'])) { ?>
  <?php if($item->category_id):?> 
    <?php $categoryItem = Engine_Api::_()->getItem('eblog_category', $item->category_id);?>
    <?php if($categoryItem):?>
      <div class="eblog_stats_list sesbasic_text_light">
        <?php if($this->withIcon) { ?>
          <span>
            <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> 
            <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
          </span>
        <?php } else { ?>
          <span>
            <?php if(empty($showin)) { ?>
            <?php echo $this->translate("in"); ?>
            <?php } ?>
            <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a>
          </span>
        <?php } ?>
      </div>
    <?php endif;?>
  <?php endif;?>
<?php } ?>
