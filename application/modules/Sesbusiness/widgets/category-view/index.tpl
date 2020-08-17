<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $randonNumber = $this->widgetId; ?>
<?php $width = $this->params['width'];?>
<?php $height = $this->params['height'];?>
<?php $showFollowButton = 0;?>
<?php if($this->viewer()->getIdentity() && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.allowfollow.category', 1)):?>
 <?php $showFollowButton = 1;?>
<?php endif;?>
<?php if($showFollowButton):?>
  <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->isFollow(array('resource_id' => $this->category->category_id,'resource_type' => 'sesbusiness_category')); ?>
  <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
  <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if(isset($this->category->thumbnail) && !empty($this->category->thumbnail)){ ?>
  <div class="sesbusiness_category_cover sesbasic_bxs sesbm sesbasic_bxs">
    <div class="sesbusiness_category_cover_inner">
    	<div class="sesbusiness_category_cover_img" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);"></div>
      <div class="sesbusiness_category_cover_content">
        <div class="sesbusiness_category_cover_breadcrumb">
          <!--breadcrumb -->
          <a href="<?php echo $this->url(array('action' => 'browse'), "sesbusiness_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
          <?php if(isset($this->breadcrumb['category'][0]->category_id)){ ?>
             <?php if($this->breadcrumb['subcategory']) { ?>
              <a href="<?php echo $this->breadcrumb['category'][0]->getHref(); ?>"><?php echo $this->breadcrumb['category'][0]->category_name ?></a>
             <?php }else{ ?>
               <?php echo $this->breadcrumb['category'][0]->category_name ?>
             <?php } ?>
             <?php if($this->breadcrumb['subcategory']) echo "&nbsp;&raquo"; ?>
          <?php } ?>
          <?php if(isset($this->breadcrumb['subcategory'][0]->category_id)){ ?>
            <?php if($this->breadcrumb['subSubcategory']) { ?>
              <a href="<?php echo $this->breadcrumb['subcategory'][0]->getHref(); ?>"><?php echo $this->breadcrumb['subcategory'][0]->category_name ?></a>
            <?php }else{ ?>
              <?php echo $this->breadcrumb['subcategory'][0]->category_name ?>
            <?php } ?>
            <?php if($this->breadcrumb['subSubcategory']) echo "&nbsp;&raquo"; ?>
          <?php } ?>
          <?php if(isset($this->breadcrumb['subSubcategory'][0]->category_id)){ ?>
            <?php echo $this->breadcrumb['subSubcategory'][0]->category_name ?>
          <?php } ?>
          <?php if($showFollowButton && isset($this->params['show_follow_button']) && $this->params['show_follow_button']):?>
            <a href='javascript:;' data-url='<?php echo $this->category->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation sesbasic_link_btn sesbusiness_category_follow sesbusiness_category_follow_<?php echo $this->category->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a> 
          <?php endif;?>
        </div>
        <div class="sesbusiness_category_cover_blocks">
          <div class="sesbusiness_category_cover_block_img">
            <span style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl(''); ?>);"></span>
          </div>
          <div class="sesbusiness_category_cover_block_info">
            <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
              <div class="sesbusiness_category_cover_title"> 
                <?php echo $this->category->title; ?>
              </div>
            <?php endif; ?>
            <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
              <div class="sesbusiness_category_cover_des clear sesbasic_custom_scroll">
                <p><?php echo nl2br($this->category->description);?></p>
              </div>
            <?php endif; ?>
            <?php if(count($this->paginatorc)){ ?>
              <div class="sesbusiness_category_cover_businesses">
              	<div class="sesbusiness_category_cover_businesses_head">
                 	<?php echo $this->params['pop_title']; ?>
                </div>
               	<?php foreach($this->paginatorc as $businessesCri){ ?>
                  <div class="sesbusiness_category_cover_item sesbasic_animation">
                    <a href="<?php echo $businessesCri->getHref(); ?>" data-src="<?php echo $businessesCri->getGuid(); ?>" class="_thumbimg">
                      <span class="bg_item_photo sesbasic_animation" style="background-image:url(<?php echo $businessesCri->getPhotoUrl('thumb.profile'); ?>);"></span>
                      <div class="_info sesbasic_animation">
                        <div class="_title"><?php echo $businessesCri->getTitle(); ?> </div>
                      </div>
                    </a>
                  </div>
              	<?php }  ?>
              </div>
            <?php	}  ?>
          </div>
        </div>
      </div>
    </div>
  </div>  
<?php } else { ?>
  <div class="sesvide_breadcrumb clear sesbasic_clearfix">
    <!--breadcrumb -->
    <a href="<?php echo $this->url(array('action' => 'browse'), "sesbusiness_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
    <?php if(isset($this->breadcrumb['category'][0]->category_id)){ ?>
       <?php if($this->breadcrumb['subcategory']) { ?>
        <a href="<?php echo $this->breadcrumb['category'][0]->getHref(); ?>"><?php echo $this->breadcrumb['category'][0]->category_name ?></a>
       <?php }else{ ?>
         <?php echo $this->breadcrumb['category'][0]->category_name ?>
       <?php } ?>
       <?php if($this->breadcrumb['subcategory']) echo "&nbsp;&raquo"; ?>
    <?php } ?>
    <?php if(isset($this->breadcrumb['subcategory'][0]->category_id)){ ?>
      <?php if($this->breadcrumb['subSubcategory']) { ?>
        <a href="<?php echo $this->breadcrumb['subcategory'][0]->getHref(); ?>"><?php echo $this->breadcrumb['subcategory'][0]->category_name ?></a>
      <?php }else{ ?>
        <?php echo $this->breadcrumb['subcategory'][0]->category_name ?>
      <?php } ?>
      <?php if($this->breadcrumb['subSubcategory']) echo "&nbsp;&raquo"; ?>
    <?php } ?>
    <?php if(isset($this->breadcrumb['subSubcategory'][0]->category_id)){ ?>
      <?php echo $this->breadcrumb['subSubcategory'][0]->category_name ?>
    <?php } ?>
  </div>
  <div class="sesbusiness_browse_cat_top sesbm">
    <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
      <div class="sesbusiness_catview_title centerT"> 
        <?php echo $this->category->title; ?>
      </div>
    <?php endif; ?>
    <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
      <div class="sesbusiness_catview_des centerT">
        <?php echo nl2br($this->category->description);?>
      </div>
    <?php endif; ?>
    <?php if($showFollowButton && isset($this->params['show_follow_button']) && $this->params['show_follow_button']):?>
      <div class="sesbusiness_catview_button centerT">
        <a href='javascript:;' data-url='<?php echo $this->category->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation sesbasic_link_btn sesbusiness_category_follow sesbusiness_category_follow_<?php echo $this->category->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>
      </div>
    <?php endif;?>
  </div>
  <?php if(count($this->paginatorc)){ ?>
  	<div class="clearfix sesbusiness_category_top_businesses sesbasic_bxs">
    	<div class="sesbusiness_catview_list_title clear sesbasic_clearfix">
      	<span class="_title"><?php echo $this->params['pop_title']; ?></span>
     	</div>
      <ul class="clear sesbasic_clearfix _iscatitem">
      	<?php foreach($this->paginatorc as $business){ ?>
        	<?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/business/_simpleGridView.tpl';?>
        <?php }  ?>
      </ul>
    </div>
  <?php	}  ?>
<?php } ?>

<!-- category subcategory -->
<?php if($this->params['show_subcat'] == 1 && count($this->innerCatData)>0){ ?>
	<div class="sesbusiness_catview_categories sesbasic_clearfix">
    <div class="sesbusiness_catview_list_title clear sesbasic_clearfix">
      <span class="_title"><?php echo $this->params['subcategory_title']; ?></span>
    </div>
    <div class="sesbasic_clearfix">
      <ul class="sesbusiness_category_grid_listing sesbasic_clearfix clear sesbasic_bxs">	
        <?php foreach( $this->innerCatData as $business ): ?>
          <li class="sesbusiness_category_grid sesbm" style="height:<?php echo is_numeric($this->params['heightSubcat']) ? $this->params['heightSubcat'].'px' : $this->params['heightSubcat'] ?>;width:<?php echo is_numeric($this->params['widthSubcat']) ? $this->params['widthSubcat'].'px' : $this->params['widthSubcat'] ?>;">
            <a href="<?php echo $business->getHref(); ?>">
              <div class="sesbusiness_category_grid_img">
                <?php if($business->thumbnail != '' && !is_null($business->thumbnail) && intval($business->thumbnail)){ ?>
                  <span class="sesbasic_animation" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($business->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);"></span>
                <?php } ?>
              </div>
              <div class="sesbusiness_category_grid_overlay sesbasic_animation"></div>
              <div class="sesbusiness_category_grid_info">
                <div>
                  <div class="sesbusiness_category_grid_details">
                    <?php if(isset($this->iconSubcatActive) && $business->cat_icon != '' && !is_null($business->cat_icon) && intval($business->cat_icon)){ ?>
                      <img src="<?php echo  Engine_Api::_()->storage()->get($business->cat_icon)->getPhotoUrl('thumb.icon'); ?>" />
                    <?php } ?>
                    <?php if(isset($this->titleSubcatActive)){ ?>
                    <span><?php echo $business->category_name; ?></span>
                    <?php } ?>
                    <?php if(isset($this->countBusinessesSubcatActive)){ ?>
                      <span class="sesbusiness_category_grid_stats"><?php echo $this->translate(array('%s business', '%s businesses', $business->total_businesses_categories), $this->locale()->toNumber($business->total_businesses_categories))?></span>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
     </div>
   </div>
<?php } ?>  
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">    
  <div class="sesbusiness_catview_list_title clear sesbasic_clearfix">
    <span class="_title"><?php echo $this->params['business_title']; ?></span>
  </div>
   <ul class="sesbusiness_cat_business_listing sesbasic_clearfix clear _iscatitem" id="tabbed-widget_<?php echo $randonNumber; ?>">
<?php } ?>
    <?php $totalCount = $this->paginator->getCurrentItemCount();?>
    <?php foreach($this->paginator as $business){  ?>
    <?php $title = $business->getTitle();?>
     <?php include APPLICATION_PATH .  '/application/modules/Sesbusiness/views/scripts/business/_simpleGridView.tpl';?>
    <?php } ?>   
    <?php  if(  $totalCount == 0){  ?>
      <div class="tip">
        <span>
        	<?php echo $this->translate("No businesses in this  category."); ?>
          <?php if (!$this->can_edit):?>
                    <?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "sesbusiness_general").'">', '</a>'); ?>
          <?php endif; ?>
        </span>
      </div>
    <?php } ?>    
    <?php if($this->params['pagging'] == 'pagging'){ ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesbusiness"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
<?php if(!$this->is_ajax){ ?> 
 </ul>
 </div>
 <?php if($this->params['pagging'] != 'pagging'){ ?>  
   <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
  	<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>   
  </div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
  <?php } ?>
  <script type="application/javascript">
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 jqueryObjectOfSes('.overlay_<?php echo $randonNumber ?>').css('display','block');
	 var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesbusiness/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: pageNum,    
				params :'<?php echo json_encode($this->params); ?>', 
				is_ajax : 1,
				widget_id : '<?php echo $randonNumber; ?>',
				widget_id: '<?php echo $this->widgetId;?>',
                category_id:'<?php echo $this->category_id;?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				jqueryObjectOfSes('.overlay_<?php echo $randonNumber ?>').css('display','none');
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
				dynamicWidth();
      }
    })).send();
    return false;
}
</script>
  <?php } ?>
<script type="text/javascript">
var valueTabData ;
// globally define available tab array
	var availableTabs_<?php echo $randonNumber; ?>;
	var requestTab_<?php echo $randonNumber; ?>;
  availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($this->defaultOptions); ?>;
<?php if($this->params['pagging'] == 'auto_load'){ ?>
		window.addEvent('load', function() {
		 jqueryObjectOfSes(window).scroll( function() {
			  var heightOfContentDiv_<?php echo $randonNumber; ?> = jqueryObjectOfSes('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
        var fromtop_<?php echo $randonNumber; ?> = jqueryObjectOfSes(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && jqueryObjectOfSes('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
     });
	});
<?php } ?>
var defaultOpenTab ;
  viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
  function viewMore_<?php echo $randonNumber; ?> (){
    var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesbusiness/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: <?php echo $this->page + 1; ?>,    
				params :'<?php echo json_encode($this->params); ?>', 
				is_ajax : 1,
				identity : '<?php echo $randonNumber; ?>',
                widget_id: '<?php echo $this->widgetId;?>',
                category_id:'<?php echo $this->category_id;?>',
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
				dynamicWidth();
      }
    })).send();
    return false;
  }
<?php if(!$this->is_ajax){ ?>
function dynamicWidth(){
	var objectClass = jqueryObjectOfSes('.sesbusiness_cat_business_list_info');
	for(i=0;i<objectClass.length;i++){
			jqueryObjectOfSes(objectClass[i]).find('div').find('.sesbusiness_cat_business_list_content').find('.sesbusiness_cat_business_list_title').width(jqueryObjectOfSes(objectClass[i]).width());
	}
}
dynamicWidth();
<?php } ?>
</script>
