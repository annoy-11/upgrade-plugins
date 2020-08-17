<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my-posts.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if($this->paginator->getTotalItemCount() > 0) { ?>
<div class="sesforum_profile_posts">
  <ul id="sesforum_topic_posts">
    <?php foreach( $this->paginator as $post ):
      if( !isset($signature) ) $signature = $post->getSignature();
      $topic = $post->getParent();
      $sesforum = $topic->getParent();
      ?>
      <li class="sesforum_profile_post_item">
      	<div class="sesforum_profile_post_header sesbasic_font_small sesbasic_text_light">
        	<span><?php echo $this->locale()->toDateTime(strtotime($post->creation_date));?></span>
          <span><?php echo $this->translate('in the topic %1$s', $topic->__toString()) ?></span>
          <!--<span><?php echo $this->translate('in the sesforum %1$s', $sesforum->__toString()) ?></span>-->
          <span>
          	<span title="<?php echo $this->translate(array('%s like', '%s likes', $post->like_count), $this->locale()->toNumber($post->like_count)); ?>"><i class="sesbasic_icon_like_o"></i> <?php echo $post->like_count ?></span>
          	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.thanks', 1)) { ?>
          	<?php $thanks = Engine_Api::_()->getDbTable('thanks', 'sesforum')->getAllUserThanks($post->user_id); ?>
            <span title="<?php echo $this->translate(array('%s thank(s)', '%s thank(s)', $thanks), $this->locale()->toNumber($thanks)); ?>"><i class="sesforum_icon_thanks"></i> <?php echo $thanks; ?></span>
            <?php } ?>
          </span>
        </div> 
        <div class="sesforum_profile_post_item_body">
          <?php if( $this->decode_bbcode ) {
            echo nl2br($this->BBCode($post->body));
          } else {
            echo $post->getDescription();
          } ?>
          <?php if( $post->edit_id ): ?>
            <i>
              <?php echo $this->translate('This post was edited by %1$s at %2$s', $this->user($post->edit_id)->__toString(), $this->locale()->toDateTime(strtotime($post->creation_date))); ?>
            </i>
          <?php endif;?>
        </div>
        <?php if( $post->file_id ): ?>
          <div class="sesforum_profile_post_item_photos">
            <?php echo $this->itemPhoto($post, null, '', array('class'=>'sesforum_post_photo'));?>
          </div>
        <?php endif;?>
      </li>
    <?php endforeach;?>
  </ul>
</div>
<?php } else { ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('There are no posts.') ?>
    </span>
  </div>
<?php } ?>
