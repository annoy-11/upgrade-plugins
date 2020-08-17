<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _sideWidget.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesqa/externals/styles/styles.css'); ?>
<ul class="sesqa_sidebar_listing sesbasic_bxs sesbasic_clearfix">
  <?php foreach($this->results as $result){ 
    if(!$result instanceof Sesqa_Model_Question)
      $result = Engine_Api::_()->getItem('sesqa_question',$result->question_id);   
    $owner = $result->getOwner();         
  ?>
  <?php $pollOptions = count($result->getOptions()); ?>
    <li class="sesqa_sidebar_list_item">
    	<div class="sesbasic_clearfix">
        <?php if(in_array('itemPhoto',$this->show_criterias)){ ?>
          <div class="_photo">
            <a href="<?php echo $result->getHref(); ?>"><img src="<?php echo $result->getPhotoUrl(); ?>" alt="" /></a>
          </div>
        <?php } ?>
        <?php if(in_array('title',$this->show_criterias)){ ?>
          <div class="_title">
            <a href="<?php echo $result->getHref(); ?>"><?php echo $this->string()->truncate($result->getTitle(),$this->params['title_truncation']); ?></a>
          </div>
        <?php } ?>
      </div>
      <ul class="sesqa_labels">
      	<?php if(in_array('newLabel',$this->show_criterias)){ 
          if(empty($enableNewSetting)){
           $newSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_new_label', 5);
           $enableNewSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_newLabel', 1);
          }
          if($newSetting && $enableNewSetting && strtotime(date("Y-m-d H:i:s")) <= strtotime($result->creation_date." + ".$newSetting." Days")){
         ?>
          	<li><span title="<?php echo $this->translate('New Question'); ?>" class="sesqa_new_label"><i class="fa fa-star"></i></span></li>
        	<?php } ?>
        <?php } ?>
        <?php if(in_array('hotLabel',$this->show_criterias) && $result->hot){ ?>
        	<li><span title="<?php echo $this->translate('Hot Question'); ?>" class="sesqa_featured_label"><i class="fa fa-star"></i></span></li>
        <?php } ?>
        <?php if(in_array('sponsoredLabel',$this->show_criterias) && $result->sponsored){ ?>
          <li><span title="<?php echo $this->translate('Sponsored Question'); ?>" class="sesqa_hot_label"><i class="fa fa-star"></i></span></li>
        <?php } ?>
        <?php if(in_array('verifiedLabel',$this->show_criterias) && $result->verified){ ?>
          <li><span title="<?php echo $this->translate('Verified Question'); ?>" class="sesqa_verified_label"><i class="fa fa-star"></i></span></li>
        <?php } ?>
        <?php if(in_array('featuredLabel',$this->show_criterias) && $result->featured){ ?>
          <li><span title="<?php echo $this->translate('Featured Question'); ?>" class="sesqa_sponsored_label"><i class="fa fa-star"></i></span></li>
        <?php } ?>
      </ul>
      <?php if($pollOptions){ ?>
      	<p><a href="<?php echo $result->getHref(); ?>" class="sesqa_poll_label" title='<?php echo $this->translate("Poll Type Question"); ?>'><i class="fa fa-signal"></i> <?php echo $this->translate("Poll"); ?></a></p>
      <?php } ?>
      <p class="sesbasic_text_light">
      	<?php if(in_array('owner',$this->show_criterias)){ ?>
          <?php echo $this->translate("asked by "); ?>
          <a href="<?php echo $owner->getHref(); ?>"><?php echo $owner->getTitle(); ?></a> 
        <?php } ?>
       	<?php if(in_array('category',$this->show_criterias)){ ?>
          <?php if($result->category_id){ 
            $category = Engine_Api::_()->getItem('sesqa_category',$result->category_id);
          ?>
          <?php if($category) ?>
            <?php echo $this->translate("SESin"); ?> <a href="<?php echo $category->getHref(); ?>"><?php echo $category->category_name;  ?></a>
          <?php  } ?>
        <?php } ?>
        <?php if(in_array('location',$this->show_criterias) && $result->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.enable.location', 1)){ ?>
          <?php echo $this->translate("near"); ?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
            <a href="<?php echo $this->url(array('resource_id' => $result->getIdentity(),'resource_type'=>'sesqa_question','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="opensmoothboxurl"><?php echo $result->location; ?></a>
          <?php } else { ?>
            <?php echo $result->location; ?>
          <?php } ?>
        <?php } ?>
        <?php if(in_array('date',$this->show_criterias)){ ?>
        on <a href="<?php echo $result->getHref(); ?>"><?php echo date('d M,Y',strtotime($result->creation_date)); ?></a>
        <?php } ?>
      </p>
      <?php if(in_array('tags',$this->show_criterias)){ ?>
        <p class="_tags">
        	<?php 
          $tags = $result->tags()->getTagMaps();
          foreach($tags as $tagMap){ 
            $tag = $tagMap->getTag();
              if (!isset($tag->text))
                continue;
        	?>
        	<a class="sesqa_tag" href="<?php echo $this->url(array('action'=>'browse'),'sesqa_general',true).'?tag_id='.$tag->getIdentity(); ?>"><?php echo $tag->text; ?></a>
     		<?php } ?>
      </p>
     	<?php } ?>
     	<div class="_stats sesbasic_text_light">
        <?php if(in_array('like',$this->show_criterias)){ ?>
          <span title="<?php echo $this->translate(array('%s like', '%s likes', $result->like_count), $this->locale()->toNumber($result->like_count)); ?>"><i class="fa fa-thumbs-up"></i><?php echo $result->like_count ?></span>
        <?php } ?>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.allow.favourite', 1) && in_array('favourite',$this->show_criterias)){ ?>
          <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $result->favourite_count), $this->locale()->toNumber($result->favourite_count)); ?>"><i class="fa fa-heart"></i><?php echo $result->favourite_count ?></span>
        <?php } ?>
        <?php if(in_array('follow',$this->show_criterias)){ ?>
          <span title="<?php echo $this->translate(array('%s follow', '%s followers', $result->follow_count), $this->locale()->toNumber($result->follow_count)); ?>"><i class="fa fa-check"></i><?php echo $result->follow_count ?></span>
       	<?php }?>
        <?php if(in_array('view',$this->show_criterias)){ ?>
        	<span title="<?php echo $this->translate(array('%s view', '%s views', $result->view_count), $this->locale()->toNumber($result->view_count)); ?>"><i class="fa fa-eye"></i><?php echo $result->view_count ?></span>
       	<?php } ?>
        <?php if(in_array('vote',$this->show_criterias)){ ?>
        	<span title="<?php echo $this->translate(array('%s vote', '%s votes',Engine_Api::_()->sesqa()->voteCount($result)), $this->locale()->toNumber(Engine_Api::_()->sesqa()->voteCount($result))); ?>"><i class="fa fa-hand-o-up"></i><?php echo Engine_Api::_()->sesqa()->voteCount($result) ?></span>
        <?php } ?>
        <?php if(in_array('comment',$this->show_criterias)){ ?>
        	<span title="<?php echo $this->translate(array('%s comment', '%s comments', $result->comment_count), $this->locale()->toNumber($result->comment_count)); ?>"><i class="fa fa-comments"></i><?php echo $result->comment_count ?></span>
        <?php } ?>
      </div>
      <?php if(($this->viewer()->getIdentity() && (in_array('followBtn',$this->show_criterias) || in_array('likeBtn',$this->show_criterias) || in_array('favBtn',$this->show_criterias))) || in_array('share',$this->show_criterias) &&  Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_allow_sharing', 1)){ ?>
      <div class="_footer sesqa_social_btns">
        <?php if($this->viewer()->getIdentity()){ ?>
        <?php if(in_array('likeBtn',$this->show_criterias)){ ?>
          <?php $LikeStatus = Engine_Api::_()->sesqa()->getLikeStatusQuestion($result->getIdentity(),$result->getType()); ?>
            <div><a href="javascript:;" data-url="<?php echo $result->getIdentity() ; ?>" class="sesbasic_icon_btn sesqa_like_question <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>" title='<?php echo $this->translate("Like")?>'><i class="fa fa-thumbs-up"></i></a></div>
          <?php } ?>
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.allow.favourite', 1) && in_array('favBtn',$this->show_criterias)){ ?>
            <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesqa')->isFavourite(array('resource_type'=>$result->getType(),'resource_id'=>$result->getIdentity())); ?>
            <div><a href="javascript:;"   data-url="<?php echo $result->getIdentity() ; ?>" class="sesbasic_icon_btn sesqa_favourite_question <?php echo ($favStatus)  ? 'button_active' : '' ?>" title='<?php echo $this->translate("Favourite")?>'><i class="fa fa-heart"></i></a></div>
          <?php } ?>
          <?php if(in_array('followBtn',$this->show_criterias)){ ?>
            <?php
              $FollowUser = Engine_Api::_()->sesqa()->getFollowStatus($result->getIdentity());
              $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
              $followText = ($FollowUser) ?  $this->translate('Unfollow') : $this->translate('Follow') ;
            ?>
             <div><a href="javacript:;"  data-url="<?php echo $result->getIdentity(); ?>" class="sesbasic_icon_btn sesqa_follow_question sesqa_follow_question_<?php echo $result->getIdentity(); ?> <?php echo $FollowUser ? 'button_active' : ''; ?>" title='<?php echo $this->translate(!$FollowUser ? "Follow" : "Unfollow")?>'><i class="fa <?php echo $followClass; ?>"></i></a></div>
          <?php } ?> 
        <?php } ?>
        <?php if(in_array('share',$this->show_criterias) &&  Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_allow_sharing', 1)){ ?>
					<div class="_socialmore sesqa_social_share_wrap">
          	<a href="javascript:void(0);" class="sesbasic_icon_btn sesqa_share_button_toggle" title='<?php echo $this->translate("Share")?>'><i class="fa fa-share-alt"></i></a>	
        		<div class="sesqa_social_share_options sesbasic_bg">
            <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $result->getHref()); ?>              
            <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $result, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
        		</div>
          </div>
        <?php } ?>
   		</div>
      <?php } ?>  
      <?php if(in_array('answer',$this->show_criterias)){ ?>  
        <?php $answer = $result->getLatestAnswer(1); ?>
        <?php if($answer){ ?>
          <div class="_answer sesbasic_clearfix">
            <div class="_answerphoto">
              <a href="<?php echo $answer->getOwner()->getHref(); ?>"><img src="<?php echo $answer->getOwner()->getPhotoUrl(); ?>" alt="" /></a>
            </div>
            <div class="_answerinfo">
              <div class="_answername"><a href="<?php echo $answer->getOwner()->getHref(); ?>"><?php echo $answer->getOwner()->getTitle(); ?></a></div>
              <div class="_answerdate sesbasic_text_light"><?php echo $this->translate("Answered %s ago",date('d M. Y',strtotime($answer->creation_date))); ?></div>
            </div>
            <div class="_answerdes">
							<?php echo $this->string()->truncate($this->string()->stripTags($answer->getDescription()), $this->params['answertitle_truncation']); ?>
          	</div>
          </div>  
        <?php } ?>
      <?php } ?>
    </li>
  <?php } ?>
</ul>
