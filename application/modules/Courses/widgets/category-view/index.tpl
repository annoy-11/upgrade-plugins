<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?> 
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>
<?php $randonNumber = $this->widgetId; ?>
<?php $width = $this->params['width'];?>
<?php $height = $this->params['height'];?>
<?php $showFollowButton = 0;?>
<?php if($this->viewer()->getIdentity() && Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allowfollow.category', 1)):?>
 <?php $showFollowButton = 1;?>
<?php endif;?>
<?php if($showFollowButton):?>
  <?php $followStatus = Engine_Api::_()->getDbTable('followers', 'courses')->isFollow(array('resource_id' => $this->category->category_id,'resource_type' => 'courses_category')); ?>
  <?php $followClass = (!$followStatus) ? 'fa-check' : 'fa-times' ;?>
  <?php $followText = ($followStatus) ?  $this->translate('Unfollow') : $this->translate('Follow');?>
<?php endif;?>
<?php if(!$this->is_ajax){   ?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if(isset($this->category->thumbnail) && !empty($this->category->thumbnail)){ ?>
  <div class="courses_category_cover sesbasic_bxs sesbm sesbasic_bxs">
    <div class="courses_category_cover_inner">
    	<div class="courses_category_cover_img" style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl('thumb.thumb'); ?>);"></div>
      <div class="courses_category_cover_content">
        <div class="courses_category_cover_breadcrumb">
          <!--breadcrumb -->
          <a href="<?php echo $this->url(array('action' => 'browse'), "courses_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
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
            <a href='javascript:;' data-url='<?php echo $this->category->category_id; ?>'  data-type='cls_category_follow' data-status='<?php echo $followStatus; ?>' class="sesbasic_animation courses_link_btn courses_likefavfollow cls_category_follow_<?php echo $this->category->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a> 
          <?php endif;?>
        </div>
        <div class="courses_category_cover_blocks">
          <div class="courses_category_cover_block_img">
            <span style="background-image:url(<?php echo  Engine_Api::_()->storage()->get($this->category->thumbnail)->getPhotoUrl(''); ?>);"></span>
          </div>
          <div class="courses_category_cover_block_info">
            <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
              <div class="courses_category_cover_title"> 
                <?php echo $this->category->title; ?>
              </div>
            <?php endif; ?>
            <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
              <div class="courses_category_cover_des clear sesbasic_custom_scroll">
                <p><?php echo nl2br($this->category->description);?></p>
              </div>
            <?php endif; ?>
            <?php if(count($this->paginatorc)){ ?>
              <div class="courses_category_cover_courses">
              	<div class="courses_category_cover_courses_head">
                 	<?php echo $this->params['pop_title']; ?>
                </div>
               	<?php foreach($this->paginatorc as $coursesCri){ ?>
                  <div class="courses_category_cover_item sesbasic_animation">
                    <a href="<?php echo $coursesCri->getHref(); ?>" data-src="<?php echo $coursesCri->getGuid(); ?>" class="_thumbimg">
                      <span class="bg_item_photo sesbasic_animation" style="background-image:url(<?php echo $coursesCri->getPhotoUrl('thumb.profile'); ?>);"></span>
                      <div class="_info sesbasic_animation">
                        <div class="_title"><?php echo $coursesCri->getTitle(); ?> </div>
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
<?php  } else {  ?>
  <div class="sesvide_breadcrumb clear sesbasic_clearfix">
    <!--breadcrumb -->
    <a href="<?php echo $this->url(array('action' => 'browse'), "courses_category"); ?>"><?php echo $this->translate("Categories"); ?></a>&nbsp;&raquo;
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
  <div class="courses_browse_cat_top sesbm">
    <?php if(isset($this->category->title) && !empty($this->category->title)): ?>
      <div class="courses_catview_title centerT"> 
        <?php echo $this->category->title; ?>
      </div>
    <?php endif; ?>
    <?php if(isset($this->category->description) && !empty($this->category->description)): ?>
      <div class="courses_catview_des centerT">
        <?php echo nl2br($this->category->description);?>
      </div>
    <?php endif; ?>
    <?php if($showFollowButton && isset($this->params['show_follow_button']) && $this->params['show_follow_button']):?>
      <div class="courses_catview_button centerT">
        <a href='javascript:;' data-url='<?php echo $this->category->category_id; ?>'  data-status='<?php echo $followStatus;?>' class="sesbasic_animation courses_link_btn courses_category_follow courses_category_follow_<?php echo $this->category->category_id; ?>"><i class='fa <?php echo $followClass ; ?>'></i><span><?php echo $followText; ?></span></a>
      </div>
    <?php endif; ?>
  </div>
  <?php if(count($this->paginatorc)){ ?>
  	<div class="clearfix courses_category_top_course sesbasic_bxs">
    	<div class="courses_catview_list_title clear sesbasic_clearfix">
      	<span class="_title"><?php echo $this->params['pop_title']; ?></span>
     	</div>
      <ul class="courses_listing sesbasic_clearfix clear">
      	<?php foreach($this->paginatorc as $course){ ?>
        	<?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/courses-views/_gridView.tpl';?>
        <?php }  ?>
      </ul>
    </div>
  <?php	}  ?>
<?php } ?>

<!-- category subcategory -->
<?php if($this->params['show_subcat'] == 1 && count($this->innerCatData)>0){ ?>
	<div class="courses_catview_categories sesbasic_clearfix">
    <div class="courses_catview_list_title clear sesbasic_clearfix">
      <span class="_title"><?php echo $this->params['subcategory_title']; ?></span>
    </div>
    <div class="sesbasic_clearfix">
      <ul class="courses_category_grid_listing sesbasic_clearfix clear sesbasic_bxs">	
        <?php foreach( $this->innerCatData as $course ):  ?>
          <li class="courses_category_grid sesbm" style="height:<?php echo is_numeric($this->params['heightSubcat']) ? $this->params['heightSubcat'].'px' : $this->params['heightSubcat'] ?>;width:<?php echo is_numeric($this->params['widthSubcat']) ? $this->params['widthSubcat'].'px' : $this->params['widthSubcat'] ?>;">
            <a href="<?php echo $course->getHref(); ?>">
              <div class="courses_category_grid_img">
                <?php if($course->thumbnail != '' && !is_null($course->thumbnail) && intval($course->thumbnail)){ ?>
                  <span class="sesbasic_animation" style="background-image:url(<?php echo  $course->thumbnail ? Engine_Api::_()->storage()->get($course->thumbnail)->getPhotoUrl('thumb.thumb') : ''; ?>);"></span>
                <?php } ?>
              </div>
              <div class="courses_category_grid_overlay sesbasic_animation"></div>
              <div class="courses_category_grid_info">
                <div>
                  <div class="courses_category_grid_details">
                    <?php if(isset($this->iconSubcatActive) && $course->cat_icon != '' && !is_null($course->cat_icon) && intval($course->cat_icon)){ ?>
                      <img src="<?php echo  Engine_Api::_()->storage()->get($course->cat_icon)->getPhotoUrl('thumb.icon'); ?>" />
                    <?php } ?>
                    <?php if(isset($this->titleSubcatActive)){ ?>
                    <span><?php echo $course->category_name; ?></span>
                    <?php } ?>
                    <?php if(isset($this->countCourseSubcatActive)){ ?>
                      <span class="courses_category_grid_stats"><?php echo $this->translate(array('%s Course', '%s Courses', $course->total_courses_categories), $this->locale()->toNumber($course->total_courses_categories))?></span>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </a>
          </li>
        <?php endforeach;  ?>
      </ul>
     </div>
   </div>
<?php }  ?>  
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">    
  <div class="courses_catview_list_title clear sesbasic_clearfix">
    <span class="_title"><?php echo $this->params['course_title']; ?></span>
  </div>
   <ul class="courses_cat_course_listing sesbasic_clearfix clear _iscatitem" id="tabbed-widget_<?php echo $randonNumber; ?>">
<?php } ?>
    <?php $totalCount = $this->paginator->getCurrentItemCount();?>
    <?php foreach($this->paginator as $course){  ?>
    <?php $title = $course->getTitle();?>
      <?php include APPLICATION_PATH .  '/application/modules/Courses/views/scripts/courses-views/_gridView.tpl';?>
    <?php } ?>   
    <?php  if(  $totalCount == 0){  ?>
      <div class="tip">
        <span>
        	<?php echo $this->translate("No Courses in this  category."); ?>
          <?php if (!$this->can_edit):?>
                    <?php echo $this->translate('Be the first to %1$spost%2$s one in this category!', '<a href="'.$this->url(array('action' => 'create'), "courses_general").'">', '</a>'); ?>
          <?php endif; ?>
        </span>
      </div>
    <?php } ?>    
    <?php if($this->params['pagging'] == 'pagging'){ ?>
      <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "courses"),array('identityWidget'=>$randonNumber)); ?>
    <?php } ?>
<?php if(!$this->is_ajax){ ?> 
 </ul>
 </div>
 <?php if($this->params['pagging'] != 'pagging'){ ?>  
   <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
  	<a href="javascript:void(0);" class="sesbasic_animation courses_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>   
  </div>
  <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="courses_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
  <?php } ?>
  <script type="application/javascript">
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 jqueryObjectOfSes('.overlay_<?php echo $randonNumber ?>').css('display','block');
	 var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/courses/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
      'url': en4.core.baseUrl + "widget/index/mod/courses/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
	var objectClass = jqueryObjectOfSes('.courses_cat_course_list_info');
	for(i=0;i<objectClass.length;i++){
			jqueryObjectOfSes(objectClass[i]).find('div').find('.courses_cat_course_list_content').find('.courses_cat_course_list_title').width(jqueryObjectOfSes(objectClass[i]).width());
	}
}
dynamicWidth();
<?php } ?>
</script>
