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
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $width = $this->params['width'];?>
<?php if(!is_numeric($width)):?>
<?php $width = explode('px', $this->params['width'])[0];?>
<?php endif;?>
<?php  $randonNumber = $this->widgetId;?>
<?php if(!$this->is_ajax){ ?>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear estore_categories_stores_listing_container">
  <?php } ?>
  <div class="estore_category_stores sesbasic_bxs sesbasic_clearfix">
    <div class="sesbasic_loading_cont_overlay"></div>
    <?php foreach( $this->paginatorCategory as $category):?>
    <div class="_row sesbasic_clearfix estore_carousel_h_wrapper">
      <div class="_head sesbasic_clearfix"> <span class="_catname floatL"> <a href="<?php echo $category->getHref();?>"><?php echo $category->category_name;?></a>
        <?php if(isset($this->countStoreActive)):?>
        <span class="bold">(<?php echo $category->total_store_categories;?>)</span>
        <?php endif;?>
        </span>
        <?php if(isset($this->seeAllActive)):?>
        <span class="_morebtn <?php echo $this->params['allignment_seeall'] == 'right' ?  'floatR' : 'floatL'; ?>"><a href="<?php echo $this->url(array('action'=> 'browse'),'estore_general', true).'?category_id='.$category->category_id;?>" class="estore_link_btn"><?php echo $this->translate('See All');?></a></span>
        <?php endif;?>
      </div>
      <div class="_list estore_store_carousel" data-width="<?php echo $width ?>" rel="<?php echo $category->total_store_categories;?>">
        <?php foreach($this->resultArray['store_data'][$category->category_id]  as $store):?>
        <div class="estore_grid_item _iscatitem <?php if((isset($this->socialSharingActive))):?>_isbtns<?php endif;?>" style="width:<?php echo $width ?>px;">
          <article>
            <div class="_thumb estore_thumb" style="height:<?php echo $height ?>px;"> <a href="<?php echo $store->getHref();?>" class="estore_thumb_img"><span style="background-image:url(<?php echo $store->getPhotoUrl() ?>);"></span></a> <a href="javascript:;" class="_cover_link"></a>
              <div class="estore_list_labels sesbasic_animation">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataLabel.tpl';?>
              </div>
              <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
              <div class="_btns sesbasic_animation">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataButtons.tpl';?>
              </div>
              <?php endif;?>
              <?php if(isset($this->newlabelActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('store.new', 1)):?>
              <div class="estore_sgrid_newlabel">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_newLabel.tpl';?>
              </div>
              <?php endif;?>
            </div>
            <div class="estore_grid_info">
              <?php if(isset($this->titleActive)): ?>
              <?php 
                $title = '';
                $titleLimit = $this->params['title_truncation'];
                if(strlen($store->getTitle()) > $titleLimit):
                  $title = mb_substr($store->getTitle(),0,$titleLimit).'...';
                else:
                  $title = $store->getTitle();
                endif;
              ?>
                <div class="_title"> <a href="<?php echo $store->getHref();?>"><?php echo $title; ?></a>
              <?php endif;?>
              <?php if(isset($this->verifiedLabelActive)&& $store->verified):?>
                <i class="estore_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
              <?php endif;?>
              </div>
              <?php $item = $store;  if(isset($this->ratingActive)):?>
              <div class="estore_sgrid_rating">
                <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_rating.tpl';?>
              </div>
              <?php endif;?>
              <div class="sesbasic_clearfix">
                <div class="_stats sesbasic_text_light">
                  <?php if(ESTORESHOWUSERDETAIL == 1 && isset($this->byActive)):  ?>
                  <span class="_owner_name"><i class="far fa-user"></i><?php echo $this->translate('By');?>&nbsp;<span><?php echo $this->htmlLink($viewer->getHref(), $viewer->getTitle());?></span></span>
                  <?php endif;?>
                </div>
                <div class="_stats  sesbasic_text_light">
                  <?php if(isset($this->creationDateActive)):?>
                  <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_date.tpl';?>
                  <?php endif;?>
                </div>
                <div class="_stats sesbasic_text_light">
                  <?php if (!empty($store->category_id)): ?>
                  <?php $category = Engine_Api::_ ()->getDbtable('categories', 'estore')->find($store->category_id)->current();?>
                  <?php endif;?>
                </div>
                <?php if(isset($category) && isset($this->categoryActive)):?>
                <div class="_stats _category sesbasic_text_light sesbasic_clearfix"><i class="far fa-folder-open"></i><span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span> </div>
                <?php endif;?>
                <?php if(isset($this->locationActive) && $store->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1)):?>
                <div class="_stats sesbasic_text_light"> <i class="fa fa-map-marker-alt sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i><span title="<?php echo $store->location;?>">
                  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && Engine_Api::_()->getApi('settings','core')->getSetting('estore.enable.map.integration', 1)):?>
                  <a href="<?php echo $this->url(array('resource_id' => $store->store_id,'resource_type'=>'stores','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $store->location;?></a>
                  <?php else:?>
                  <?php echo $store->location;?>
                  <?php endif;?>
                  </span> </div>
                <?php endif;?>
                <div class="_stats _location sesbasic_text_light">
                  <?php include APPLICATION_PATH .  '/application/modules/Estore/views/scripts/_dataStatics.tpl';?>
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
        <div class="sesbasic_tip clearfix"> <img src="<?php echo Engine_Api::_()->estore()->getFileUrl(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_store_no_photo', 'application/modules/Estore/externals/images/store-icon.png')); ?>" alt="" /> <span class="sesbasic_text_light"> <?php echo $this->translate('There are no results that match your search. Please try again.') ?> </span> </div>
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
<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > <a href="javascript:void(0);" id="feed_viewmore_link_<?php echo $randonNumber; ?>" class="sesbasic_animation estore_link_btn"><i class="fa fa-sync"></i><span><?php echo $this->translate('View More'); ?></span></a> </div>
<div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="estore_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>
<?php } ?>
<?php } ?>
<script type="text/javascript">
    <?php if($this->params['pagging'] == 'auto_load'){ ?>
      window.addEvent('load', function() { 
        sesJqueryObject (window).scroll(function() {
            var containerId = '#scrollHeightDivSes_<?php echo $randonNumber;?>';
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
        if ($('view_more_<?php echo $randonNumber; ?>')){
          $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginatorCategory->count() == 0 ? 'none' : ($this->paginatorCategory->count() == $this->paginatorCategory->getCurrentPageNumber() ? 'none' : '' )) ?>";
        }
    }
    function viewMore_<?php echo $randonNumber; ?>(){
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
