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
          <i class="far fa-user"></i>
          <span><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
      	</span>
      </div>
    <?php endif;?>
		<?php if(isset($this->creationDateActive)):?>
      <div class="_stats _date">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
			</div>
    <?php endif;?>
    <?php if(isset($category) && $this->categoryActive):?>
      <div class="_stats sesbasic_clearfix sesbasic_text_light _category">
      	<span>
          <i class="far fa-folder-open"></i>
          <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span>
      	</span>
      </div>
    <?php endif;?>
    <?php if($store->location && isset($this->locationActive)):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix _location">
      	<span>
          <i class="fa fa-map-marker-alt" title="<?php echo $this->translate('Location');?>"></i>
          <span title="<?php echo $store->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a><?php else:?><?php echo $store->location;?><?php endif;?></span>
        </span>
      </div>
    <?php endif;?>
    <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($store->follow_count)) || (isset($this->memberActive) && isset($store->member_count))):?>
      <div class="_stats sesbasic_text_light sesbasic_clearfix">
        <?php if(isset($this->likeActive)):?>
          <span title="<?php echo $this->translate(array('%s Like', '%s Likes', $store->like_count), $this->locale()->toNumber($store->like_count)) ?>"><i class="far fa-thumbs-up"></i><span><?php echo $store->like_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($this->commentActive)):?>
          <span title="<?php echo $this->translate(array('%s Comment', '%s Comments', $store->comment_count), $this->locale()->toNumber($store->comment_count)) ?>"><i class="far fa-comment"></i><span><?php echo $store->comment_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($this->viewActive)):?>
          <span title="<?php echo $this->translate(array('%s View', '%s Views', $store->view_count), $this->locale()->toNumber($store->view_count)) ?>"><i class="far fa-eye"></i><span><?php echo $store->view_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($this->favouriteActive)):?>
          <span title="<?php echo $this->translate(array('%s Favourite', '%s Favourites', $store->favourite_count), $this->locale()->toNumber($store->favourite_count)) ?>"><i class="far fa-heart"></i><span><?php echo $store->favourite_count; ?></span></span>
        <?php endif;?>
        <?php if(isset($this->memberActive)):?>
          <span title="<?php echo $this->translate(array('%s Member', '%s Member', $store->member_count), $this->locale()->toNumber($store->member_count)) ?>"><i class="far fa-user"></i><span><?php echo $store->member_count; ?></span></span>
        <?php endif;?>
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
  
