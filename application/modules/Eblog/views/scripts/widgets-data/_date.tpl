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
<?php if(in_array('creationDate', $allParams['show_criteria'])) { ?>
  <?php if($this->viewType == 1) { ?>
    <div class="eblog_list_date">
      <span>
        <?php if($item->publish_date): ?>
          <span class="_day"><?php echo date('d',strtotime($item->publish_date));?></span>
          <span class="_month"><?php echo date('M',strtotime($item->publish_date));?></span>
        <?php else: ?>
          <span class="_day"><?php echo date('d',strtotime($item->creation_date));?></span>
          <span class="_month"><?php echo date('M',strtotime($item->creation_date));?></span>
        <?php endif; ?>
      </span>
    </div>
  <?php } else if($this->viewType == 2) { ?>
    <div class="eblog_list_second_blog_date">
      <?php if($item->publish_date): ?>
        <p class=""><span class="month"><?php echo date('M',strtotime($item->publish_date));?></span> <span class="date"><?php echo date('d',strtotime($item->publish_date));?></span> <span class="year"><?php echo date('Y',strtotime($item->publish_date));?></span></p>
      <?php else: ?>
        <p class=""><span class="month"><?php echo date('M',strtotime($item->creation_date));?></span> <span class="date"><?php echo date('d',strtotime($item->creation_date));?></span> <span class="year"><?php echo date('Y',strtotime($item->creation_date));?></span></p>
      <?php endif; ?>
    </div>
  <?php } else if($this->viewType == 3) {  ?>
    <div class="eblog_list_full_date_blog">
      <p class="sesbasic_text_light">
        <?php if($item->publish_date): ?>
          <?php echo date('M d, Y',strtotime($item->publish_date));?>
        <?php else: ?>
          <?php echo date('M d, Y',strtotime($item->creation_date));?>
        <?php endif; ?>
      </p>
    </div>
  <?php } else if($this->viewType == 4) { ?>
    <div class="eblog_list_stats sesbasic_text_light"> 
      <span>
        <?php if($item->publish_date): ?>
          <?php echo date('M d, Y',strtotime($item->publish_date));?>
        <?php else: ?>
          <?php echo date('M d, Y',strtotime($item->creation_date));?>
        <?php endif; ?>
      </span>
    </div>
  <?php } else if($this->viewType == 5) { ?>
    <div class="eblog_list_stats sesbasic_text_light">
      <?php if($item->publish_date): ?>
        <?php echo $this->translate("on "); ?><?php echo date('M d, Y',strtotime($item->publish_date));?>
      <?php else: ?>
        <?php echo date('M d, Y',strtotime($item->creation_date));?>
      <?php endif; ?>
    </div>
  <?php } else if($this->viewType == 6) { ?>
    <div class="eblog_grid_date_blog sesbasic_text_light">
      <?php if($item->publish_date): ?>
        <?php echo $this->translate("Posted "); ?><?php echo date('M d, Y',strtotime($item->publish_date));?>
      <?php else: ?>
        <?php echo date('M d, Y',strtotime($item->creation_date));?>
      <?php endif; ?>
    </div>
  <?php } else if($this->viewType == 7) { ?>
    <div class="eblog_list_stats eblog_pinboard_date sesbasic_text_light">
      <?php if($item->publish_date): ?>
        <span><a href="<?php echo $this->url(array('action'=>'browse'),'eblog_general',true).'?date='.date('Y-m-d',strtotime($item->publish_date)); ?>"> <?php echo date('d M',strtotime($item->publish_date));?></a></span>
      <?php else: ?>
        <span><a href="<?php echo $this->url(array('action'=>'browse'),'eblog_general',true).'?date='.date('Y-m-d',strtotime($item->creation_date)); ?>"> <?php echo date('d M',strtotime($item->creation_date));?></a></span>
      <?php endif; ?>
    </div>
  <?php } ?>
<?php } ?>
