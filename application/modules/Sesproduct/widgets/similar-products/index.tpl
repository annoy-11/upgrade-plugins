<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php  if(!$this->is_ajax): ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
<?php endif;?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonnumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonnumber = $this->identity; ?>
<?php endif;?>

<ul id="widget_sesproduct_<?php echo $randonnumber; ?>" class=" sesproduct_products_listing sesbasic_clearfix sesbasic_bxs">
  <div class="sesbasic_loading_cont_overlay" id="sesproduct_widget_overlay_<?php echo $randonnumber; ?>"></div>
  <?php foreach($this->paginator as $item):?>
		<li class="sesproduct_grid sesbasic_bxs" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
			<article>
      	<div class="sesproduct_thumb"> 	
          <div class="sesproduct_grid_thumb" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height?>;">
            <a href="<?php echo $item->getHref();?>" class="sesproduct_thumb_img">
              <span style="background-image:url(<?php echo $item->getPhotoUrl();?>);"></span>
            </a>
            <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->verifiedLabel)):?>
              <div class="sesproduct_labels ">
                <?php if(isset($this->featuredLabelActive) && $item->featured == 1):?>
                  <span class="sesproduct_label_featured" title='<?php echo $this->translate("Featured")?>'> <i class="fa fa-star"></i> </span>
                <?php endif;?>
                <?php if(isset($this->sponsoredLabelActive) && $item->sponsored == 1):?>
                  <span class="sesproduct_label_sponsored" title='<?php echo $this->translate("Sponsored")?>'> <i class="fa fa-star"></i> </span>
                <?php endif;?>
              </div>
            <?php endif;?>
          
          	<div class="sesproduct_img_thumb_over"> 
            	<a href="<?php echo $item->getHref();?>" data-url="<?php echo $item->getType() ?>"></a>
              <?php if((isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)) || isset($this->likeButtonActive) || isset($this->favouriteButtonActive)):?>
                <?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref()); ?>
                <div class="sesproduct_list_grid_thumb_btns"> 
                  <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.sharing', 1)):?>
                    
                    <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
                  <?php endif;?>
                  <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ):?>
                    <?php $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');?>
                    <?php if(isset($this->likeButtonActive) && $canComment):?>
                      <?php $LikeStatus = Engine_Api::_()->sesproduct()->getLikeStatus($item->product_id,$item->getType()); ?>
                      <a href="javascript:;" data-url="<?php echo $item->product_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesproduct_like_sesproduct_product <?php echo ($LikeStatus) ? 'button_active' : '' ; ?>"> <i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
                    <?php endif;?>
                    <?php if(isset($this->favouriteButtonActive) && isset($item->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.favourite', 1)): ?>
                      <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesproduct')->isFavourite(array('resource_type'=>'sesproduct','resource_id'=>$item->product_id)); ?>
                      <a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesproduct_favourite_sesproduct_product <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->product_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
                    <?php endif;?>
                  <?php endif;?>
                </div>
              <?php endif;?>
            </div>
          </div>
          <div class="sesproduct_grid_info sesbasic_clearfix">
          	<div class="sesproduct_grid_heading">
          	<?php if(isset($this->titleActive)):?>
            	<div class="sesproduct_grid_info_title">
                <?php if(strlen($item->getTitle()) > $this->title_truncation_list):?>
                  <?php $title = mb_substr($item->getTitle(),0,$this->title_truncation_list).'...';?>
                  <?php echo $this->htmlLink($item->getHref(),$title,array('title'=>$item->getTitle()));?>
                <?php else: ?>
                  <?php echo $this->htmlLink($item->getHref(),$item->getTitle(),array('title'=>$item->getTitle())  ) ?>
                <?php endif;?>   
                <?php if(isset($this->verifiedLabelActive) && $item->verified == 1):?>
                  <div class="sesproduct_verify">
                    <i class="sesproduct_label_verified sesbasic_verified_icon" title="Verified"></i>
                  </div>
                <?php endif;?>
            	</div>  
            <?php endif;?>
            </div>
            <div class="sesproduct_grid_meta_block">
              <?php if(isset($this->storeNamePhotoActive)):?>
                <div class="sesproduct_product_stat sesbasic_text_light">
                  <?php $store = Engine_Api::_()->getItem('stores',$item->store_id); ?>
                  <div class="sesproduct_store_name">
                    <div class="store_logo">
                      <img src="<?php echo $store->getPhotoUrl(); ?>"/>
                    </div>
                    <div class="store_name sesbasic_text_light">
                    	<span><?php echo $store->title; ?></span>
                    </div>
                  </div>
                </div>
              <?php endif;?>
              <?php if(isset($this->creationDateActive)): ?>
                <div class="sesproduct_product_stat sesbasic_text_light">
                    <span>
                    <i class="fa fa-calendar"></i>
                    <?php if($item->publish_date): ?>
                        <?php echo date('M d, Y',strtotime($item->publish_date));?>
                    <?php else: ?>
                        <?php echo date('M d, Y',strtotime($item->creation_date));?>
                    <?php endif; ?>
                    </span>
                </div>
              <?php endif; ?>
              <?php if(isset($this->brandActive)  && $item->brand != ''): ?>
                <div class="sesproduct_product_brand sesbasic_text_light">
                	<span><i class="fa fa-cube" title=""></i> <a href="javascript:;"><?php echo $item->brand ?></a></span>
                </div>
              <?php endif;?>
              <?php if(isset($this->stockActive)): ?>
              	<?php  include APPLICATION_PATH.'/application/modules/Sesproduct/views/scripts/_stock.tpl'; ?>
              <?php endif;?>
              <?php if(isset($this->categoryActive)): ?>
                <?php if($item->category_id != '' && intval($item->category_id) && !is_null($item->category_id)) {  
                        $category_id = $item->category_id; 
                  } else {
                        $category_id = 0;
                 }
                 ?>
                  <?php $categoryItem = Engine_Api::_()->getItem('sesproduct_category', $category_id);?>
                  <?php if($categoryItem):?>
                    
                  <?php endif;?>
              <?php endif;?>
              <?php if($categoryItem){ ?>
              	<div class="sesproduct_product_stat sesbasic_text_light"> 
                 	<span> <i class="fa fa-folder-open" title="<?php echo $this->translate('Category'); ?>"></i> <a href="<?php echo $categoryItem->getHref(); ?>"><?php echo $categoryItem->category_name; ?></a> </span>
                </div>
            	<?php } ?>
            	<?php if(isset($this->locationActive)): ?>
                <div class="sesproduct_product_stat sesbasic_text_light"> 
                    <span> <i class="fa fa-map-marker"></i> <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?><a href="<?php echo $this->url(array('resource_id' => $item->product_id,'resource_type'=>'sesproduct','action'=>'get-direction'), 'sesbasic_get_direction', true) ;?>" class="opensmoothboxurl" title="<?php echo $item->location;?>"><?php echo $item->location;?></a><?php } else { ?><?php echo $item->location;?><?php } ?> </span>
                </div>
             <?php endif;?>
            </div>
            <?php if(isset($this->descriptionActive)): ?>
                <div class="sesproduct_listing_item_des">
                    <p class="sesproduct_product_description"><?php echo $this->string()->truncate($this->string()->stripTags($item->body), $this->description_truncation_list) ?></p>
                </div>
            <?php endif;?>
            <div class="sesbasic_clearfix sesbasic_bxs clear">
              <?php if(isset($this->priceActive)){ ?>
                <?php  include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_productPrice.tpl"); ?>
              <?php } ?>
              <?php if(isset($this->ratingActive)){ ?>
                  <?php include APPLICATION_PATH .  '/application/modules/Sesproduct/views/scripts/_productRatingStat.tpl';?>
              <?php } ?>
            </div>
            <div class="sesproduct_add_cart sesbasic_clearfix">
              <div class="cart_only_text hidden">
              	<?php if(isset($this->addCartActive)): ?>
                	<?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item)); ?>
               	<?php endif; ?>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
                  <a href="javascript:;" class="sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><?php echo $this->translate('Add to Wishlist'); ?></a>
                <?php endif; ?>
              </div>
              <div class="cart_only_icon">
              	<?php if(isset($this->addCartActive)): ?>
                	<?php echo $this->partial('_addToCart.tpl','sesproduct',array('item'=>$item,'icon'=>true)); ?>
               	<?php endif; ?>
                <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.wishlist', 1) && isset($this->addWishlistActive)): ?>
                  <a href="javascript:;" class="sesproduct_wishlist" data-rel="<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate('Add to Wishlist'); ?>"><i class="far fa-bookmark"></i></a>
                <?php endif; ?>
              </div>
            </div>
            <?php if(isset($this->addCompareActive)): ?>
              <div class="sesproduct_product_compare sesbasic_clearfix">
                <?php include(APPLICATION_PATH."/application/modules/Sesproduct/views/scripts/_addToCompare.tpl"); ?>
              </div>
             <?php endif; ?>
          </div>
      	</div>  
    	</article>  
		</li>
  <?php endforeach;?>
  <?php if(isset($this->widgetName)){ ?>
		<div class="sidebar_privew_next_btns">
			<div class="sidebar_previous_btn">
				<?php echo $this->htmlLink('javascript:void(0);', $this->translate('Previous'), array(
					'id' => "widget_previous_".$randonnumber,
					'onclick' => "widget_previous_$randonnumber()",
					'class' => 'buttonlink previous_icon'
				)); ?>
			</div>
			<div class="sidebar_next_btns">
				<?php echo $this->htmlLink('javascript:void(0);', $this->translate('Next'), array(
					'id' => "widget_next_".$randonnumber,
					'onclick' => "widget_next_$randonnumber()",
					'class' => 'buttonlink_right next_icon'
				)); ?>
			</div>
		</div>
	<?php } ?>
</ul>

<?php if(isset($this->widgetName)){ ?>
  <script type="application/javascript">
		var anchor_<?php echo $randonnumber ?> = sesJqueryObject('#widget_sesproduct_<?php echo $randonnumber; ?>').parent();
		function showHideBtn<?php echo $randonnumber ?> (){
			sesJqueryObject('#widget_previous_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->paginator->getCurrentPageNumber() == 1 ? 'none' : '' ) ?>');
			sesJqueryObject('#widget_next_<?php echo $randonnumber; ?>').parent().css('display','<?php echo ( $this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' ) ?>');	
		}
		showHideBtn<?php echo $randonnumber ?> ();
		function widget_previous_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#sesproduct_widget_overlay_<?php echo $randonnumber; ?>').show();
			new Request.HTML({
				url : en4.core.baseUrl + 'widget/index/mod/sesproduct/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
				data : {
					format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>', 
					page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() - 1) ?>
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					sesJqueryObject('#sesproduct_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
			}).send()
		};

		function widget_next_<?php echo $randonnumber; ?>(){
			sesJqueryObject('#sesproduct_widget_overlay_<?php echo $randonnumber; ?>').show();
			new Request.HTML({
				url : en4.core.baseUrl + 'widget/index/mod/sesproduct/name/<?php echo $this->widgetName; ?>/content_id/' + <?php echo sprintf('%d', $this->identity) ?>,
				data : {
					format : 'html',
					is_ajax: 1,
					params :'<?php echo json_encode($this->params); ?>' , 
					page : <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					anchor_<?php echo $randonnumber ?>.html(responseHTML);
					sesJqueryObject('#sesproduct_widget_overlay_<?php echo $randonnumber; ?>').hide();
					showHideBtn<?php echo $randonnumber ?> ();
				}
			}).send();
		};
	</script>
<?php } ?>
