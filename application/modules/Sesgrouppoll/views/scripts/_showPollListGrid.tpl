<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showPollListGrid.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $groupNameSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroup.show.userdetail', 0);?>
<?php $gridclass = $this->gridlist? "sesgrouppoll_twoitems" : ""; ?>
<?php $randonNumber = $this->widgetId; ?>
<?php $widgetType = 'profile-page';?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $counter = 0;?>
<?php if(isset($this->page_id)):?>
  <?php $pageId = $this->page_id;?>
<?php else:?>
  <?php $pageId = 0;?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  <style>
  .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesgroup/externals/styles/styles.css'); ?>
  <?php if(isset($this->optionsEnable) && @in_array('pinboard',$this->optionsEnable)):?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
  <?php endif;?>
  <div id="browse-widget_<?php echo $randonNumber;?>" class="sesbasic_view_type_<?php echo $randonNumber;?>  sesbasic_clearfix clear">
<?php } ?>
    <?php if(isset($this->params['show_item_count']) && $this->params['show_item_count']){ ?>
      <div class="sesbasic_clearfix sesbm sesgroup_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sesgrouppoll' : 'paginator_count_ajax_sesgrouppoll_entry' ?>"><span id="total_item_count_sesgroup_entry" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("page found.") : $this->translate("pages found."); ?></div>
    <?php } ?>
<?php if(!$this->is_ajax){ ?>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
  <ul class="sesgrouppoll_poll_listing sesbasic_clearfix <?php echo $gridclass; ?> clear" id="tabbed-widget_<?php echo $randonNumber; ?>"   style="min-height:50px;">
<?php } ?>
<?php if(0 == count($this->paginator)): ?>
<div class="tip">
    <span>
      <?php echo $this->translate('There are no polls yet.') ?>
    </span>
</div>
<?php else: ?>
<?php foreach($this->paginator as $poll):?>
 <li id="poll-item-<?php echo $poll->poll_id ?>" style="height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;">
 <?php echo $this->htmlLink(
    $poll->getHref(),
    $this->itemPhoto($poll->getOwner(), 'thumb.icon', $poll->getOwner()->getTitle()),
    array('class' => 'polls_browse_photo')
    ) ?>
    <div class="sesgrouppoll_browse_info">
      <h3 class="sesgrouppoll_browse_info_title">
		  <?php if((in_array("title", $this->show_criteria))): ?>
		  <?php if(strlen($poll->getTitle()) > $this->title_truncation):?>
		  <?php $title = mb_substr($poll->getTitle(),0,$this->title_truncation).'...';?>
		  <?php else:?>
		  <?php $title = $poll->getTitle();?>
		  <?php endif; ?>
		  <?php echo $this->htmlLink($poll->getHref(), $title) ?>
		  <?php endif; ?>
      </h3>
<?php $groupItem = Engine_Api::_()->getItem('sesgroup_group',$poll->group_id); ?>
		<?php if($groupItem): ?>
		<?php if((in_array("by", $this->show_criteria)) && (in_array("in", $this->show_criteria))): ?>
			<?php if($groupNameSetting): ?>
				<div class="sesgrouppolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate('Posted by %s in %s ', $this->htmlLink($poll->getOwner(), $poll->getOwner()->getTitle()),$this->htmlLink($groupItem->getHref(), $groupItem->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			<?php else: ?>
				<div class="sesgrouppolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate(' in %s ',$this->htmlLink($groupItem->getHref(), $groupItem->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			<?php endif  ?>
		<?php elseif((in_array("by", $this->show_criteria)) && !(in_array("in", $this->show_criteria))): ?>
                         <?php if($groupNameSetting): ?>
			<div class="sesgrouppolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate('Posted by %s',$this->htmlLink($poll->getOwner(), $poll->getOwner()->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
                     	<?php endif; ?>
		<?php elseif(!(in_array("by", $this->show_criteria)) && (in_array("in", $this->show_criteria))): ?>
			
				<div class="sesgrouppolls_browse_info_date sesbasic_text_light">
				 <?php echo $this->translate(' in %s', $this->htmlLink($groupItem->getHref(), $groupItem->getTitle())) ?>
			 	 <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			
		<?php endif; ?>
		<?php endif; ?>
		<?php $item = $poll; ?>
      <div class="stats sesbasic_text_light">
						<?php if((in_array("view", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s view', '%s views', $item->view_count), $this->locale()->toNumber(	$item->view_count)) ?>">
								<i class="fa fa-eye"></i> <span><?php echo $item->view_count ;?></span>
							</span>
						<?php endif; ?>
						<?php if((in_array("comment", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s comment', '%s comments', $item->comment_count), $this->locale()->toNumber(	$item->view_count)) ?>">
								<i class="fa fa-comment"></i> <span><?php echo $item->comment_count ;?></span>
							</span>
						<?php endif; ?>
						<?php if((in_array("like", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s like', '%s likes', $item->like_count), $this->locale()->toNumber(	$item->like_count)) ?>">
								<i class="fa fa-thumbs-up"></i> <span><?php echo $item->like_count ;?></span>
							</span>
						<?php endif; ?>
						<?php if((in_array("favourite", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s favourite', '%s favourites', $item->favourite_count), $this->locale()->toNumber(	$item->favourite_count)) ?>">
								<i class="fa fa-heart"></i> <span><?php echo $item->favourite_count ;?></span>
							</span>
						<?php endif; ?>
						<?php if((in_array("vote", $this->show_criteria))): ?>
							<span title="<?php echo $this->translate(array('%s vote', '%s votes', $item->vote_count), $this->locale()->toNumber(	$item->vote_count)) ?>">
								<i class="fa fa-hand-o-up"></i><span><?php echo $item->vote_count ;?></span>
							</span>
						<?php endif; ?>
					</div>
		 <?php if((in_array("description", $this->show_criteria))): ?>
			<?php if (!empty($poll->description)): ?>
				<?php if(strlen($poll->description) > $this->title_truncation):?>
					<?php $description = mb_substr($poll->description,0,$this->title_truncation).'...';?>
				<?php else:?>
					<?php $description = $poll->description;?>
				<?php endif; ?>
				<?php if($description): ?>
					<div class="sesgrouppoll_browse_info_desc sesbasic_text_light">
						<?php echo $description; ?>
					</div>
				<?php endif; ?>	
			<?php endif; ?>
		<?php endif; ?>
		
		<?php // polls like favourite ?>
    <div class="sesgrouppoll_stats">
		<div class="_btnsleft">
		  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
		  <?php $viewerId = $viewer->getIdentity();?>
		  <?php if($viewerId ):?>
			<?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesgrouppoll_poll', $viewer, 'create');?>
			<?php  if($canComment && in_array("likeButton", $this->show_criteria)):?>
			  <?php $likeStatus = Engine_Api::_()->sesgroup()->getLikeStatus($poll->poll_id,'sesgrouppoll_poll'); ?>
			  <a href="javascript:;" data-type="like_view" data-url="<?php echo $poll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesgrouppoll_like_<?php echo $poll->poll_id ?> sesgrouppoll_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $poll->like_count;?></span></a>
			<?php endif;?>
			  <?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.allow.favourite', 1) && in_array("favouriteButton", $this->show_criteria)):?>
				<?php 	$value['resource_type'] = 'sesgrouppoll_poll';
						$value['resource_id'] = $poll->poll_id;
						$favouriteStatus = Engine_Api::_()->getDbTable('Favourites', 'sesgrouppoll')->isFavourite($value);
				$favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesgrouppoll')->isFavourite(array('resource_id' => $poll->poll_id,'resource_type' => 'sesgrouppoll_poll')); ?>
				<a href="javascript:;" data-type="favourite_view" data-url="<?php echo $poll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesgrouppoll_favourite_<?php echo $poll->poll_id ?> sesgrouppoll_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $poll->favourite_count;?></span></a>
			  <?php endif;?>
			<?php endif;?>
		  <?php  // endif;?>
		</div>
		<?php //end  polls like favourite ?>
	<!-- polls end  polls like favourite -->
         <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppoll.allow.share', 1);?>
		 <!-- social share -->
             <?php if(in_array("socialSharing", $this->show_criteria) && $shareType):?>
                <?php  echo $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $poll, 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
             <?php endif;?>
		 <!-- social share end -->
    </div>
    </div>
   </li>
  <?php endforeach;?>
  <?php endif ?>

<?php if($this->params['pagging'] == 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesgroup"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  </ul>
  <?php if($this->params['pagging'] != 'pagging' && $this->params['show_limited_data'] == 'no'):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
</div>
</div>
<?php if(!$this->is_ajax){ ?>
</div>
</div>
<?php } ?>
<script type="text/javascript">
  var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
  var searchParams<?php echo $randonNumber; ?> ;
  sesJqueryObject(document).ready(function() {
    if(sesJqueryObject('.sesgroup_browse_search').find('#filter_form').length) {
      var search = sesJqueryObject('.sesgroup_browse_search').find('#filter_form');
      searchParams<?php echo $randonNumber; ?> = search.serialize();
    }
  });
  var requestTab_<?php echo $randonNumber; ?>;
  var valueTabData ;
    // globally define available tab array
  <?php if($this->params['pagging'] == 'auto_load' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')){  ?>
    window.addEvent('load', function() {
      sesJqueryObject(window).scroll( function() {
        var heightOfContentDiv_<?php echo $randonNumber; ?> = sesJqueryObject('#scrollHeightDivSes_<?php echo $randonNumber; ?>').offset().top;
		console.log()
        var fromtop_<?php echo $randonNumber; ?> = sesJqueryObject(this).scrollTop();
        if(fromtop_<?php echo $randonNumber; ?> > heightOfContentDiv_<?php echo $randonNumber; ?> - 100 && sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display') == 'block' ){
          document.getElementById('feed_viewmore_link_<?php echo $randonNumber; ?>').click();
        }
      });
    });
  <?php } ?>
  sesJqueryObject(document).on('click','.selectView_<?php echo $randonNumber; ?>',function(){
    //if(sesJqueryObject(this).hasClass('active'))
   // return;
    //if($("view_more_<?php echo $randonNumber; ?>"))
     // document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';
    //document.getElementById("tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";
   // sesJqueryObject('#sesgroup_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
   // sesJqueryObject('#sesgroup_simplegrid_view_<?php echo $randonNumber; ?>').removeClass('active');
   // sesJqueryObject('#sesgroup_advgrid_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#sesgroup_list_view_<?php echo $randonNumber; ?>').removeClass('active');
   // sesJqueryObject('#sesgroup_advlist_view_<?php echo $randonNumber; ?>').removeClass('active');
    //sesJqueryObject('#sesgroup_pinboard_view_<?php echo $randonNumber; ?>').removeClass('active');
    //sesJqueryObject('#sesgroup_map_view_<?php echo $randonNumber; ?>').removeClass('active');
   // sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','none');
   // sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');
   // sesJqueryObject(this).addClass('active');
    if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
      requestTab_<?php echo $randonNumber; ?>.cancel();
    }
    if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {
      requestViewMore_<?php echo $randonNumber; ?>.cancel();
    }
    requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/sesgroup/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
      'data': {
          format: 'html',
          page: 1,
          type:sesJqueryObject(this).attr('rel'),
          is_ajax : 1,
          searchParams: searchParams<?php echo $randonNumber; ?>,
          identity : '<?php echo $randonNumber; ?>',
          widget_id: '<?php echo $this->widgetId;?>',
          getParams:'<?php echo $this->getParams;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
          page_id:1,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
        var totalPage= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesgrouppoll_entry");
        sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesgrouppoll').html(totalPage.html());
        totalPage.remove();
        if($("loading_image_<?php echo $randonNumber; ?>"))
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
        if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber;?>').find('.active').attr('rel') == 'map'){
          var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
            if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
              oldMapData_<?php echo $randonNumber; ?> = [];
              newMapData_<?php echo $randonNumber ?> = mapData;
              loadMap_<?php echo $randonNumber ?> = true;
              sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
              initialize_<?php echo $randonNumber?>();	
              mapFunction_<?php echo $randonNumber?>();
            }
            else {
              sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
              initialize_<?php echo $randonNumber?>();	
            }
        }
        pinboardLayout_<?php echo $randonNumber ?>('true');
       }
      })).send();
    });
  </script>
  <?php } ?>
  <?php if(!$this->is_ajax){ ?>
  <script type="application/javascript">
    var wookmark = undefined;
    //Code for Pinboard View
    var wookmark<?php echo $randonNumber ?>;
    function pinboardLayout_<?php echo $randonNumber ?>(force){
      if(sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') != 'pinboard'){
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').removeClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
        sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').css('height','');
        return;
      }
      sesJqueryObject('.new_image_pinboard_<?php echo $randonNumber; ?>').css('display','none');
      var imgLoad = imagesLoaded('#tabbed-widget_<?php echo $randonNumber; ?>');
      imgLoad.on('progress',function(instance,image){
        sesJqueryObject(image.img).parent().parent().parent().parent().parent().show();
        sesJqueryObject(image.img).parent().parent().parent().parent().parent().removeClass('new_image_pinboard_<?php echo $randonNumber; ?>');
        imageLoadedAll<?php echo $randonNumber ?>(force);
      });
    }
    function imageLoadedAll<?php echo $randonNumber ?>(force){
      sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard_<?php echo $randonNumber; ?>');
      sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').addClass('sesbasic_pinboard');
      if (typeof wookmark<?php echo $randonNumber ?> == 'undefined' || typeof force != 'undefined') {
        (function() {
          function getWindowWidth() {
            return Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
          }				
          wookmark<?php echo $randonNumber ?> = new Wookmark('.sesbasic_pinboard_<?php echo $randonNumber; ?>', {
            itemWidth: <?php echo isset($this->params['width_pinboard']) ? str_replace(array('px','%'),array(''),$this->params['width_pinboard']) : '300'; ?>, // Optional min width of a grid item
            outerOffset: 0, // Optional the distance from grid to parent
            align:'left',
            flexibleWidth: function () {
              // Return a maximum width depending on the viewport
              return getWindowWidth() < 1024 ? '100%' : '40%';
            }
          });
        })();
      } else {
        wookmark<?php echo $randonNumber ?>.initItems();
        wookmark<?php echo $randonNumber ?>.layout(true);
      }
    }
    sesJqueryObject(window).resize(function(e){
      pinboardLayout_<?php echo $randonNumber ?>('',true);
    });
    <?php if($this->view_type == 'pinboard'):?>
      sesJqueryObject(document).ready(function(){
        pinboardLayout_<?php echo $randonNumber ?>();
      });
    <?php endif;?>
  </script>
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
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
      var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';  
      requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
        method: 'post',
        'url': en4.core.baseUrl + "widget/index/mod/sesgrouppoll/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: '<?php echo $this->page; ?>',    
          params : params<?php echo $randonNumber; ?>, 
          is_ajax : 1,
          is_search:is_search_<?php echo $randonNumber;?>,
          view_more:1,
          searchParams:searchParams<?php echo $randonNumber; ?> ,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
          page_id:'<?php echo $pageId;?>',
		  limit_data:'<?php echo $this->limit_data; ?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
			
			console.log(responseHTML);
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsesgroup-wrapper'))
            sesJqueryObject('#loadingimgsesgroup-wrapper').hide();
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') )
            sesJqueryObject('#map-data_<?php echo $randonNumber;?>').remove();
          if(!isSearch) {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            var totalPage= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesgrouppoll_entry");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesgrouppoll').html(totalPage.html());
            totalPage.remove();
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') == 'map') {
            if(document.getElementById('sesgroup_map_view_<?php echo $randonNumber;?>'))
              document.getElementById('sesgroup_map_view_<?php echo $randonNumber;?>').style.display = 'block';
            var mapData = sesJqueryObject.parseJSON(sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find('#map-data_<?php echo $randonNumber; ?>').html());
            if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
              newMapData_<?php echo $randonNumber ?> = mapData;
              for(var i=0; i < mapData.length; i++) {
                var isInsert = 1;
                for(var j= 0;j < oldMapData_<?php echo $randonNumber; ?>.length; j++){
                  if(oldMapData_<?php echo $randonNumber; ?>[j]['id'] == mapData[i]['id']){
                    isInsert = 0;
                    break;
                  }
                }
                if(isInsert){
                  oldMapData_<?php echo $randonNumber; ?>.push(mapData[i]);
                }
              }	
              loadMap_<?php echo $randonNumber;?> = true;
              mapFunction_<?php echo $randonNumber?>();
            }
            else{
              if(typeof  map_<?php echo $randonNumber;?> == 'undefined'){
                sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
                initialize_<?php echo $randonNumber?>();	
              }	
            }
          }
          else{
            oldMapData_<?php echo $randonNumber; ?> = [];	
          }
          document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = 'none';
          pinboardLayout_<?php echo $randonNumber ?>('true');
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
        'url': en4.core.baseUrl + "widget/index/mod/sesgrouppoll/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
        'data': {
          format: 'html',
          page: pageNum,    
          params :params<?php echo $randonNumber; ?> , 
          is_ajax : 1,
		  is_search:is_search_<?php echo $randonNumber;?>,
          searchParams:searchParams<?php echo $randonNumber; ?>,
          widget_id: '<?php echo $this->widgetId;?>',
          type:'<?php echo $this->view_type;?>',
          getParams:'<?php echo $this->getParams;?>',
          resource_type: '<?php echo !empty($this->resource_type) ? $this->resource_type : "";?>',
          resource_id: '<?php echo !empty($this->resource_id) ? $this->resource_id : "";?>',
          page_id:'<?php echo $pageId;?>', 
		  limit_data:'<?php echo $this->limit_data ?>',	  
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsesgroup-wrapper'))
            sesJqueryObject('#loadingimgsesgroup-wrapper').hide();
          sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','none');
          document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML =  responseHTML;
          if(isSearch){
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber;?>').find('.active').attr('rel') == 'map'){
            var mapData = sesJqueryObject.parseJSON(sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find('#map-data_<?php echo $randonNumber; ?>').html());
            if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
              oldMapData_<?php echo $randonNumber; ?> = [];
              newMapData_<?php echo $randonNumber ?> = mapData;
              loadMap_<?php echo $randonNumber ?> = true;
              sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
              mapFunction_<?php echo $randonNumber?>();
            }
            else{
              sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
              initialize_<?php echo $randonNumber?>();	
            }
          }
          else{
            oldMapData_<?php echo $randonNumber; ?> = [];	
          }
          pinboardLayout_<?php echo $randonNumber ?>('true');
          sesJqueryObject('html, body').animate({
              scrollTop: sesJqueryObject("#scrollHeightDivSes_<?php echo $randonNumber; ?>").offset().top
          }, 500);
        }
      }));
      requestViewMore_<?php echo $randonNumber; ?>.send();
      return false;
    }
  <?php } ?>
</script>
                             
