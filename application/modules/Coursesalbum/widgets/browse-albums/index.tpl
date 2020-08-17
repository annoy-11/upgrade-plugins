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
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)){
				$randonNumber = $this->identityForWidget;
      }else{
      	$randonNumber = $this->identity; 
       }?>
 <div class="coursesalbum_album_search_result sesbasic_clearfix sesbm" id="<?php echo !$this->is_ajax ? 'paginator_count_coursesalbum' : 'paginator_count_ajax_coursesalbum' ?>">	
 		<span id="total_item_count_coursesalbum" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->translate("albums found."); ?>
 </div>
 <?php if(!$this->is_ajax){ ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>">
    <ul class="coursesalbum_album_listings coursesalbum_browse_album_listings sesbasic_bxs sesbasic_clearfix" id="tabbed-widget_<?php echo $randonNumber; ?>">
 <?php }
    foreach( $this->paginator as $album ):  ?>
      <?php $course = Engine_Api::_()->getItem('courses', $album->course_id); ?>
      <?php if($this->view_type == 1){ ?>
        <li id="thumbs-photo-<?php echo $album->photo_id ?>" class="coursesalbum_album_list_grid_thumb coursesalbum_album_list_grid sespa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sespa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">  
          <article>
          <a class="coursesalbum_album_list_grid_img" href="<?php echo Engine_Api::_()->coursesalbum()->getHref($album->getIdentity(),$album->album_id); ?>" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
            <span class="main_image_container" style="background-image: url(<?php echo $album->getPhotoUrl('thumb.normalmain'); ?>);"></span>
            <div class="ses_image_container" style="display:none;">
              <?php $image = Engine_Api::_()->coursesalbum()->getAlbumPhoto($album->getIdentity(),$album->photo_id); 
                foreach($image as $key=>$valuePhoto){  ?>
                 <div class="child_image_container"><?php echo $valuePhoto->getPhotoUrl('thumb.normalmain');  ?></div>
              <?php  }  ?>  
             	<div class="child_image_container"><?php echo $album->getPhotoUrl('thumb.normalmain'); ?></div>          
            </div>
          </a>
          <?php  if(isset($this->socialSharing) || isset($this->likeButton) || isset($this->favouriteButton)){  ?>
            <span class="coursesalbum_album_list_grid_btns">
             <?php if(isset($this->socialSharing)){ 
              //album viewpage link for sharing
              $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $album->getHref());
             ?>
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $album, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

              <?php }
              $canComment = $album->authorization()->isAllowed($this->viewer, 'comment'); 
              if(Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && isset($this->likeButton) && $canComment){  ?>
                <!--Album Like Button-->
                <?php $albumLikeStatus = Engine_Api::_()->coursesalbum()->getLikeStatus($album->getIdentity(), $album->getType()); ?>
                <a href="javascript:;" data-contenttype="album" data-resource-type="<?php echo $album->getType(); ?>" data-url='<?php echo $album->album_id; ?>' class="sesbasic_icon_btn_count sesbasic_icon_btn sesbasic_icon_like_btn coursesalbum_albumlike <?php echo ($albumLikeStatus) ? 'button_active' : '' ; ?>">
                  <i class="fa fa-thumbs-up"></i>
                  <span><?php echo $album->like_count; ?></span>
                </a>
              <?php } 
              if(Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && isset($this->favouriteButton)){
                $albumFavStatus = Engine_Api::_()->getDbTable('favourites', 'courses')->isFavourite(array('resource_type'=>'coursesalbum_album','resource_id'=>$album->getIdentity())); ?>
                <a href="javascript:;" data-contenttype="album" data-resource-type="<?php echo $album->getType(); ?>" data-url='<?php echo $album->getIdentity(); ?>' class="sesbasic_icon_btn_count sesbasic_icon_btn sesbasic_icon_fav_btn coursesalbum_albumFav <?php echo ($albumFavStatus) ? 'button_active' : '' ; ?>">
                  <i class="fa fa-heart"></i>
                  <span><?php echo $album->favourite_count; ?></span>
                </a>
            <?php } ?>
          	</span>
         	<?php } ?>
          <?php if(isset($this->featured) || isset($this->sponsored)){ ?>
          	<span class="coursesalbum_labels coursesalbum_album_labels_container">
              <?php if(isset($this->featured) && $album->featured == 1){ ?>
                <p class="coursesalbum_label_featured"><?php echo $this->translate("Featured"); ?></p>
              <?php } ?>
            <?php if(isset($this->sponsored)  && $album->sponsored == 1){ ?>
            	<p class="coursesalbum_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
            <?php } ?>
          </span>
         <?php } ?>
         <?php if(isset($this->like) || isset($this->comment) || isset($this->view) || isset($this->title) || isset($this->rating) || isset($this->photoCount) || isset($this->favouriteCount) || isset($this->downloadCount)  || isset($this->by) || isset($this->classroomname)){ ?>
              <p class="coursesalbum_album_list_grid_info sesbasic_clearfix<?php if(!isset($this->photoCount)) { ?> nophotoscount<?php } ?>">
              <?php if(isset($this->title)) { ?>
                <span class="coursesalbum_album_list_grid_title">
                  <?php echo $this->htmlLink($album, $this->string()->truncate($album->getTitle(), $this->title_truncation),array('title'=>$album->getTitle())) ; ?>
                </span>
              <?php } ?>
              <span class="coursesalbum_album_list_grid_stats">
                <?php if(isset($this->classroomname)) { ?>
                  <span class="coursesalbum_album_list_grid_owner">
                    <?php echo $this->translate('in ');?>
                   <?php echo $this->htmlLink($course->getHref(), $course->getTitle(), array('class' => 'thumbs_author')) ?>
                  </span>
                <?php }?>
                <?php if(COURSESSHOWUSERDETAIL == 1 && isset($this->by)) { ?>
                  <span class="coursesalbum_album_list_grid_owner">
                    <?php echo $this->translate('by ');?>
                   <?php echo $this->htmlLink($album->getOwner()->getHref(), $album->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?>
                  </span>
                <?php }?>
              </span>
              <span class="coursesalbum_album_list_grid_stats sesbasic_text_light">
                <?php if(isset($this->like)) { ?>
                  <span class="coursesalbum_album_list_grid_likes coursesalbum_album_likes_count_<?php echo $album->getIdentity(); ?>" title="<?php echo $this->translate(array('%s like', '%s likes', $album->like_count), $this->locale()->toNumber($album->like_count))?>">
                    <i class="sesbasic_icon_like_o"></i>
                    <?php echo $album->like_count;?>
                  </span>
                <?php } ?>
                <?php if(isset($this->comment)) { ?>
                  <span class="coursesalbum_album_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $album->comment_count), $this->locale()->toNumber($album->comment_count))?>">
                    <i class="sesbasic_icon_comment_o"></i>
                    <?php echo $album->comment_count;?>
                  </span>
               <?php } ?>
               <?php if(isset($this->view)) { ?>
                  <span class="coursesalbum_album_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $album->view_count), $this->locale()->toNumber($album->view_count))?>">
                    <i class="sesbasic_icon_view"></i>
                    <?php echo $album->view_count;?>
                  </span>
               <?php } ?>
               <?php if(isset($this->favouriteCount)) { ?>
                  <span class="coursesalbum_album_list_grid_fav coursesalbum_album_favs_count_<?php echo $album->getIdentity(); ?>" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $album->favourite_count), $this->locale()->toNumber($album->favourite_count))?>">
                    <i class="sesbasic_icon_favourite_o"></i>  
                    <?php echo $album->favourite_count;?>            
                  </span>
                <?php } ?>
                 <?php if(isset($this->photoCount)) { ?>
               	<span class="coursesalbum_album_list_grid_count" title="<?php echo $this->translate(array('%s photo', '%s photos', $album->count()), $this->locale()->toNumber($album->count()))?>" >
                  <i class="fa fa-photo"></i> 
                  <?php echo $album->count();?>                
               	</span>
                <?php } ?>
                </span>
              </p>
         <?php } ?>
         		<?php if(isset($this->photoCount)) { ?>
              <p class="coursesalbum_album_list_grid_count">
                <?php echo $this->translate(array('%s <span>photo</span>', '%s <span>photos</span>', $album->count()),$this->locale()->toNumber($album->count())); ?>
              </p>
              <?php } ?>
              </article>
            </li>
      <?php }else{ ?>
      		<?php $image = Engine_Api::_()->coursesalbum()->getAlbumPhoto($album->getIdentity(),$album->photo_id,3);  ?>
          <?php if(count($image) == 0) {
          	$heightDiv = (str_replace('px','',$this->height)) + 100;
          }else{
          	$heightDiv = $this->height;
          } ?>
          <?php $imageURL = Engine_Api::_()->sesbasic()->getImageViewerHref($album); ?>
          <li class="coursesalbum_album_list_thumbnail_view" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
           <?php $albumPhoto = Engine_Api::_()->getItem('coursesalbum_photo', $album->photo_id); ?>
           <?php if(!empty($album->photo_id) && !is_null($albumPhoto)) { ?>
                <div class="coursesalbum_album_thumbnail_view_main_img" style="height:<?php echo is_numeric($heightDiv) ? $heightDiv.'px' : $heightDiv ?>;">
                <a class="ses-image-viewer" onclick="openLightBoxForSesPlugins('<?php echo $albumPhoto->getHref(); ?>', '<?php echo $album->getPhotoUrl(); ?>')" href="<?php echo $albumPhoto->getHref(); ?>"><span class="coursesalbum_album_thumbnail_view_thumb" style="background-image:url(<?php echo $albumPhoto->getPhotoUrl('thumb.normalmain'); ?>);"></span></a>
                </div>
            <?php } else { ?>
                <div class="coursesalbum_album_thumbnail_view_main_img" style="height:<?php echo is_numeric($heightDiv) ? $heightDiv.'px' : $heightDiv ?>;">
                <span class="coursesalbum_album_thumbnail_view_thumb" style="background-image:url('./application/modules/Coursesalbum/externals/images/nophoto_class_thumb_profile.png');"></span></a>
                </div>
            <?php } ?>
						<?php 
            		if(count($image) != 0) { ?>
                <div class="coursesalbum_album_thumbnail_view_thumbs thumbs<?php echo count($image); ?> clear sesbasic_clearfix">
             		<?php	foreach($image as $key=>$valuePhoto) { ?>
                <div>
                  <?php $imageURL = $valuePhoto->getPhotoUrl('thumb.normalmain'); ?>
                  <a onclick="openLightBoxForSesPlugins('<?php echo $valuePhoto->getHref(); ?>', '<?php echo $valuePhoto->getPhotoUrl()	; ?>')" href="<?php echo $valuePhoto->getHref(); ?>" class="ses-image-viewer"><span class="coursesalbum_album_thumbnail_view_thumb" style="background-image:url(<?php echo $imageURL;  ?>);"></span></a>
                </div>
            <?php } ?>
            		</div>
            <?php	}  ?>
            <div class="coursesalbum_album_thumbnail_view_btm clear sesbasic_clearfix">
              <div class="coursesalbum_album_thumbnail_owner_photo">
              	<?php $user = Engine_Api::_()->getItem('user',$album->owner_id) ?>
                <a href="<?php echo $user->getHref();; ?>">
                  <?php echo $this->itemPhoto($user, 'thumb.profile'); ?>
                 </a>          
              </div>
              <div class="coursesalbum_album_thumbnail_album_info">
                <p class="coursesalbum_album_thumbnail_album_name">
                  <?php if(isset($this->title)) { ?>
                   <?php echo $this->htmlLink($album, $this->string()->truncate($album->getTitle(), $this->title_truncation),array('title'=>$album->getTitle())) ; ?>
                  <?php } ?>
                </p>
                <p class="coursesalbum_album_thumbnail_album_by sesbasic_clearfix sesbasic_text_light"> 
                  <?php if(isset($this->classroomname)) { ?>
                    <span>
                      <?php echo $this->translate('in ');?>
                       <?php echo $this->htmlLink($course->getHref(), $course->getTitle(), array('class' => 'thumbs_author')) ?>
                    </span>
                  <?php }?>
                  <?php if(isset($this->by)) { ?>
                    <span>
                      <?php echo $this->translate('by');?>
                       <?php echo $this->htmlLink($album->getOwner()->getHref(), $album->getOwner()->getTitle(), array('class' => 'thumbs_author')) ?>
                    </span>
                  <?php } ?>
                </p>
                <?php if(isset($this->featured) || isset($this->sponsored)){ ?>
                  <span class="coursesalbum_labels coursesalbum_album_labels_container">
                    <?php if(isset($this->featured) && $album->featured == 1){ ?>
                      <p class="coursesalbum_label_featured"><?php echo $this->translate("Featured"); ?></p>
                    <?php } ?>
                  <?php if(isset($this->sponsored)  && $album->sponsored == 1){ ?>
                    <p class="coursesalbum_label_sponsored"><?php echo $this->translate("Sponsored"); ?></p>
                  <?php } ?>
                </span>
               <?php } ?>
                <p class="coursesalbum_album_thumbnail_album_stats coursesalbum_album_list_stats sesbasic_clearfix sesbasic_text_light">
                	<?php if(isset($this->like)) { ?>
                  <span title="<?php echo $this->translate(array('%s like', '%s likes', $album->like_count), $this->locale()->toNumber($album->like_count))?>">
                    <i class="sesbasic_icon_like_o"></i>
                    <?php echo $album->like_count;?>
                  </span>
                <?php } ?>
                <?php if(isset($this->comment)) { ?>
                  <span  title="<?php echo $this->translate(array('%s comment', '%s comments', $album->comment_count), $this->locale()->toNumber($album->comment_count))?>">
                    <i class="sesbasic_icon_comment_o"></i>
                    <?php echo $album->comment_count;?>
                  </span>
               <?php } ?>
               <?php if(isset($this->view)) { ?>
                  <span  title="<?php echo $this->translate(array('%s view', '%s views', $album->view_count), $this->locale()->toNumber($album->view_count))?>">
                    <i class="sesbasic_icon_view"></i>
                    <?php echo $album->view_count;?>
                  </span>
               <?php } ?>
               <?php if(isset($this->favouriteCount)) { ?>
                  <span  title="<?php echo $this->translate(array('%s favourite', '%s favourites', $album->favourite_count), $this->locale()->toNumber($album->favourite_count))?>">
                    <i class="sesbasic_icon_favourite_o"></i> 
                    <?php echo $album->favourite_count;?>            
                  </span>
                <?php } ?>
                 <?php if(isset($this->photoCount)) { ?>
               	<span  title="<?php echo $this->translate(array('%s photo', '%s photos', $album->count()), $this->locale()->toNumber($album->count()))?>" >
                  <i class="fa fa-photo"></i> 
                  <?php echo $album->count();?>                
               	</span>
                <?php } ?>
                </p>
            <?php  if(isset($this->socialSharing) || isset($this->likeButton) || isset($this->favouriteButton)){  ?>
            	<p class="coursesalbum_album_list_btns coursesalbum_album_thumbnail_album_btns">
             	<?php if(isset($this->socialSharing)){ 
              //album viewpage link for sharing
                $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $album->getHref());
             ?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $album, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>

              <?php }
              $canComment = $album->authorization()->isAllowed($this->viewer, 'comment');
                if(Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && isset($this->likeButton) && $canComment){  ?>
                  <!--Album Like Button-->
                  <?php $albumLikeStatus = Engine_Api::_()->coursesalbum()->getLikeStatus($album->getIdentity(), $album->getType()); ?>
                  <a href="javascript:;" data-contenttype="album" data-resource-type="<?php echo $album->getType(); ?>" data-url='<?php echo $album->album_id; ?>' class="sesbasic_icon_btn_count sesbasic_icon_btn sesbasic_icon_like_btn coursesalbum_albumlike <?php echo ($albumLikeStatus) ? 'button_active' : '' ; ?>">
                    <i class="fa fa-thumbs-up"></i>
                    <span><?php echo $album->like_count; ?></span>
                  </a>
              	<?php } 
                 if(Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && isset($this->favouriteButton)){
                  $albumFavStatus = Engine_Api::_()->getDbTable('favourites', 'courses')->isFavourite(array('resource_type'=>'coursesalbum_album','resource_id'=>$album->album_id)); ?>
                    <a href="javascript:;" data-contenttype="album" data-resource-type="<?php echo $album->getType(); ?>" data-url='<?php echo $album->album_id; ?>' class="sesbasic_icon_btn_count sesbasic_icon_btn sesbasic_icon_fav_btn coursesalbum_albumFav <?php echo ($albumFavStatus) ? 'button_active' : '' ; ?>">
                      <i class="fa fa-heart"></i>
                      <span><?php echo $album->favourite_count; ?></span>
                    </a>
                <?php } ?>
              </span>
            <?php } ?>
                </p>
              </div>
            </div>
          </li>      
      <?php } ?>
      <?php endforeach;
      if($this->load_content == 'pagging'){ ?>
 		 		<?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "courses"),array('identityWidget'=>$randonNumber)); ?>
			<?php } ?>
       <?php  if(  $this->paginator->getTotalItemCount() == 0){  ?>
            <div class="sesbasic_tip">
             <img src="application/modules/Coursesalbum/externals/images/no-album.png" />
              <span>
                <?php echo $this->translate("There are currently no albums.");?>
              </span>
            </div>    
    			<?php } ?>
<?php if(!$this->is_ajax){ ?>
    </ul>
  </div>  
 	<?php if($this->load_content != 'pagging'){ ?>
  	<div class="sesbasic_load_btn sesbasic_load_btn" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
   		<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
   	</div>
  	<div class="sesbasic_load_btn" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;">
     <span class="coursesalbum_link_btn"><i class="fa fa-spinner fa-spin"></i></span>
    </div>
  <?php } ?>
<?php } ?>
 <?php if($this->load_content == 'auto_load'){ ?>
<script type="text/javascript">
		window.addEvent('load', function() {
		 sesJqueryObject(window).scroll( function() {
			  var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
        var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
						document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
				}
     });
	});
</script>
<?php } ?>
<script type="text/javascript">
var params<?php echo $randonNumber; ?> = '<?php echo json_encode($this->params); ?>';
var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
var searchParams<?php echo $randonNumber; ?>;
function paggingNumber<?php echo $randonNumber; ?>(pageNum){
	 sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','block');
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/coursesalbum/name/browse-albums",
      'data': {
        format: 'html',
        page: pageNum,    
				params :params<?php echo $randonNumber; ?>, 
				is_ajax : 1,
				searchParams : searchParams<?php echo $randonNumber; ?>,
				identity : identity<?php echo $randonNumber; ?>,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
			 if($('loadingimgcoursesalbum-wrapper'))
				sesJqueryObject('#loadingimgcoursesalbum-wrapper').hide();
				sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','none');
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
				sesJqueryObject('#paginator_count_coursesalbum').find('#total_item_count_coursesalbum').html(sesJqueryObject('#paginator_count_ajax_coursesalbum').find('#total_item_count_coursesalbum').html());
				sesJqueryObject('#paginator_count_ajax_coursesalbum').remove();
      }
    })).send();
    return false;
}
  var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
  viewMoreHide_<?php echo $randonNumber; ?>();
  function viewMoreHide_<?php echo $randonNumber; ?>() {
    if ($('view_more_<?php echo $randonNumber; ?>'))
      $('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
  }
  function viewMore_<?php echo $randonNumber; ?> (){
    document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
    document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';    
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/coursesalbum/name/browse-albums/index/',
      'data': {
        format: 'html',
        page: page<?php echo $randonNumber; ?>,    
				params :params<?php echo $randonNumber; ?>, 
				is_ajax : 1,
				searchParams : searchParams<?php echo $randonNumber; ?>,
				identity : identity<?php echo $randonNumber; ?>,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
				if($('loadingimgcoursesalbum-wrapper'))
					sesJqueryObject('#loadingimgcoursesalbum-wrapper').hide();
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
				sesJqueryObject('#paginator_count_coursesalbum').find('#total_item_count_coursesalbum').html(sesJqueryObject('#paginator_count_ajax_coursesalbum').find('#total_item_count_coursesalbum'));
				sesJqueryObject('#paginator_count_ajax_coursesalbum').remove();
				//document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'block';
				document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
	};
</script>
