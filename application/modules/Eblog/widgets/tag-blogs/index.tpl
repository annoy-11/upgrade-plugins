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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eblog/externals/styles/styles.css'); ?>
<div class="eblog_tags_cloud_blog sesbasic_bxs ">
  <ul class="eblog_tags_cloud_list">
    <?php foreach($this->tagCloudData as $valueTags):?>
      <?php if($valueTags['text'] == '' && empty($valueTags['text'])) continue; ?>
      <li><a href="<?php echo $this->url(array('module' =>'eblog', 'action' => 'browse'),'eblog_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><b><?php echo $valueTags['text'] ?></b><sup><?php echo $valueTags['itemCount']; ?></sup></a></li>
    <?php endforeach;?>
  </ul>
</div>
