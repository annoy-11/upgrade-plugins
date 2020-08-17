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

<ul class="sesforum_popular_members sesbasic_bxs">
  <?php foreach ($this->members as $member): ?>
    <?php if(in_array($this->criteria, array('thanksCount', 'reputationCount'))) { ?>
      <?php $user = Engine_Api::_()->getItem('user', $member->resource_id); ?>
    <?php } else { ?>
      <?php $user = Engine_Api::_()->getItem('user', $member->user_id); ?>
    <?php } ?>
    <li class="sesbasic_clearfix">
    	<div class="sesforum_user_thumb">
      	<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'), array('class' => 'thumb')) ?>
			</div>	
      <div class="sesforum_user_info">
        <div class="sesforum_user_name">
        	<?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
        </div>
        <div class="sesforum_user_stats sesbasic_font_small sesbasic_text_light">
          <?php if ($this->criteria == 'topicCount'): ?>
            <span><i class="sesforum_icon_topic"></i><?php echo $this->translate("%s topics", $member->totalResult); ?> </span> 
          <?php elseif ($this->criteria == 'postCount'): ?>
            <span><i class="sesforum_icon_post"></i><?php echo $this->translate("%s posts", $member->totalResult); ?></span>
          <?php elseif ($this->criteria == 'reputationCount'): ?>
            <span><i class="sesforum_icon_reputation"></i><?php echo $this->translate("%s reputations", $member->totalResult); ?></span>
          <?php elseif ($this->criteria == 'thanksCount'): ?>
            <span><i class="sesforum_icon_thanks"></i><?php echo $this->translate("%s thanks", $member->totalResult); ?></span>
          <?php endif; ?>
      </div>
    </li>
  <?php endforeach; ?>
</ul>
