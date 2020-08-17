<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesproduct/externals/styles/styles.css'); ?>
<div class="sesproduct_tags_cloud_product sesbasic_bxs " style="background-color:#<?php echo $this->widgetbgcolor; ?>;">
  <ul class="sesproduct_tags_cloud_list">
  <?php $counter = 0; ?>
  <?php foreach($this->tagCloudData as $valueTags):?>
  <?php if($counter == $this->show_count) { break; } ?>
    <?php if($valueTags['text'] == '' && empty($valueTags['text'])):?>
      <?php continue;?>
    <?php endif;?>
    <li><a href="<?php echo $this->url(array('module' =>'sesproduct', 'action' => 'browse'),'sesproduct_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>" style="background-color:#<?php echo $this->buttonbgcolor; ?>;"><b style="color:#<?php echo $this->textcolor; ?>;"><?php echo $valueTags['text'] ?></b><sup><?php echo $valueTags['itemCount'];?></sup></a></li>
  <?php $counter++; endforeach;?>
  </ul>
</div>
