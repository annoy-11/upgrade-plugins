<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesforum/externals/styles/styles.css'); ?>

<div class="sesforum_tags_cloud_product sesbasic_bxs ">
  <div class="sesbasic_tags">
  <?php $counter = 0; ?>
  <?php foreach($this->tagCloudData as $valueTags):?>
    <?php if($valueTags['text'] == '' && empty($valueTags['text'])):?>
      <?php continue;?>
    <?php endif;?>
    <a href="<?php echo $this->url(array(), 'sesforum_search', true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>" ><?php echo $valueTags['text'] ?>&nbsp;<b><?php echo $valueTags['itemCount'];?></b></a>
  <?php $counter++; endforeach;?>
  </div>
</div>
