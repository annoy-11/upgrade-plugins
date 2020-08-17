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
    <?php foreach( $this->paginator as $post ):
      $user = $post->getOwner();
      $topic = $post->getParent();
      $sesforum = $topic->getParent();
      ?>
      <li class="sesforum_sidebar_list_item">
        <?php if(in_array('by', $this->stats) || in_array('photo', $this->stats) || in_array('creationdate', $this->stats)) { ?>
          <div class="sesforum_sidebar_list_item_header">
            <?php if(in_array('photo', $this->stats)) { ?>
              <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon')) ?>
            <?php } ?>
            <div class="sesforum_sidebar_list_item_header_cont">
              <?php if(in_array('by', $this->stats)) { ?>
                <div class="_name"><?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?></div>
              <?php } ?>
              <?php if(in_array('creationdate', $this->stats)) { ?>
                <div class="_date sesbasic_font_small sesbasic_text_light"><?php echo $this->timestamp($post->creation_date) ?></div>
              <?php } ?>
            </div>
        	</div>
       	<?php } ?>
        <?php if(in_array('topicName', $this->stats) || in_array('forumName', $this->stats)) { ?>
          <div class="sesforum_sidebar_list_stats sesbasic_font_small sesbasic_text_light">
            <?php if(in_array('topicName', $this->stats) || in_array('forumName', $this->stats)) { ?>
              <?php if(in_array('topicName', $this->stats)) { ?>
                <?php echo $this->translate('in') ?>
                <?php echo $this->htmlLink($topic->getHref(), $this->translate($topic->getTitle())) ?>
              <?php } ?>
              <?php if(in_array('forumName', $this->stats)) { ?>
                - <?php echo $this->translate('in') ?>
                <?php echo $this->htmlLink($sesforum->getHref(), $this->translate($sesforum->getTitle())) ?>
              <?php } ?>
            <?php } ?>
          </div>
        <?php } ?>
        <div class='sesforum_sidebar_list_title'>
          <?php $text = strip_tags($post->getDescription());
          $text =  ( Engine_String::strlen($text) > $this->descLimit ? Engine_String::substr($text, 0, $this->descLimit) . '...' : $text); ?>
          <a href="<?php echo $post->getHref(); ?>"><?php echo $text; ?></a>
        </div>
        <?php if(in_array('creationdate', $this->stats) || in_array('likeCount', $this->stats)) { ?>
          <div class="sesforum_sidebar_list_stats sesbasic_font_small sesbasic_text_light">
            <?php if(in_array('likeCount', $this->stats)) { ?>
              <span title="<?php echo $this->translate(array('%s like', '%s likes', $post->like_count), $this->locale()->toNumber($post->like_count)); ?>">
                <i class="sesbasic_icon_like_o"></i>
                <?php echo $this->translate(array('%s like', '%s likes', $post->like_count), $this->locale()->toNumber($post->like_count)); ?>
              </span>
            <?php } ?>
          </div>
        <?php } ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
