<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/styles/styles.css'); ?>
<?php // Carousel Layout ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Estore/externals/scripts/slick/slick.js') ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $width = $this->params['width'];?>
<?php if(!is_numeric($width)):?>
  <?php $width = explode('px', $this->params['width'])[0];?>
<?php endif;?>
<?php  $randonNumber = $this->widgetId;?>
<?php if($this->params['view_type'] == 'carousel'):?>
    <?php if(!$this->is_ajax){ ?>
      <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear estore_categories_stores_listing_container">
       <?php } ?>
        <div class="estore_category_stores sesbasic_bxs sesbasic_clearfix">
          <div class="sesbasic_loading_cont_overlay"></div>
      <?php foreach( $this->paginatorCategory as $category):?>
        <div class="_row sesbasic_clearfix estore_carousel_h_wrapper">
          <div class="_head sesbasic_clearfix">
            <span class="_catname floatL">
              <a href="<?php echo $category->getHref();?>"><?php echo $category->category_name;?></a>
              <?php if(isset($this->countStoreActive)):?><span class="bold">(<?php echo $category->total_store_categories;?>)</span><?php endif;?>  
            </span>
            <?php if(isset($this->seeAllActive)):?>
            <span class="_morebtn <?php echo $this->params['allignment_seeall'] == 'right' ?  'floatR' : 'floatL'; ?>"><a href="<?php echo $this->url(array('action'=> 'browse'),'estore_general', true).'?category_id='.$category->category_id;?>" class="estore_link_btn"><?php echo $this->translate('See All');?></a></span>
            <?php endif;?>
          </div>
          <div class="_list estore_store_carousel slider" data-width="<?php echo $width ?>" rel="<?php echo $category->total_store_categories;?>">
            <?php foreach($this->resultArray['store_data'][$category->category_id]  as $store):?>
              <div class="estore_grid_item _iscatitem <?php if((isset($this->socialSharingActive))):?>_isbtns<?php endif;?>" style="width:<?php echo $width ?>px;">
                <article>
					<?php	$dayIncludeTime = strtotime(date("Y-m-d H:i:s", strtotime('+'.(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer(), 'stores', 'newBsduration')*24).' hours', strtotime($store->creation_date))));
					$currentTime = strtotime(date("Y-m-d H:i:s"));
         if(isset($this->newLabelActive) && $dayIncludeTime > $currentTime && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1)):?>
            <div class="estore_sgrid_newlabel">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
            </div>
        <?php endif;?>
    <div class="_thumb estore_thumb" style="height:<?php echo $height ?>px;"> 
      <a href="<?php echo $store->getHref();?>" class="estore_thumb_img"><span style="background-image:url(<?php echo $store->getCoverPhotoUrl() ?>);"></span></a>
      <a href="javascript:;" class="_cover_link"></a>
      <div class="estore_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
      </div>      
      <div class="estore_sgrid_seller_info">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/seller_info.tpl';?>
      </div>
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
      <div class="_btns sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
      </div>
      <?php endif;?>
      <?php if(!empty($title)):?>
      <div class="_thumbinfo">
        <div>
          <div class="estore_profile_isrounded"> <a href="<?php echo $store->getHref();?>" class="estore_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $store->getPhotoUrl('thumb.icon'); ?>);"></span></a></div>
          <div class="_title"> <a href="<?php echo $store->getHref();?>"><?php echo $title; ?></a>
            <div class="_date">
              <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):?>
              <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
              <?php endif;?>
              <?php if(isset($this->creationDateActive)):?>
              -&nbsp;
              <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
              <?php endif;?>
            </div>
          </div>
        </div>
      </div>
      <?php endif;?>
    </div>
    <div class="estore_grid_info">
      <?php if(isset($this->verifiedLabelActive) && $store->verified):?>
        <div class="estore_verify"> <i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i> </div>
      <?php endif;?>
       <?php if(isset($this->totalProductActive)):?>
        <div class="estore_sgrid_product_img">
            <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_productImg.tpl';?>
        </div>
        <?php endif;  ?>
      <div class="sesbasic_clearfix"> 
        <?php if(isset($this->priceActive)):?>
        <div class="estore_sgrid_price">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_priceLabel.tpl';?>
        </div>
        <?php endif;  ?>
        <?php if(isset($category) && isset($this->categoryActive)):?>
        <div class="_stats _category sesbasic_text_light sesbasic_clearfix"> <i class="fa fa-folder-open"></i> <span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span> </div>
        <?php endif;?>
        <?php if(isset($this->ratingActive)): $item = $store; ?>
            <div class="estore_sgrid_rating">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/rating.tpl';?>
            </div>
        <?php endif; unset($item);?>
        <div class="_stats sesbasic_text_light">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?>
        </div>
        <?php if(isset($this->locationActive) && $store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1)):?>
        <div class="_stats sesbasic_text_light _location"> <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>">  </i> <span title="<?php echo $store->location;?>">
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?>
          <a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a>
          <?php else:?>
          <?php echo $store->location;?>
          <?php endif;?>
          </span> 
        </div>
        <?php endif;?>
        <?php if($descriptionLimit):?>
        <div class="_des sesbasic_clearfix"><?php echo $this->string()->truncate($this->string()->stripTags($store->description), $descriptionLimit) ?></div>
        <?php endif;?>
        <div class="estore_grid_share">
          <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?>
        </div>  
      </div>
    </div>
  </article>
              </div>
            <?php endforeach; ?>
        	</div>
      	</div>
    <?php endforeach; ?>
    <?php if($this->paginatorCategory->getTotalItemCount() == 0 && !$this->is_ajax):  ?>
        <div id="estore_category_stores_<?php echo $randonNumber;?>" class="">
            <div id="error-message_<?php echo $randonNumber;?>">
                <div class="sesbasic_tip clearfix">
                    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_store_no_photo', 'application/modules/Estore/externals/images/store-icon.png'); ?>" alt="" />
                    <span class="sesbasic_text_light">
                    <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif;?>
    <?php if($this->params['pagging'] == 'pagging'){ ?>
        <?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "estore"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
    
    </div>	
    <?php if(!$this->is_ajax){ ?>
     </div>
     <?php if($this->params['pagging'] != 'pagging'){ ?>  
   <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
  	<a href="javascript:void(0);" id="feed_viewmore_link_<?php echo $randonNumber; ?>" class="sesbasic_animation estore_link_btn"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More'); ?></span></a>
  </div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="estore_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
  <?php } ?>
  <?php } ?>
<?php elseif($this->params['view_type'] == 'grid'):?>
  <div class="sesbasic_bxs sesbasic_clearfix estore_cotegory_grid_layout">
    <?php foreach( $this->paginatorCategory as $category): ?>
    <div class="_item" style="width:<?php echo $width ?>px;">
        <article class="sesbasic_animation">
          <header class="sesbasic_clearfix">
            <?php if(isset($this->seeAllActive)):?>
              <span class="_seeall"><a href="<?php echo $this->url(array('action'=> 'browse'),'estore_general', true).'?category_id='.$category->category_id;?>"><?php echo $this->translate('See All');?></a></span>
            <?php endif;?>
            <span class="_catname">
            	<a href="<?php echo $category->getHref();?>">
                <?php if($category->colored_icon){
                      $str = Engine_Api::_()->getItem('storage_file',$category->colored_icon);
                      if($str){
                 ?>
                <img src="<?php echo $str->getPhotoUrl(); ?>" />
                <?php } } ?>
                <span><?php echo $category->category_name;?></span>
                 <?php if(isset($this->countStoreActive)):?><span class="bold">(<?php echo $category->total_store_categories;?>)</span><?php endif;?>  
              </a>
             </span>
            <?php if(isset($this->categoryDescriptionActive)):?>
              <p><?php echo $this->string()->truncate($this->string()->stripTags($category->description), $this->params['grid_description_truncation']) ?></p>
            <?php endif;?>
          </header>
          <div class="_cont">
    <?php foreach($this->resultArray['store_data'][$category->category_id] as $store):?>
            <?php if(isset($this->titleActive)):?>
              <?php if(strlen($store->getTitle()) > $this->params['title_truncation']):?>
                <?php $title = mb_substr($store->getTitle(),0,$this->params['title_truncation']).'...';?>
              <?php else: ?>
                <?php $title = $store->getTitle();?>
              <?php endif; ?>
              <div class="_pagelist">
                <a href="<?php echo $store->getHref(); ?>">
                	<i class="fa fa-angle-right sesbasic_text_light"></i>
									<?php echo $this->itemPhoto($store, 'thumb.icon', $store->getTitle());?>
                  <span><?php echo $title; ?></span></a>
              </div>
            <?php endif;?>
           
    <?php endforeach; ?>
     </div>
        </article>
      </div>
    <?php endforeach; ?>
  </div>
<?php elseif($this->params['view_type'] == 'slideshow'):?>
  <div class="estore_category_stores sesbasic_bxs sesbasic_clearfix">
    <div class="sesbasic_loading_cont_overlay"></div>
      <?php foreach( $this->paginatorCategory as $category): ?>
        <div class="_row sesbasic_clearfix estore_carousel_h_wrapper">
          <div class="_head sesbasic_clearfix">
            <span class="_catname floatL">
            	<a href="<?php echo $category->getHref();?>"><?php echo $category->category_name;?></a>
            	<?php if(isset($this->countStoreActive)):?><span>(<?php echo $category->total_store_categories;?>)</span><?php endif;?>  
            </span>
            <?php if(isset($this->seeAllActive)):?>
              <span class="_morebtn <?php echo $this->params['allignment_seeall'] == "right" ?  "floatR" : "floatL"; ?>"><a href="<?php echo $this->url(array('action'=> 'browse'),'estore_general', true).'?category_id='.$category->category_id;?>" class="estore_link_btn"><?php echo $this->translate('See All');?></a></span>
            <?php endif;?>
          </div>
          <div class="_list estore_category_slideshow slider" data-width="<?php echo $width ?>" rel="<?php echo $category->total_store_categories;?>">
      <?php foreach( $this->resultArray['store_data'][$category->category_id] as $store):?>
        <div class="estore_list_item sesbasic_clearfix">
          <article class="sesbasic_clearfix">
              <div class="_thumb estore_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
              <?php $href = $store->getHref();$imageURL = $store->getPhotoUrl('thumb.profile');?>
              <a href="<?php echo $href; ?>" class="estore_thumb_img"><span style="background-image:url(<?php echo $imageURL; ?>);"></span></a>
              <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
                <div class="estore_list_labels sesbasic_animation">
                  <?php if(isset($this->featuredLabelActive) && $store->featured){ ?>
                    <span class="estore_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                  <?php if(isset($this->sponsoredLabelActive) && $store->sponsored){ ?>
                    <span class="estore_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                  <?php if(isset($this->hotLabelActive) && $store->hot){ ?>
                      <span class="estore_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                </div>
              <?php } ?>
              <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
                <div class="_btns sesbasic_animation">
                  <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
                </div>
              <?php endif;?>
            </div>
            <div class="_cont">
              <?php if(isset($this->titleActive) ): ?>
                <?php if(strlen($store->getTitle()) > $this->params['title_truncation']):?>
                  <?php $title = mb_substr($store->getTitle(),0,$this->params['title_truncation']).'...';?>
                <?php else: ?>
                  <?php $title = $store->getTitle();?>
                <?php endif; ?>
                <div class="_title">
                  <?php echo $this->htmlLink($store->getHref(),$store->getTitle()) ?>
                  <?php if(isset($this->verifiedLabelActive) && $store->verified): ?>
                  <i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="_continner">
              	<div class="_continnerleft">
                  <?php $owner = $store->getOwner(); ?>	
                    <?php  if(isset($this->byActive)): ?>
                    <div class="_owner sesbasic_text_light">
                      <span class="_owner_img">
                        <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                      </span>
                      <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span>
                      <span class="_date" title="">-&nbsp;<?php echo date('jS M', strtotime($store->creation_date));?>,&nbsp;<?php echo date('Y', strtotime($store->creation_date));?></span>
                     </div>
                  <?php endif; ?>
                  <div class="_stats sesbasic_text_light">
                    <span><?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?></span>
                  </div>
                 
                  <?php if(isset($this->locationActive) && $store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_enable_location', 1)):?>
                    <div class="_stats _location sesbasic_text_light">  
                      <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                      <span title="<?php echo $store->location;?>"><?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a><?php else:?><?php echo $store->location;?><?php endif;?></span>
                    </div>
                  <?php endif;?>
                  
                  <div class="_stats sesbasic_clearfix _middleinfo">
                    <?php if(isset($category) && isset($this->categoryActive)):?>
                      <div><i class="fa fa-folder-open sesbasic_text_light"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
                    <?php endif;?>
                    <!--<?php if(isset($this->priceActive) && $store->price):?>
                      <div><i class="fa fa-usd sesbasic_text_light"></i><span><?php echo $store->price;?></span></div>
                    <?php endif;?>!-->
                  </div>
                  <?php if(isset($this->descriptionActive)):?>
                    <div class="_des">
                      <?php echo $this->string()->truncate($this->string()->stripTags($store->description), $this->params['slideshow_description_truncation']) ?>
                    </div>
                  <?php endif;?>                  
              	</div>
                <?php if(isset($this->contactDetailActive) && ((isset($store->store_contact_phone) && $store->store_contact_phone) || (isset($store->store_contact_email) && $store->store_contact_email) || (isset($store->store_contact_website) && $store->store_contact_website))):?>
                  <div class="_continnerright">
                    <div class="estore_list_contact_btns sesbasic_clearfix">
                      <?php if($store->store_contact_phone):?>
                        
                        <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                          <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $store->store_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox estore_link_btn"><?php echo $this->translate("View Phone No")?></a>
                        <?php endif;?>
                        
                      <?php endif;?>
                      <?php if($store->store_contact_email):?>
                        
                        <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                          <a href='mailto:<?php echo $store->store_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox estore_link_btn"><?php echo $this->translate("Send Email")?></a>
                        <?php endif;?>
                        
                      <?php endif;?>
                      <?php if($store->store_contact_website):?>
                        
                        <?php if(ESTORESHOWCONTACTDETAIL == 1):?>
                          <a href="<?php echo parse_url($store->store_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $store->store_contact_website : $store->store_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'estore_general',true);?>" class="smoothbox estore_link_btn"><?php echo $this->translate("Visit Website")?></a>
                        <?php endif;?>
                        
                      <?php endif;?>
                    </div>
                  </div>
                <?php endif;?>
              </div>  
              <div class="_footer">
              	<?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataSharing.tpl';?>
              </div>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
      </div>
            </div>
      <?php endforeach; ?>
  </div>
<?php endif;?>
<script type="text/javascript">
    <?php if($this->params['pagging'] == 'auto_load'){ ?>
        window.addEvent('load', function() { 
        sesJqueryObject (window).scroll( function() {
            var containerId = '#scrollHeightDivSes_<?php echo $randonNumber;?>'; alert(containerId);
            if(typeof sesJqueryObject(containerId).offset() != 'undefined') {
                var hT = sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').offset().top,
                hH = sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').outerHeight(),
                wH = sesJqueryObject(window).height(),
                wS = sesJqueryObject(this).scrollTop();
                if ((wS + 30) > (hT + hH - wH) && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block') {
                    document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
                }
            }
        });
    <?php } ?>
    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
        sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
        (new Request.HTML({
            method: 'post',
            'url': en4.core.baseUrl + "widget/index/mod/estore/name/<?php echo $this->widgetName; ?>",
            'data': {
                format: 'html',
                page: pageNum,    
                params :'<?php echo json_encode($this->params); ?>', 
                is_ajax : 1,
                widget_id: '<?php echo $randonNumber; ?>',
            },
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','none');
                document.getElementById('scrollHeightDivSes_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
                makeSlidesObject();
            }
        })).send();
        return false;
    }

    var defaultOpenTab ;
    viewMoreHide_<?php echo $randonNumber; ?>();
    function viewMoreHide_<?php echo $randonNumber; ?>() {
        if ($('view_more_<?php echo $randonNumber; ?>'))
        $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginatorCategory->count() == 0 ? 'none' : ($this->paginatorCategory->count() == $this->paginatorCategory->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
    function viewMore_<?php echo $randonNumber; ?> (){
        var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
        document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
        document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
        (new Request.HTML({
            method: 'post',
            'url': en4.core.baseUrl + "widget/index/mod/estore/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
            'data': {
                format: 'html',
                page: <?php echo $this->page + 1; ?>,    
                is_ajax : 1,
                widget_id: '<?php echo $randonNumber; ?>',
            },
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                document.getElementById('scrollHeightDivSes_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('scrollHeightDivSes_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
                document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
                makeSlidesObject();
            }
        })).send();
        return false;
    }
</script>
