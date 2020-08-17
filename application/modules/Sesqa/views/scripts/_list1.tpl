<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _list1.tpl  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php if(!$this->is_ajax){ ?>
  <div class="sesqa_list_view_container clear sesbasic_bxs">
	<ul class="sesbasic_clearfix" id="sesqa-tabbed-widget-<?php echo $this->widgetIdentity; ?>">
<?php } ?>
  	<?php if(count($this->paginator)){ ?>
  		<?php foreach($this->paginator as $question){ ?>
        <li class="sesqa_list1_item sesbasic_clearfix" style="<?php if($this->width){ ?>width:<?php echo $this->width.'px;'; ?> <?php } ?>">
        	<article>
            <ul class="_statsbox">
              <?php $votecount = $question->upvote_count - $question->downvote_count; ?>
              <?php if(in_array('vote',$this->showOptions)){ ?>
              	<li><span class="_count"><?php echo $votecount; ?></span><span class="_txt"><?php echo $votecount == 1 ? $this->translate('Vote') : $this->translate('Votes'); ?></span></li>
              <?php } ?>
              <?php if(in_array('answerCount',$this->showOptions)){ ?>
              	<li><span class="_count <?php if($question->best_answer){ ?>sesqa_list_best<?php } ?>"><?php echo $question->answer_count; ?></span><span class="_txt"><?php echo $question->answer_count == 1 ? $this->translate('Answer') : $this->translate('Answers'); ?></span></li>
              <?php } ?>
              <?php if(in_array('view',$this->showOptions)){ ?>
              	<li><span class="_count"><?php echo $question->view_count; ?></span><span class="_txt"><?php echo $question->view_count == 1 ? $this->translate('View') : $this->translate('Views'); ?></span></li>
              <?php } ?>
            </ul>
            <div class="sesqa_list1_item_content">
            	<div class="_header sesbasic_clearfix">
              	<div class="_right">
                  <ul class="sesqa_labels">
                    <?php if(in_array('newLabel',$this->showOptions)){ 
                      if(empty($enableNewSetting)){
												 
                       $newSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_new_label', 5);
                       $enableNewSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_newLabel', 1);
                      }
                      if($newSetting && $enableNewSetting && strtotime(date("Y-m-d H:i:s")) <= strtotime($question->creation_date." + ".$newSetting." Days")){
                    ?>
                      <li><span title="<?php echo $this->translate('New Question'); ?>" class="sesqa_new_label"><i class="fa fa-star"></i></span></li>
                      <?php } ?>
                    <?php  } ?>
                    <?php if(in_array('hotLabel',$this->showOptions) && $question->hot){ ?>
                      <li><span title="<?php echo $this->translate('Hot Question'); ?>" class="sesqa_featured_label"><i class="fa fa-star"></i></span></li>
                    <?php } ?>
                    <?php if(in_array('sponsoredLabel',$this->showOptions) && $question->sponsored){ ?>
                      <li><span title="<?php echo $this->translate('Sponsored Question'); ?>" class="sesqa_hot_label"><i class="fa fa-star"></i></span></li>
                    <?php } ?>
                    <?php if(in_array('verifiedLabel',$this->showOptions) && $question->verified){ ?>
                      <li><span title="<?php echo $this->translate('Verified Question'); ?>" class="sesqa_verified_label"><i class="fa fa-star"></i></span></li>
                    <?php } ?>
                    <?php if(in_array('featuredLabel',$this->showOptions) && $question->featured){ ?>
                      <li><span title="<?php echo $this->translate('Featured Question'); ?>" class="sesqa_sponsored_label"><i class="fa fa-star"></i></span></li>
                    <?php } ?>
                  </ul>
									<?php $pollOptions = count($question->getOptions()); ?>
                    <?php if($pollOptions || $question->best_answer){ ?>
                      <?php if($pollOptions){ ?>
                      <a href="<?php echo $question->getHref(); ?>" class="sesqa_poll_label"><i class="fa fa-signal"></i><?php echo $this->translate('SESPoll'); ?></a>
                  	<?php } ?>
                  <?php } ?>
                </div>
              	<div class="_title"><a href="<?php echo $question->getHref(); ?>"><?php echo $this->string()->truncate($question->getTitle(),$this->titleTruncateLimit); ?></a></div>
              </div>
              <ul class="_info sesbasic_clearfix">
                <?php if(in_array('owner',$this->showOptions)){ ?>
                  <li>
                  	<i class="fa fa-user sesbasic_text_light"></i><span class="sesbasic_text_light"><a href="<?php echo $question->getOwner()->getHref(); ?>" title='<?php echo $this->translate("Created By"); ?>'><?php echo $question->getOwner()->getTitle(); ?></a></span></li>
                <?php } ?>
                <?php if(in_array('category',$this->showOptions) && $question->category_id){ 
                    $category_id = $question->category_id;
                    $category = Engine_Api::_()->getItem('sesqa_category',$question->category_id);
                    if($category){
                  ?>
                  	<li><a href="<?php echo $category->getHref(); ?>" title='<?php echo $this->translate("SESCategory"); ?>'><i class="fa fa-folder-open-o sesbasic_text_light"></i><span><?php echo $category->category_name; ?></span></a></li>
                  <?php } ?>
                <?php } ?>
                <?php if(in_array('date',$this->showOptions)){ ?>
                  <li><i class="fa fa-calendar sesbasic_text_light"></i><span class="sesbasic_text_light"><?php echo Engine_Api::_()->sesqa()->questionAsked($question,array(),true); ?></span></li>
                <?php } ?>
                <li class="_stats sesbasic_text_light">
                 <?php if(in_array('comment',$this->showOptions)){ ?>    
                    <span title="<?php echo $this->translate(array('%s comment', '%s comments', $question->comment_count), $this->locale()->toNumber($question->comment_count)); ?>"><i class="fa fa-comments"></i><span><?php echo $question->comment_count ?></span></span>
                  <?php } ?>
                  <?php if(in_array('like',$this->showOptions)){ ?>
                    <span title="<?php echo $this->translate(array('%s like', '%s likes', $question->like_count), $this->locale()->toNumber($question->like_count)); ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $question->like_count ?></span></span>
                   <?php } ?>
                   <?php if(in_array('follow',$this->showOptions)){ ?>
                      <span title="<?php echo $this->translate(array('%s follow', '%s follows', $question->follow_count), $this->locale()->toNumber($question->follow_count)); ?>"><i class="fa fa-check"></i><span><?php echo $question->follow_count ?></span></span>
                   <?php } ?>
                   <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.allow.favourite', 1) && in_array('favourite',$this->showOptions)){ ?>
                    <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $question->favourite_count), $this->locale()->toNumber($question->favourite_count)); ?>"><i class="fa fa-heart"></i><span><?php echo $question->favourite_count ?></span></span>
                   <?php } ?>
                </li>
                <?php if(in_array('location',$this->showOptions) && $question->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.enable.location', 1)){ ?>
                  <li>
                    <i class="fa fa-map-marker sesbasic_text_light"></i><span class="sesbasic_text_light"><?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $question->getIdentity(),'resource_type'=>'sesqa_question','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="opensmoothboxurl" title="<?php echo $this->translate("SESLocation"); ?>"><?php echo $question->location; ?></a><?php } else { ?><?php echo $question->location; ?><?php } ?></span> 
                	</li>
                <?php } ?>
              </ul>
              <div class="_footer">
                <?php if(in_array('tags',$this->showOptions)){ ?>
                  <div class="_tags">
                    <?php 
                      $tags = $question->tags()->getTagMaps();
                      foreach($tags as $tagMap){ 
                        $tag = $tagMap->getTag();
                          if (!isset($tag->text))
                            continue;
                        ?>
                      <a class="sesqa_tag" href="<?php echo $this->url(array('action'=>'browse'),'sesqa_general',true).'?tag_id='.$tag->getIdentity(); ?>"><?php echo $tag->text; ?></a>
                    <?php } ?>
                  </div>
                <?php } ?>
                <div class="sesqa_social_btns">
                  <?php if($this->viewer()->getIdentity()){ ?>
                  	<?php if(in_array('likeBtn',$this->showOptions)){ ?>
                  		<?php $LikeStatus = Engine_Api::_()->sesqa()->getLikeStatusQuestion($question->getIdentity(),$question->getType()); ?>
                  		<div><a href="javascript:;" data-url="<?php echo $question->getIdentity() ; ?>"  class="sesbasic_icon_btn sesqa_like_question <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>" title='<?php echo $this->translate("Like")?>'><i class="fa fa-thumbs-up"></i></a></div>
                  	<?php } ?>
                  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.allow.favourite', 1) && in_array('favBtn',$this->showOptions)){ ?>
                  	<?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesqa')->isFavourite(array('resource_type'=>$question->getType(),'resource_id'=>$question->getIdentity())); ?>
                  		<div><a href="javascript:;"   data-url="<?php echo $question->getIdentity() ; ?>" class="sesbasic_icon_btn sesqa_favourite_question <?php echo ($favStatus)  ? 'button_active' : '' ?>" title='<?php echo $this->translate("Favourite")?>'><i class="fa fa-heart"></i></a></div>
                  <?php } ?>
                  <?php if(in_array('followBtn',$this->showOptions)){ ?>
                    <?php
                      $FollowUser = Engine_Api::_()->sesqa()->getFollowStatus($question->getIdentity());
                      $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;
                      $followText = ($FollowUser) ?  $this->translate('Unfollow') : $this->translate('Follow') ;
                    ?>
                  		<div><a href="javascript:;"  data-url="<?php echo $question->getIdentity(); ?>" class="sesbasic_icon_btn sesqa_follow_question sesqa_follow_question_<?php echo $question->getIdentity(); ?> <?php echo $FollowUser ? 'button_active' : ''; ?>"><i class="fa <?php echo $followClass; ?>" title='<?php echo $this->translate(!$FollowUser ? "Follow" : "Unfollow")?>'></i></a></div>
                  	<?php } ?>   
                  <?php } ?>
                  <?php if(in_array('share',$this->showOptions) &&  Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_allow_sharing', 1)){ ?>
										<div class="_socialmore sesqa_social_share_wrap">
                      <a href="javascript:void(0);" class="sesbasic_icon_btn sesqa_share_button_toggle" title='<?php echo $this->translate("Share")?>'><i class="fa fa-share-alt"></i></a>
                      <div class="sesqa_social_share_options sesbasic_bg">
                        <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $question->getHref()); ?>
                        <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $question, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                  		</div>
                    </div>  
                  <?php } ?>
            		</div>
            	</div>
            </div>
            <!-- toggle options -->
            <?php if(!empty($this->widgetName) && $this->widgetName == "manage-tabbed-widget"){ ?>
              <?php 
                $canEdit = $question->authorization()->isAllowed($this->viewer(), 'edit');
                $canDelete = $question->authorization()->isAllowed($this->viewer(), 'delete');
                if($canEdit || $canDelete){
              ?>
                <!-- toggle options -->
                <div class="sesqa_toggle_option">
                  <a href="javascript:;" class="sesbasic_pulldown_toggle"><i class="sesbasic_text_light fa fa-ellipsis-h"></i></a>
                  <div class="sesbasic_pulldown_options">
                    <ul class="_isicon">
                     <?php if($canEdit){ ?>
                     <li><a href="<?php echo $this->url(array('action' => 'edit','question_id' => $question->getIdentity()),'sesqa_general'); ?>"><i class="fa fa-pencil"></i><?php echo $this->translate("SESEdit"); ?></a></li>
                    <?php } ?>
                    <?php if($canDelete){ ?>
                     <li><a href="<?php echo $this->url(array('action' => 'delete','question_id' => $question->getIdentity()),'sesqa_general'); ?>" class="smoothbox"><i class="fa fa-trash"></i><?php echo $this->translate("SESDelete"); ?></a></li>
                    <?php } ?>
                    </ul>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          </article>
        </li>
  		<?php } ?>
      <?php if($this->loadOptionData == 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')){ ?>
        <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesqa"),array('identityWidget'=>$randonNumber)); ?>
      <?php } ?>
  	<?php }else{ ?>
    	<li class="sesqa_noquestion_tip_wrapper norecord<?php echo $this->widgetIdentity; ?>" id="norecord<?php echo $this->widgetIdentity; ?>">
      	<div class="sesqa_noquestion_tip clearfix">
    			<img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_notip_image', 'application/modules/Sesqa/externals/images/notip.png'); ?>" alt="" />
          <span class="sesbasic_text_light">
            <?php if($this->widgetName == "manage-tabbed-widget"){ ?>
              <?php echo $this->translate("No result found with the given search criteria."); ?>
            <?php }else if($this->widgetName == "profile-widget"){ ?> 
              <?php echo $this->translate("No question created by this member yet."); ?>
            <?php }else{ ?>
              <?php echo $this->translate('Nobody has created an question yet.') ?>
              <?php if( $this->canCreate ): ?>
                <?php echo $this->translate('Be the first to %1$screate%2$s one!', '<a href="'.$this->url(array('action'=>'create'), 'sesqa_general').'">', '</a>'); ?>
              <?php endif; ?>
            <?php } ?>
          </span>
  			</div>
    	</li>
  	<?php } ?>
<?php if(!$this->is_ajax){ ?> 
		</ul>
	</div>
<?php } ?>
