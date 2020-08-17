<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
$viewer = Engine_Api::_()->user()->getViewer();
$viewer_id = $viewer->getIdentity();
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupforum/externals/styles/styles.css'); ?>

<script type="text/javascript">
  en4.core.runonce.add(function() {
    var pre_rate = <?php echo $this->topic->rating;?>;
    var rated = '<?php echo $this->rated;?>';
    var topic_id = <?php echo $this->topic->topic_id;?>;
    var total_votes = <?php echo $this->rating_count;?>;
    var viewer = <?php echo $this->viewer_id;?>;
    new_text = '';

    var rating_over = window.rating_over = function(rating) {
      if( rated == 1 ) {
        $('rating_text').innerHTML = "<?php echo $this->translate('you already rated');?>";
        //set_rating();
      } else if( viewer == 0 ) {
        $('rating_text').innerHTML = "<?php echo $this->translate('please login to rate');?>";
      } else {
        $('rating_text').innerHTML = "<?php echo $this->translate('click to rate');?>";
        for(var x=1; x<=5; x++) {
          if(x <= rating) {
            $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big');
          } else {
            $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
          }
        }
      }
    }
    
    var rating_out = window.rating_out = function() {
      if (new_text != ''){
        $('rating_text').innerHTML = new_text;
      }
      else{
        $('rating_text').innerHTML = " <?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";        
      }
      if (pre_rate != 0){
        set_rating();
      }
      else {
        for(var x=1; x<=5; x++) {
          $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
        }
      }
    }

    var set_rating = window.set_rating = function() {
      var rating = pre_rate;
      if (new_text != ''){
        $('rating_text').innerHTML = new_text;
      }
      else{
        $('rating_text').innerHTML = "<?php echo $this->translate(array('%s rating', '%s ratings', $this->rating_count),$this->locale()->toNumber($this->rating_count)) ?>";
      }
      for(var x=1; x<=parseInt(rating); x++) {
        $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big');
      }

      for(var x=parseInt(rating)+1; x<=5; x++) {
        $('rate_'+x).set('class', 'rating_star_big_generic rating_star_big_disabled');
      }

      var remainder = Math.round(rating)-rating;
      if (remainder <= 0.5 && remainder !=0){
        var last = parseInt(rating)+1;
        $('rate_'+last).set('class', 'rating_star_big_generic rating_star_big_half');
      }
    }

    var rate = window.rate = function(rating) {
      $('rating_text').innerHTML = "<?php echo $this->translate('Thanks for rating!');?>";
      for(var x=1; x<=5; x++) {
        $('rate_'+x).set('onclick', '');
      }
      (new Request.JSON({
        'format': 'json',
        'url' : '<?php echo $this->url(array('module' => 'sesgroupforum', 'controller' => 'index', 'action' => 'rate'), 'default', true) ?>',
        'data' : {
          'format' : 'json',
          'rating' : rating,
          'topic_id': topic_id
        },
        'onRequest' : function(){
          rated = 1;
          total_votes = total_votes+1;
          pre_rate = (pre_rate+rating)/total_votes;
          set_rating();
        },
        'onSuccess' : function(responseJSON, responseText)
        {
          $('rating_text').innerHTML = responseJSON[0].total+" ratings";
          new_text = responseJSON[0].total+" ratings";
        }
      })).send();

    }

    var tagAction = window.tagAction = function(tag){
      $('tag').value = tag;
      $('filter_form').submit();
    }
    
    set_rating();
  });
</script>

<div class="sesgroupforum_topic_view sesbasic_bxs<?php if( $this->topic->closed ): ?> sesgroupforum_topic_closed<?php endif; ?>">
  <div class="sesgroupforum_topic_view_header sesbasic_clearfix">
    <div class="sesgroupforum_topic_title">
      <h3><?php echo $this->topic->getTitle() ?></h3>
    </div>
    <div class="sesgroupforum_topic_header_options">
      <?php if(isset($this->backToTopicButton)): ?>
        <?php echo $this->htmlLink($this->sesgroup->getHref(), $this->translate('Back To Group'), array(
            'class' => 'icon_back sesbasic_button'
        )) ?>
       <?php endif; ?>
      <?php if( $this->canPost && isset($this->postReply)): ?>
        <?php echo $this->htmlLink($this->topic->getHref(array('action' => 'post-create')), $this->translate('Post Reply'), array(
          'class' => 'sesgroupforum_icon_post_reply sesbasic_button'
        )) ?>
      <?php endif; ?>
      <?php if( $this->viewer->getIdentity() && $this->settings->getSetting('sesgroupforum.subscribe', 1)): ?>
            <?php if(!$this->isWatching ): ?>
            <?php echo $this->htmlLink($this->url(array('action' => 'watch', 'watch' => '1')), $this->translate('Subscribe'), array(
                'class' => 'sesgroupforum_icon_topic_watch sesbasic_button'
            )) ?>
            <?php else: ?>
            <?php echo $this->htmlLink($this->url(array('action' => 'watch', 'watch' => '0')), $this->translate('Unsubscribe'), array('class' => 'sesgroupforum_icon_topic_unwatch sesbasic_button')); ?>
            <?php endif; ?>
        <?php if(0) { ?>
        <?php $isSubscribe = Engine_Api::_()->getDbTable('subscribes', 'sesgroupforum')->isSubscribe(array('resource_id' => $this->topic->getIdentity())); ?>
            <a class="active sesbasic_icon_subscribe sesbasic_button" id="<?php echo $this->topic->getType(); ?>_unsubscribe_<?php echo $this->topic->getIdentity(); ?>" style ='display:<?php echo $isSubscribe ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "sesgroupforumSubscribe('<?php echo $this->topic->getIdentity(); ?>', '<?php echo $this->topic->getType(); ?>');"><?php echo $this->translate("Unsubscribe") ?></a>
            
            <a class="sesbasic_icon_subscribe sesbasic_button"" id="<?php echo $this->topic->getType(); ?>_subscribe_<?php echo $this->topic->getIdentity(); ?>" style ='display:<?php echo $isSubscribe ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "sesgroupforumSubscribe('<?php echo $this->topic->getIdentity(); ?>', '<?php echo $this->topic->getType(); ?>');"><?php echo $this->translate("Subscribe") ?></a>
            <input type="hidden" id="<?php echo $this->topic->getType(); ?>_subscribehidden_<?php echo $this->topic->getIdentity(); ?>" value='<?php echo $isSubscribe ? $isSubscribe : 0; ?>' />
        <?php } ?>
      <?php endif; ?>
    </div>
  </div>
  <div class="sesgroupforum_topic_options sesbasic_clearfix">
    <div class="sesgroupforum_topic_options_top sesbasic_clearfix">
      <div class="sesgroupforum_topic_options_left sesbasic_text_light">
        <?php if($viewer_id && $this->settings->getSetting('sesgroupforum.rating', 1) && isset($this->ratings)) { ?>      
          <div id="video_rating" class="rating" onmouseout="rating_out();">
            <span id="rate_1" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?>onclick="rate(1);"<?php endif; ?> onmouseover="rating_over(1);"></span>
            <span id="rate_2" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?>onclick="rate(2);"<?php endif; ?> onmouseover="rating_over(2);"></span>
            <span id="rate_3" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?>onclick="rate(3);"<?php endif; ?> onmouseover="rating_over(3);"></span>
            <span id="rate_4" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?>onclick="rate(4);"<?php endif; ?> onmouseover="rating_over(4);"></span>
            <span id="rate_5" class="rating_star_big_generic" <?php if (!$this->rated && $this->viewer_id):?>onclick="rate(5);"<?php endif; ?> onmouseover="rating_over(5);"></span>
            <span id="rating_text" class="rating_text"><?php echo $this->translate('click to rate');?></span>
          </div>
        <?php } ?>
        <?php if(isset($this->likeCount)) { ?>     
            <div class="sesbasic_text_light">
                <span><i class="sesbasic_icon_like_o"></i><?php echo $this->translate(array('%s like', '%s likes', $this->topic->like_count), $this->locale()->toNumber($this->topic->like_count)); ?></span>
            </div>  
       <?php } ?>
        <?php if(isset($this->replyCount)) { ?>     
            <div class="sesbasic_text_light">
                <span><?php echo $this->translate(array('%1$s %2$s reply', '%1$s %2$s replies', $this->topic->post_count-1), $this->locale()->toNumber($this->topic->post_count-1), '</span><span class="_label sesbasic_text_light">') ?></span>
            </div>  
       <?php } ?>
      </div>
      <div class="sesgroupforum_topic_options_right">
        <?php if($viewer_id && isset($this->likeButton)) { ?>
          <!--Like Button-->
          <?php 
          $canLike = 1;
          $isLike = Engine_Api::_()->getDbTable('likes', 'core')->isLike($this->topic, $viewer); ?>
          <?php if ($canLike && !empty($viewer_id)): ?>
            <div>
              <a class="active sesbasic_icon_like sesbasic_button" id="<?php echo $this->topic->getType(); ?>_unlike_<?php echo $this->topic->getIdentity(); ?>" style ='display:<?php echo $isLike ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "sesgroupforumLike('<?php echo $this->topic->getIdentity(); ?>', '<?php echo $this->topic->getType(); ?>');"><?php echo $this->translate("Unlike") ?></a>
              <a class="sesbasic_icon_like sesbasic_button"" id="<?php echo $this->topic->getType(); ?>_like_<?php echo $this->topic->getIdentity(); ?>" style ='display:<?php echo $isLike ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "sesgroupforumLike('<?php echo $this->topic->getIdentity(); ?>', '<?php echo $this->topic->getType(); ?>');"><?php echo $this->translate("Like") ?></a>
            <input type="hidden" id="<?php echo $this->topic->getType(); ?>_likehidden_<?php echo $this->topic->getIdentity(); ?>" value='<?php echo $isLike ? $isLike : 0; ?>' />
            </div>
          <?php endif; ?>
       
        <?php } ?>
        <?php if(isset($this->shareButton) && $viewer_id) { ?>   
           <div>
                <?php echo $this->htmlLink(array('module'=> 'activity', 'controller' => 'index', 'action' => 'share', 'route' => 'default', 'type' => $this->topic->getType(), 'id' => $this->topic->getIdentity(), 'format' => 'smoothbox'), $this->translate("Share"), array('class' => 'sesbasic_button smoothbox sesbasic_icon_share',)); ?>
          </div>
        <?php } ?>
        <?php if((($this->canEdit || $this->canDelete) && $this->topic->user_id == $this->viewer()->getIdentity()) || (($this->canEdit == 2) || ($this->canDelete == 2))): ?>
          <div class="sesbasic_pulldown_wrapper">
            <a href="javasrcipt:void(0);" class="sesbasic_pulldown_toggle sesbasic_button fa fa-ellipsis-h"></a>
            <div class="sesbasic_pulldown_options">
              <ul class="_isicon">
                <?php if(($this->canEdit && $this->topic->user_id == $this->viewer()->getIdentity()) || $this->canEdit == 2): ?>
                  <?php if( !$this->topic->sticky ): ?>
                    <li><?php echo $this->htmlLink(array('action' => 'sticky', 'sticky' => '1', 'reset' => false), $this->translate('Make Sticky'), array('class' => 'sesgroupforum_icon_post_stick')) ?></li>
                  <?php else: ?>
                    <li><?php echo $this->htmlLink(array('action' => 'sticky', 'sticky' => '0', 'reset' => false), $this->translate('Remove Sticky'), array('class' => 'sesgroupforum_icon_post_unstick')) ?></li>
                  <?php endif; ?>
                  <?php if( !$this->topic->closed ): ?>
                    <li><?php echo $this->htmlLink(array('action' => 'close', 'close' => '1', 'reset' => false), $this->translate('Close'), array('class' => 'sesgroupforum_icon_post_close')) ?></li>
                  <?php else: ?>
                    <li><?php echo $this->htmlLink(array('action' => 'close', 'close' => '0', 'reset' => false), $this->translate('Open'), array('class' => 'sesgroupforum_icon_post_unclose')) ?></li>
                  <?php endif; ?>
                    <li><?php echo $this->htmlLink(array('action' => 'rename', 'reset' => false), $this->translate('Rename'), array('class' => 'smoothbox sesgroupforum_icon_post_rename')) ?></li>
                    <!--<li><?php //echo $this->htmlLink(array('action' => 'move', 'reset' => false), $this->translate('Move'), array('class' => 'smoothbox sesgroupforum_icon_post_move')) ?></li>-->
                <?php endif; ?>
                <?php if( ($this->canDelete && $this->topic->user_id == $this->viewer()->getIdentity()) || $this->canDelete == 2 ): ?>
                  <li><?php echo $this->htmlLink(array('action' => 'delete', 'reset' => false), $this->translate('Delete'), array('class' => 'smoothbox sesbasic_icon_delete')) ?></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        <?php endif; ?>  
      </div> 
      <?php $valueTags = Engine_Api::_()->sesgroupforum()->tagCloudItemCore('fetchAll',null,$this->topic->getIdentity()); ?>
      <?php if($this->tags && count($valueTags) >0): ?>
      <div class="sesgroupforum_topic_view_tags sesbasic_tags">   
        <?php foreach($valueTags as $valueTag): ?>
          <a href="javascript:void(0);"><?php echo $valueTag['text'] ?></a>
          <!--<a href="<?php //echo $this->url(array('module' => 'sesgroupforum', 'controller' => 'index', 'action' => 'search'), 'default', true).'?tag_id='.$valueTag['tag_id'].'&tag_name='.$valueTag['text']  ;?>" ><?php //echo $valueTag['text'] ?></a>-->
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div> 
<!--    <div class="">
      <a href="" class="tag">test</a>
      <a href="" class="tag">topic</a>
      <a href="" class="tag">forum</a>
    </div> -->
  </div>
  <?php if( $this->topic->closed ): ?>
    <div class="sesgroupforum_topic_close_msg">
      <i class="fa fa-lock"></i>
      <span><?php echo $this->translate('This topic has been closed.');?></span>
    </div>
  <?php endif; ?>
<!--  <div class="sesgroupforum_topic_pages">
    <?php //echo $this->paginationControl($this->paginator, null, null, array(
     /* 'params' => array(
        'post_id' => null,
      ),
    ));*/ ?>
  </div>-->
  <script type="text/javascript">
    en4.core.runonce.add(function() {
      $$('.sesgroupforum_topic_posts_info_body').enableLinks();
  
      // Scroll to the selected post
      var post_id = <?php echo sprintf('%d', $this->post_id) ?>;
      if( post_id > 0 ) {
        window.scrollTo(0, $('sesgroupforum_post_' + post_id).getPosition().y);
      }
    });
  </script>
  
  <ul class="sesgroupforum_topic_view_posts">
    <?php foreach( $this->paginator as $i => $post ): ?>
      <?php $user = $this->user($post->user_id); ?>
      <?php $signature = $post->getSignature(); ?>
      <li id="sesgroupforum_post_<?php echo $post->post_id ?>" class="sesgroupforum_topic_view_post_item sesgroupforum_nth_<?php echo $i % 2 ?>">
        <div class="sesgroupforum_topic_view_post_author_photo">
          <?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon')) ?>
          
          <div class="sesgroupforum_topic_view_post_author_stats sesbasic_text_light">
            <?php if($this->settings->getSetting('sesgroupforum.thanks', 1) && isset($this->thanksCount)) { ?>
              <?php $thanks = Engine_Api::_()->getDbTable('thanks', 'sesgroupforum')->getAllUserThanks($post->user_id); ?>
              <?php if($thanks) { ?>
                <span title='<?php echo $this->translate("Thanks")?>'><i class="sesgroupforum_icon_thanks"></i><span><?php echo $this->translate(array('%s thanks', '%s thanks', $thanks), $this->locale()->toNumber($thanks)); ?></span></span>
              <?php } ?>
            <?php } ?>
            <?php if($this->settings->getSetting('sesgroupforum.reputation', 1) && isset($this->reputationCount)) { ?>
              <?php $getIncreaseReputation = Engine_Api::_()->getDbTable('reputations', 'sesgroupforum')->getIncreaseReputation(array('user_id'=>$post->user_id)); ?>
              <?php $getDecreaseReputation = Engine_Api::_()->getDbTable('reputations', 'sesgroupforum')->getDecreaseReputation(array('user_id'=>$post->user_id)); ?>
              <span title='<?php echo $this->translate("Reputation")?>'><i class="sesgroupforum_icon_reputation"></i><span><?php echo $getIncreaseReputation; ?>&nbsp;-&nbsp;<?php echo $getDecreaseReputation; ?></span></span>
            <?php } ?>
            <?php if($signature && isset($this->postsCount)): ?>
              <span><i class="sesgroupforum_icon_post"></i><span><?php echo $signature->post_count; ?> <?php echo $this->translate('posts');?></span></span>
            <?php endif; ?>
          </div>
        </div>
        <div class="sesgroupforum_topic_view_post_info">
          <div class="sesgroupforum_topic_view_post_header sesbasic_clearfix sesbasic_text_light">
            <span class="sesgroupforum_author_name">
              <?php echo $user->__toString(); ?>
            </span>
            <span class="sesgroupforum_post_date sesbasic_text_light">
              <a href="<?php echo $post->getHref() ?>"><i class="sesgroupforum_icon_post"></i></a>
              <?php echo $this->locale()->toDateTime(strtotime($post->creation_date)) ?>
            </span>
            <?php if(isset($this->likeCount)) { ?>
              <span class="floatR _like"><i class="sesbasic_icon_like_o"></i><span><?php echo $this->translate(array('%s like', '%s likes', $post->like_count), $this->locale()->toNumber($post->like_count)); ?></span></span>
            <?php } ?>
          </div>
          <div class="sesgroupforum_topic_view_post_body sesbasic_html_block">
            <?php
              $body = $post->body; 
              $doNl2br = false;
              if( strip_tags($body) == $body ) {
                $body = nl2br($body);
              }
              if( !$this->decode_html && $this->decode_bbcode ) {
                $body = $this->BBCode($body, array('link_no_preparse' => true));
              }
              echo $body;
            ?>
            <?php if( $post->edit_id && !empty($post->modified_date) ):?>
              <div class="sesgroupforum_topic_view_post_msg sesbasic_lbg">
                <?php echo $this->translate('This post was edited by %1$s at %2$s', $this->user($post->edit_id)->__toString(), $this->locale()->toDateTime(strtotime($post->modified_date))); ?>
              </div>
            <?php endif;?>
          </div>
          <?php if ($post->file_id):?>
            <div class="sesgroupforum_topic_view_post_photos">
              <?php echo $this->itemPhoto($post, null, '', array('class'=>'sesgroupforum_post_photo'));?>
            </div>
          <?php endif;?>
          <?php if(isset($this->signature)): ?>
          	<div class="sesgroupforum_topic_view_post_signature">
              <?php
                $body = $signature->body; 
                $doNl2br = false;
                    if( strip_tags($body) == $body ) {
                        $body = nl2br($body);
                    }
                    if( !$this->decode_html && $this->decode_bbcode ) {
                        $body = $this->BBCode($body, array('link_no_preparse' => true));
                    }
                echo $body;
              ?>
          	</div>
          <?php endif;?>
          <div class="sesgroupforum_topic_view_post_footer sesbasic_clearfix">
            <?php if( $this->canPost && isset($this->quote) && !$this->topic->closed): ?>
              <div><?php echo $this->htmlLink(array('route' => 'sesgroupforum_topic', 'action' => 'post-create', 'topic_id'=>$this->subject()->getIdentity(), 'quote_id'=>$post->getIdentity()), $this->translate('Quote'), array('class' => 'sesgroupforum_icon_post_quote')) ?></div>
            <?php endif;?>
            <?php if($viewer_id) { ?>
            <?php if(isset($this->shareButton)) { ?>
              <div><?php echo $this->htmlLink(array('module'=> 'activity','controller' => 'index','action' => 'share', 'route' => 'default', 'type' => $post->getType(), 'id' => $post->getIdentity(), 'format' => 'smoothbox'), $this->translate("Share"), array('class' => 'smoothbox sesbasic_icon_share')); ?></div>
            <?php } ?>
            <?php $isReputation = Engine_Api::_()->getDbTable('reputations', 'sesgroupforum')->isReputation(array('post_id' => $post->getIdentity(), 'resource_id' => $post->user_id)); ?>
            <?php if($this->settings->getSetting('sesgroupforum.reputation', 1) && empty($isReputation) && $viewer_id != $post->user_id) { ?>
              <div><?php echo $this->htmlLink(array('module'=> 'sesgroupforum','controller' => 'index', 'action' => 'add-reputation', 'route' => 'default','resource_id' => $post->user_id,'resource_type' =>$post->getType(),'post_id' => $post->getIdentity(),'format' => 'smoothbox'),$this->translate("Add Reputation"), array('class' => 'smoothbox sesgroupforum_icon_reputation')); ?></div>
            <?php } ?>
            <?php } ?>
            <!--Like Button-->
            <?php  
            if(isset($this->likeButton)) {
              $canLike = 1;
              $isLike = Engine_Api::_()->getDbTable('likes', 'core')->isLike($post, $viewer); ?>
              <?php if ($canLike && !empty($viewer_id)): ?>
                  <div>
                  <a class="sesbasic_icon_like active" id="<?php echo $post->getType(); ?>_unlike_<?php echo $post->getIdentity(); ?>" style ='display:<?php echo $isLike ? "inline-block" : "none" ?>' href = "javascript:void(0);" onclick = "sesgroupforumLike('<?php echo $post->getIdentity(); ?>', '<?php echo $post->getType(); ?>');"><?php echo $this->translate("Unlike") ?></a>
                  <a class="sesbasic_icon_like" id="<?php echo $post->getType(); ?>_like_<?php echo $post->getIdentity(); ?>" style ='display:<?php echo $isLike ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "sesgroupforumLike('<?php echo $post->getIdentity(); ?>', '<?php echo $post->getType(); ?>');"><?php echo $this->translate("Like") ?></a>
                  <input type="hidden" id="<?php echo $post->getType(); ?>_likehidden_<?php echo $post->getIdentity(); ?>" value='<?php echo $isLike ? $isLike : 0; ?>' />
                  </div>
              <?php endif; ?>
            <?php } ?>
            <!--Thanks Button-->
            <?php if($this->settings->getSetting('sesgroupforum.thanks', 1)) { ?>
             <?php
            $isThank = Engine_Api::_()->getDbTable('thanks', 'sesgroupforum')->isThank(array('post_id' => $post->post_id,'resource_id' => $post->user_id)); ?>
            <?php if (empty($isThank) && !empty($viewer_id) && $viewer_id != $post->user_id): ?>
            <div>
              <a class="sesgroupforum_icon_thanks" id="<?php echo $post->getType(); ?>_thank_<?php echo $post->post_id; ?>" style ='display:<?php echo $isThank ? "none" : "inline-block" ?>' href = "javascript:void(0);" onclick = "sesTopicThank('<?php echo $post->post_id; ?>', '<?php echo $post->getType(); ?>', '<?php echo $post->user_id; ?>');"><?php echo $this->translate("Say Thanks") ?></a>
              <input type="hidden" id="<?php echo $post->getType(); ?>_thankhidden_<?php echo $post->post_id; ?>" value='<?php echo $isThank ? $isThank : 0; ?>' />
              </div>
            <?php endif; ?>
            <!--Thanks Button-->
            <?php } ?>
            
            <?php if(($this->canDelete_Post || $this->canEdit_Post || ($post->user_id != $this->viewer()->getIdentity() || $viewer_id)) && $viewer_id) { ?>
            <div class="sesbasic_pulldown_wrapper">
              <a href="javasrcipt:void(0);" class="sesbasic_pulldown_toggle fa fa-ellipsis-h"></a>
              <div class="sesbasic_pulldown_options">
                <ul class="_isicon">
                  <?php if($this->viewer()->getIdentity() && $post->user_id != $this->viewer()->getIdentity()): ?>
                    <li><?php echo $this->htmlLink(array('route' => 'default', 'module' => 'core', 'controller' => 'report', 'action' => 'create', 'subject' => $post->getGuid(), 'format' => 'smoothbox'), $this->translate('Report'), array('class' => 'sesbasic_icon_report smoothbox')) ?></li>
                  <?php endif; ?>
                  <?php if(!$post->isOwner($this->viewer)): ?>
                   <?php if($this->canEdit_Post == 2): ?>
                      <li><a href="<?php echo $this->url(array('post_id'=>$post->getIdentity(), 'action'=>'edit'), 'sesgroupforum_post'); ?>" class="sesbasic_icon_edit"><?php echo $this->translate('Edit');?></a></li>
                   <?php endif; ?>
                    <?php if($this->canDelete_Post == 2): ?>
                      <li><a href="<?php echo $this->url(array('post_id'=>$post->getIdentity(), 'action'=>'delete'), 'sesgroupforum_post');?>" class="smoothbox sesbasic_icon_delete"><?php echo $this->translate('Delete');?></a></li>
                   <?php endif; ?>
                  <?php elseif( $post->user_id != 0 && $post->isOwner($this->viewer)): ?>
                    <?php if($this->canEdit_Post ):   ?>
                      <li><a href="<?php echo $this->url(array('post_id'=>$post->getIdentity(), 'action'=>'edit'), 'sesgroupforum_post'); ?>" class="sesbasic_icon_edit"><?php echo $this->translate('Edit');?></a></li>
                    <?php endif; ?>
                    <?php if( $this->canDelete_Post ): ?>
                      <li><a href="<?php echo $this->url(array('post_id'=>$post->getIdentity(), 'action'=>'delete'), 'sesgroupforum_post');?>" class="smoothbox sesbasic_icon_delete"><?php echo $this->translate('Delete');?></a></li>
                    <?php endif; ?>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>  
      </li>
    <?php endforeach;?>
  </ul>
  <div class="sesgroupforum_topic_pages">
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      'params' => array(
        'post_id' => null,
      ),
    )); ?>
  </div>
  <?php if(($this->canPost) && $this->form && !$this->topic->closed): ?>
    <div class="sesgroupforum_topic_view_reply">
      <div class="sesgroupforum_topic_view_reply_author_photo sesbasic_clearfix">
        <?php echo $this->htmlLink($viewer->getHref(), $this->itemPhoto($viewer, 'thumb.icon')) ?>
      </div>
      <div class="sesgroupforum_topic_view_reply_form_box">
        <?php echo $this->form->setAttrib('class', 'sesgroupforum_topic_view_reply_form')->render($this) ?>
      </div>
    </div>
  <?php endif; ?>
</div>



<script type="text/javascript">
  $$('.core_main_sesgroupforum').getParent().addClass('active');
</script>
