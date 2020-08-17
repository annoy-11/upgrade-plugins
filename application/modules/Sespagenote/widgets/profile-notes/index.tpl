<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagenote/externals/styles/style.css'); ?> 
<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
  <?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
  <?php $randonNumber = $this->identity;?>
<?php endif;?>
<?php if(!$this->is_ajax): ?>
<div class="sespage_profile_tab_wrapper sespage_profile_photos sesbasic_bxs">
    <div class="sespage_profile_content_search sesbasic_clearfix">
      <div class="_input">
        <input placeholder="<?php echo $this->translate('Search'); ?>" type="text" id="note_text_search" name="note_text_search" />
      </div>
      <div class="_select">
        <select onchange="noteSearch(this.value);" id="note_browsebyoptions">
          <option value="creation_date"><?php echo $this->translate("Recently Created"); ?></option>
          <option value="like_count"><?php echo $this->translate("Most Liked"); ?></option>
          <option value="view_count"><?php echo $this->translate("Most Viewed"); ?></option>
          <option value="comment_count"><?php echo $this->translate("Most Commented"); ?></option>
          <option value="favourite_count"><?php echo $this->translate("Most Favourite"); ?></option>
        </select>
      </div>
      
      <?php if((!$this->is_ajax) && $this->canCreate && ($this->paginator->count() > 1 || $this->canUpload ) && (!$this->page_note_count || $this->paginator->getTotalItemCount() <= $this->page_note_count)): ?> 
        <?php if( $this->canUpload ): ?>
          <div class="_addbtn">
            <?php echo $this->htmlLink(array(
              'route' => 'sespagenote_general',
              'controller' => 'index',
              'action' => 'create',
              'parent_id' => $this->page_id,
              ), $this->translate('Create Note'), array(
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
      <ul class="sespagenote_profile_listings sesbasic_bxs sesbasic_clearfix" id="tabbed-widget_<?php echo $randonNumber; ?>">
  <?php endif;?>
  <?php if($this->paginator->getTotalItemCount() > 0) { ?>
		<?php foreach( $this->paginator as $item ): ?>
      <?php $resource = Engine_Api::_()->getItem('sespage_page', $item->parent_id); ?>
      <li class="sesbasic_bg">
     		<article class="sesbasic_bg">  
        <div class="sespagenote_profile_top">
         <div class="sespagenote_profile_inner">
					<a href="<?php echo $item->getHref(); ?>" class="sespagenote_profile_img">
						<span style="background-image: url(<?php echo $item->getPhotoUrl(); ?>);"></span>
					</a>
            <!-- Share Buttons -->
            <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataSharing.tpl';?>
            <!-- Labels -->
            <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataLabel.tpl';?>
            
            <?php if($this->pagenameActive) { ?>
            <?php $page = Engine_Api::_()->getItem('sespage_page', $item->parent_id); ?>
            <span class="sespagenote_pagename"> 
                <i class="fa fa-file-text"></i> <a href="<?php echo $page->getHref(); ?>"><?php echo $page->getTitle(); ?></a>
            </span>
          <?php } ?>
          </div>
          <div class="sespagenote_profile_body">
					  <span class="_name"><?php echo $this->htmlLink($item, Engine_Api::_()->sesbasic()->textTruncation($item->getTitle(), $this->grid_title_truncation), array('title' => $item->getTitle())) ?></span>
              <span class="_owner sesbasic_text_light">
								<?php if(isset($this->byActive)) { ?>
									<span>
										<?php echo $this->translate('<i class="fa fa-user"></i>');
											$itemOwner  = Engine_Api::_()->getItem('user',$item->owner_id); ?>
										<?php echo $this->htmlLink($itemOwner->getHref(), $itemOwner->getTitle(), array('class' => 'thumbs_author')) ?>
									</span>
								<?php }?>
                <?php if($this->posteddateActive) { ?>
                  <span>
                    <i class="fa fa-clock-o"></i> <?php echo $this->timestamp($item->creation_date) ?>
                  </span>
                <?php } ?>
							</span>
							<?php if($this->descriptionActive) { ?>
                <span class="_desc sesbasic_text_light">
                  <?php $ro = preg_replace('/\s+/', ' ',$item->body);?>
                  <?php $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));?>
                  <?php  echo nl2br( Engine_String::strlen($tmpBody) > $this->grid_description_truncation ? Engine_String::substr($tmpBody, 0, $this->grid_description_truncation) . '...' : $tmpBody );?>
                </span>
              <?php } ?>
          </div>
          <?php if($this->canEdit || $this->canDelete) { ?>
            <div class="sespagenote_control_btns">
              <?php if($this->canEdit && ($item->owner_id == $this->viewer->getIdentity() || $resource->owner_id == $this->viewer->getIdentity())) { ?>
              <?php echo $this->htmlLink(array('route' => 'sespagenote_general', 'controller' => 'index', 'action' => 'edit', 'parent_id' => $item->parent_id, 'pagenote_id' => $item->getIdentity(), 'reset' => true,), $this->translate('<i class="fa fa-pencil"></i>'), array('class' => 'buttonlink', 'title' => 'Edit')); ?>
              <?php } ?>
              <?php if($this->canDelete && ($item->owner_id == $this->viewer->getIdentity() || $resource->owner_id == $this->viewer->getIdentity())) { ?>
              <?php echo $this->htmlLink(array('route' => 'sespagenote_general','controller' => 'index', 'action' => 'delete','parent_id' => $item->parent_id, 'pagenote_id' => $item->getIdentity(), 'format' => 'smoothbox'), $this->translate('<i class="fa fa-trash"></i>'), array('class' => 'buttonlink smoothbox','title' => 'Delete')); ?>
              <?php } ?>
            </div>
          <?php } ?>
           <!-- Stats -->
           <?php include APPLICATION_PATH .  '/application/modules/Sespagenote/views/scripts/_dataStatics.tpl';?>
				</article>
      </li>
		<?php endforeach;?>
  <?php } else { ?>
		<div class="tip">
			<span>
				<?php echo $this->translate('No notes were found matching your search criteria.');?>
			</span>
		</div>
  <?php } ?>
  <?php if($this->load_content == 'pagging'){ ?>
    <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sespage"),array('identityWidget'=>$randonNumber)); ?>
  <?php } ?>
  <?php if(!$this->is_ajax){ ?>
     </ul>
     <div class="sesbasic_loading_cont_overlay" id="notewidgetoverlay"></div>
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
      'url': en4.core.baseUrl + "widget/index/mod/sespagenote/name/profile-notes",
      'data': {
      format: 'html',
      page: pageNum,    
      params :params<?php echo $randonNumber; ?>, 
      is_ajax : 1,
      searchParams : searchParams<?php echo $randonNumber; ?>,
      identity : identity<?php echo $randonNumber; ?>,
      sort:$('note_browsebyoptions').value,
      search:$('note_text_search').value,
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
      'url': en4.core.baseUrl + 'widget/index/mod/sespagenote/name/profile-notes/index/',
      'data': {
	format: 'html',
	page: page<?php echo $randonNumber; ?>,    
	params :params<?php echo $randonNumber; ?>, 
	is_ajax : 1,
	searchParams : searchParams<?php echo $randonNumber; ?>,
	identity : identity<?php echo $randonNumber; ?>,
  sort:$('note_browsebyoptions').value,
  search:$('note_text_search').value,
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
  
  function noteSearch() {
  
    document.getElementById('notewidgetoverlay').style.display = 'block';   
    
    (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + 'widget/index/mod/sespagenote/name/profile-notes/index/',
      'data': {
        format: 'html',
        page: page<?php echo $randonNumber; ?>,    
        params :params<?php echo $randonNumber; ?>, 
        is_ajax : 1,
        sort:$('note_browsebyoptions').value,
        search:$('note_text_search').value,
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
        
        document.getElementById('notewidgetoverlay').style.display = 'none';  
      }
    })).send();
    return false;

  
  }
  
  en4.core.runonce.add(function() {
    var url = en4.core.baseUrl + 'widget/index/mod/sespagenote/name/profile-notes/index/';
    $('note_text_search').addEvent('keypress', function(e) {
      if( e.key != 'enter' ) return;
      noteSearch();
    })
  });
</script>
