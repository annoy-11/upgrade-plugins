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
<div class="sesforum_sidebar_list sesbasic_bxs">
  <ul>
    <?php foreach( $this->paginator as $topic ):
      $user = $topic->getOwner('user');
      $sesforum = $topic->getParent();
      ?>
      <li class="sesforum_sidebar_list_item">
      	<?php if(in_array('by', $this->stats) || in_array('photo', $this->stats)) { ?>
          <div class="sesforum_sidebar_list_item_header">
            <?php if(in_array('photo', $this->stats)) { ?>
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon'), array('class' => 'thumb')) ?>
            <?php  } ?>
            <div class="sesforum_sidebar_list_item_header_cont">
              <?php if(in_array('by', $this->stats)) { ?>
                <div class="_name sesbasic_font_small"><?php echo $this->htmlLink($user->getHref(), $this->translate($user->getTitle())) ?></div>
              <?php } ?>
              <?php if(in_array('creationdate', $this->stats)) { ?>
                <div class="_date sesbasic_font_small sesbasic_text_light"><?php echo $this->timestamp($topic->creation_date) ?></div>
              <?php } ?>
            </div>
          </div>  
        <?php } ?>
        <?php if(in_array('topicName', $this->stats)) { ?>
          <div class='sesforum_sidebar_list_title'>
            <?php echo $this->htmlLink($topic->getHref(), $topic->getTitle()) ?>
          </div>
        <?php } ?>
        <?php if(in_array('forumName', $this->stats)) { ?>
        	<div class="sesforum_sidebar_list_stats sesbasic_font_small sesbasic_text_light">  
          	<?php echo $this->translate('In') ?>
            <?php echo $this->htmlLink($sesforum->getHref(), $this->translate($sesforum->getTitle())) ?>
          </div>
        <?php } ?>
        <?php if(in_array('likeCount', $this->stats) || in_array('postCount', $this->stats) || in_array('viewCount', $this->stats) || in_array('rating', $this->stats)) { ?>
          <div class="sesforum_sidebar_list_stats sesbasic_font_small sesbasic_text_light">
            <span>
              <?php if(in_array('likeCount', $this->stats)) { ?>
              	<span title="<?php echo $this->translate(array('%s like', '%s likes', $topic->like_count), $this->locale()->toNumber($topic->like_count)); ?>">
                	<i class="sesbasic_icon_like_o"></i>
                	<?php echo $topic->like_count ? $topic->like_count : 0; ?>
              	</span>
              <?php } ?>
              <?php if(in_array('postCount', $this->stats)) { ?>
              	<span title="<?php echo $this->translate(array('%s post', '%s posts', $topic->post_count), $this->locale()->toNumber($topic->post_count)); ?>">
                	<i class="sesforum_icon_post"></i>
                	<?php echo $topic->post_count ? $topic->post_count : 0; ?>
              	</span>
              <?php } ?>
              <?php if(in_array('viewCount', $this->stats)) { ?>
              	<span title="<?php echo $this->translate(array('%s view', '%s views', $topic->view_count), $this->locale()->toNumber($topic->view_count)); ?>">
                	<i class="sesbasic_icon_view"></i>
                	<?php echo $topic->view_count ? $topic->view_count : 0; ?>
              	</span>
              <?php } ?>
              <?php if(in_array('rating', $this->stats)) { ?>
              	<span title="<?php echo $this->translate(array('%s rating', '%s ratings', floor($topic->rating)), $this->locale()->toNumber(floor($topic->rating))); ?>">
                  <i class="sesbasic_icon_rating"></i>
                  <?php echo $topic->rating ? floor($topic->rating) : 0; ?>
              	</span>
              <?php } ?>
            </span>
          </div>
        <?php } ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
