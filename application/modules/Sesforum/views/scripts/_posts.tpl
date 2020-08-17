<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _posts.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
if( !isset($signature) ) $signature = $post->getSignature();
        $topic = $post->getParent();
        $sesforum = $topic->getParent();
      ?>
      <li class="sesforum_profile_post_item">
      	<article>
        	<div class="sesforum_profile_post_header">
          	<div class="_left">
                <span class="_title sesbasic_text_light"><?php echo $this->translate('in the topic %1$s', $topic->__toString()) ?></span>
                <span class="sesbasic_text_light sesbasic_font_small"><?php echo $this->locale()->toDateTime(strtotime($post->creation_date));?></span>
            </div>
            <div class="_right sesbasic_text_light">
                <span title="<?php echo $this->translate(array('%s like', '%s likes', $post->like_count), $this->locale()->toNumber($post->like_count)); ?>"><i class="sesbasic_icon_like_o"></i> <?php echo $post->like_count ?></span>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.thanks', 1)) { ?>
                <?php $thanks = Engine_Api::_()->getDbTable('thanks', 'sesforum')->getAllUserThanks($post->user_id); ?>
                <span title="<?php echo $this->translate(array('%s thank(s)', '%s thank(s)', $thanks), $this->locale()->toNumber($thanks)); ?>"><i class="sesforum_icon_thanks"></i> <?php echo $thanks; ?></span>
              <?php } ?>
            </div>
          </div>
          <div class="sesforum_profile_post_item_body">
            <?php if( $this->decode_bbcode ) {
               if(strlen(nl2br($this->BBCode($post->body))) > $this->description_truncation_limit):
                  $title = mb_substr(nl2br($this->BBCode($post->body)),0,$this->description_truncation_limit).'...';
                      echo $title;
                   else: 
                      echo $this->BBCode($post->body);
                  endif;
              
            } else { 
              if(strlen($post->getDescription()) > $this->description_truncation_limit):
                  $title = mb_substr($post->getDescription(),0,$this->description_truncation_limit).'...';
                      echo $title;
                   else: 
                      echo $post->getDescription();
                  endif;
            } ?>
            <?php if( $post->edit_id ): ?>
            	<p><i><?php echo $this->translate('This post was edited by %1$s at %2$s', $this->user($post->edit_id)->__toString(), $this->locale()->toDateTime(strtotime($post->creation_date))); ?></i></p>
            <?php endif;?>
          </div>
          <?php if($post->file_id ): ?>
            <div class="sesforum_profile_post_item_photos">
              <?php echo $this->itemPhoto($post, null, '', array('class'=>'sesforum_post_photo'));?>
            </div>
          <?php endif;?>
        </article>
      </li>
