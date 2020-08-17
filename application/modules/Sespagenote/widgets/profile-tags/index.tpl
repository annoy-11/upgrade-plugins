<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagenote/externals/styles/style.css'); ?> 
<div class="sespagenote_cloud_widget sesbasic_cloud_widget sesbasic_clearfix">
  <div class="sespagenote_tags_cloud_page sesbasic_bxs ">
    <ul class="sespagenote_tags_cloud_list">
      <?php foreach($this->paginator as $valueTags):?>
        <?php if($valueTags['text'] == '' || empty($valueTags['text'] )):?>
          <?php continue; ?>
        <?php endif;?>
        <li><a href="<?php echo $this->url(array('action' => 'browse'),'sespagenote_general',true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>"><?php echo $valueTags['text'] ?></a></li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
