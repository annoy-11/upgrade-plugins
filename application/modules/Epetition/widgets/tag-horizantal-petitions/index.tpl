<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<div class="sesbasic_cloud_widget sesbasic_clearfix <?php if($this->viewtype): ?> sesbasic_cloud_widget_full <?php endif; ?>" style="background-color:#<?php echo $this->widgetbgcolor; ?>;">
  <h3 style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;"><img src="application/modules/Epetition/externals/images/trading_icon.png" /><?php echo $this->translate("Trending Topics"); ?></h3>
  <a href="<?php echo $this->url(array('action' => 'tags'),'epetition_general',true);?>" class="sesbasic_more_link clear" style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;"><?php echo $this->translate("See All Tags");?> &raquo;</a>
  <div class="epetition_tags_horizantal_petitions sesbasic_bxs sesbasic_horrizontal_scroll ">
    <ul class="epetition_tags_cloud_list">
      <?php foreach($this->paginator as $valueTags):?>
        <?php if($valueTags['text'] == '' || empty($valueTags['text'] )):?>
          <?php continue; ?>
        <?php endif;?>
        <li>
          <a style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;" href="<?php echo $this->url(array('module' =>'epetition','controller' => 'index', 'action' => 'browse'),'epetition_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>">       #<?php echo $this->translate($valueTags['text']); ?></a>
        </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>