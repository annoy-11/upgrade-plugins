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
<?php $randonNumber = $this->widgetId; ?>
<?php if(!$this->is_ajax){ ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Courses/externals/styles/styles.css'); ?>
  <div class="courses_browse_wishlist sesbasic_bxs sesbasic_clearfix">
    <div class="courses_browse_wishlist_inner" id="browse-wishlist-widget_<?php echo $randonNumber; ?>">
<?php } ?>
  <?php foreach($this->paginator as $item){  ?>
    <div class="wishlist-box">
       <div class="_img">
          <img src="<?php echo $item->getPhotoUrl(); ?>" />
          <div class="edit_delete">
          <?php if(isset($this->editButton)) { ?>
           <a class="sesbasic_icon_edit" href="javascript:void(0);" onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'edit','wishlist_id'=> $this->wishlist->wishlist_id),'courses_wishlist_view',true); ?>')"><?php echo $this->translate("Edit"); ?></a>
          <?php } ?>
          <?php if(isset($this->deleteButton)) { ?>
             <a class="sesbasic_icon_delete" href="javascript:void(0);" onclick="Smoothbox.open('<?php echo $this->url(array('action'=>'delete','wishlist_id'=> $this->wishlist->wishlist_id),'courses_wishlist_view',true); ?>')" ><?php echo $this->translate("Delete"); ?></a>
          <?php } ?>
          </div>
          <?php if($item->is_sponsored || $item->is_featured): ?>
           <div class="courses_labels">
            <?php if(in_array('featuredLabel', $this->information) && $item->is_featured): ?>
              <p class="courses_label_featured" title="<?php echo $this->translate('Featured');?>"><?php echo $this->translate('Featured');?></p>
            <?php endif; ?>
            <?php if(in_array('sponsoredLabel', $this->information) && $item->is_sponsored): ?>
             <p class="courses_label_sponsored" title="<?php echo $this->translate('Sponsored');?>"><?php echo $this->translate('SPONSORED');?></p>
            <?php endif; ?>
          </div>
          <?php endif; ?>
          <div class="courses_share_btns">
          <?php if(!empty($this->information) && in_array('socialSharing', $this->information)){ ?>
            <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_icon_limit' => $this->socialshare_icon_limit, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon)); ?>
          <?php } ?> 
          <?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 ){
            $canComment =  true;
            if(!empty($this->information) && in_array('likeButton', $this->information) && $canComment){
             $LikeStatus = Engine_Api::_()->courses()->getLikeStatus($item->wishlist_id,$item->getType()); ?>
              <a href="javascript:;" data-type ="courses_wishlist_like_view" data-url="<?php echo $item->wishlist_id; ?>"  class="sesbasic_icon_btn sesbasic_icon_btn_count courses_likefavfollow courses_wishlist_like_<?php echo $item->wishlist_id; ?><?php echo ($LikeStatus) ? ' button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $item->like_count; ?></span></a>
           <?php } ?>
           <?php if(!empty($this->information) && in_array('favouriteButton', $this->information) && isset($item->favourite_count)){ 
            $favStatus = Engine_Api::_()->getDbtable('favourites', 'courses')->isFavourite(array('resource_type'=>$item->getType(),'resource_id'=>$item->wishlist_id)); ?>  
            <a href="javascript:;" data-type ="courses_wishlist_favourite_view" class="sesbasic_icon_btn courses_likefavfollow courses_wishlist_favourite_<?php echo $item->wishlist_id; ?> <?php echo ($favStatus)  ? 'button_active' : '' ?>"  data-url="<?php echo $item->wishlist_id ; ?>"><i class="fa fa-heart"></i><span><?php echo $item->favourite_count; ?></span></a>
           <?php } ?>
         <?php } ?>
         </div>
       </div> 
       <div class="_cont">
        <?php if(!empty($this->information) && in_array('title', $this->information) ){ ?>
            <a href="<?php echo $item->getHref(); ?>"><?php echo $item->getTitle(); ?></a>
        <?php } ?>
        <!--  For creation date -->
         <?php if(!empty($this->information) && in_array('date', $this->information) ){ ?>
            <span class="date"><i class="fa fa-calendar"></i><?php echo date('dS D, Y',strtotime($item->creation_date)); ?></span>
          <?php } ?>
        <?php if(!empty($this->information) && in_array('viewCount', $this->information)): ?>
          <span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>"><i class="fa fa-eye"></i><?php echo $item->view_count; ?></span>
        <?php endif; ?>
        <?php if(!empty($this->information) && in_array('favouriteCount', $this->information)): ?>
          <span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>" class="courses_wishlist_favourite_count_<?php echo $item->wishlist_id; ?>"><i class="fa fa-heart"></i><?php echo $item->favourite_count;?></span>
        <?php endif; ?>
        <?php if(!empty($this->information) && in_array('likeCount', $this->information)): ?>
          <span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count)); ?>" class="courses_wishlist_like_count_<?php echo $item->wishlist_id; ?>"><i class="fa fa-thumbs-up"></i><?php echo $item->like_count; ?></span>
        <?php endif; ?>
       <?php if(in_array('courseCount', $this->information)){ ?>
            <p></i><?php echo $this->translate(array('%s course.', '%s courses.',$item->courses_count),$item->courses_count); ?></p>
        <?php } ?>
       </div>
    </div>
  <?php } ?>
    <?php  if($this->paginator->getTotalItemCount() == 0):  ?>
      <div id="browse-widget_<?php echo $randonNumber;?>" style="width:100%;">
        <div id="error-message_<?php echo $randonNumber;?>">
          <div class="sesbasic_tip clearfix">
            <img src="application/modules/Courses/externals/images/wishlist.png" alt="" />
            <span class="sesbasic_text_light">
              <?php echo $this->translate('There are no results that match your search. Please try again.') ?>
            </span>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php if($this->params['pagging'] == 'pagging'): ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "courses"),array('identityWidget'=>$randonNumber)); ?>
  <?php endif;?>
<?php if(!$this->is_ajax){ ?>
</div>
  <?php if($this->params['pagging'] != 'pagging'):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
</div>
<?php } ?>
<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var requestViewMore_<?php echo $randonNumber; ?>;
  var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
  var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
  var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  var is_search_<?php echo $randonNumber;?> = 0;
  <?php if($this->params['pagging'] != 'pagging'){ ?>
    viewMoreHide_<?php echo $randonNumber; ?>();	
    function viewMoreHide_<?php echo $randonNumber; ?>() {
      if ($('view_more_<?php echo $randonNumber; ?>'))
        $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
    }
    function viewMore_<?php echo $randonNumber; ?> (){
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
      if(!isSearch)
        sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
      requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/courses/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>",
        'data': {
          format: 'html',
          page: page<?php echo $randonNumber; ?>,    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          is_search:is_search_<?php echo $randonNumber;?>,
          view_more:1,
          searchParams:searchParams<?php echo $randonNumber; ?> ,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
          getParams:'<?php echo $this->getParams;?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
          sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').hide(); 
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgecourse-wrapper'))
            sesJqueryObject('#loadingimgecourse-wrapper').hide();
          if(!isSearch) {
            document.getElementById('browse-wishlist-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('browse-wishlist-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else { 
            document.getElementById('browse-wishlist-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('browse-wishlist-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
        }
      });
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php }else{ ?>
    function paggingNumber<?php echo $randonNumber; ?>(pageNum){
      sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
      requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/courses/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: pageNum,    
          params :params<?php echo $randonNumber; ?> , 
          is_ajax : 1,
          searchParams:searchParams<?php echo $randonNumber; ?>,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
          course_id:'<?php echo $courseId;?>',  
          <?php if($this->wishlist_id){ ?>
            wishlist_id:'<?php echo $this->wishlist_id;?>',
          <?php } ?>
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgecourse-wrapper'))
            sesJqueryObject('#loadingimgecourse-wrapper').hide();
          sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
          document.getElementById('browse-wishlist-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
        }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php } ?>
   var isSearch = false;
</script>
