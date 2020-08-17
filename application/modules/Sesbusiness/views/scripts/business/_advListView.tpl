<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advListView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['advlist_title_truncation'])):?>
    <?php $titleLimit = $this->params['advlist_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($business->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($business->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $business->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->advlistdescriptionActive)):?>
  <?php $descriptionLimit = $this->params['advlist_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
  <?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $business->getOwner();?>
<li class="sesbusiness_list_item" id="sesbusiness_manage_listing_item_<?php echo $business->getIdentity(); ?>">
  <article class="sesbasic_clearfix">
    <div class="_thumb sesbusiness_thumb" style="height:<?php echo is_numeric($height) ? $height.'px' : $height?>;width:<?php echo is_numeric($width) ? $width.'px' : $width ?>;">
      <a href="<?php echo $business->getHref();?>" class="sesbusiness_thumb_img sesbusiness_browse_location_<?php echo $business->getIdentity(); ?>">
      	<span style="background-image:url(<?php echo $business->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="sesbusiness_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
					<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataButtons.tpl';?>
        </div>
      <?php endif;?>
  	</div>
    <div class="_cont">
      <?php if(!empty($title)):?>
        <div class="_title">
          <a href="<?php echo $business->getHref();?>" class='sesbusiness_browse_location_<?php echo $business->getIdentity(); ?>'><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $business->verified):?><i class="sesbusiness_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
        </div>
      <?php endif;?>
      <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessreview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated')):?>
        <?php echo $this->partial('_businessRating.tpl', 'sesbusinessreview', array('showRating' =>(isset($this->ratingActive) ? 1 : 0), 'rating' => $business->rating, 'review' => $business->review_count,'business_id' => $business->business_id));?>
      <?php endif;?>
      <div class="_continner">
        <div class="_continnerleft">
          <div class="_owner sesbasic_text_light">
            <?php if(SESBUSINESSSHOWUSERDETAIL == 1):?>
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
               -&nbsp<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_date.tpl';?>
            <?php endif;?>
          </div>
          <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || isset($this->followActive) || isset($this->memberActive)):?>
            <div class="_stats sesbasic_text_light">
              <i class="fa fa-bar-chart"></i>
              <span>
                <?php if(isset($this->likeActive)):?>
                  <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $business->like_count), $this->locale()->toNumber($business->like_count)) ?>"><?php echo $this->translate(array('%s Like', '%s Likes', $business->like_count), $this->locale()->toNumber($business->like_count)) ?></span><?php endif;?>
                <?php if(isset($this->commentActive)):?>
                  <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $business->comment_count), $this->locale()->toNumber($business->comment_count)) ?>"><?php echo $this->translate(array('%s Comment', '%s Comments', $business->comment_count), $this->locale()->toNumber($business->comment_count)) ?></span>
                <?php endif;?>
                <?php if(isset($this->viewActive)):?>
                  <span title="<?php echo $this->translate(array('%s View', '%s Views', $business->view_count), $this->locale()->toNumber($business->view_count)) ?>"><?php echo $this->translate(array('%s View', '%s Views', $business->view_count), $this->locale()->toNumber($business->view_count)) ?></span><?php endif;?>
                <?php if(isset($this->favouriteActive)):?>
                  <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $business->favourite_count), $this->locale()->toNumber($business->favourite_count)) ?>"><?php echo $this->translate(array('%s Favourite', '%s Favourites', $business->favourite_count), $this->locale()->toNumber($business->favourite_count)) ?></span><?php endif;?>
                <?php if(isset($this->followActive) && isset($business->follow_count)):?>
                  <span title="<?php echo $this->translate(array('%s Follower', '%s Followers', $business->follow_count), $this->locale()->toNumber($business->follow_count)) ?>"><?php echo $this->translate(array('%s Follower', '%s Followers', $business->follow_count), $this->locale()->toNumber($business->follow_count)) ?></span><?php endif;?>
                <?php if(isset($this->memberActive) && isset($business->member_count)):?>
                  <span title="<?php echo $this->translate(array('%s Member', '%s Members', $business->member_count), $this->locale()->toNumber($business->member_count)) ?>"><?php echo $this->translate(array('%s Member', '%s Members', $business->member_count), $this->locale()->toNumber($business->member_count)) ?></span><?php endif;?>
              </span>
            </div>
          <?php endif;?>
          <?php if(isset($this->locationActive) && $business->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness_enable_location', 1)):?>
            <div class="_stats sesbasic_text_light">
              <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i> 	 
              <span title="<?php echo $business->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sesbusiness.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $business->location;?></a><?php else:?><?php echo $business->location;?><?php endif;?></span>
            </div>  
          <?php endif;?>
          <div class="sesbasic_clearfix _middleinfo">
            <?php if(isset($category) && isset($this->categoryActive)):?>
              <div><i class="fa fa-folder-open sesbasic_text_light"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
            <?php endif;?>
            <!--<?php if(isset($this->priceActive) && $business->price):?>
              <div class="sesbusiness_ht"><i class="fa fa-usd"></i> <span><?php echo $business->price;?></span></div>
            <?php endif;?>!-->
          </div>
          
          <?php if($descriptionLimit):?>
            <div class="_des">
              <?php echo $this->string()->truncate($this->string()->stripTags($business->description), $descriptionLimit) ?>
            </div>
          <?php endif;?>
        </div>
        <?php if(isset($this->contactDetailActive) && ((isset($business->business_contact_phone) && $business->business_contact_phone) || (isset($business->business_contact_email) && $business->business_contact_email) || (isset($business->business_contact_website) && $business->business_contact_website))):?>
          <div class="_continnerright">
            <div class="sesbusiness_list_contact_btns sesbasic_clearfix">
              <?php if($business->business_contact_phone):?>
                <div class="sesbasic_clearfix">
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href="javascript:void(0);" class="sesbasic_link_btn" onclick="sessmoothboxDialoge('<?php echo $business->business_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("View Phone No")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <?php if($business->business_contact_email):?>
                <div class="sesbasic_clearfix">
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href='mailto:<?php echo $business->business_contact_email ?>' class="sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <?php if($business->business_contact_website):?>
                <div class="sesbasic_clearfix">
                  <?php if(SESBUSINESSSHOWCONTACTDETAIL == 1):?>
                    <a href="<?php echo parse_url($business->business_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $business->business_contact_website : $business->business_contact_website; ?>" target="_blank" class="sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sesbusiness_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
            </div>
          </div>
        <?php endif;?> 
      </div>
      <div class="_footer sesbasic_clearfix">
        <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/_dataSharing.tpl';?>
      </div>
    </div>
  </article>
</li>
