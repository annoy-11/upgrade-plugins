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
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
<div class="epetition_tags_cloud_petition sesbasic_bxs ">
  <ul class="epetition_tags_cloud_list">
  <?php foreach($this->tagCloudData as $valueTags):?>
    <?php if($valueTags['text'] == '' && empty($valueTags['text'])):?>
      <?php continue;?>
    <?php endif;?>
    <li><a href="<?php echo $this->url(array('module' =>'epetition', 'action' => 'browse'),'epetition_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><b><?php echo $valueTags['text'] ?></b><sup><?php echo $valueTags['itemCount']; ?></sup></a></li>
  <?php endforeach;?>
  </ul>
</div>
