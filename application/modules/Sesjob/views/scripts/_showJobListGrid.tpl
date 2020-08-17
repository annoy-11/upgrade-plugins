<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _showJobListGrid.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php  if(!$this->is_ajax): ?>
  <style>
    .displayFN{display:none !important;}
  </style>
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesjob/externals/styles/styles.css'); ?> 
  <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?> 
<?php endif;?>

<?php if(isset($this->identityForWidget) && !empty($this->identityForWidget)):?>
	<?php $randonNumber = $this->identityForWidget;?>
<?php else:?>
	<?php $randonNumber = $this->identity; ?>
<?php endif;?>

<?php if($this->profile_jobs == true):?>
  <?php $moduleName = 'sesjob';?>
<?php else:?>
  <?php $moduleName = 'sesjob';?>
<?php endif;?>

<?php $counter = 0;?>
<?php  if(isset($this->defaultOptions) && count($this->defaultOptions) == 1): ?>
  <script type="application/javascript">
      en4.core.runonce.add(function() {
          sesJqueryObject('#tab-widget-sesjob-<?php echo $randonNumber; ?>').parent().css('display', 'none');
          sesJqueryObject('.sesjob_container_tabbed<?php echo $randonNumber; ?>').css('border', 'none');
      });
  </script>
<?php endif;?>

<?php if(!$this->is_ajax){ ?>
	<div class="sesbasic_view_type sesbasic_clearfix clear" style="display:<?php echo $this->bothViewEnable ? 'block' : 'none'; ?>;height:<?php echo $this->bothViewEnable ? '' : '0px'; ?>">
		<?php if(isset($this->show_item_count) && $this->show_item_count){ ?>
			<div class="sesbasic_clearfix sesbm sesjob_search_result" style="display:<?php !$this->is_ajax ? 'block' : 'none'; ?>" id="<?php echo !$this->is_ajax ? 'paginator_count_sesjob' : 'paginator_count_ajax_sesjob' ?>"><span id="total_item_count_sesjob" style="display:inline-block;"><?php echo $this->paginator->getTotalItemCount(); ?></span> <?php echo $this->paginator->getTotalItemCount() == 1 ?  $this->translate("job found.") : $this->translate("jobs found."); ?></div>
		<?php } ?>
		<div class="sesbasic_view_type_options sesbasic_view_type_options_<?php echo $randonNumber; ?>">
			<?php if(is_array($this->optionsEnable) && in_array('list',$this->optionsEnable)){ ?>
				<a href="javascript:;" rel="list" id="sesjob_list_view_<?php echo $randonNumber; ?>" class="listicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'list') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('List View') : '' ; ?>"></a>
			<?php } ?>
			<?php if(is_array($this->optionsEnable) && in_array('grid',$this->optionsEnable)){ ?>
				<a href="javascript:;" rel="grid" id="sesjob_grid_view_<?php echo $randonNumber; ?>" class="a-gridicon selectView_<?php echo $randonNumber; ?> <?php if($this->view_type == 'grid') { echo 'active'; } ?>" title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Grid View') : '' ; ?>"></a>
			<?php } ?>
			<?php if(is_array($this->optionsEnable) && in_array('map',$this->optionsEnable) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob_enable_location', 1)){ ?>
				<a title="<?php echo ((isset($this->htmlTitle) && !empty($this->htmlTitle)) || (empty($this->htmlTitle) && !isset($this->htmlTitle)) ) ? $this->translate('Map View') : '' ; ?>" id="sesjob_map_view_<?php echo $randonNumber; ?>" class="mapicon map_selectView_<?php echo $randonNumber;?> selectView_<?php echo $randonNumber;?> <?php if($this->view_type == 'map') { echo 'active'; } ?>" rel="map" href="javascript:;"></a>
			<?php } ?>
		</div>
	</div>
<?php } ?>
<?php $locationArray = array();?>
<?php if(!$this->is_ajax){ ?>
  <div id="scrollHeightDivSes_<?php echo $randonNumber; ?>" class="sesbasic_clearfix sesbasic_bxs clear">
    <ul class="sesjob_job_listing sesbasic_clearfix clear" id="tabbed-widget_<?php echo $randonNumber; ?>" style="min-height:50px;">
<?php } ?>

<?php foreach( $this->paginator as $item ):?>
  <?php $href = $item->getHref();?>
  <?php $photoPath = $item->getPhotoUrl();?>
  <?php if($this->view_type == 'grid'){ ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesjob/views/scripts/_gridView.tpl';?>
  <?php }else if($this->view_type == 'list'){ ?>
    <?php include APPLICATION_PATH .  '/application/modules/Sesjob/views/scripts/_listView.tpl';?>
  <?php } elseif($this->view_type == 'map') {
  		$job = $item;
   ?>
  	
  	<?php $location = '';?>
	<?php if($job->lat): ?>
		<?php $labels = '';?>
		<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)  || isset($this->hotLabelActive)):?>
			<?php $labels .= "<div class=\"sesjob_list_labels\">";?>
			<?php if(isset($this->featuredLabelActive) && $job->featured == 1):?>
				<?php $labels .= "<p class=\"sesjob_label_featured\">".$this->translate('FEATURED')."</p>";?>
			<?php endif;?>
			<?php if(isset($this->sponsoredLabelActive) && $job->sponsored == 1):?>
				<?php $labels .= "<p class=\"sesjob_label_sponsored\">".$this->translate('SPONSORED')."</p>";?>
			<?php endif;?>
			<?php if(isset($this->hotLabelActive) && $job->hot == 1):?>
				<?php $labels .= "<p class=\"sesjob_label_hot\">".$this->translate('HOT')."</p>";?>
			<?php endif;?>
			<?php $labels .= "</div>";?>
		<?php endif;?>
		<?php $vlabel = '';?>
		<?php if(isset($this->verifiedLabelActive) && $job->verified == 1) :?>
			<?php $vlabel = "<div class=\"sesjob_verified_label\" title=\"VERIFIED\"><i class=\"fa fa-check\"></i></div>";?>
		<?php endif;?>
		<?php if(isset($this->locationActive) && $job->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.location', 1)):?>
			<?php $locationText = $this->translate('Location');?>
			<?php $locationvalue = $job->location;?>
			<?php $location = "<div class=\"sesjob_list_stats sesjob_list_location sesbasic_text_light\">
			<span class=\"widthfull\">
			<i class=\"fa fa-map-marker\" title=\"$locationText\"></i>
			<span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $job->job_id,'resource_type'=>'sesjob_job','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"opensmoothboxurl\">$locationvalue</a></span>
			</span>
			</div>";?>
		<?php endif;?>
		<?php $likeButton = '';?>
		<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likeButtonActive)):?>
		<?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($job->job_id,$job->getType());?>
			<?php $likeClass = ($LikeStatus) ? ' button_active' : '' ;?>
			<?php $likeButton = '<a href="javascript:;" data-url="'.$job->getIdentity().'" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesjob_like_sesjob_job_'. $job->job_id.' sesjob_like_sesjob_job '.$likeClass .'"> <i class="fa fa-thumbs-up"></i><span>'.$job->like_count.'</span></a>';?>
		<?php endif;?>
		<?php $favouriteButton = '';?>
		<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($job->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)){
			$favStatus = Engine_Api::_()->getDbtable('favourites', 'sesjob')->isFavourite(array('resource_type'=>'sesjob_job','resource_id'=>$job->job_id));
			$favClass = ($favStatus)  ? 'button_active' : '';
			$favouriteButton = '<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn  sesjob_favourite_sesjob_job_'. $job->job_id.' sesjob_favourite_sesjob_job '.$favClass .'" data-url="'.$job->getIdentity().'"><i class="fa fa-heart"></i><span>'.$job->favourite_count.'</span></a>';
		}?>
		<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $job->getHref());?>
		<?php $stats = '<div class="sesbasic_largemap_stats sesjob_list_stats sesbasic_clearfix"><span class="widthfull">';
		if(isset($this->commentActive)){
			$stats .= '<span title="'.$this->translate(array('%s comment', '%s comments', $job->comment_count), $this->locale()->toNumber($job->comment_count)).'"><i class="fa fa-comment"></i>'.$job->comment_count.'</span>';
		}
		if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.favourite', 1)){
			$stats .= '<span title="'.$this->translate(array('%s favourite', '%s favourites', $job->favourite_count), $this->locale()->toNumber($job->favourite_count)).'"><i class="fa fa-heart"></i>'. $job->favourite_count.'</span>';
		}
		if(isset($this->viewActive)){
			$stats .= '<span title="'. $this->translate(array('%s view', '%s views', $job->view_count), $this->locale()->toNumber($job->view_count)).'"><i class="fa fa-eye"></i>'.$job->view_count.'</span>';
		}
		if(isset($this->likeActive)){
			$stats .= '<span title="'.$this->translate(array('%s like', '%s likes', $job->like_count), $this->locale()->toNumber($job->like_count)).'"><i class="fa fa-thumbs-up"></i>'.$job->like_count.'</span> ';
		}
		?>
	  <?php $stats .= '<span></div>';?>
    <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.sharing', 1)):?>
    
    <?php $socialshareIcons = $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $job, 'socialshare_enable_plusicon' => $this->socialshare_enable_mapviewplusicon, 'socialshare_icon_limit' => $this->socialshare_icon_mapviewlimit, 'params' => 'feed')); ?>
     <?php  $socialshare = '<div class="sesjob_list_grid_thumb_btns">'.$socialshareIcons.$likeButton.$favouriteButton.'</div>';?>
    <?php else:?>
			<?php $socialshare = $likeButton.$favouriteButton;?>
    <?php endif;?>
		<?php $owner = $job->getOwner();
			$owner =  '<div class="sesjob_grid_date sesjob_list_stats sesbasic_text_light"><span><i class="fa fa-user"></i>'.$this->translate("by ") .$this->htmlLink($owner->getHref(),$owner->getTitle() ).'</span></div>';
			$locationArray[$counter]['id'] = $job->getIdentity();
			$locationArray[$counter]['owner'] = $owner;
			$locationArray[$counter]['location'] = $location;
			$locationArray[$counter]['stats'] = $stats;
			$locationArray[$counter]['socialshare'] = $socialshare;
			$locationArray[$counter]['lat'] = $job->lat;
			$locationArray[$counter]['lng'] = $job->lng;
      $locationArray[$counter]['labels'] = $labels;
      $locationArray[$counter]['vlabel'] = $vlabel;
			$locationArray[$counter]['iframe_url'] = '';
			$locationArray[$counter]['image_url'] = $job->getPhotoUrl();
			$locationArray[$counter]['sponsored'] = $job->sponsored;
			$locationArray[$counter]['title'] = '<a href="'.$job->getHref().'">'.$job->getTitle().'</a>';  
			$counter++;?>
  <?php endif;?>
  
  
  <?php } ?>
<?php endforeach; ?>
<?php if($this->view_type == 'map'):?>
  <div id="map-data_<?php echo $randonNumber;?>" style="display:none;"><?php echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ?></div>
  <?php if(!$this->view_more || $this->is_search):?>
    <ul id="sesjob_map_view_<?php echo $randonNumber;?>" class="sesjob_map_view_full">
      <div id="map-canvas-<?php echo $randonNumber;?>" class="map sesbasic_large_map sesbm sesbasic_bxs"></div>
    </ul>
  <?php endif;?>
<?php endif;?>
<?php  if(  $this->paginator->getTotalItemCount() == 0 &&  (empty($this->widgetType)) && $this->view_type != 'map'){  ?>
  <?php if( isset($this->category) || isset($this->tag) || isset($this->text) ):?>
    <div class="tip">
      <span>
	<?php echo $this->translate('Nobody has posted a job with that criteria.');?>
	<?php if ($this->can_create && empty($this->type)):?>
	  <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesjob_general").'">', '</a>'); ?>
	<?php endif; ?>
      </span>
    </div>
  <?php else:?>
    <div class="tip">
      <span>
	<?php echo $this->translate('Nobody has created a job yet.');?>
	<?php if ($this->can_create && empty($this->type)):?>
	  <?php echo $this->translate('Be the first to %1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesjob_general").'">', '</a>'); ?>
	<?php endif; ?>
      </span>
    </div>
  <?php endif; ?>
<?php }else if( $this->paginator->getTotalItemCount() == 0 && isset($this->tabbed_widget) && $this->tabbed_widget){?>
  <div class="tip">
    <span>
      <?php $errorTip = ucwords(str_replace('SP',' ',$this->defaultOpenTab)); ?>
      <?php echo $this->translate("There are currently no %s",$errorTip);?>
      <?php if (isset($this->can_create) && $this->can_create && empty($this->type)):?>
	<?php echo $this->translate('%1$spost%2$s one!', '<a href="'.$this->url(array('action' => 'create'), "sesjob_general").'">', '</a>'); ?>
      <?php endif; ?>
    </span>
  </div>
<?php } ?>
  
<?php if($this->loadOptionData == 'pagging' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')): ?>
  <?php echo $this->paginationControl($this->paginator, null, array("_pagging.tpl", "sesjob"),array('identityWidget'=>$randonNumber)); ?>
<?php endif;?>
  
<?php if(!$this->is_ajax){ ?>
  </ul>
 <?php if($this->params['pagging'] != 'pagging' && (!isset($this->params['show_limited_data']) || $this->params['show_limited_data'] == 'no')):?>
    <div class="sesbasic_load_btn" id="view_more_<?php echo $randonNumber;?>" onclick="viewMore_<?php echo $randonNumber; ?>();" >
      <a href="javascript:void(0);" class="sesbasic_animation sesbasic_link_btn" id="feed_viewmore_link_<?php echo $randonNumber; ?>"><i class="fa fa-repeat"></i><span><?php echo $this->translate('View More');?></span></a>
    </div>  
    <div class="sesbasic_load_btn sesbasic_view_more_loading_<?php echo $randonNumber;?>" id="loading_image_<?php echo $randonNumber; ?>" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div>
  <?php endif;?>
  </div>

  <script type="text/javascript">
    var requestTab_<?php echo $randonNumber; ?>;
    var valueTabData ;
    // globally define available tab array
    var requestTab_<?php echo $randonNumber; ?>;
		<?php if($this->loadOptionData == 'auto_load' && (empty($this->show_limited_data) || $this->show_limited_data  == 'no')){ ?>
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
    sesJqueryObject(document).on('click','.selectView_<?php echo $randonNumber; ?>',function(){
      if(sesJqueryObject(this).hasClass('active'))
      return;
      if($("view_more_<?php echo $randonNumber; ?>"))
      document.getElementById("view_more_<?php echo $randonNumber; ?>").style.display = 'none';
      document.getElementById("tabbed-widget_<?php echo $randonNumber; ?>").innerHTML = "<div class='clear sesbasic_loading_container'></div>";
      sesJqueryObject('#sesjob_grid_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesjob_list_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#sesjob_map_view_<?php echo $randonNumber; ?>').removeClass('active');
      sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').css('display','none');
      sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').css('display','none');
      sesJqueryObject(this).addClass('active');
      if (typeof(requestTab_<?php echo $randonNumber; ?>) != 'undefined') {
				requestTab_<?php echo $randonNumber; ?>.cancel();
      }
      if (typeof(requestViewMore_<?php echo $randonNumber; ?>) != 'undefined') {
				requestViewMore_<?php echo $randonNumber; ?>.cancel();
      }
      requestTab_<?php echo $randonNumber; ?> = (new Request.HTML({
				method: 'post',
				'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + defaultOpenTab,
				'data': {
					format: 'html',
					page: 1,
					type:sesJqueryObject(this).attr('rel'),
					params : <?php echo json_encode($this->params); ?>, 
					is_ajax : 1,
					searchParams: searchParams<?php echo $randonNumber; ?>,
					identity : '<?php echo $randonNumber; ?>',
				},
				onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
					document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = responseHTML;
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
				}
      })).send();
    });
  </script>
<?php } ?>
  
<?php if(isset($this->optionsListGrid['paggindData']) || isset($this->loadJs)){ ?>
	<script type="text/javascript">
		var defaultOpenTab = '<?php echo $this->defaultOpenTab; ?>';
		var requestViewMore_<?php echo $randonNumber; ?>;
		var params<?php echo $randonNumber; ?> = <?php echo json_encode($this->params); ?>;
		var identity<?php echo $randonNumber; ?>  = '<?php echo $randonNumber; ?>';
		var page<?php echo $randonNumber; ?> = '<?php echo $this->page + 1; ?>';
		var searchParams<?php echo $randonNumber; ?> ;
		var is_search_<?php echo $randonNumber;?> = 0;
		<?php if($this->loadOptionData != 'pagging'){ ?>
            en4.core.runonce.add(function() {
				viewMoreHide_<?php echo $randonNumber; ?>();
			});
			function viewMoreHide_<?php echo $randonNumber; ?>() {
				if ($('view_more_<?php echo $randonNumber; ?>'))
				$('view_more_<?php echo $randonNumber; ?>').style.display = "<?php echo ($this->paginator->count() == 0 ? 'none' : ($this->paginator->count() == $this->paginator->getCurrentPageNumber() ? 'none' : '' )) ?>";
			}
			function viewMore_<?php echo $randonNumber; ?> (){
				sesJqueryObject('#view_more_<?php echo $randonNumber; ?>').hide();
				sesJqueryObject('#loading_image_<?php echo $randonNumber; ?>').show(); 
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
				//document.getElementById('view_more_<?php echo $randonNumber; ?>').style.display = 'none';
				//document.getElementById('loading_image_<?php echo $randonNumber; ?>').style.display = '';
				if(typeof requestViewMore_<?php echo $randonNumber; ?>  != "undefined"){
                    requestViewMore_<?php echo $randonNumber; ?>.cancel();
                }
				requestViewMore_<?php echo $randonNumber; ?> = new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: page<?php echo $randonNumber; ?>,    
						params : params<?php echo $randonNumber; ?>, 
						is_ajax : 1,
						is_search:is_search_<?php echo $randonNumber;?>,
						view_more:1,
						searchParams:searchParams<?php echo $randonNumber; ?> ,
						identity : '<?php echo $randonNumber; ?>',
						identityObject:'<?php echo isset($this->identityObject) ? $this->identityObject : "" ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsesjob-wrapper'))
						sesJqueryObject('#loadingimgsesjob-wrapper').hide();
						if(document.getElementById('map-data_<?php echo $randonNumber;?>') )
						sesJqueryObject('#map-data_<?php echo $randonNumber;?>').remove();
						if(!isSearch) {
							document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
						}
						else {
							document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML = document.getElementById('tabbed-widget_<?php echo $randonNumber; ?>').innerHTML + responseHTML;
							oldMapData_<?php echo $randonNumber; ?> = [];
							isSearch = false;
						}
						if(document.getElementById('map-data_<?php echo $randonNumber;?>') && sesJqueryObject('.sesbasic_view_type_options_<?php echo $randonNumber; ?>').find('.active').attr('rel') == 'map') {
							if(document.getElementById('sesjob_map_view_<?php echo $randonNumber;?>'))	
							document.getElementById('sesjob_map_view_<?php echo $randonNumber;?>').style.display = 'block';
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
							}else{
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
					}
				});
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php }else{ ?>
			function paggingNumber<?php echo $randonNumber; ?>(pageNum){
				sesJqueryObject('.sesbasic_loading_cont_overlay').css('display','block');
				var openTab_<?php echo $randonNumber; ?> = '<?php echo $this->defaultOpenTab; ?>';
                if(typeof requestViewMore_<?php echo $randonNumber; ?>  != "undefined"){
                    requestViewMore_<?php echo $randonNumber; ?>.cancel();
                }
				requestViewMore_<?php echo $randonNumber; ?> = (new Request.HTML({
					method: 'post',
					'url': en4.core.baseUrl + "widget/index/mod/"+"<?php echo $moduleName;?>"+"/name/<?php echo $this->widgetName; ?>/openTab/" + openTab_<?php echo $randonNumber; ?>,
					'data': {
						format: 'html',
						page: pageNum,    
						params :params<?php echo $randonNumber; ?> , 
						is_ajax : 1,
						searchParams:searchParams<?php echo $randonNumber; ?>  ,
						identity : identity<?php echo $randonNumber; ?>,
						type:'<?php echo $this->view_type; ?>'
					},
					onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
						if($('loading_images_browse_<?php echo $randonNumber; ?>'))
						sesJqueryObject('#loading_images_browse_<?php echo $randonNumber; ?>').remove();
						if($('loadingimgsesjob-wrapper'))
						sesJqueryObject('#loadingimgsesjob-wrapper').hide();
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
					}
				}));
				requestViewMore_<?php echo $randonNumber; ?>.send();
				return false;
			}
		<?php } ?>
	</script>
<?php } ?>

<!--Start Map Work on Page Load-->
<?php if(!$this->is_ajax): ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/marker.js'); ?>
	<script type="application/javascript">
		sesJqueryObject(document).on('click',function(){
			sesJqueryObject('.sesjob_list_option_toggle').removeClass('open');
		});
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
			{nearbyDistance:40,circleSpiralSwitchover:0 }
			);
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
				var images = '<div class="image sesjob_map_thumb_img"><img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'"  /></div>';		
				var owner = markerArrayData_<?php echo $randonNumber?>[i]['owner'];
				var location = markerArrayData_<?php echo $randonNumber?>[i]['location'];
				var socialshare = markerArrayData_<?php echo $randonNumber?>[i]['socialshare'];
				var sponsored = markerArrayData_<?php echo $randonNumber?>[i]['sponsored'];
				var vlabel = markerArrayData_<?php echo $randonNumber?>[i]['vlabel'];
				var labels = markerArrayData_<?php echo $randonNumber?>[i]['labels'];
				var allowBlounce = <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.enable.bounce', 1); ?>;
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
				'<div class="large map_large_marker"><div class="sesjob_map_thumb sesjob_grid_btns_wrap">' +
				images + socialshare+vlabel+labels+
				'</div><div class="sesbasic_large_map_content sesjob_large_map_content sesbasic_clearfix">' +
				'<div class="sesbasic_large_map_content_title">'+markerArrayData_<?php echo $randonNumber?>[i]['title']+'</div>' +owner+location+
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
		<?php if($this->view_type == 'map'){?>
				en4.core.runonce.add(function() {
				var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
				if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
					newMapData_<?php echo $randonNumber ?> = mapData;
					sesJqueryObject.merge(oldMapData_<?php echo $randonNumber; ?>, newMapData_<?php echo $randonNumber ?>);
					mapFunction_<?php echo $randonNumber?>();
					sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked')
				}
				else{
					if(typeof  map_<?php echo $randonNumber;?> == 'undefined') {
						sesJqueryObject('#map-data_<?php echo $randonNumber; ?>').html('');
						initialize_<?php echo $randonNumber?>();	
					}
				}
			});
		<?php } ?>
	</script> 
<?php endif;?>
<!--End Map Work-->
