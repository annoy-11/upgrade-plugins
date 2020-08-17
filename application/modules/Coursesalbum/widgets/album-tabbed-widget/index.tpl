<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Coursesalbum/externals/styles/style_album.css'); ?>
<?php 
  if(isset($this->identityForWidget) && !empty($this->identityForWidget)){
    $randonNumber = $this->identityForWidget;
  } else {
    $randonNumber = $this->identity; 
  }
?>
<?php if(!$this->is_ajax) { ?>
<!--Default Tabs-->
<?php if($this->tab_option == 'default'){ ?>
  <div class="layout_core_container_tabs">
    <div class="tabs_alt tabs_parent" id="coursesalbum_tabbed_widget_container_<?php echo $randonNumber; ?>">
<?php } ?>
<!--Advance Tabs-->
<?php if($this->tab_option == 'advance'){ ?>
  <div class="sesbasic_tabs_container sesbasic_clearfix sesbasic_bxs">
    <div class="sesbasic_tabs sesbasic_clearfix" id="coursesalbum_tabbed_widget_container_<?php echo $randonNumber; ?>">
 <?php } ?>
<!--Filter Tabs-->
<?php if($this->tab_option == 'filter'){ ?>
  <div class="sesbasic_filter_tabs_container sesbasic_clearfix sesbasic_bxs">
    <div class="sesbasic_filter_tabs sesbasic_clearfix" id="coursesalbum_tabbed_widget_container_<?php echo $randonNumber; ?>">
<?php } ?>
    <ul id="tab-widget-coursesalbum-<?php echo $randonNumber; ?>">
      <?php 
        $defaultOptionArray = array();
        foreach($this->defaultOptions as $key=>$valueOptions) {
        $defaultOptionArray[] = $key;
      ?>
        <li <?php if($this->defaultOpenTab == $key){ ?> class="active"<?php } ?> id="sesTabContainer_<?php echo $randonNumber; ?>_<?php echo $key; ?>">
          <a href="javascript:;" data-src="<?php echo $key; ?>" onclick="changeTabSes_<?php echo $randonNumber; ?>('<?php echo $key; ?>')"><?php echo $this->translate($valueOptions); ?></a></li>
      <?php } ?>
    </ul>
  </div>
  <div class="sesbasic_tabs_content sesbasic_clearfix sesbasic_bxs">
  <?php  if(count($this->defaultOptions) == 1) { ?>
    <script type="application/javascript">
      sesJqueryObject('#coursesalbum_tabbed_widget_container_<?php echo $randonNumber; ?>').css('display','none');
    </script>
  <?php } ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix">
    <ul class="coursesalbum_album_listings coursesalbum_tabbed_listings coursesalbum_photos_flex_view sesbasic_bxs sesbasic_clearfix" id="album-tabbed-widget_<?php echo $randonNumber; ?>">
<?php } ?>
    <?php $limit = $this->limit;
    			foreach( $this->paginator as $item ): ?>
            <?php $course = Engine_Api::_()->getItem('courses', $item->course_id); ?>
            <li id="thumbs-photo-<?php echo $item->photo_id ?>" class="coursesalbum_album_list_grid_thumb coursesalbum_album_list_grid sespa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sespa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
            	<article>  
              <a class="coursesalbum_album_list_grid_img" href="<?php echo Engine_Api::_()->coursesalbum()->getHref($item->getIdentity(),$item->album_id); ?>" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
                <span class="main_image_container" style="background-image: url(<?php echo $item->getPhotoUrl('thumb.normalmain'); ?>);"></span>
              </a>
              <?php  if(isset($this->socialSharing) ||  isset($this->favouriteButton) || isset($this->likeButton)){  ?>
      <span class="coursesalbum_album_list_grid_btns">
       <?php if(isset($this->socialSharing)){ 
       	//album viewpage link for sharing
          $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $item->getHref());
       ?>
        <?php echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $item, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
        <?php }
        $canComment =  $item->authorization()->isAllowed(Engine_Api::_()->user()->getViewer(), 'comment');
        	if(Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && isset($this->likeButton) && $canComment){ ?>
                <!--Album Like Button-->
                <?php $albumLikeStatus = Engine_Api::_()->eclassroom()->getLikeStatus($item->getIdentity(), $item->getType()); ?>
                <a href="javascript:;" data-contenttype="album" data-resource-type="<?php echo $item->getType(); ?>" data-url='<?php echo $item->album_id; ?>' class="sesbasic_icon_btn_count sesbasic_icon_btn sesbasic_icon_like_btn coursesalbum_albumlike <?php echo ($albumLikeStatus) ? 'button_active' : '' ; ?>">
                  <i class="fa fa-thumbs-up"></i>
                  <span><?php echo $item->like_count; ?></span>
                </a>
              <?php } 
              	if(Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && isset($this->favouriteButton)) {
             	 		$albumFavStatus = Engine_Api::_()->getDbTable('favourites', 'eclassroom')->isFavourite(array('resource_type'=>'album','resource_id'=>$item->album_id)); ?>
              <a href="javascript:;" data-contenttype="album" data-resource-type="<?php echo $item->getType(); ?>" data-src='<?php echo $item->getIdentity(); ?>' class="sesbasic_icon_btn_count sesbasic_icon_btn sesbasic_icon_fav_btn coursesalbum_albumFav <?php echo ($albumFavStatus)>0 ? 'button_active' : '' ; ?>">
                <i class="fa fa-heart"></i>
                <span><?php echo $item->favourite_count; ?></span>
              </a>
         <?php } ?>
         </span>
         <?php } ?>
          <?php if(isset($this->featured) || isset($this->sponsored)){ ?>
          	<span class="coursesalbum_labels">
              <?php if(isset($this->featured) && $item->featured == 1){ ?>
                <p class="coursesalbum_label_featured"><?php echo $this->translate("Featured"); ?></p>
              <?php } ?>
            <?php if(isset($this->sponsored)  && $item->sponsored == 1){ ?>
            	<p class="coursesalbum_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
            <?php } ?>
          </span>
         <?php } ?>
         <?php if(isset($this->like) || isset($this->comment) || isset($this->view) || isset($this->title) || isset($this->rating) || isset($this->photoCount) || isset($this->favouriteCount) || isset($this->downloadCount)  || isset($this->by) || isset($this->classroomName)){ ?>
              <p class="coursesalbum_album_list_grid_info sesbasic_clearfix<?php if(!isset($this->photoCount)) { ?> nophotoscount<?php } ?>">
              <?php if(isset($this->title)) { ?>
                <span class="coursesalbum_album_list_grid_title">
                  <?php echo $this->htmlLink($item, $this->string()->truncate($item->getTitle(), $this->title_truncation),array('title'=>$item->getTitle())) ; ?>
                </span>
              <?php } ?>
              <span class="coursesalbum_album_list_grid_stats">
                <?php if(isset($this->classroomName)) { ?>
                  <span class="coursesalbum_album_list_grid_owner">
                    <?php echo $this->translate('in ');?>
                   <?php echo $this->htmlLink($course->getHref(), $course->getTitle(), array('class' => 'thumbs_author')) ?>
                  </span>
                <?php } ?>
                <?php if(ECLASSROOMSHOWUSERDETAIL == 1 && isset($this->by)) { ?>
                  <span class="coursesalbum_album_list_grid_owner">
                    <?php echo $this->translate('by ');?>
                   <?php echo $this->htmlLink($item->getOwner()->getHref(), $item->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?>
                  </span>
                <?php }?>
              </span>
              <span class="coursesalbum_album_list_grid_stats sesbasic_text_light">
                <?php if(isset($this->like)) { ?>
                  <span class="coursesalbum_album_list_grid_likes coursesalbum_album_likes_count_<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber($item->like_count))?>">
                    <i class="sesbasic_icon_like_o"></i>
                    <?php echo $item->like_count;?>
                  </span>
                <?php } ?>
                <?php if(isset($this->comment)) { ?>
                  <span class="coursesalbum_album_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber($item->comment_count))?>">
                    <i class="sesbasic_icon_comment_o"></i>
                    <?php echo $item->comment_count;?>
                  </span>
               <?php } ?>
               <?php if(isset($this->view)) { ?>
                  <span class="coursesalbum_album_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber($item->view_count))?>">
                    <i class="sesbasic_icon_view"></i>
                    <?php echo $item->view_count;?>
                  </span>
               <?php } ?>
               <?php if(isset($this->favouriteCount)) { ?>
                  <span class="coursesalbum_album_list_grid_fav coursesalbum_album_favs_count_<?php echo $item->getIdentity(); ?>" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber($item->favourite_count))?>">
                    <i class="sesbasic_icon_favourite_o"></i> 
                    <?php echo $item->favourite_count;?>            
                  </span>
                <?php } ?>
                 <?php if(isset($this->photoCount)) { ?>
               	<span class="coursesalbum_album_list_grid_count" title="<?php echo $this->translate(array('%s photo', '%s photos', $item->count()), $this->locale()->toNumber($item->count()))?>" >
                  <i class="fa fa-photo"></i> 
                  <?php echo $item->count();?>                
               	</span>
                <?php } ?>
                </span>
              </p>
         <?php } ?>
          <?php if(isset($this->photoCount)) { ?>
              <p class="coursesalbum_album_list_grid_count">
                <?php echo $this->translate(array('%s <span>photo</span>', '%s <span>photos</span>', $item->count()),$this->locale()->toNumber($item->count())) ?>
              </p>
              <?php  } ?>
              </article>
            </li>
    <?php $limit++;
    			endforeach;
           if($this->loadOptionData == 'pagging' && $this->show_limited_data == 'no'){ ?>
             <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "courses"),array('identityWidget'=>$randonNumber)); ?>
         <?php } ?>
          <?php  if($this->paginator->getTotalItemCount() == 0){  ?>
            <div class="tip">
              <span>
                <?php echo $this->translate("There are currently no ".ucfirst($this->albumPhotoOption)."s.");?>
              </span>
            </div>    
    			<?php } ?>
    <?php if(!$this->is_ajax){ ?>
  </ul>
   <?php if($this->loadOptionData != 'pagging' && $this->show_limited_data == 'no'){ ?>
  <div class="sesbasic_load_btn sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
  	<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
  </div>
  <div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"> <span class="coursesalbum_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>
  <?php } ?>
</div>
</div>
</div>
<script type="text/javascript">
var valueTabData ;
var params<?php echo $randonNumber; ?> = '<?php echo json_encode($this->params); ?>';
var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
var searchParams<?php echo $randonNumber; ?>;
  var truncateRow = false;

	function paggingNumber<?php echo $randonNumber; ?>(pageNum){
		 sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
		 var valueTab ;
		 sesJqueryObject('#tab-widget-coursesalbum-<?php echo $randonNumber; ?> > li').each(function(index){
					if(sesJqueryObject(this).hasClass('active')){
					  valueTab = sesJqueryObject(this).find('a').attr('data-src');
					}
		 });
		 if(typeof valueTab == 'undefined')
		 	return false;
			(new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + 'widget/index/mod/coursesalbum/name/album-tabbed-widget/openTab/' + valueTab,
				'data': {
					format: 'html',
					page: pageNum,   
					searchParams : searchParams<?php echo $randonNumber; ?>, 
					params :params<?php echo $randonNumber; ?> , 
					is_ajax : 1,
					identity : identity<?php echo $randonNumber; ?>,
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','none');
					 if($('loadingimgeclassroom-wrapper'))
						sesJqueryObject('#loadingimgeclassroom-wrapper').hide();
					document.getElementById('album-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
				}
			})).send();
			return false;
	}
// globally define available tab array
	var availableTabs_<?php echo $randonNumber; ?>;
	var requestTab_<?php echo $randonNumber; ?>;
  availableTabs_<?php echo $randonNumber; ?> = <?php echo json_encode($defaultOptionArray); ?>;
<?php if($this->loadOptionData == 'auto_load' && $this->show_limited_data == 'no'){ ?>
		window.addEvent('load', function() {
		 sesJqueryObject(window).scroll( function() {
			  var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
        var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
     });
	});
<?php } ?>
</script>
<?php } ?>

<script type="text/javascript">
	function changeTabSes_<?php echo $randonNumber; ?>(valueTab){
			if(sesJqueryObject("#sesTabContainer_<?php echo $randonNumber ?>_"+valueTab).hasClass('active'))
				return;
			var id = '_<?php echo $randonNumber; ?>';
			var length = availableTabs_<?php echo $randonNumber; ?>.length;
			for (var i = 0; i < length; i++) {
					if(availableTabs_<?php echo $randonNumber; ?>[i] == valueTab)
						document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).addClass('active');
					else
						document.getElementById('sesTabContainer'+id+'_'+availableTabs_<?php echo $randonNumber; ?>[i]).removeClass('active');
			}
		if(valueTab){
				document.getElementById("album-tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";
				if(document.getElementById("view_more_<?php echo $randonNumber; ?>"))
				document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';
			 if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
				 requestTab_<?php echo $randonNumber; ?>.cancel();
 			 }
			 requestTab_<?php echo $randonNumber; ?> = new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + 'widget/index/mod/coursesalbum/name/album-tabbed-widget/openTab/' + valueTab,
				'data': {
					format: 'html',
					page:  1,    
					params :'<?php echo json_encode($this->params); ?>', 
					is_ajax : 1,
					identity : '<?php echo $randonNumber; ?>',
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					document.getElementById('album-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = '';
					document.getElementById('album-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('album-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				}
    	});
		requestTab_<?php echo $randonNumber; ?>.send();
    return false;			
		}
	}
<?php if($this->loadOptionData != 'pagging'){ ?>
  viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
	var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
  function viewMore_<?php echo $randonNumber; ?> (){
    var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
				 requestTab_<?php echo $randonNumber; ?>.cancel();
 			 }
		requestTab_<?php echo $randonNumber; ?> = 
		(new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/coursesalbum/name/album-tabbed-widget/openTab/' + openTab_<?php echo $randonNumber; ?>,
      'data': {
        format: 'html',
        page: page<?php echo $randonNumber; ?>,    
				params :params<?php echo $randonNumber; ?> , 
				is_ajax : 1,
				searchParams : searchParams<?php echo $randonNumber; ?>,
				identity : identity<?php echo $randonNumber; ?>,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('album-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('album-tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				 if($('loadingimgeclassroom-wrapper'))
					sesJqueryObject('#loadingimgeclassroom-wrapper').hide();
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
  }
<?php } ?>
</script>
