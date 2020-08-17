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
<div class="sesbasic_bxs sesforum_statistics_container">
  <?php if($this->viewtype == 'vertical') {  ?>
  	<ul class="sesforum_statistics_sidebar">
   <?php  } else { ?> 
   	<ul class="sesforum_statistics">
   <?php } ?>
    <?php if(in_array('forumCount', $this->stats) && empty($this->forum_id)) { ?>
      <li>
      	<article>
          <i class="sesforum_icon_forum sesbasic_text_light"></i>
          <span class="_label"><?php echo $this->translate('Forum'); ?></span>
          <span class="_count"><?php echo $this->results->forumCount; ?></span>
      	</article>
      </li>
    <?php } ?>
    <?php if(in_array('topicCount', $this->stats)) { ?>
      <li>
				<article>
          <i class="sesforum_icon_topic sesbasic_text_light"></i>
          <span class="_label"><?php echo $this->translate('Topic'); ?></span>
          <span class="_count"><?php echo $this->results->topicCount; ?></span>
				</article>
      </li>
    <?php } ?>
    <?php if(in_array('postCount', $this->stats)) { ?>
      <li>
      	<article>
          <i class="sesforum_icon_post sesbasic_text_light"></i>
          <span class="_label"><?php echo $this->translate('Post'); ?></span>
          <span class="_count"><?php echo $this->results->postCount; ?></span>
      	</article>    
      </li>
    <?php } ?>
    <?php if(in_array('totaluserCount', $this->stats)) { ?>
      <li>
      	<article>
          <i class="sesforum_icon_users sesbasic_text_light"></i>
          <span class="_label"><?php echo $this->translate('Total Users'); ?></span>
          <span class="_count"><?php echo $this->totalusers; ?></span>
      	</article>
      </li>
    <?php } ?>
    <?php if(in_array('activeusercount', $this->stats)) { ?>
      <li>
      	<article>
          <i class="sesforum_icon_active_users sesbasic_text_light"></i>
          <span class="_label"><?php echo $this->translate('Total Active Users'); ?></span>
          <span class="_count"><?php echo $this->activeUsers ? $this->activeUsers : 0; ?></span>
				</article>
      </li>
    <?php } ?>
  </ul>
</div>
