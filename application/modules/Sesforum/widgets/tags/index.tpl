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

<div class="sesforum_sidebar_tags sesbasic_bxs sesbasic_clearfix">
  <ul>
  	<?php $counter = 0; ?>
    <?php foreach($this->tagCloudData as $valueTags):?>
    	<?php if($valueTags['text'] == '' && empty($valueTags['text'])):?>
        <?php continue;?>
      <?php endif;?>
      <li>
      	<a href="<?php echo $this->url(array(), 'sesforum_search', true).'?tag_id='.$valueTags['tag_id'].'&tag_name='.$valueTags['text']  ;?>">
        	<span class="_label"><?php echo $valueTags['text'] ?></span>
          <span class="_count"><?php echo $valueTags['itemCount'];?></span>
      	</a>
      </li>
    <?php $counter++; endforeach;?>
  </ul>
  <div class="clear sesforum_sidebar_tags_all sesbasic_clearfix">
    <a href="<?php echo $this->url(array(), 'sesforum_tags', true) ?>" class="sesbasic_more_link clear"><?php echo $this->translate("See All Tags »"); ?></a>
  </div>
</div>
