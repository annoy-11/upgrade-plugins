<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
  $baseUrl = $this->layout()->staticBaseUrl; 
  $this->headLink()->appendStylesheet($baseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css');
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
  $this->headScript()->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); 
?>

<div class="sesbasic_cloud_widget sesbasic_clearfix <?php if($this->viewtype): ?> sesbasic_cloud_widget_full <?php endif; ?>" style="background-color:#<?php echo $this->widgetbgcolor; ?>;">
  <h3 style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;"><img src="application/modules/Eblog/externals/images/trading_icon.png" /><?php echo $this->translate("Trending Topics"); ?></h3>
  <a href="<?php echo $this->url(array('action' => 'tags'),'eblog_general',true);?>" class="sesbasic_more_link clear" style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;"><?php echo $this->translate("See All Tags");?> &raquo;</a>
  <div class="eblog_tags_horizantal_blogs sesbasic_bxs sesbasic_horrizontal_scroll ">  
    <ul class="eblog_tags_cloud_list">
      <?php foreach($this->paginator as $valueTags):?>
        <?php if($valueTags['text'] == '' || empty($valueTags['text'] )) continue; ?>
        <li><a style="background-color:#<?php echo $this->buttonbgcolor; ?>;color:#<?php echo $this->textcolor; ?>;" href="<?php echo $this->url(array('module' =>'eblog','controller' => 'index', 'action' => 'browse'),'eblog_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>">       #<?php echo $this->translate($valueTags['text']); ?></a></li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
