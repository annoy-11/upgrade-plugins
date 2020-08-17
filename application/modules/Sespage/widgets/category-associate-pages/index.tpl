<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?>
<?php // Carousel Layout ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/scripts/slick/slick.js') ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $width = $this->params['width'];?>
<?php if(!is_numeric($width)):?>
  <?php $width = explode('px', $this->params['width'])[0];?>
<?php endif;?>
<?php  $randonNumber = $this->widgetId;?>
<?php if($this->params['view_type'] == 'carousel'):?>
    <?php if(!$this->is_ajax){ ?>
      <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear sespage_categories_pages_listing_container">
       <?php } ?>
        <div class="sespage_category_pages sesbasic_bxs sesbasic_clearfix">
          <div class="sesbasic_loading_cont_overlay"></div>
      <?php foreach( $this->paginatorCategory as $category):?>
        <div class="_row sesbasic_clearfix sespage_carousel_h_wrapper">
          <div class="_head sesbasic_clearfix">
            <span class="_catname floatL">
              <a href="<?php echo $category->getHref();?>"><?php echo $category->category_name;?></a>
              <?php if(isset($this->countPageActive)):?><span class="bold">(<?php echo $category->total_page_categories;?>)</span><?php endif;?>  
            </span>
            <?php if(isset($this->seeAllActive)):?>
            <span class="_morebtn <?php echo $this->params['allignment_seeall'] == 'right' ?  'floatR' : 'floatL'; ?>"><a href="<?php echo $this->url(array('action'=> 'browse'),'sespage_general', true).'?category_id='.$category->category_id;?>" class="sesbasic_link_btn"><?php echo $this->translate('See All');?></a></span>
            <?php endif;?>
          </div>
          <div class="_list sespage_page_carousel slider" data-width="<?php echo $width ?>" rel="<?php echo $category->total_page_categories;?>">
            <?php foreach($this->resultArray['page_data'][$category->category_id]  as $page):?>
              <div class="sespage_grid_item _iscatitem <?php if((isset($this->socialSharingActive))):?>_isbtns<?php endif;?>" style="width:<?php echo $width ?>px;">
                <article>
                  <div class="_thumb sespage_thumb" style="height:<?php echo $this->params['height'] ?>">
                    <?php $href = $page->getHref();?>
                    <a href="<?php echo $href; ?>" class="sespage_thumb_img">
                        <span class="sesbasic_animation" style="background-image:url(<?php echo $page->getPhotoUrl('thumb.profile'); ?>);"></span>
                    </a>
                    <a href="<?php echo $page->getHref();?>" class="_thumblink"></a>
                    <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive) || isset($this->hotLabelActive)){ ?>
                      <div class="sespage_list_labels sesbasic_animation">
                      <?php if(isset($this->featuredLabelActive) && $page->featured){ ?>
                          <span class="sespage_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
                      <?php } ?>
                      <?php if(isset($this->sponsoredLabelActive) && $page->sponsored){ ?>
                          <span class="sespage_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
                      <?php } ?>
                      <?php if(isset($this->hotLabelActive) && $page->hot){ ?>
                          <span class="sespage_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
                      <?php } ?>
                      </div>
                    <?php } ?>
                    <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
                      <div class="_btns sesbasic_animation">
                        <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?>
                      </div>
                    <?php endif;?>
                    <?php if(isset($this->titleActive) ){ ?>
                      <div class="_thumbinfo">
                        <div>
                          <div class="_title">
                            <?php if(strlen($page->getTitle()) > $this->params['title_truncation']):?>
                            <?php $title = mb_substr($page->getTitle(),0,$this->params['title_truncation']).'...';?>
                            <?php else: ?>
                            <?php $title = $page->getTitle();?>
                            <?php endif; ?>
                            <?php echo $this->htmlLink($page->getHref(),$title) ?><?php if(isset($this->verifiedLabelActive)&& $page->verified):?><i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i><?php endif;?>
                          </div>
                        </div>  
                      </div>
                    <?php } ?>
                  </div>
                  <div class="_cont sesbasic_clearfix">
                    <?php $owner = $page->getOwner(); ?>
                    <?php if(SESPAGESHOWUSERDETAIL == 1 && isset($this->byActive)){ ?>
                      <div class="_owner sesbasic_text_light">
                        <?php if(isset($this->byActive)):?>
                          <span class="_owner_img">
                            <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                          </span>
                          <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span>
                        <?php endif;?>
                        <span class="_date" title="">-&nbsp;<?php echo date('jS M', strtotime($page->creation_date));?>,&nbsp;<?php echo date('Y', strtotime($page->creation_date));?></span>
                        <?php if(isset($this->priceActive)):?>
                          <div class="_price sespage_button">
                            <i class="fa fa-usd"></i><span><?php echo $page->price;?></span>
                          </div>
                        <?php endif;?>
                      </div>
                     <?php  } ?>
                     
                     <?php if(isset($this->likeActive) || isset($this->commentActive) || isset($this->viewActive) || isset($this->favouriteActive) || (isset($this->followActive) && isset($page->follow_count)) || (isset($this->memberActive) && isset($page->member_count))):?>
                      <div class="_stats sesbasic_text_light">
                        <i class="fa fa-bar-chart"></i>
                        <span><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?></span>
                      </div>
                    <?php endif;?>
                    <?php if(isset($this->locationActive) && $page->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage_enable_location', 1)):?>
                      <div class="_stats sesbasic_text_light _location">
                          <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                          <span title="<?php echo $page->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sespage.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $page->page_id,'resource_type'=>'sespage_page','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $page->location;?></a><?php else:?><?php echo $page->location;?><?php endif;?></span>
                      </div>
                    <?php endif;?>
                    <?php if(isset($this->contactDetailActive) && ((isset($page->page_contact_phone) && $page->page_contact_phone) || (isset($page->page_contact_email) && $page->page_contact_email) || (isset($page->page_contact_website) && $page->page_contact_website))):?>
                      <div class="_contactlinks sesbasic_clearfix sesbasic_animation">
                        <?php if($page->page_contact_phone):?>
                          <span>
                            <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                              <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $page->page_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                            <?php else:?>
                              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("View Phone No")?></a>
                            <?php endif;?>
                          </span>
                        <?php endif;?>
                        <?php if($page->page_contact_email):?>
                          <span>
                            <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                              <a href='mailto:<?php echo $page->page_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                            <?php else:?>
                              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Send Email")?></a>
                            <?php endif;?>
                          </span>
                        <?php endif;?>
                        <?php if($page->page_contact_website):?>
                          <span>
                            <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                              <a href="<?php echo parse_url($page->page_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $page->page_contact_website : $page->page_contact_website; ?>" target="_blank" ><?php echo $this->translate("Visit Website")?></a>
                            <?php else:?>
                              <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox"><?php echo $this->translate("Visit Website")?></a>
                            <?php endif;?>
                          </span>
                        <?php endif;?>
                      </div>
                    <?php endif;?>
                  </div>
                  <?php if((isset($this->socialSharingActive))):?>
                    <div class="_sharebuttons sesbasic_clearfix">
                      <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataSharing.tpl';?>
                    </div>
                 <?php endif; ?>
              	</article>
              </div>
            <?php endforeach; ?>
        	</div>
      	</div>
    <?php endforeach; ?>
    <?php if($this->paginatorCategory->getTotalItemCount() == 0 && !$this->is_ajax):  ?>
        <div id="sespage_category_pages_<?php echo $randonNumber;?>" class="">
            <div id="error-message_<?php echo $randonNumber;?>">
                <div class="sesbasic_tip clearfix">
                    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage_page_no_photo', 'application/modules/Sespage/externals/images/page-icon.png'); ?>" alt="" />
                    <span class="sesbasic_text_light">
                    <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif;?>
    <?php if($this->params['pagging'] == 'pagging'){ ?>
        <?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "sespage"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
    
    </div>	
    <?php if(!$this->is_ajax){ ?>
     </div>
     <?php if($this->params['pagging'] != 'pagging'){ ?>  
   <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
  	<a href="javascript:void(0);" id="feed_viewmore_link_<?php echo $randonNumber; ?>" class="sesbasic_animation sesbasic_link_btn"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More'); ?></span></a>
  </div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
  <?php } ?>
  <?php } ?>
<?php elseif($this->params['view_type'] == 'grid'):?>
  <div class="sesbasic_bxs sesbasic_clearfix sespage_category_grid_layout">
    <?php foreach( $this->paginatorCategory as $category): ?>
    <div class="_item" style="width:<?php echo $width ?>px;">
        <article class="sesbasic_animation">
          <header class="sesbasic_clearfix">
            <?php if(isset($this->seeAllActive)):?>
              <span class="_seeall"><a href="<?php echo $this->url(array('action'=> 'browse'),'sespage_general', true).'?category_id='.$category->category_id;?>"><?php echo $this->translate('See All');?></a></span>
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
              </a>
             </span>
            <?php if(isset($this->categoryDescriptionActive)):?>
              <p><?php echo $this->string()->truncate($this->string()->stripTags($category->description), $this->params['grid_description_truncation']) ?></p>
            <?php endif;?>
          </header>
          <div class="_cont">
    <?php foreach($this->resultArray['page_data'][$category->category_id] as $page):?>
            <?php if(isset($this->titleActive)):?>
              <?php if(strlen($page->getTitle()) > $this->params['title_truncation']):?>
                <?php $title = mb_substr($page->getTitle(),0,$this->params['title_truncation']).'...';?>
              <?php else: ?>
                <?php $title = $page->getTitle();?>
              <?php endif; ?>
              <div class="_pagelist">
                <a href="<?php echo $page->getHref(); ?>">
                	<i class="fa fa-angle-right sesbasic_text_light"></i>
									<?php echo $this->itemPhoto($page, 'thumb.icon', $page->getTitle());?>
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
  <div class="sespage_category_pages sesbasic_bxs sesbasic_clearfix">
    <div class="sesbasic_loading_cont_overlay"></div>
      <?php foreach( $this->paginatorCategory as $category): ?>
        <div class="_row sesbasic_clearfix sespage_carousel_h_wrapper">
          <div class="_head sesbasic_clearfix">
            <span class="_catname floatL">
            	<a href="<?php echo $category->getHref();?>"><?php echo $category->category_name;?></a>
            	<?php if(isset($this->countPageActive)):?><span>(<?php echo $category->total_page_categories;?>)</span><?php endif;?>  
            </span>
            <?php if(isset($this->seeAllActive)):?>
              <span class="_morebtn <?php echo $this->params['allignment_seeall'] == "right" ?  "floatR" : "floatL"; ?>"><a href="<?php echo $this->url(array('action'=> 'browse'),'sespage_general', true).'?category_id='.$category->category_id;?>" class="sesbasic_link_btn"><?php echo $this->translate('See All');?></a></span>
            <?php endif;?>
          </div>
          <div class="_list sespage_category_slideshow slider" data-width="<?php echo $width ?>" rel="<?php echo $category->total_page_categories;?>">
      <?php foreach( $this->resultArray['page_data'][$category->category_id] as $page):?>
        <div class="sespage_list_item sesbasic_clearfix">
          <article class="sesbasic_clearfix sesbasic_bg">
              <div class="_thumb sespage_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
              <?php $href = $page->getHref();$imageURL = $page->getPhotoUrl('thumb.profile');?>
              <a href="<?php echo $href; ?>" class="sespage_thumb_img"><span style="background-image:url(<?php echo $imageURL; ?>);"></span></a>
              <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
                <div class="sespage_list_labels sesbasic_animation">
                  <?php if(isset($this->featuredLabelActive) && $page->featured){ ?>
                    <span class="sespage_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                  <?php if(isset($this->sponsoredLabelActive) && $page->sponsored){ ?>
                    <span class="sespage_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                  <?php if(isset($this->hotLabelActive) && $page->hot){ ?>
                      <span class="sespage_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                </div>
              <?php } ?>
              <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
                <div class="_btns sesbasic_animation">
                  <?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataButtons.tpl';?>
                </div>
              <?php endif;?>
            </div>
            <div class="_cont">
              <?php if(isset($this->titleActive) ): ?>
                <?php if(strlen($page->getTitle()) > $this->params['title_truncation']):?>
                  <?php $title = mb_substr($page->getTitle(),0,$this->params['title_truncation']).'...';?>
                <?php else: ?>
                  <?php $title = $page->getTitle();?>
                <?php endif; ?>
                <div class="_title">
                  <?php echo $this->htmlLink($page->getHref(),$page->getTitle()) ?>
                  <?php if(isset($this->verifiedLabelActive) && $page->verified): ?>
                  <i class="sespage_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="_continner">
              	<div class="_continnerleft">
                  <?php $owner = $page->getOwner(); ?>	
                    <?php if(isset($this->byActive)): ?>
                    <div class="_owner sesbasic_text_light">
                      <span class="_owner_img">
                        <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                      </span>
                      <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span>
                      <span class="_date" title="">-&nbsp;<?php echo date('jS M', strtotime($page->creation_date));?>,&nbsp;<?php echo date('Y', strtotime($page->creation_date));?></span>
                     </div>
                  <?php endif; ?>
                  <div class="_stats sesbasic_text_light">
                    <i class="fa fa-bar-chart"></i>
                    <span><?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataStatics.tpl';?></span>
                  </div>
                  <?php if(isset($this->locationActive) && $page->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage_enable_location', 1)):?>
                    <div class="_stats _location sesbasic_text_light">  
                      <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                      <span title="<?php echo $page->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('sespage.enable.map.integration', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)):?><a href="<?php echo $this->url(array('resource_id' => $page->page_id,'resource_type'=>'sespage_page','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $page->location;?></a><?php else:?><?php echo $page->location;?><?php endif;?></span>
                    </div>
                  <?php endif;?>
                  <div class="sesbasic_clearfix _middleinfo">
                    <?php if(isset($category) && isset($this->categoryActive)):?>
                      <div><i class="fa fa-folder-open sesbasic_text_light"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
                    <?php endif;?>
                    <?php if(isset($this->priceActive) && $page->price):?>
                      <div><i class="fa fa-usd sesbasic_text_light"></i><span><?php echo $page->price;?></span></div>
                    <?php endif;?>
                  </div>
                  <?php if(isset($this->descriptionActive)):?>
                    <div class="_des">
                      <?php echo $this->string()->truncate($this->string()->stripTags($page->description), $this->params['slideshow_description_truncation']) ?>
                    </div>
                  <?php endif;?>
                </div>
                <?php if(isset($this->contactDetailActive) && ((isset($page->page_contact_phone) && $page->page_contact_phone) || (isset($page->page_contact_email) && $page->page_contact_email) || (isset($page->page_contact_website) && $page->page_contact_website))):?>
									<div class="_continnerright">
                    <div class="sespage_list_contact_btns sesbasic_clearfix">
                      <?php if($page->page_contact_phone):?>
                        <div class="sesbasic_clearfix">
                          <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                            <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $page->page_contact_phone ;?>');" class="sesbasic_link_btn"><?php echo $this->translate("View Phone No")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("View Phone No")?></a>
                          <?php endif;?>
                        </div>
                      <?php endif;?>
                      <?php if($page->page_contact_email):?>
                        <div class="sesbasic_clearfix">
                          <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                            <a href='mailto:<?php echo $page->page_contact_email ?>' class="sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Send Email")?></a>
                          <?php endif;?>
                        </div>
                      <?php endif;?>
                      <?php if($page->page_contact_website):?>
                        <div class="sesbasic_clearfix">
                          <?php if(SESPAGESHOWCONTACTDETAIL == 1):?>
                            <a href="<?php echo parse_url($page->page_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $page->page_contact_website : $page->page_contact_website; ?>" class="sesbasic_link_btn" target="_blank" ><?php echo $this->translate("Visit Website")?></a>
                          <?php else:?>
                            <a href="<?php echo $this->url(array('action' => 'show-login-page'),'sespage_general',true);?>" class="smoothbox sesbasic_link_btn"><?php echo $this->translate("Visit Website")?></a>
                          <?php endif;?>
                        </div>
                      <?php endif;?>
                    </div>
                	</div>
              	<?php endif;?>    
              </div>
              <div class="_footer sesbasic_clearfix">
              	<?php include APPLICATION_PATH .  '/application/modules/Sespage/views/scripts/_dataSharing.tpl';?>
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
    <?php if($this->loadOptionData == 'auto_load'){ ?>
        window.addEvent('load', function() {
        sesJqueryObject (window).scroll( function() {
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
    <?php } ?>
    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
        sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
        (new Request.HTML({
            method: 'post',
            'url': en4.core.baseUrl + "widget/index/mod/sespage/name/<?php echo $this->widgetName; ?>",
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
                makeSespageSlidesObject();
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
            'url': en4.core.baseUrl + "widget/index/mod/sespage/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
            'data': {
                format: 'html',
                page: <?php echo $this->page + 1; ?>,    
                is_ajax : 1,
                widget_id: '<?php echo $randonNumber; ?>',
            },
            onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
                document.getElementById('scrollHeightDivSes_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('scrollHeightDivSes_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
                document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
                makeSespageSlidesObject();
            }
        })).send();
        return false;
    }
</script>
