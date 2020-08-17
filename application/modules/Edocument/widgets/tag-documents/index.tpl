<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Edocument/externals/styles/styles.css'); ?>
<div class="edocument_tags_cloud_document sesbasic_bxs ">
  <ul class="edocument_tags_cloud_list">
    <?php foreach($this->tagCloudData as $valueTags): ?>
      <?php if($valueTags['text'] == '' && empty($valueTags['text'])):?>
        <?php continue;?>
      <?php endif;?>
      <li><a href="<?php echo $this->url(array('module' =>'edocument', 'action' => 'browse'),'edocument_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><b><?php echo $valueTags['text'] ?></b><sup><?php echo $valueTags['itemCount']; ?></sup></a></li>
    <?php endforeach;?>
  </ul>
</div>
