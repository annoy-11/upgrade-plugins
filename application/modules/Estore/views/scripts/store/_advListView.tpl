<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _advListView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php  $title = '';?>
<?php if(isset($this->titleActive)):?>
  <?php if(isset($this->params['advlist_title_truncation'])):?>
    <?php $titleLimit = $this->params['advlist_title_truncation'];?>
  <?php else:?>
    <?php $titleLimit = $this->params['title_truncation'];?>
  <?php endif;?>
  <?php if(strlen($store->getTitle()) > $titleLimit):?>
    <?php $title = mb_substr($store->getTitle(),0,$titleLimit).'...';?>
  <?php else:?>
    <?php $title = $store->getTitle();?>
  <?php endif; ?>
<?php endif;?>
<?php $descriptionLimit = 0;?>
<?php if(isset($this->advlistdescriptionActive)):?>
  <?php $descriptionLimit = $this->params['advlist_description_truncation'];?>
<?php elseif(isset($this->descriptionActive)):?>
  <?php $descriptionLimit = $this->params['description_truncation'];?>
<?php endif;?>
<?php $owner = $store->getOwner();?>
<li class="estore_list_item" id="estore_manage_listing_item_<?php echo $store->getIdentity(); ?>">
  <article class="sesbasic_clearfix">
    <div class="_thumb estore_thumb" style="height:<?php echo is_numeric($height) ? $height.'px' : $height?>;width:<?php echo is_numeric($width) ? $width.'px' : $width ?>;">
      <a href="<?php echo $store->getHref();?>" class="estore_thumb_img estore_browse_location_<?php echo $store->getIdentity(); ?>">
      	<span style="background-image:url(<?php echo $store->getPhotoUrl('thumb.profile'); ?>);"></span>
      </a>
      <div class="estore_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
        <div class="_btns sesbasic_animation">
					<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
        </div>
      <?php endif;?>
  	</div>
    <div class="_cont">
      <?php if(!empty($title)):?>
        <div class="_title">
          <a href="<?php echo $store->getHref();?>" class='estore_browse_location_<?php echo $store->getIdentity(); ?>'><?php echo $title;?></a> <?php if(isset($this->verifiedLabelActive)&& $store->verified):?><i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
        </div>
      <?php endif;?>
      <div class="_continner">
        <div class="_continnerleft">
          <div class="_owner sesbasic_text_light">
            <?php if(ESTORESHOWUSERDETAIL == 1):?>
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
               -&nbsp<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
            <?php endif;?>
          </div>
          <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || isset($this->followActive) || isset($this->memberActive)):?>
            <div class="_stats sesbasic_text_light">
              <i class="fa fa-chart-bar"></i>
              <span>
                <?php if(isset($this->likeActive)):?>
                  <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $store->like_count), $this->locale()->toNumber($store->like_count)) ?>"><?php echo $this->translate(array('%s Like', '%s Likes', $store->like_count), $this->locale()->toNumber($store->like_count)) ?></span><?php endif;?>
                <?php if(isset($this->commentActive)):?>
                  <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $store->comment_count), $this->locale()->toNumber($store->comment_count)) ?>"><?php echo $this->translate(array('%s Comment', '%s Comments', $store->comment_count), $this->locale()->toNumber($store->comment_count)) ?></span>
                <?php endif;?>
                <?php if(isset($this->viewActive)):?>
                  <span title="<?php echo $this->translate(array('%s View', '%s Views', $store->view_count), $this->locale()->toNumber($store->view_count)) ?>"><?php echo $this->translate(array('%s View', '%s Views', $store->view_count), $this->locale()->toNumber($store->view_count)) ?></span><?php endif;?>
                <?php if(isset($this->favouriteActive)):?>
                  <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $store->favourite_count), $this->locale()->toNumber($store->favourite_count)) ?>"><?php echo $this->translate(array('%s Favourite', '%s Favourites', $store->favourite_count), $this->locale()->toNumber($store->favourite_count)) ?></span><?php endif;?>
                <?php if(isset($this->followActive) && isset($store->follow_count)):?>
                  <span title="<?php echo $this->translate(array('%s Follower', '%s Followers', $store->follow_count), $this->locale()->toNumber($store->follow_count)) ?>"><?php echo $this->translate(array('%s Follower', '%s Followers', $store->follow_count), $this->locale()->toNumber($store->follow_count)) ?></span><?php endif;?>
                <?php if(isset($this->memberActive) && isset($store->member_count)):?>
                  <span title="<?php echo $this->translate(array('%s Member', '%s Members', $store->member_count), $this->locale()->toNumber($store->member_count)) ?>"><?php echo $this->translate(array('%s Member', '%s Members', $store->member_count), $this->locale()->toNumber($store->member_count)) ?></span><?php endif;?>
              </span>
            </div>
          <?php endif;?>
          <?php if(isset($this->locationActive) && $store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_enable_location', 1)):?>
            <div class="_stats sesbasic_text_light">
              <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i> 	 
              <span title="<?php echo $store->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a><?php else:?><?php echo $store->location;?><?php endif;?></span>
            </div>  
          <?php endif;?>
          <div class="sesbasic_clearfix _middleinfo">
            <?php if(isset($category) && isset($this->categoryActive)):?>
              <div><i class="fa fa-folder-open sesbasic_text_light"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
            <?php endif;?> 
            <!--<?php if(isset($this->priceActive) && $store->price):?>
              <div class="estore_ht"><i class="fa fa-dollar-sign"></i> <span><?php echo $store->price;?></span></div>
            <?php endif;?>!-->
        </div>
          
          <?php if($descriptionLimit):?>
            <div class="_des">
              <?php echo $this->string()->truncate($this->string()->stripTags($store->description), $descriptionLimit) ?>
            </div>
          <?php endif;?>
        </div>
        <?php if(isset($this->contactDetailActive) && ((isset($store->store_contact_phone) && $store->store_contact_phone) || (isset($store->store_contact_email) && $store->store_contact_email) || (isset($store->store_contact_website) && $store->store_contact_website))):?>
          <div class="_continnerright">
            <div class="estore_list_contact_btns sesbasic_clearfix">
              <?php if($store->store_contact_phone):?>
                <div class="sesbasic_clearfix">
                  <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                    <a href="javascript:void(0);" class="sesbasic_link_btn" onclick="sessmoothboxDialoge('<?php echo $store->store_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("View Phone No")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <?php if($store->store_contact_email):?>
                <div class="sesbasic_clearfix">
                  <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                    <a href='mailto:<?php echo $store->store_contact_email ?>' class="sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
              <?php if($store->store_contact_website):?>
                <div class="sesbasic_clearfix">
                  <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                    <a href="<?php echo parse_url($store->store_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $store->store_contact_website : $store->store_contact_website; ?>" target="_blank" class="sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                  <?php else:?>
                    <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                  <?php endif;?>
                </div>
              <?php endif;?>
            </div>
          </div>
        <?php endif;?> 
      </div>
      <div class="_footer sesbasic_clearfix">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?>
      </div>
    </div>
  </article>
</li>
 
