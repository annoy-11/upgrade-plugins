<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showPollListGrid.tpl  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $businessNameSetting = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.show.userdetail', 0);?>
<?php $gridclass = $this->gridlist? "sesbusinesspoll_twoitems" : ""; ?>
<?php $randonNumber = $this->widgetId; ?>
<?php $widgetType = 'profile-page';?>
<?php $viewer = Engine_Api::_()->user()->getViewer();?>
<?php $viewerId = $viewer->getIdentity();?>
<?php $counter = 0;?>
<?php if(isset($this->business_id)):?>
  <?php $businessId = $this->business_id;?>
<?php else:?>
  <?php $businessId = 0;?>
<?php endif;?>
<?php if(!$this->is_ajax){ ?>
  <style>
  .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/styles.css'); ?>
  <?php if(isset($this->optionsEnable) && @in_array('pinboard',$this->optionsEnable)):?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Sesbasic/externals/scripts/imagesloaded.pkgd.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/wookmark.min.js');?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/pinboardcomment.js');?>
  <?php endif;?>
  <div id="browse-widget_<?php echo $randonNumber;?>" class="sesbasic_view_type_<?php echo $randonNumber;?>  sesbasic_clearfix clear">
<?php } ?>
    <?php if(isset($this->params['show_item_count']) && $this->params['show_item_count']){ ?>
      <div class="sesbasic_clearfix sesbm sesbusiness_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sesbusinesspoll' : 'paginator_count_ajax_sesbusinesspoll_entry' ?>"><span id="total_item_count_sesbusiness_entry" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("page found.") : $this->translate("pages found."); ?></div>
    <?php } ?>
<?php if(!$this->is_ajax){ ?>
<div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
  <ul class="sesbusinesspoll_poll_listing <?php echo $gridclass; ?> sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>"   style="min-height:50px;">
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
    <div class="sesbusinesspoll_browse_info">
      <h3 class="sesbusinesspoll_browse_info_title">
		  <?php if((in_array("title", $this->show_criteria))): ?>
		  <?php if(strlen($poll->getTitle()) > $this->title_truncation):?>
		  <?php $title = mb_substr($poll->getTitle(),0,$this->title_truncation).'...';?>
		  <?php else:?>
		  <?php $title = $poll->getTitle();?>
		  <?php endif; ?>
		  <?php echo $this->htmlLink($poll->getHref(), $title) ?>
		  <?php endif; ?>
      </h3>
<?php $businessItem = Engine_Api::_()->getItem('businesses',$poll->business_id); ?>
		<?php if((in_array("by", $this->show_criteria)) && (in_array("in", $this->show_criteria))): ?>
			<?php if($businessNameSetting): ?>
				<div class="sesbusinesspolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate('Posted by %s in %s ', $this->htmlLink($poll->getOwner(), $poll->getOwner()->getTitle()),$this->htmlLink($businessItem->getHref(), $businessItem->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			<?php else: ?>
				<div class="sesbusinesspolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate('in %s ',$this->htmlLink($businessItem->getHref(), $businessItem->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			<?php endif;  ?>
		<?php elseif((in_array("by", $this->show_criteria)) && !(in_array("in", $this->show_criteria))): ?>
			<?php if($businessNameSetting): ?>
				<div class="sesbusinesspolls_browse_info_date sesbasic_text_light">
				  <?php echo $this->translate('Posted by %s',$this->htmlLink($poll->getOwner(), $poll->getOwner()->getTitle())) ?>
				  <?php echo $this->timestamp($poll->creation_date) ?>
				</div>
			<?php endif; ?>
		<?php elseif(!(in_array("by", $this->show_criteria)) && (in_array("in", $this->show_criteria))): ?>
			<div class="sesbusinesspolls_browse_info_date sesbasic_text_light">
			  <?php echo $this->translate('in %s', $this->htmlLink($businessItem->getHref(), $businessItem->getTitle())) ?>
			  <?php echo $this->timestamp($poll->creation_date) ?>
			</div>
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
					<div class="sesbusinesspoll_browse_info_desc sesbasic_text_light">
						<?php echo $description; ?>
					</div>
				<?php endif; ?>	
			<?php endif; ?>
		<?php endif; ?>
		
		<?php // polls like favourite ?>
    <div class="sesbusinesspoll_stats">
		<div class="_btnsleft">
		  <?php $viewer = Engine_Api::_()->user()->getViewer();?>
		  <?php $viewerId = $viewer->getIdentity();?>
		  <?php if($viewerId ):?>
			<?php $canComment = Engine_Api::_()->authorization()->isAllowed('sesbusinesspoll_poll', $viewer, 'create');?>
			<?php  if($canComment && in_array("likeButton", $this->show_criteria)):?>
			  <?php $likeStatus = Engine_Api::_()->sesbusiness()->getLikeStatus($poll->poll_id,'sesbusinesspoll_poll'); ?>
			  <a href="javascript:;" data-type="like_view" data-url="<?php echo $poll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesbusinesspoll_like_<?php echo $poll->poll_id ?> sesbusinesspoll_likefavfollow <?php echo ($likeStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-thumbs-up"></i><span><?php echo $poll->like_count;?></span></a>
			<?php endif;?>
			  <?php if( Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.allow.favourite', 1) && in_array("favouriteButton", $this->show_criteria)):?>
				<?php 	$value['resource_type'] = 'sesbusinesspoll_poll';
						$value['resource_id'] = $poll->poll_id;
						$favouriteStatus = Engine_Api::_()->getDbTable('Favourites', 'sesbusinesspoll')->isFavourite($value);
				$favouriteStatus = Engine_Api::_()->getDbTable('favourites', 'sesbusinesspoll')->isFavourite(array('resource_id' => $poll->poll_id,'resource_type' => 'sesbusinesspoll_poll')); ?>
				<a href="javascript:;" data-type="favourite_view" data-url="<?php echo $poll->poll_id ; ?>" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn sesbusinesspoll_favourite_<?php echo $poll->poll_id ?> sesbusinesspoll_likefavfollow <?php echo ($favouriteStatus) ? 'button_active' : '' ; ?>"><i class="fa fa-heart"></i><span><?php echo $poll->favourite_count;?></span></a>
			  <?php endif;?>
			<?php endif;?>
		  <?php  // endif;?>
		</div>
		<?php //end  polls like favourite ?>
	<!-- polls end  polls like favourite -->
         <?php $shareType = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.allow.share', 1);?>
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
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesbusiness"),array('identityWidget'=>$randonNumber)); ?>
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
    if(sesJqueryObject('.sesbusiness_browse_search').find('#filter_form').length) {
      var search = sesJqueryObject('.sesbusiness_browse_search').find('#filter_form');
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
   // sesJqueryObject('#sesbusiness_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
   // sesJqueryObject('#sesbusiness_simplegrid_view_<?php echo $randonNumber; ?>').removeClass('active');
   // sesJqueryObject('#sesbusiness_advgrid_view_<?php echo $randonNumber; ?>').removeClass('active');
    sesJqueryObject('#sesbusiness_list_view_<?php echo $randonNumber; ?>').removeClass('active');
   // sesJqueryObject('#sesbusiness_advlist_view_<?php echo $randonNumber; ?>').removeClass('active');
    //sesJqueryObject('#sesbusiness_pinboard_view_<?php echo $randonNumber; ?>').removeClass('active');
    //sesJqueryObject('#sesbusiness_map_view_<?php echo $randonNumber; ?>').removeClass('active');
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
      'url': en4.core.baseUrl + "widget/index/mod/sesbusiness/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
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
          business_id:1,
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
        var totalPage= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesbusinesspoll_entry");
        sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesbusinesspoll').html(totalPage.html());
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
        'url': en4.core.baseUrl + "widget/index/mod/sesbusinesspoll/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
          business_id:'<?php echo $businessId;?>',
		  limit_data:'<?php echo $this->limit_data; ?>',
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
			
			console.log(responseHTML);
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsespage-wrapper'))
            sesJqueryObject('#loadingimgsespage-wrapper').hide();
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') )
            sesJqueryObject('#map-data_<?php echo $randonNumber;?>').remove();
          if(!isSearch) {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
          }
          else {
            document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
            var totalPage= sesJqueryObject('#tabbed-widget_<?php echo $randonNumber; ?>').find("#paginator_count_ajax_sesbusinesspoll_entry");
            sesJqueryObject('.sesbasic_view_type_<?php echo $randonNumber; ?>').find('#paginator_count_sesbusinesspoll').html(totalPage.html());
            totalPage.remove();
            oldMapData_<?php echo $randonNumber; ?> = [];
            isSearch = false;
          }
          if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') == 'map') {
            if(document.getElementById('sesbusiness_map_view_<?php echo $randonNumber;?>'))
              document.getElementById('sesbusiness_map_view_<?php echo $randonNumber;?>').style.display = 'block';
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
        'url': en4.core.baseUrl + "widget/index/mod/sesbusinesspoll/id/<?php echo $this->widgetId; ?>/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
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
          business_id:'<?php echo $businessId;?>', 
		  limit_data:'<?php echo $this->limit_data ?>',	  
        },
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          if($('loading_images_browse_<?php echo $randonNumber; ?>'))
            sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
          if($('loadingimgsespage-wrapper'))
            sesJqueryObject('#loadingimgsespage-wrapper').hide();
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
                             
<!--Start Map Work on Page Load-->
<?php if(!$this->is_ajax): ?>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js'); ?>
  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/marker.js'); ?>
  <script type="application/javascript">
    var  loadMap_<?php echo $randonNumber;?> = false;
    var newMapData_<?php echo $randonNumber ?> = [];
    function mapFunction_<?php echo $randonNumber?>(){
      if(!map_<?php echo $randonNumber;?> || loadMap_<?php echo $randonNumber;?>){
        initialize_<?php echo $randonNumber?>();
        loadMap_<?php echo $randonNumber;?> = false;
      }
      if(sesJqueryObject('.map_selectView_<?php echo $randonNumber;?>').hasClass('active')) {
        if(!newMapData_<?php echo $randonNumber ?>)
        return false;
        <?php if($this->loadOptionData == 'pagging'){ ?>DeleteMarkers_<?php echo $randonNumber ?>();<?php }?>
        google.maps.event.trigger(map_<?php echo $randonNumber;?>, "resize");
        markerArrayData_<?php echo $randonNumber?> = newMapData_<?php echo $randonNumber ?>;
        if(markerArrayData_<?php echo $randonNumber?>.length)
        newMarkerLayout_<?php echo $randonNumber?>();
        newMapData_<?php echo $randonNumber ?> = '';
        sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked');
      }
    }
    var isSearch = false;
    var oldMapData_<?php echo $randonNumber; ?> = [];
    var markers_<?php echo $randonNumber;?>  = [];
    var map_<?php echo $randonNumber;?>;
    if('<?php echo $this->lat; ?>' == '') {
      var latitude_<?php echo $randonNumber;?> = '26.9110600';
      var longitude_<?php echo $randonNumber;?> = '75.7373560';
    }else{
      var latitude_<?php echo $randonNumber;?> = '<?php echo $this->lat; ?>';
      var longitude_<?php echo $randonNumber;?> = '<?php echo $this->lng; ?>';
    }
    function initialize_<?php echo $randonNumber?>() {
      var bounds_<?php echo $randonNumber;?> = new google.maps.LatLngBounds();
      map_<?php echo $randonNumber;?> = new google.maps.Map(document.getElementById('map-canvas-<?php echo $randonNumber;?>'), {
        zoom: 17,
        scrollwheel: true,
        center: new google.maps.LatLng(latitude_<?php echo $randonNumber;?>, longitude_<?php echo $randonNumber;?>),
      });
      oms_<?php echo $randonNumber;?> = new OverlappingMarkerSpiderfier(map_<?php echo $randonNumber;?>,
      {nearbyDistance:40,circleSpiralSwitchover:0 });
    }
	var countMarker_<?php echo $randonNumber;?> = 0;
    function DeleteMarkers_<?php echo $randonNumber ?>(){
      //Loop through all the markers and remove
      for (var i = 0; i < markers_<?php echo $randonNumber;?>.length; i++) {
        markers_<?php echo $randonNumber;?>[i].setMap(null);
      }
      markers_<?php echo $randonNumber;?> = [];
      markerData_<?php echo $randonNumber ?> = [];
      markerArrayData_<?php echo $randonNumber?> = [];
    };
    var markerArrayData_<?php echo $randonNumber?> ;
    var markerData_<?php echo $randonNumber ?> =[];
    var bounds_<?php echo $randonNumber;?> = new google.maps.LatLngBounds();
    function newMarkerLayout_<?php echo $randonNumber?>(dataLenth){
      if(typeof dataLenth != 'undefined') {
        initialize_<?php echo $randonNumber?>();
        markerArrayData_<?php echo $randonNumber?> = sesJqueryObject.parseJSON(dataLenth);
      }
      if(!markerArrayData_<?php echo $randonNumber?>.length)
      return;
      DeleteMarkers_<?php echo $randonNumber ?>();
      markerArrayData_<?php echo $randonNumber?> = oldMapData_<?php echo $randonNumber; ?>;
      var bounds = new google.maps.LatLngBounds();
      for(i=0;i<markerArrayData_<?php echo $randonNumber?>.length;i++){
        var images = '<div class="sesbusiness_thumb_img"><span style="background-image:url('+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+');"  /></span></div>';
        var owner = markerArrayData_<?php echo $randonNumber?>[i]['owner'];
        var location = markerArrayData_<?php echo $randonNumber?>[i]['location'];
        var socialshare = markerArrayData_<?php echo $randonNumber?>[i]['socialshare'];
				var stats = markerArrayData_<?php echo $randonNumber?>[i]['stats'];
				var buttons = markerArrayData_<?php echo $randonNumber?>[i]['buttons'];
        var sponsored = markerArrayData_<?php echo $randonNumber?>[i]['sponsored'];
        var vlabel = markerArrayData_<?php echo $randonNumber?>[i]['vlabel'];
        var labels = markerArrayData_<?php echo $randonNumber?>[i]['labels'];
        var allowBlounce = <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.enable.bounce', 1); ?>;
        if(sponsored == 1 && allowBlounce)
          var animateClass = 'animated bounce ';
        else
          var animateClass = '';
        //animate class "animated bounce"
        var marker_html = '<div class="'+animateClass+'pin public marker_'+countMarker_<?php echo $randonNumber;?>+'" data-lat="'+ markerArrayData_<?php echo $randonNumber?>[i]['lat']+'" data-lng="'+ markerArrayData_<?php echo $randonNumber?>[i]['lng']+'">' +
        '<div class="wrapper">' +
        '<div class="small">' +
        '<img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'" style="height:48px;width:48px;" alt="" />' +
        '</div>' +
        '<div class="large map_large_marker sesbusiness_map_item"><div class="sesbusiness_map_thumb sesbusiness_thumb">' +
        images + buttons+labels+
        '</div><div class="_cont sesbasic_clearfix">' +
        '<div class="_title">'+markerArrayData_<?php echo $randonNumber?>[i]['title']+vlabel+'</div>' +owner+stats+location+socialshare+
				'</div>' +
        '<a class="icn close" href="javascript:;" title="Close"><i class="fa fa-close"></i></a>' + 
        '</div>' +
        '</div>' +
        '<span class="sesbasic_largemap_pointer"></span>' +
        '</div>';
        markerData = new RichMarker({
          position: new google.maps.LatLng(markerArrayData_<?php echo $randonNumber?>[i]['lat'], markerArrayData_<?php echo $randonNumber?>[i]['lng']),
          map: map_<?php echo $randonNumber;?>,
          flat: true,
          draggable: false,
          scrollwheel: false,
          id:countMarker_<?php echo $randonNumber;?>,
          anchor: RichMarkerPosition.BOTTOM,
          content: marker_html,
        });
        oms_<?php echo $randonNumber;?>.addListener('click', function(marker) {
          var id = marker.markerid;
          previousIndex = sesJqueryObject('.marker_'+ id).parent().parent().css('z-index');
          sesJqueryObject('.marker_'+ id).parent().parent().css('z-index','9999');
          sesJqueryObject('.pin').removeClass('active').css('z-index', 10);
          sesJqueryObject('.marker_'+ id).addClass('active').css('z-index', 200);
          sesJqueryObject('.marker_'+ id+' .large .close').click(function(){
          sesJqueryObject(this).parent().parent().parent().parent().parent().css('z-index',previousIndex);
            sesJqueryObject('.pin').removeClass('active');
            return false;
          });
        });
        markers_<?php echo $randonNumber;?> .push( markerData);
        markerData.setMap(map_<?php echo $randonNumber;?>);
        bounds.extend(markerData.getPosition());
        markerData.markerid = countMarker_<?php echo $randonNumber;?>;
        oms_<?php echo $randonNumber;?>.addMarker(markerData);
        countMarker_<?php echo $randonNumber;?>++;
      }
      map_<?php echo $randonNumber;?>.fitBounds(bounds);
    }

  </script>
<?php endif;?>