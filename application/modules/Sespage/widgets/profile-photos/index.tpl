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

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/style_album.css'); ?> 
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
  <?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
  <?php $randonNumber = $this->identity;?>
<?php endif;?>
<?php if(!$this->is_ajax): ?>
<div class="sespage_profile_tab_wrapper sespage_profile_photos sesbasic_bxs">
  
    <div class="sespage_profile_content_search sesbasic_clearfix">
      <div class="_input">
        <input placeholder="<?php echo $this->translate('Search'); ?>" type="text" id="album_text_search" name="album_text_search" />
      </div>
      <div class="_select">
        <select onchange="albumSearch(this.value);" id="album_browsebyoptions">
          <option value="creation_date"><?php echo $this->translate("Recently Created"); ?></option>
          <option value="most_liked"><?php echo $this->translate("Most Liked"); ?></option>
          <option value="most_viewed"><?php echo $this->translate("Most Viewed"); ?></option>
          <option value="most_commented"><?php echo $this->translate("Most Commented"); ?></option>
        </select>
      </div>
      <?php if((!$this->is_ajax) && ($this->paginator->count() > 1 || $this->canUpload ) && (!$this->page_album_count || $this->paginator->getTotalItemCount() <= $this->page_album_count)): ?> 
        <?php if( $this->canUpload ): ?>
          <div class="_addbtn">
            <?php echo $this->htmlLink(array(
              'route' => 'sespage_extended',
              'controller' => 'album',
              'action' => 'create',
              'page_id' => $this->page_id,
              ), $this->translate('Add New Album'), array(
              'class' => 'sesbasic_button sesbasic_icon_add sespage_cbtn'
            )) ?>
          </div>  
        <?php endif; ?>
      <?php endif; ?>
    </div>
  
    <script type="application/javascript">
    var tabId_pPhoto = <?php echo $this->identity; ?>;
    window.addEvent('domready', function() {
      tabContainerHrefSesbasic(tabId_pPhoto);	
    });
    </script>
    <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="prelative">
      <ul class="sespage_album_listings sespage_browse_album_listings sesbasic_bxs sesbasic_clearfix" id="tabbed-widget_<?php echo $randonNumber; ?>">
  <?php endif;?>
  <?php if($this->paginator->getTotalItemCount() > 0) { ?>
  <?php foreach( $this->paginator as $album ): ?>
    <?php if($this->view_type == 1){ ?>
      <li id="thumbs-photo-<?php echo $album->photo_id ?>" class="sespage_album_list_grid_thumb sespage_album_list_grid sespa-i-<?php echo (isset($this->insideOutside) && $this->insideOutside == 'outside') ? 'outside' : 'inside'; ?> sespa-i-<?php echo (isset($this->fixHover) && $this->fixHover == 'fix') ? 'fix' : 'over'; ?>" style="width:<?php echo is_numeric($this->width) ? $this->width.'px' : $this->width ?>;">
     		<article>  
          <a class="sespage_album_list_grid_img" href="<?php echo Engine_Api::_()->sespage()->getHref($album->getIdentity(),$album->album_id); ?>" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;">
            <span class="main_image_container" style="background-image: url(<?php echo $album->getPhotoUrl('thumb.normalmain'); ?>);"></span>
            <div class="ses_image_container" style="display:none;">
              <?php $image = Engine_Api::_()->sespage()->getAlbumPhoto($album->getIdentity(),$album->photo_id);
              foreach($image as $key=>$valuePhoto){?>
                <div class="child_image_container"><?php echo $valuePhoto->getPhotoUrl('thumb.normalmain');  ?></div>
              <?php  }  ?>  
              <div class="child_image_container"><?php echo $album->getPhotoUrl('thumb.normalmain'); ?></div>          
            </div>
          </a>
        <?php  if(isset($this->socialSharing) || isset($this->likeButton)){  ?>
          <span class="sespage_album_list_grid_btns">
            <?php if(isset($this->socialSharing)){ 
              //album viewpage link for sharing
              $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $album->getHref());
              ?>
              <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $album, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
            <?php }
            $canComment = $this->pageItem->authorization()->isAllowed($this->viewer, 'comment');;
            if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 && isset($this->likeButton) && $canComment){  ?>
              <!--Album Like Button-->
              <?php $albumLikeStatus = Engine_Api::_()->sespage()->getLikeStatusPage($album->album_id,'sespage_album'); ?>
              <a href="javascript:;" data-url='<?php echo $album->album_id; ?>' class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sespage_albumlike <?php echo ($albumLikeStatus) ? 'button_active' : '' ; ?>">
              <i class="fa fa-thumbs-up"></i>
              <span><?php echo $album->like_count; ?></span>
                  </a>
            <?php }  ?>
          </span>
        <?php } ?>
        <?php if(isset($this->like) || isset($this->comment) || isset($this->view) || isset($this->title) || isset($this->photoCount) ||  isset($this->by)){ ?>
          <p class="sespage_album_list_grid_info sesbasic_clearfix<?php if(!isset($this->photoCount)) { ?> nophotoscount<?php } ?>">
            <?php if(isset($this->title)) { ?>
              <span class="sespage_album_list_grid_title">
          <?php echo $this->htmlLink($album, $this->string()->truncate($album->getTitle(), $this->title_truncation),array('title'=>$album->getTitle())) ; ?>
              </span>
            <?php } ?>
            <span class="sespage_album_list_grid_stats">
              <?php if(SESPAGESHOWUSERDETAIL == 1 && isset($this->by)) { ?>
          <span class="sespage_album_list_grid_owner">
            <?php echo $this->translate('By');
              $albumOwner  = Engine_Api::_()->getItem('user',$album->owner_id);
            ?>
            <?php echo $this->htmlLink($albumOwner->getHref(), $albumOwner->getTitle(), array('class' => 'thumbs_author')) ?>
          </span>
              <?php }?>
            </span>
            <span class="sespage_album_list_grid_stats sesbasic_text_light">
              <?php if(isset($this->like) && isset($album->like_count)) { ?>
          <span class="sespage_album_list_grid_likes" title="<?php echo $this->translate(array('%s like', '%s likes', $album->like_count), $this->locale()->toNumber($album->like_count))?>">
            <i class="fa fa-thumbs-up"></i>
            <?php echo $album->like_count;?>
              </span>
              <?php } ?>
              <?php if(isset($this->comment)) { ?>
          <span class="sespage_album_list_grid_comment" title="<?php echo $this->translate(array('%s comment', '%s comments', $album->comment_count), $this->locale()->toNumber($album->comment_count))?>">
            <i class="fa fa-comment"></i>
            <?php echo $album->comment_count;?>
          </span>
              <?php } ?>
              <?php if(isset($this->view)) { ?>
          <span class="sespage_album_list_grid_views" title="<?php echo $this->translate(array('%s view', '%s views', $album->view_count), $this->locale()->toNumber($album->view_count))?>">
            <i class="fa fa-eye"></i>
            <?php echo $album->view_count;?>
          </span>
              <?php } ?>
              <?php if(isset($this->photoCount)) { ?>
          <span class="sespage_album_list_grid_count" title="<?php echo $this->translate(array('%s photo', '%s photos', $album->count()), $this->locale()->toNumber($album->count()))?>" >
            <i class="fa fa-photo"></i> 
            <?php echo $album->count();?>                
          </span>
              <?php } ?>
            </span>
          </p>
        <?php } ?>
        <?php if(isset($this->photoCount)) { ?>
          <p class="sespage_album_list_grid_count">
            <?php echo $this->translate(array('%s <span>photo</span>', '%s <span>photos</span>', $album->count()),$this->locale()->toNumber($album->count())); ?>
          </p>
        <?php } ?>
  		</article>
      </li>
    <?php }?>
  <?php endforeach;?>
  <?php } else { ?>
		<div class="tip">
			<span>
				<?php echo $this->translate('No albums were found matching your search criteria.');?>
			</span>
		</div>
  <?php } ?>
  <?php if($this->load_content == 'pagging'){ ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sespage"),array('identityWidget'=>$randonNumber)); ?>
  <?php } ?>
  <?php if(!$this->is_ajax){ ?>
     </ul>
     <div class="sesbasic_loading_cont_overlay" id="albumwidgetoverlay"></div>
    </div>  
    <?php if($this->load_content != 'pagging'){ ?>      
    	<div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" > 
      	<a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
      </div>
  		<div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span> </div>  
    <?php } ?>
  <?php } ?>
</div>  
<?php if($this->load_content == 'auto_load'){ ?>
  <script type="text/javascript">
  window.addEvent('load', function() {
    sesJqueryObject(window).scroll( function() {
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
      'url': en4.core.baseUrl + "widget/index/mod/sespage/name/profile-photos",
      'data': {
      format: 'html',
      page: pageNum,    
      params :params<?php echo $randonNumber; ?>, 
      is_ajax : 1,
      searchParams : searchParams<?php echo $randonNumber; ?>,
      identity : identity<?php echo $randonNumber; ?>,
      sort:$('album_browsebyoptions').value,
      search:$('album_text_search').value,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      if($('loadingimgsespage-wrapper'))
	sesJqueryObject('#loadingimgsespage-wrapper').hide();
	sesJqueryObject ('.overlay_<?php echo $randonNumber ?>').css('display','none');
	document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;	sesJqueryObject('#paginator_count_sespage').find('#total_item_count_sespage').html(sesJqueryObject('#paginator_count_ajax_sespage').find('#total_item_count_sespage').html());
	sesJqueryObject('#paginator_count_ajax_sespage').remove();
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
      'url': en4.core.baseUrl + 'widget/index/mod/sespage/name/profile-photos/index/',
      'data': {
	format: 'html',
	page: page<?php echo $randonNumber; ?>,    
	params :params<?php echo $randonNumber; ?>, 
	is_ajax : 1,
	searchParams : searchParams<?php echo $randonNumber; ?>,
	identity : identity<?php echo $randonNumber; ?>,
  sort:$('album_browsebyoptions').value,
  search:$('album_text_search').value,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if($('loadingimgsespage-wrapper'))
	sesJqueryObject('#loadingimgsespage-wrapper').hide();
	document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
	sesJqueryObject('#paginator_count_sespage').find('#total_item_count_sespage').html(sesJqueryObject('#paginator_count_ajax_sespage').find('#total_item_count_sespage'));
	sesJqueryObject('#paginator_count_ajax_sespage').remove();
	//document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'block';
	document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
      }
    })).send();
    return false;
  }
  
  function albumSearch() {
  
    document.getElementById('albumwidgetoverlay').style.display = 'block';   
    
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/sespage/name/profile-photos/index/',
      'data': {
        format: 'html',
        page: page<?php echo $randonNumber; ?>,    
        params :params<?php echo $randonNumber; ?>, 
        is_ajax : 1,
        sort:$('album_browsebyoptions').value,
        search:$('album_text_search').value,
        searchParams : searchParams<?php echo $randonNumber; ?>,
        identity : identity<?php echo $randonNumber; ?>,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if($('loadingimgsespage-wrapper'))
          sesJqueryObject('#loadingimgsespage-wrapper').hide();
          
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
        
        sesJqueryObject('#paginator_count_sespage').find('#total_item_count_sespage').html(sesJqueryObject('#paginator_count_ajax_sespage').find('#total_item_count_sespage'));
        
        sesJqueryObject('#paginator_count_ajax_sespage').remove();
        
        //document.getElementById('view_more_<?php //echo $randonNumber; ?>').style.display = 'block';
        
        document.getElementById('albumwidgetoverlay').style.display = 'none';  
      }
    })).send();
    return false;

  
  }
  
  en4.core.runonce.add(function() {
    var url = en4.core.baseUrl + 'widget/index/mod/sespage/name/profile-photos/index/';
    $('album_text_search').addEvent('keypress', function(e) {
      if( e.key != 'enter' ) return;
      albumSearch();
    })
  });
</script>
