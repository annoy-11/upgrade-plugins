<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<div class="eclassroom_tags_cloud_classroom sesbasic_bxs " style="background-color:#<?php echo $this->widgetbgcolor; ?>;">
  <ul class="eclassroom_tags_cloud_list">
  <?php foreach($this->tagCloudData as $valueTags):?>
    <?php if($valueTags['text'] == '' && empty($valueTags['text'])):?>
      <?php continue;?>
    <?php endif;?>
    <li><a href="<?php echo $this->url(array('action' => 'browse'),'eclassroom_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>" style="background-color:#<?php echo $this->buttonbgcolor; ?>;"><b style="color:#<?php echo $this->textcolor; ?>;"><?php echo $valueTags['text'] ?></b><sup><?php echo $valueTags['itemCount']; ?></sup></a></li>
  <?php endforeach;?>
  </ul>
</div>
