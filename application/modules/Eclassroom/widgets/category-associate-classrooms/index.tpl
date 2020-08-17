<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Eclassroom/externals/styles/styles.css'); ?>
<?php // Carousel Layout ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js');?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/scripts/slick/slick.js') ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $width = $this->params['width'];?>
<?php if(!is_numeric($width)):?>
  <?php $width = explode('px', $this->params['width'])[0];?>
<?php endif;?>
<?php  $randonNumber = $this->widgetId;?>
<?php if($this->params['view_type'] == 'carousel'):?>
    <?php if(!$this->is_ajax){ ?>
      <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear eclassrooms_listing">
       <?php } ?>
        <div class="eclassroom_category_classrooms sesbasic_bxs sesbasic_clearfix">
          <div class="sesbasic_loading_cont_overlay"></div>
      <?php foreach( $this->paginatorCategory as $category):?>
        <div class="_row sesbasic_clearfix eclassroom_carousel_h_wrapper">
          <div class="_head sesbasic_clearfix">
            <span class="_catname floatL">
              <a href="<?php echo $category->getHref();?>"><?php echo $category->category_name;?></a>
              <?php if(isset($this->countClassroomActive)):?><span class="bold">(<?php echo $category->total_classroom_categories;?>)</span><?php endif;?>  
            </span>
            <?php if(isset($this->seeAllActive)):?>
            <span class="_morebtn <?php echo $this->params['allignment_seeall'] == 'right' ?  'floatR' : 'floatL'; ?>"><a href="<?php echo $this->url(array('action'=> 'browse'),'eclassroom_general', true).'?category_id='.$category->category_id;?>" class="eclassroom_link_btn sesbasic_link_btn"><?php echo $this->translate('See All');?></a></span>
            <?php endif;?>
          </div>
          <div class="_list eclassroom_classroom_carousel slider" data-width="<?php echo $width ?>" rel="<?php echo $category->total_classroom_categories;?>">
            <?php foreach($this->resultArray['classroom_data'][$category->category_id]  as $classroom):?>
              <div class="eclassroom_grid_item _iscatitem <?php if((isset($this->socialSharingActive))):?>_isbtns<?php endif;?>" style="width:<?php echo $width ?>px;">
                <article>
					<?php	$dayIncludeTime = strtotime(date("Y-m-d H:i:s", strtotime('+'.(Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer(), 'classroom', 'newBsduration')*24).' hours', strtotime($classroom->creation_date))));
					$currentTime = strtotime(date("Y-m-d H:i:s"));
        ?>
      <div class="_thumb eclassroom_thumb" style="height:<?php echo $height ?>px;"> 
        <a href="<?php echo $classroom->getHref();?>" class="eclassroom_thumb_img"><span style="background-image:url(<?php echo $classroom->getCoverPhotoUrl() ?>);"></span></a>
      <a href="javascript:;" class="_cover_link"></a>
      <div class="eclassroom_list_labels sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataLabel.tpl';?>
      </div>      
      <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)):?>
      <div class="_btns sesbasic_animation">
        <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataButtons.tpl';?>
      </div>
      <?php endif;?>
      <?php if(!empty($title)):?>
      <div class="_thumbinfo">
        <div>
          <div class="eclassroom_profile_isrounded"> <a href="<?php echo $classroom->getHref();?>" class="eclassroom_thumb_img"><span class="bg_item_photo" style="background-image:url(<?php echo $classroom->getPhotoUrl('thumb.icon'); ?>);"></span></a></div>
          <div class="_title"> <a href="<?php echo $classroom->getHref();?>"><?php echo $title; ?></a>
            <div class="_date">
              <?php if(ECLASSROOMSHOWUSERDETAIL == 1 && isset($this->byActive)):?>
              <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(), $owner->getTitle());?></span>
              <?php endif;?>
              <?php if(isset($this->creationDateActive)):?>
              -&nbsp;
              <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_date.tpl';?>
              <?php endif;?>
            </div>
          </div>
        </div>
      </div>
      <?php endif;?>
    </div>
    <div class="eclassroom_grid_info">
      <?php if(isset($this->verifiedLabelActive) && $classroom->verified):?>
        <div class="eclassroom_verify"> <i class="eclassroom_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i> </div>
      <?php endif;?>
      <div class="sesbasic_clearfix"> 
        <?php if(isset($category) && isset($this->categoryActive)):?>
        <div class="_stats _category sesbasic_text_light sesbasic_clearfix"> <i class="fa fa-folder-open"></i> <span><?php echo $this->translate('in');?>&nbsp;<a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span> </div>
        <?php endif;?>
        <?php if(isset($this->ratingActive)): ?>
            <div class="eclassroom_sgrid_rating">
                <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/rating.tpl';?>
            </div>
        <?php endif;?>
        <div class="_stats sesbasic_text_light">
          <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataStatics.tpl';?>
        </div>
        <?php if(isset($this->locationActive) && $classroom->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1)):?>
        <div class="_stats sesbasic_text_light _location"> <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>">  </i> <span title="<?php echo $classroom->location;?>">
          <?php if(Engine_Api::_()->getApi('settings','core')->getSetting('eclassroom.enable.map.integration', 1)):?>
          <a href="<?php echo $this->url(array('resource_id' => $classroom->classroom_id,'resource_type'=>'classrooms','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $classroom->location;?></a>
          <?php else:?>
          <?php echo $classroom->location;?>
          <?php endif;?>
          </span> 
        </div>
        <?php endif;?>
        <?php if($descriptionLimit):?>
        <div class="_des sesbasic_clearfix"><?php echo $this->string()->truncate($this->string()->stripTags($classroom->description), $descriptionLimit) ?></div>
        <?php endif;?>
        <div class="eclassroom_grid_share">
          <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataSharing.tpl';?>
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
        <div id="eclassroom_category_classrooms_<?php echo $randonNumber;?>" class="">
            <div id="error-message_<?php echo $randonNumber;?>">
                <div class="sesbasic_tip clearfix">
                    <img src="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom_classroom_no_photo', 'application/modules/Eclassroom/externals/images/classroom-icon.png'); ?>" alt="" />
                    <span class="sesbasic_text_light">
                    <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
                    </span>
                </div>
            </div>
        </div>
    <?php endif;?>
    <?php if($this->params['pagging'] == 'pagging'){ ?>
        <?php echo $this->paginationControl($this->paginatorCategory, null, array("_pagging.tpl", "eclassroom"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
    
    </div>	
    <?php if(!$this->is_ajax){ ?>
     </div>
     <?php if($this->params['pagging'] != 'pagging'){ ?>  
   <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
  	<a href="javascript:void(0);" id="feed_viewmore_link_<?php echo $randonNumber; ?>" class="sesbasic_animation sesbasic_link_btn eclassroom_link_btn"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More'); ?></span></a>
  </div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="eclassroom_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
  <?php } ?>
  <?php } ?>
<?php elseif($this->params['view_type'] == 'grid'):?>
  <div class="sesbasic_bxs sesbasic_clearfix eclassroom_category_grid_layout">
    <?php foreach( $this->paginatorCategory as $category): ?>
    <div class="_item" style="width:<?php echo $width ?>px;">
        <article class="sesbasic_animation">
          <header class="sesbasic_clearfix">
            <?php if(isset($this->seeAllActive)):?>
              <span class="_seeall"><a href="<?php echo $this->url(array('action'=> 'browse'),'eclassroom_general', true).'?category_id='.$category->category_id;?>"><?php echo $this->translate('See All');?></a></span>
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
                 <?php if(isset($this->countClassroomActive)):?><span class="bold">(<?php echo $category->total_classroom_categories;?>)</span><?php endif;?>  
              </a>
             </span>
            <?php if(isset($this->categoryDescriptionActive)):?>
              <p><?php echo $this->string()->truncate($this->string()->stripTags($category->description), $this->params['grid_description_truncation']) ?></p>
            <?php endif;?>
          </header>
          <div class="_cont">
    <?php foreach($this->resultArray['classroom_data'][$category->category_id] as $classroom):?>
            <?php if(isset($this->titleActive)):?>
              <?php if(strlen($classroom->getTitle()) > $this->params['title_truncation']):?>
                <?php $title = mb_substr($classroom->getTitle(),0,$this->params['title_truncation']).'...';?>
              <?php else: ?>
                <?php $title = $classroom->getTitle();?>
              <?php endif; ?>
              <div class="_pagelist">
                <a href="<?php echo $classroom->getHref(); ?>">
                	<i class="fa fa-angle-right sesbasic_text_light"></i>
									<?php echo $this->itemPhoto($classroom, 'thumb.icon', $classroom->getTitle());?>
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
  <div class="eclassroom_category_classrooms sesbasic_bxs sesbasic_clearfix">
    <div class="sesbasic_loading_cont_overlay"></div>
      <?php foreach( $this->paginatorCategory as $category): ?>
        <div class="_row sesbasic_clearfix eclassroom_carousel_h_wrapper">
          <div class="_head sesbasic_clearfix">
            <span class="_catname floatL">
            	<a href="<?php echo $category->getHref();?>"><?php echo $category->category_name;?></a>
            	<?php if(isset($this->countClassroomActive)):?><span>(<?php echo $category->total_classroom_categories;?>)</span><?php endif;?>  
            </span>
            <?php if(isset($this->seeAllActive)):?>
              <span class="_morebtn <?php echo $this->params['allignment_seeall'] == "right" ?  "floatR" : "floatL"; ?>"><a href="<?php echo $this->url(array('action'=> 'browse'),'eclassroom_general', true).'?category_id='.$category->category_id;?>" class="eclassroom_link_btn sesbasic_link_btn"><?php echo $this->translate('See All');?></a></span>
            <?php endif;?>
          </div>
          <div class="_list eclassroom_category_slideshow slider" data-width="<?php echo $width ?>" rel="<?php echo $category->total_classroom_categories;?>">
      <?php foreach( $this->resultArray['classroom_data'][$category->category_id] as $classroom):?>
        <div class="eclassroom_list_item sesbasic_clearfix">
          <article class="sesbasic_clearfix">
              <div class="_thumb eclassroom_thumb" style="height:<?php echo $this->params['height'] ?>px;width:<?php echo $this->params['width'] ?>px;">
              <?php $href = $classroom->getHref();$imageURL = $classroom->getPhotoUrl('thumb.profile');?>
              <a href="<?php echo $href; ?>" class="eclassroom_thumb_img"><span style="background-image:url(<?php echo $imageURL; ?>);"></span></a>
              <?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)){ ?>
                <div class="eclassroom_list_labels sesbasic_animation">
                  <?php if(isset($this->featuredLabelActive) && $classroom->featured){ ?>
                    <span class="eclassroom_label_featured" title="<?php echo $this->translate('Featured');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                  <?php if(isset($this->sponsoredLabelActive) && $classroom->sponsored){ ?>
                    <span class="eclassroom_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                  <?php if(isset($this->hotLabelActive) && $classroom->hot){ ?>
                      <span class="eclassroom_label_hot" title="<?php echo $this->translate('Hot');?>"><i class="fa fa-star"></i></span>
                  <?php } ?>
                </div>
              <?php } ?>
              <?php if(isset($this->likeButtonActive) || isset($this->favouriteButtonActive) || isset($this->followButtonActive)): ?>
                <div class="_btns sesbasic_animation">
                  <?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataButtons.tpl';?>
                </div>
              <?php endif;?>
            </div>
            <div class="_cont">
              <?php if(isset($this->titleActive) ): ?>
                <?php if(strlen($classroom->getTitle()) > $this->params['title_truncation']):?>
                  <?php $title = mb_substr($classroom->getTitle(),0,$this->params['title_truncation']).'...';?>
                <?php else: ?>
                  <?php $title = $classroom->getTitle();?>
                <?php endif; ?>
                <div class="_title">
                  <?php echo $this->htmlLink($classroom->getHref(),$classroom->getTitle()) ?>
                  <?php if(isset($this->verifiedLabelActive) && $classroom->verified): ?>
                  <i class="eclassroom_label_verified sesbasic_verified_icon" title='<?php echo $this->translate("Verified");?>'></i>
                  <?php endif; ?>
                </div>
              <?php endif; ?>
              <div class="_continner">
              	<div class="_continnerleft">
                  <?php $owner = $classroom->getOwner(); ?>	
                    <?php  if(isset($this->byActive)): ?>
                    <div class="_owner sesbasic_text_light">
                      <span class="_owner_img">
                        <?php echo $this->htmlLink($owner->getHref(), $this->itemPhoto($owner, 'thumb.icon', $owner->getTitle()), array('title'=>$owner->getTitle())) ?>
                      </span>
                      <span class="_owner_name"><?php echo $this->translate('by');?>&nbsp;<?php echo $this->htmlLink($owner->getHref(),$owner->getTitle() ) ?></span>
                      <span class="_date" title="">-&nbsp;<?php echo date('jS M', strtotime($classroom->creation_date));?>,&nbsp;<?php echo date('Y', strtotime($classroom->creation_date));?></span>
                     </div>
                  <?php endif; ?>
                  <?php if($this->ratingActive): ?>
                    <div class="sesbasic_rating_star">
                        <?php  include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/rating.tpl';?>
                    </div>
                  <?php endif;?>
                  <div class="_stats sesbasic_text_light">
                    <span><?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataStatics.tpl';?></span>
                  </div>
                  
                  <?php if(isset($this->locationActive) && $classroom->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1)):?>
                    <div class="_stats _location sesbasic_text_light">  
                      <i class="fa fa-map-marker sesbasic_text_light" title="<?php echo $this->translate('Location');?>"></i>
                      <span title="<?php echo $classroom->location;?>"><?php if(Engine_Api::_()->getApi('settings','core')->getSetting('eclassroom.enable.map.integration', 1)):?><a href="<?php echo $this->url(array('resource_id' => $classroom->classroom_id,'resource_type'=>'classroom','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $classroom->location;?></a><?php else:?><?php echo $classroom->location;?><?php endif;?></span>
                    </div>
                  <?php endif;?>
                  <div class="_stats sesbasic_clearfix _middleinfo">
                    <?php if(isset($category) && isset($this->categoryActive)):?>
                      <div><i class="fa fa-folder-open sesbasic_text_light"></i> <span><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a></span></div>
                    <?php endif;?>
                  </div>
                  <?php if(isset($this->descriptionActive)):?>
                    <div class="_des">
                      <?php echo $this->string()->truncate($this->string()->stripTags($classroom->description), $this->params['slideshow_description_truncation']) ?>
                    </div>
                  <?php endif;?>
              	</div>
                <?php if(isset($this->contactDetailActive) && ((isset($classroom->classroom_contact_phone) && $classroom->classroom_contact_phone) || (isset($classroom->classroom_contact_email) && $classroom->classroom_contact_email) || (isset($classroom->classroom_contact_website) && $classroom->classroom_contact_website))):?>
                  <div class="_continnerright">
                    <div class="eclassroom_list_contact_btns sesbasic_clearfix">
                      <?php if($classroom->classroom_contact_phone):?>
                        <?php if(EClASSROOMSHOWCONTACTDETAIL == 1):?>
                          <a href="javascript:void(0);" onclick="sessmoothboxDialoge('<?php echo $classroom->classroom_contact_phone ;?>');"><?php echo $this->translate("View Phone No")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'eclassroom_general',true);?>" class="smoothbox eclassroom_link_btn"><?php echo $this->translate("View Phone No")?></a>
                        <?php endif;?>
                      <?php endif;?>
                      <?php if($classroom->classroom_contact_email):?>
                        <?php if(EClASSROOMSHOWCONTACTDETAIL == 1):?>
                          <a href='mailto:<?php echo $classroom->classroom_contact_email ?>'><?php echo $this->translate("Send Email")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'eclassroom_general',true);?>" class="smoothbox eclassroom_link_btn"><?php echo $this->translate("Send Email")?></a>
                        <?php endif;?>
                      <?php endif;?>
                      <?php if($classroom->classroom_contact_website):?>
                        <?php if(EClASSROOMSHOWCONTACTDETAIL == 1):?>
                          <a href="<?php echo parse_url($classroom->classroom_contact_website, PHP_URL_SCHEME) === null ? 'http://' . $classroom->classroom_contact_website : $classroom->classroom_contact_website; ?>" target="_blank"><?php echo $this->translate("Visit Website")?></a>
                        <?php else:?>
                          <a href="<?php echo $this->url(array('action' => 'show-login-page'),'eclassroom_general',true);?>" class="smoothbox eclassroom_link_btn"><?php echo $this->translate("Visit Website")?></a>
                        <?php endif;?>
                      <?php endif;?>
                    </div>
                  </div>
                <?php endif;?>
              </div>  
              <div class="_footer">
              	<?php include APPLICATION_PATH .  '/application/modules/Eclassroom/views/scripts/_dataSharing.tpl';?>
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
            'url': en4.core.baseUrl + "widget/index/mod/eclassroom/name/<?php echo $this->widgetName; ?>",
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
            'url': en4.core.baseUrl + "widget/index/mod/eclassroom/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
