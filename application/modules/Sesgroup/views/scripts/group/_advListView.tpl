<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advListView.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $title = '';?>
<?php if(isset($this->params['advlist_limit_member'])):?>
    <?php $limitMember = $this->params['advlist_limit_member'];?>
  <?php else:?>
    <?php $limitMember = $this->params['limit_member'];?>
  <?php endif;?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['advlist_title_truncation'])):?>
    <?php $titleLimit = $this->params['advlist_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($group->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($group->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $group->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->advlistdescriptionActive)):?>
  <?php $descriptionLimit = $this->params['advlist_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
  <?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $group->getOwner();?>
<li class="sesgroup_list_item" id="sesgroup_manage_listing_item_<?php echo $group->getIdentity(); ?>">
  <article class="sesbasic_clearfix">
    <div class="_thumb sesgroup_thumb" style="height:<?php echo is_numeric($height) ? $height.'px' : $height?>;width:<?php echo is_numeric($width) ? $width.'px' : $width ?>;">
      <a href="<?php echo $group->getHref();?>" class="sesgroup_thumb_img sesgroup_browse_location_<?php echo $group->getIdentity(); ?>">
      	<span style="background-image:url(<?php echo $group->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="sesgroup_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
					<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataButtons.tpl';?>
        </div>
      <?php endif;?>
  	</div>
    <div class="_cont">
      <?php if(!empty($title)):?>
        <div class="_title">
          <a href="<?php echo $group->getHref();?>" class='sesgroup_browse_location_<?php echo $group->getIdentity(); ?>'><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $group->verified):?><i class="sesgroup_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
        </div>
      <?php endif;?>
      <div class="_continner">
        <div class="_continnerleft">
          <div class="_owner sesbasic_text_light">
            <?php if(SESGROUPSHOWUSERDETAIL == 1):?>
              <?php if(isset($this->ownerPhotoActive)):?>
                <span class="_owner_img">
                  <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                </span>
              <?php endif;?>
              <?php if(isset($this->byActive)):?>
                <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
              <?php endif;?>
            <?php endif;?>
            <?php if(isset($this->creationDateActive)):?>
               -&nbsp<?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_date.tpl';?>
            <?php endif;?>
          </div>
          <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || isset($this->followActive) || isset($this->memberActive)):?>
            <div class="_stats sesbasic_text_light">
              <i class="fa fa-bar-chart"></i>
              <span>
                <?php if(isset($this->likeActive)):?>
                  <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $group->like_count), $this->locale()->toNumber($group->like_count)) ?>"><?php echo $this->translate(array('%s Like', '%s Likes', $group->like_count), $this->locale()->toNumber($group->like_count)) ?></span><?php endif;?>
                <?php if(isset($this->commentActive)):?>
                  <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $group->comment_count), $this->locale()->toNumber($group->comment_count)) ?>"><?php echo $this->translate(array('%s Comment', '%s Comments', $group->comment_count), $this->locale()->toNumber($group->comment_count)) ?></span>
                <?php endif;?>
                <?php if(isset($this->viewActive)):?>
                  <span title="<?php echo $this->translate(array('%s View', '%s Views', $group->view_count), $this->locale()->toNumber($group->view_count)) ?>"><?php echo $this->translate(array('%s View', '%s Views', $group->view_count), $this->locale()->toNumber($group->view_count)) ?></span><?php endif;?>
                <?php if(isset($this->favouriteActive)):?>
                  <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $group->favourite_count), $this->locale()->toNumber($group->favourite_count)) ?>"><?php echo $this->translate(array('%s Favourite', '%s Favourites', $group->favourite_count), $this->locale()->toNumber($group->favourite_count)) ?></span><?php endif;?>
                <?php if(isset($this->followActive) && isset($group->follow_count)):?>
                  <span title="<?php echo $this->translate(array('%s Follower', '%s Followers', $group->follow_count), $this->locale()->toNumber($group->follow_count)) ?>"><?php echo $this->translate(array('%s Follower', '%s Followers', $group->follow_count), $this->locale()->toNumber($group->follow_count)) ?></span><?php endif;?>
                <?php if(isset($this->memberActive) && isset($group->member_count)):?>
                  <span title="<?php echo $this->translate(array('%s Member', '%s Members', $group->member_count), $this->locale()->toNumber($group->member_count)) ?>"><?php echo $this->translate(array('%s Member', '%s Members', $group->member_count), $this->locale()->toNumber($group->member_count)) ?></span><?php endif;?>
              </span>
            </div>
          <?php endif;?>
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_groupMemberStatics.tpl';?>
          <?php if(isset($this->locationActive) && $group->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup_enable_location', 1)):?>
            <div class="_stats sesbasic_text_light">
              <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i> 	 
              <span title="<?php echo $group->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesgroup.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $group->group_id,'resource_type'=>'sesgroup_group','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $group->location;?></a><?php else:?><?php echo $group->location;?><?php endif;?></span>
            </div>  
          <?php endif;?>
          <div class="sesbasic_clearfix _middleinfo">
            <?php if(isset($category) && isset($this->categoryActive)):?>
              <div><i class="fa fa-folder-open sesbasic_text_light"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
            <?php endif;?>
            <!--<?php if(isset($this->priceActive) && $group->price):?>
              <div class="sesgroup_ht"><i class="fa fa-usd"></i> <span><?php echo $group->price;?></span></div>
            <?php endif;?>!-->
          </div>
          <?php if($descriptionLimit):?>
            <div class="_des">
              <?php echo $this->string()->truncate($this->string()->stripTags($group->description), $descriptionLimit) ?>
            </div>
          <?php endif;?>
          <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_groupMemberPhoto.tpl';?>
        </div>
        <?php if(isset($this->contactDetailActive) && ((isset($group->group_contact_phone) && $group->group_contact_phone) || (isset($group->group_contact_email) && $group->group_contact_email) || (isset($group->group_contact_website) && $group->group_contact_website))):?>
          <div class="_continnerright">
            <div class="sesgroup_list_contact_btns sesbasic_clearfix">
              <?php if($group->group_contact_phone):?>
                <div class="sesbasic_clearfix">
                  <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                    <a href="javascript:void(0);" class="sesbasic_link_btn" onclick="sessmoothboxDialoge('<?php echo $group->group_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("View Phone No")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <?php if($group->group_contact_email):?>
                <div class="sesbasic_clearfix">
                  <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                    <a href='mailto:<?php echo $group->group_contact_email ?>' class="sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <?php if($group->group_contact_website):?>
                <div class="sesbasic_clearfix">
                  <?php if(SESGROUPSHOWCONTACTDETAIL == 1):?>
                    <a href="<?php echo parse_url($group->group_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $group->group_contact_website : $group->group_contact_website; ?>" target="_blank" class="sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesgroup_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
            </div>
          </div>
        <?php endif;?> 
      </div>
      <div class="_footer sesbasic_clearfix">
	    <?php include APPLICATION_PATH .  '/application/modules/Sesgroup/views/scripts/_dataSharing.tpl';?>
      </div>
    </div>
  </article>
</li>