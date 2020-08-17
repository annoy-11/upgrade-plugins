<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>
<div class="sesgroup_tags_cloud_group sesbasic_bxs ">
  <ul class="sesgroup_tags_cloud_list">
  <?php foreach($this->tagCloudData as $valueTags):?>
    <?php if($valueTags['text'] == '' && empty($valueTags['text'])):?>
      <?php continue;?>
    <?php endif;?>
    <li><a href="<?php echo $this->url(array('action' => 'browse'),'sesgroup_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><b><?php echo $valueTags['text'] ?></b><sup><?php echo $valueTags['itemCount']; ?></sup></a></li>
  <?php endforeach;?>
  </ul>
</div>