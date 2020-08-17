<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
<div class="sesbasic_clearfix sesbasic_bxs ">
  <ul class="sesbasic_tags_list">
  <?php foreach($this->tagCloudData as $valueTags):?>
    <?php if($valueTags['text'] == '' && empty($valueTags['text'])):?>
      <?php continue;?>
    <?php endif;?>
    <li><a href="<?php echo $this->url(array('module' =>'sescrowdfunding', 'action' => 'browse'),'sescrowdfunding_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><b><?php echo $valueTags['text'] ?></b><sup><?php echo $valueTags['itemCount']; ?></sup></a></li>
  <?php endforeach;?>
  </ul>
</div>