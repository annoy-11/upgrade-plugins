<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _listView.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $owner = $store->getOwner();?>
<li class="estore_sidebar_list_item sesbasic_clearfix">
  <div class="_thumb" style="width:<?php echo is_numeric($width)?$width.'px':$width ?>;">
    <span style="height:<?php echo is_numeric($height)?$height.'px':$height ?>;width:<?php echo is_numeric($width)?$width.'px':$width ?>;"><a href="<?php echo $store->getHref();?>" class="floatL estore_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $store->getPhotoUrl('thumb.profile'); ?>);"></span></a></span>
    <div class="_labels">
      <?php if(isset($this->featuredLabelActive) && $store->featured):?>
      <span class="estore_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
      <?php if(isset($this->sponsoredLabelActive) && $store->sponsored):?>
      <span class="estore_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
      <?php if(isset($this->hotLabelActive) && $store->hot):?>
      <span class="estore_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
      <?php endif;?>
    </div>
  </div>

  <div class="_cont">
    <?php if(isset($this->titleActive)):?>
      <div class="_title">
        <a href="<?php echo $store->getHref();?>"><?php echo $title;?></a><?php if(isset($this->verifiedLabelActive)&& $store->verified):?><i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
      </div>
    <?php endif;?>
    <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
      <div class="_stats sesbasic_clearfix sesbasic_text_light">
      	<span>
          <i class="fa fa-user"></i>
          <span><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
      	</span>
      </div>
    <?php endif;?>
		<?php if(isset($this->creationDateActive)):?>
      <div class="_date">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
			</div>
    <?php endif;?>
     <?php if(isset($this->ratingActive)) { $item = $store; ?>
            <div class="estore_sgrid_rating">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/rating.tpl';?>
            </div>
    <?php unset($item); } ?>
    <?php if(isset($this->priceActive)):?>
      <div class="_listprice sesbasic_text_light">
        <?php if(!empty($store->price) && $store->price != '') { ?>
          <?php if($store->price_type == '1'){
            echo $this->translate('Price'); 
          }else{
            echo $this->translate('Starting Price'); 
          }?>
        	<span class="price_val"><i class="fa fa-usd"></i> <b><?php echo $store->price; ?></b></span>
        <?php } ?>
      </div>
    <?php endif;?>
    <?php if(isset($category) && $this->categoryActive):?>
      <div class="_stats sesbasic_clearfix sesbasic_text_light _category">
      	<span>
          <i class="fa fa-folder-open"></i>
          <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
      	</span>
      </div>
    <?php endif;?>
    <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($store->follow_count)) || (isset($this->memberActive) && isset($store->member_count))):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
        <?php if(isset($this->likeActive)):?>
          <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $store->like_count), $this->locale()->toNumber($store->like_count)) ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $store->like_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($this->commentActive)):?>
          <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $store->comment_count), $this->locale()->toNumber($store->comment_count)) ?>"><i class="fa fa-comment"></i><span><?php echo $store->comment_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($this->viewActive)):?>
          <span title="<?php echo $this->translate(array('%s View', '%s Views', $store->view_count), $this->locale()->toNumber($store->view_count)) ?>"><i class="fa fa-eye"></i><span><?php echo $store->view_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($this->favouriteActive)):?>
          <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $store->favourite_count), $this->locale()->toNumber($store->favourite_count)) ?>"><i class="fa fa-heart"></i><span><?php echo $store->favourite_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($this->memberActive)):?>
          <span title="<?php echo $this->translate(array('%s Member', '%s Member', $store->member_count), $this->locale()->toNumber($store->member_count)) ?>"><i class="fa fa-user"></i><span><?php echo $store->member_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($store)) {  ?>
        <?php $paginator = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct')->getProduct(array('store_id'=>$store->store_id)); ?>
         <span><i class="fa fa-shopping-bag"></i><span><?php echo count($paginator); ?></span></span>
        <?php } ?>
      </div>
    <?php endif;?>
    <?php if($store->location && isset($this->locationActive)):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix _location">
      	<span>
          <i class="fa fa-map-marker" title="<?php echo $this->translate('Location');?>"></i>
          <span title="<?php echo $store->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a><?php else:?><?php echo $store->location;?><?php endif;?></span>
        </span>
      </div>
    <?php endif;?>
    <?php if(isset($this->contactDetailActive) && (isset($store->store_contact_phone) || isset($store->store_contact_email) || isset($store->store_contact_website))):?>
      <?php if($store->store_contact_phone):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<span>
            <i class="fa fa-mobile"></i>
            <span>
              <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $store->store_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
              <?php endif;?>
            </span>
          </span>
      	</div>  
      <?php endif;?>
      <?php if($store->store_contact_email):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<span>
      	  	<i class="fa fa-envelope"></i>
            <span>
              <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                <a href='mailto:<?php echo $store->store_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
              <?php endif;?>
            </span>
          </span>
        </div>  
      <?php endif;?>
      <?php if($store->store_contact_website):?>
        <div class="_stats sesbasic_text_light sesbasic_clearfix">
        	<span>
            <i class="fa fa-globe"></i>
            <span>
              <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                <a href="<?php echo parse_url($store->store_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $store->store_contact_website : $store->store_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
              <?php else:?>
                <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
              <?php endif;?>
            </span>
          </span>
        </div>
      <?php endif;?>
    <?php endif;?>
    <?php if(isset($this->socialSharingActive) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
    	<div class="_footer">
        <div class="_btns"><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?></div>
        <div class="_sharebuttons"><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?></div>
    	</div>
    <?php endif;?>
  </div>
  <script>
  function showSocialIconsS(id) {
    if(sesJqueryObject('#sidebarsocialicons_' + id)) {
        if (sesJqueryObject('#sidebarsocialicons_' + id).css('display') == 'block') {
            sesJqueryObject('#sidebarsocialicons_' + id).css('display','none');
        } else {
            sesJqueryObject('#sidebarsocialicons_' + id).css('display','block');
        }
    }
  }
  window.addEvent('domready', function() {
    $(document.body).addEvent('click', function(event){
      if(event.target.className != 'estore_sidebar_list_option_btns' && event.target.id != 'testcl') {
      	sesJqueryObject('.estore_sidebar_list_option_btns').css('display', 'none');
      }
    });
  });
</script>
</li>
  
