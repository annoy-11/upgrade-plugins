<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescontest
 * @package    Sescontest
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _pinboardView.tpl  2017-12-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(empty($widgetName)):?>
  <?php if(strlen($entry->getTitle()) > $this->params['pinboard_title_truncation']):?>
    <?php $title = mb_substr($entry->getTitle(),0,$this->params['pinboard_title_truncation']).'...';?>
  <?php else: ?>
    <?php $title = $entry->getTitle();?>
  <?php endif; ?>
  <?php $descriptionLimit =   $this->params['pinboard_description_truncation'];?>
<?php endif;?>
<?php if(!$this->viewer()->getIdentity()):?><?php $levelId = 5;?><?php else:?><?php $levelId = $this->viewer()->level_id;?><?php endif;?>
<?php $voteType = Engine_Api::_()->authorization()->getPermission($levelId, 'participant', 'allow_entry_vote');?>
<?php if ($voteType != 0 && (($voteType == 1 && $entry->owner_id != $this->viewer()->getIdentity()) || $voteType == 2)):?>
  <?php $canIntegrate = Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.vote.integrate', 0);?>
<?php else:?>
  <?php $canIntegrate = 0;?>
<?php endif;?>
<li class="sesbasic_pinboard_item sescontest_winners_pinboard_item sesbasic_bxs" style="width:<?php echo $width ?>px;">
  <div class="sescontest_winners_pinboard_item_inner">
		<header class="sesbasic_clearfix">
        <?php if(isset($this->mediaTypeActive)):?>
		  <span class="sesbasic_animation sescontest_list_type"><a href="<?php echo $this->url(array('action' => $action),'sescontest_media',true);?>"><i class="<?php echo $imageClass;?>" title="<?php echo $contestType;?>"></i></a></span>
        <?php endif;?>
    	<?php if(isset($this->titleActive)):?>
      	<p class="_title"><?php echo $this->htmlLink($entry->getHref(), $title);?></p>
      <?php endif;?>
        <div class="_owner sesbasic_clearfix">
          <?php if(isset($this->ownerPhotoActive)):?>
            <div class="_img">
              <?php if($owner->photo_id):?>
                <a href="<?php echo $owner->getHref();?>"><img src="<?php echo Engine_Api::_()->storage()->get($owner->photo_id)->getPhotoUrl('thumb.icon'); ?>" alt=""></a>
              <?php else:?>
                <a href="<?php echo $owner->getHref();?>"><img src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" alt=""></a>
              <?php endif;?>
            </div>
          <?php endif;?>
          <div class="_cont">
          	<?php if(isset($this->ownerNameActive) || isset($this->contestNameActive)):?>
              <p class="_meta sesbasic_text_light">
                <?php if(isset($this->ownerNameActive)):?><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?><?php endif;?><?php if($this->contestNameActive):?>&nbsp;<?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $contest->gethref();?>"><?php echo $contest->getTitle();?></a><?php endif;?>
              </p>
            <?php endif;?>
            <p class="_stats">
            	<?php if(isset($this->submitDateActive)):?><span title="<?php echo $this->translate('Submitted on ');?><?php echo date('d-m-Y',strtotime($entry->creation_date));?>"><i class="fa fa-calendar"></i><span><?php echo date('d-m-Y',strtotime($entry->creation_date));?></span>&nbsp;&nbsp;|</span><?php endif;?>
            
              <?php if(isset($this->voteCountActive) && (!$contest->resulttime || strtotime($contest->resulttime) <= time())):?>
                <span title="<?php echo $this->translate(array('%s Vote', '%s Votes', $entry->vote_count), $this->locale()->toNumber($entry->vote_count)) ?>">
                  <i class="fa fa-hand-o-up"></i>
                  <span><?php echo $entry->vote_count;?></span>
                </span>
              <?php endif;?>
              <?php if(isset($this->likeActive)):?>
                <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $entry->like_count), $this->locale()->toNumber($entry->like_count)) ?>">
                  <i class="fa fa-thumbs-up"></i>
                  <span><?php echo $entry->like_count;?></span>
                </span>
              <?php endif;?>
              <?php if(isset($this->commentActive)):?>
                <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $entry->comment_count), $this->locale()->toNumber($entry->comment_count)) ?>">
                  <i class="fa fa-comment"></i>
                  <span><?php echo $entry->comment_count;?></span>
                </span>
              <?php endif;?>
              <?php if(isset($this->viewActive)):?>
                <span title="<?php echo $this->translate(array('%s View', '%s Views', $entry->view_count), $this->locale()->toNumber($entry->view_count)) ?>">
                  <i class="fa fa-eye"></i>
                  <span><?php echo $entry->view_count;?></span>
                </span>
              <?php endif;?>
              <?php if(isset($this->favouriteActive)):?>
                <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $entry->favourite_count), $this->locale()->toNumber($entry->favourite_count)) ?>">
                  <i class="fa fa-heart"></i>
                  <span><?php echo $entry->favourite_count;?></span>
                </span>
              <?php endif;?>
            </p>
        	</div>
      	</div>
      </header>    
    <div class="_thumb sesbasic_clearfix">
  		<div class="_img"><a href="<?php echo $entry->getHref();?>"><img src="<?php echo $entry->getPhotoUrl('thumb.main');?>" alt="<?php echo $title;?>" /></a></div>
      
      <div class="sescontest_list_btns">
        <?php if(isset($this->socialSharingActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.entry.allow.share', 1)):?>
          <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $entry, 'socialshare_enable_plusicon' => $this->params['socialshare_enable_plusicon'], 'socialshare_icon_limit' => $this->params['socialshare_icon_limit'])); ?>
        <?php endif;?>
        <?php if(isset($this->likeButtonActive) && $canComment):?>
          <a href="javascript:;" data-type="like_entry_view" data-integrate = "<?php echo $canIntegrate;?>" data-url="<?php echo $entry->participant_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sescontest_entry_like_<?php echo $entry->participant_id ?> sescontest_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $entry->like_count;?></span></a>
        <?php endif;?>
        <?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sescontest.entry.allow.favourite', 1) && $this->viewer()->getIdentity()):?>
          <a href="javascript:;" data-type="favourite_entry_view" data-url="<?php echo $entry->participant_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sescontest_entry_favourite_<?php echo $entry->participant_id ?> sescontest_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $entry->favourite_count;?></span></a>  
        <?php endif;?>
      </div>
      <span class="_overlay"></span>
      <a href="<?php echo $entry->getHref();?>" class="_link"></a>
      
      <div class="sescontest_winners_item_award">
        <?php if(!empty($entry->rank) && isset($this->rankActive)):?>
          <?php $number = Engine_Api::_()->sescontest()->ordinal($entry->rank);?>
          <span class="_awardicon"><span><?php echo $number;?></span><span>Award</span></span>
        <?php endif;?>
        <!--<?php if(isset($this->mediaTypeActive)):?>
        <span class="_contestname"><a href="<?php echo $this->url(array('action' => $action),'sescontest_media',true);?>"><?php echo $contestType;?></a></span>
        <?php endif;?>-->
      </div>
      
      <?php if(isset($this->pinboarddescriptionActive)):?>
        <div class="_des sesbasic_animation">
          <?php echo $this->string()->truncate($this->string()->stripTags($entry->description), $descriptionLimit) ?>
        </div>
      <?php endif;?>
      <?php if(isset($this->voteButtonActive)):?>
        <div class="_votebtn">
          <?php include APPLICATION_PATH .  '/application/modules/Sescontest/views/scripts/_voteData.tpl';?>
        </div>
      <?php endif;?>
    </div>    
  </div>
</li>