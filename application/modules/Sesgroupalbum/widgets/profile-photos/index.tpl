<?php if((!$this->is_ajax) && ($this->paginator->count() > 1 || $this->canUpload )): ?> 
  <?php if( $this->canUpload ): ?>
    <?php echo $this->htmlLink(array(
      'route' => 'default',
      'module' => 'sesgroupalbum',
      'controller' => 'album',
      'action' => 'create',
      'group_id' => $this->group_id,
      ), $this->translate('Add New Album'), array(
      'class' => 'sesbasic_button fa fa-plus'
    )) ?>
  <?php endif; ?>
<?php endif; ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroupalbum/externals/styles/styles.css'); ?> 
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
  <?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
  <?php $randonNumber = $this->identity;?>
<?php endif;?>

 <div class="sesgroupalbum_search_result sesbasic_clearfix sesbm" id="<?php echo !$this->is_ajax ? 'paginator_count_sesgroupalbum' : 'paginator_count_ajax_sesgroupalbum' ?>"><span id="total_item_count_sesgroupalbum" style="display:inline-block;"> 
 <?php echo $this->translate(array('%s album found', '%s albums found', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount()))?>
 </div>
 
  <?php if(!$this->is_ajax): ?>
  <script type="application/javascript">
  var tabId_pPhoto = <?php echo $this->identity; ?>;
window.addEvent('domready', function() {
	tabContainerHrefSesbasic(tabId_pPhoto);	
});
  </script>
    <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>">
      <ul class="sesgroupalbum_listings sesgroupalbum_browse_album_listings sesbasic_bxs sesbasic_clearfix" id="tabbed-widget_<?php echo $randonNumber; ?>">
  <?php endif;?>			 
  <?php foreach( $this->paginator as $album ): ?>
    <?php if($this->view_type == 1){  ?>
      <li id="thumbs-photo-<?php echo $album->photo_id ?>" class="sesgroupalbum_list_grid_thumb sesgroupalbum_list_grid sesea-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sesea-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?> sesbm" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">  
	<a class="sesgroupalbum_list_grid_img" href="<?php echo Engine_Api::_()->sesgroupalbum()->getHref($album->getIdentity(),$album->album_id); ?>" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
	  <span class="main_image_container" style="background-image: url(<?php echo $album->getPhotoUrl('thumb.profile'); ?>);"></span>
	  <div class="ses_image_container" style="display:none;">
	    <?php $image = Engine_Api::_()->sesgroupalbum()->getAlbumPhoto($album->getIdentity(),$album->photo_id); 
	    foreach($image as $key=>$valuePhoto){?>
	      <div class="child_image_container"><?php echo Engine_Api::_()->sesgroupalbum()->getPhotoUrl($valuePhoto->photo_id,'thumb.profile');  ?></div>
	    <?php  }  ?>  
	    <div class="child_image_container"><?php echo $album->getPhotoUrl('thumb.profile'); ?></div>          
	  </div>
	</a>
	<?php  if(isset($this->socialSharing) || isset($this->likeButton) || isset($this->favouriteButton)){  ?>
	  <span class="sesgroupalbum_list_grid_btns">
	    <?php if(isset($this->socialSharing)){
	      //album viewpage link for sharing
	      $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $album->getHref());
	      ?>
	      <a href="<?php echo 'http://www.facebook.com/sharer/sharer.php?u=' . $urlencode . '&t=' . $album->getTitle(); ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Facebook'); ?>')" class="sesbasic_icon_btn sesbasic_icon_facebook_btn"><i class="fa fa-facebook"></i></a>
	      <a href="<?php echo 'http://twitthis.com/twit?url=' . $urlencode . '&title=' . $album->getTitle(); ?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Twitter')?>')" class="sesbasic_icon_btn sesbasic_icon_twitter_btn"><i class="fa fa-twitter"></i></a>
	      <a href="<?php echo 'http://pinterest.com/pin/create/button/?url='.$urlencode; ?>&media=<?php echo urlencode((strpos($album->getPhotoUrl('thumb.main'),'http') === FALSE ? (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] ) : $album->getPhotoUrl('thumb.main')) . $album->getPhotoUrl('thumb.main')); ?>&description=<?php echo $album->getTitle();?>" onclick="return socialSharingPopUp(this.href,'<?php echo $this->translate('Pinterest'); ?>')" class="sesbasic_icon_btn sesbasic_icon_pintrest_btn"><i class="fa fa-pinterest"></i></a>
	    <?php }
	    $canComment = $this->group->authorization()->isAllowed($this->viewer, 'comment');

	    if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && isset($this->likeButton) && $canComment){  ?>
	      <!--Album Like Button-->
	      <?php $albumLikeStatus = Engine_Api::_()->sesgroupalbum()->getLikeStatusGroup($album->album_id,'sesgroupalbum_album'); ?>
	      <a href="javascript:;" data-src='<?php echo $album->album_id; ?>' class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesgroupalbum_albumlike <?php echo ($albumLikeStatus) ? 'button_active' : '' ; ?>">
		<i class="fa fa-thumbs-up"></i>
		<span><?php echo $album->like_count; ?></span>
	      </a>
	    <?php } if(isset($this->favouriteButton) && Engine_Api::_()->user()->getViewer()->getIdentity() !=0 && $canComment){ ?>
	     <?php $favStatus = Engine_Api::_()->getDbtable('favourites', 'sesgroupalbum')->isFavourite(array('resource_type'=>'sesgroupalbum_album','resource_id'=>$album->album_id)); ?>
        <a href="javascript:;" data-src='<?php echo $album->album_id; ?>' class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesgroupalbum_albumFav <?php echo ($favStatus) ? 'button_active' : '' ; ?>">
          <i class="fa fa-heart"></i>
          <span><?php echo $album->favourite_count; ?></span>
        </a>
        <?php }
        ?>
	    
	  </span>
	<?php }  ?>
	<?php if(isset($this->like) || isset($this->favouriteCount) || isset($this->comment) ||  isset($this->view) || isset($this->title) || isset($this->photoCount) ||  isset($this->by)){ ?>
	  <p class="sesgroupalbum_list_grid_info sesbasic_clearfix<?php if(!isset($this->photoCount)) { ?> nophotoscount<?php } ?>">
	    <?php if(isset($this->title)) { ?>
	      <span class="sesgroupalbum_list_grid_title">
		<?php echo $this->htmlLink($album, $this->string()->truncate($album->getTitle(), $this->title_truncation),array('title'=>$album->getTitle())) ; ?>
	      </span>
	    <?php } ?>
	    <span class="sesgroupalbum_list_grid_stats">
	      <?php if(isset($this->by)) { ?>
		<span class="sesgroupalbum_list_grid_owner">
		  <?php echo $this->translate('By');
      	$albumOwner  = Engine_Api::_()->getItem('user',$album->owner_id);
      ?>
		  <?php echo $this->htmlLink($albumOwner->getHref(), $albumOwner->getTitle(), array('class' => 'thumbs_author')) ?>
		</span>
	      <?php }?>
	    </span>
	    <span class="sesgroupalbum_list_grid_stats sesbasic_text_light">
	      <?php if(isset($this->like) && isset($album->like_count)) { ?>
		<span class="sesgroupalbum_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $album->like_count), $this->locale()->toNumber($album->like_count))?>">
		  <i class="fa fa-thumbs-up"></i>
		  <?php echo $album->like_count;?>
	      </span>
	      <?php } ?>
         <?php if(isset($this->favouriteCount)) { ?>
		  <span class="sesbasic_list_grid_fav" title="<?php echo $this->translate(array('%s favourite', '%s favourites', $album->favourite_count), $this->locale()->toNumber($album->favourite_count))?>">
	    <i class="fa fa-heart"></i>
	    <?php echo $album->favourite_count;?>
		  </span>
			<?php } ?>
	      <?php if(isset($this->comment)) { ?>
		<span class="sesgroupalbum_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $album->comment_count), $this->locale()->toNumber($album->comment_count))?>">
		  <i class="fa fa-comment"></i>
		  <?php echo $album->comment_count;?>
		</span>
	      <?php } ?>
	      <?php if(isset($this->view)) { ?>
		<span class="sesgroupalbum_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $album->view_count), $this->locale()->toNumber($album->view_count))?>">
		  <i class="fa fa-eye"></i>
		  <?php echo $album->view_count;?>
		</span>
	      <?php } ?>
	      <?php if(isset($this->photoCount)) { ?>
		<span class="sesgroupalbum_list_grid_count" title="<?php echo $this->translate(array('%s photo', '%s photos', $album->count()), $this->locale()->toNumber($album->count()))?>" >
		  <i class="fa fa-photo"></i> 
		  <?php echo $album->count();?>
		</span>
	      <?php } ?>
	    </span>
	  </p>
	<?php } ?>
      </li>
    <?php }?>
  <?php endforeach;?>
  <?php if($this->load_content == 'pagging'){ ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesgroupalbum"),array('identityWidget'=>$randonNumber)); ?>
  <?php } ?>
  <?php if(!$this->is_ajax){ ?>
     </ul>
    </div>  
    <?php if($this->load_content != 'pagging'){ ?>
      <div class="sesbasic_view_more" id="view_more_<?php echo $randonNumber; ?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
	<?php echo $this->htmlLink('javascript:void(0);', $this->translate('View More'), array('id' => "feed_viewmore_link_$randonNumber", 'class' => 'buttonlink icon_viewmore')); ?> 
      </div>
      <div class="sesbasic_view_more_loading" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;">
	<img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Sesbasic/externals/images/loading.gif' />
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
      'url': en4.core.baseUrl + "widget/index/mod/sesgroupalbum/name/profile-photos",
      'data': {
      format: 'html',
      page: pageNum,    
      params :params<?php echo $randonNumber; ?>, 
      is_ajax : 1,
      searchParams : searchParams<?php echo $randonNumber; ?>,
      identity : identity<?php echo $randonNumber; ?>,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      if($('loadingimgsesgroupalbum-wrapper'))
	sesJqueryObject('#loadingimgsesgroupalbum-wrapper').hide();
	sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','none');
	document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;	sesJqueryObject('#paginator_count_sesgroupalbum').find('#total_item_count_sesgroupalbum').html(sesJqueryObject('#paginator_count_ajax_sesgroupalbum').find('#total_item_count_sesgroupalbum').html());
	sesJqueryObject('#paginator_count_ajax_sesgroupalbum').remove();
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
      'url': en4.core.baseUrl + 'widget/index/mod/sesgroupalbum/name/profile-photos/index/',
      'data': {
	format: 'html',
	page: page<?php echo $randonNumber; ?>,    
	params :params<?php echo $randonNumber; ?>, 
	is_ajax : 1,
	searchParams : searchParams<?php echo $randonNumber; ?>,
	identity : identity<?php echo $randonNumber; ?>,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if($('loadingimgsesgroupalbum-wrapper'))
	sesJqueryObject('#loadingimgsesgroupalbum-wrapper').hide();
	document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
	sesJqueryObject('#paginator_count_sesgroupalbum').find('#total_item_count_sesgroupalbum').html(sesJqueryObject('#paginator_count_ajax_sesgroupalbum').find('#total_item_count_sesgroupalbum'));
	sesJqueryObject('#paginator_count_ajax_sesgroupalbum').remove();
	//document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'block';
	document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
  };
</script>