<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<div class="sesbasic_cloud_widget sesbasic_clearfix <?php if($this->viewtype): ?> sesbasic_cloud_widget_full <?php endif; ?>" style="background-color:#<?php echo $this->widgetbgcolor; ?>;">
  <h3 style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;"><img src="application/modules/Sesrecipe/externals/images/trading_icon.png" /><?php echo $this->translate("Trending Topics"); ?></h3>
  <a href="<?php echo $this->url(array('action' => 'tags'),'sesrecipe_general',true);?>" class="sesbasic_more_link clear" style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;"><?php echo $this->translate("See All Tags");?> &raquo;</a>
  <div class="sesrecipe_tags_horizantal_recipes sesbasic_bxs sesbasic_horrizontal_scroll ">  
    <ul class="sesrecipe_tags_cloud_list">
      <?php foreach($this->paginator as $valueTags):?>
        <?php if($valueTags['text'] == '' || empty($valueTags['text'] )):?>
          <?php continue; ?>
        <?php endif;?>
        <li>
          <a style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;" href="<?php echo $this->url(array('module' =>'sesrecipe','controller' => 'index', 'action' => 'browse'),'sesrecipe_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>">       #<?php echo $this->translate($valueTags['text']); ?></a>
        </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>