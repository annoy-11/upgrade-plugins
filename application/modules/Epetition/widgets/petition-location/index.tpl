<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php if(!$this->is_ajax): ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Epetition/externals/styles/styles.css'); ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js');?>
<?php endif;?>
<?php $randonNumber = "location_widget_epetition"; ?>
<?php $locationArray = array();$counter = 0;?>
<?php foreach( $this->paginator as $petition ): ?>
  <?php $location = '';?>
	<?php if($petition->lat): ?>
		<?php $labels = '';?>
		<?php if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)):?>
			<?php $labels .= "<div class=\"epetition_list_labels\">";?>
			<?php if(isset($this->featuredLabelActive) && $petition->featured == 1):?>
				<?php $labels .= "<p class=\"epetition_label_featured\">".$this->translate('FEATURED')."</p>";?>
			<?php endif;?>
			<?php if(isset($this->sponsoredLabelActive) && $petition->sponsored == 1):?>
				<?php $labels .= "<p class=\"epetition_label_sponsored\">".$this->translate('SPONSORED')."</p>";?>
			<?php endif;?>
			<?php $labels .= "</div>";?>
		<?php endif;?>
		<?php $vlabel = '';?>
		<?php if(isset($this->verifiedLabelActive) && $petition->verified == 1) :?>
			<?php $vlabel = "<div class=\"epetition_verified_label\" title=\"VERIFIED\"><i class=\"fa fa-check\"></i></div>";?>
		<?php endif;?>
		<?php if(isset($this->locationActive) && $petition->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.location', 1)):?>
			<?php $locationText = $this->translate('Location');?>
			<?php $locationvalue = $petition->location;?>
			<?php $location = "<div class=\"epetition_list_stats epetition_list_location sesbasic_text_light\">
			<span class=\"widthfull\">
			<i class=\"fa fa-map-marker\" title=\"$locationText\"></i>
			<span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $petition->epetition_id,'resource_type'=>'epetition','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"opensmoothboxurl\">$locationvalue</a></span>
			</span>
			</div>";?>
		<?php endif;?>
		<?php $likeButton = '';?>
		<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likeButtonActive)):?>
		<?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($petition->epetition_id,$petition->getType());?>
			<?php $likeClass = ($LikeStatus) ? ' button_active' : '' ;?>
			<?php $likeButton = '<a href="javascript:;" data-url="'.$petition->getIdentity().'" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn epetition_like_epetition_'. $petition->epetition_id.' epetition_like_epetition '.$likeClass .'"> <i class="fa fa-thumbs-up"></i><span>'.$petition->like_count.'</span></a>';?>
		<?php endif;?>
		<?php $favouriteButton = '';?>
		<?php if(isset($this->favouriteButtonActive) && Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($petition->favourite_count) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)){
			$favStatus = Engine_Api::_()->getDbtable('favourites', 'epetition')->isFavourite(array('resource_type'=>'epetition','resource_id'=>$petition->epetition_id));
			$favClass = ($favStatus)  ? 'button_active' : '';
			$favouriteButton = '<a href="javascript:;" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_fav_btn  epetition_favourite_epetition_'. $petition->epetition_id.' epetition_favourite_epetition '.$favClass .'" data-url="'.$petition->getIdentity().'"><i class="fa fa-heart"></i><span>'.$petition->favourite_count.'</span></a>';
		}?>

		<?php $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $petition->getHref());?>
		<?php
         $stats ="<div>";
		if(isset($this->commentActive)){
			$stats .= '<span title="'.$this->translate(array('%s comment', '%s comments', $petition->comment_count), $this->locale()->toNumber($petition->comment_count)).'"><i class="fa fa-comment"></i>'.$petition->comment_count.'</span>';
		}
		if(isset($this->favouriteActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.favourite', 1)){
			$stats .= '<span title="'.$this->translate(array('%s favourite', '%s favourites', $petition->favourite_count), $this->locale()->toNumber($petition->favourite_count)).'"><i class="fa fa-heart"></i>'. $petition->favourite_count.'</span>';
		}
		if(isset($this->viewActive)){
			$stats .= '<span title="'. $this->translate(array('%s view', '%s views', $petition->view_count), $this->locale()->toNumber($petition->view_count)).'"><i class="fa fa-eye"></i>'.$petition->view_count.'</span>';
		}
		if(isset($this->likeActive)){
			$stats .= '<span title="'.$this->translate(array('%s like', '%s likes', $petition->like_count), $this->locale()->toNumber($petition->like_count)).'"><i class="fa fa-thumbs-up"></i>'.$petition->like_count.'</span> ';
		}
		if(isset($this->ratingActive) && Engine_Api::_()->sesbasic()->getViewerPrivacy('epetition_review', 'view')){
			$stats .= '<span  title="'.$this->translate(array('%s rating', '%s ratings', round($petition->rating,1)), $this->locale()->toNumber(round($petition->rating,1))).'"><i class="fa fa-star"></i>'. round($petition->rating,1).'/5'.'</span>';
		}
		?>
	  <?php $stats .= '<span></div>';?>
    <?php if(isset($this->socialSharingActive)  && Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.sharing', 1)):?>
    
    <?php $socialShare = $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $petition, 'param' => 'feed', 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit)); ?>
    
     <?php  $socialshare = '<div class="epetition_list_grid_thumb_btns">'.$socialShare.$likeButton.$favouriteButton.'</div>';?>
    <?php else:?>
			<?php $socialshare = $likeButton.$favouriteButton;?>
    <?php endif;?>
		<?php $owner = $petition->getOwner();
			$owner =  '<div class="epetition_grid_date epetition_list_stats sesbasic_text_light"><span><i class="fa fa-user"></i>'.$this->translate("by ") .$this->htmlLink($owner->getHref(),$owner->getTitle() ).'</span></div>';
			$locationArray[$counter]['id'] = $petition->getIdentity();
			$locationArray[$counter]['owner'] = $owner;
			$locationArray[$counter]['location'] = $location;
			$locationArray[$counter]['stats'] = $stats;
			$locationArray[$counter]['socialshare'] = $socialshare;
			$locationArray[$counter]['lat'] = $petition->lat;
			$locationArray[$counter]['lng'] = $petition->lng;
      $locationArray[$counter]['labels'] = $labels;
      $locationArray[$counter]['vlabel'] = $vlabel;
			$locationArray[$counter]['iframe_url'] = '';
			$locationArray[$counter]['image_url'] = $petition->getPhotoUrl();
			$locationArray[$counter]['sponsored'] = $petition->sponsored;
			$locationArray[$counter]['title'] = '<a href="'.$petition->getHref().'">'.$petition->getTitle().'</a>';  
			$counter++;?>
  <?php endif;?>
<?php endforeach; ?>

<?php if(!$this->is_ajax){ ?>
	<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js'); ?>
	<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/marker.js'); ?>
  <script type="text/javascript">
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
      var bounds = new google.maps.LatLngBounds();
      for(i=0;i<markerArrayData_<?php echo $randonNumber?>.length;i++){
	var images = '<div class="image epetition_map_thumb_img"><img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'"  /></div>';		
	var location = markerArrayData_<?php echo $randonNumber?>[i]['location'];
	var owner = markerArrayData_<?php echo $randonNumber?>[i]['owner'];
	var stats = markerArrayData_<?php echo $randonNumber?>[i]['stats'];
	var socialshare = markerArrayData_<?php echo $randonNumber?>[i]['socialshare'];
	var sponsored = markerArrayData_<?php echo $randonNumber?>[i]['sponsored'];
	var vlabel = markerArrayData_<?php echo $randonNumber?>[i]['vlabel'];
	var labels = markerArrayData_<?php echo $randonNumber?>[i]['labels'];
	var allowBlounce = <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.bounce', 1); ?>;
	if(sponsored == 1 && allowBlounce)
	var animateClass = 'animated bounce ';
	else
	var animateClass = '';
	
	var marker_html = '<div class="'+animateClass+'pin public marker_'+countMarker_<?php echo $randonNumber;?>+'" data-lat="'+ markerArrayData_<?php echo $randonNumber?>[i]['lat']+'" data-lng="'+ markerArrayData_<?php echo $randonNumber?>[i]['lng']+'">' +
	'<div class="wrapper">' +
	'<div class="small">' +
	'<img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'" style="height:48px;width:48px;" alt="" />' +
	'</div>' +
	'<div class="large map_large_marker"><div class="epetition_map_thumb epetition_grid_btns_wrap">' +
	images+socialshare+vlabel+labels+
	'</div><div class="sesbasic_large_map_content epetition_large_map_content sesbasic_clearfix">' +
	'<div class="epetition_large_map_content_title">'+markerArrayData_<?php echo $randonNumber?>[i]['title']+'</div>'+ owner + location+stats +'<div class="epetition_list_stats_btn clearfix clear"><span>'+'</span><span>'+'</span><span>'+'</span><span>'+'</span></div></div></div>'+'<a class="icn close" href="javascript:;" title="Close"><i class="fa fa-close"></i></a>' + 
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
	  content: marker_html
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
		sesJqueryObject('.marker_'+ id+' .close').click(function(){
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
    var searchParams;
    var markerArrayData ;
    function callNewMarkersAjax(){
      (new Request.HTML({
      method: 'post',
      'url': en4.core.baseUrl + "widget/index/mod/epetition/name/<?php echo $this->widgetName; ?>",
      'data': {
	format: 'html',
	is_ajax : 1,
	searchParams:searchParams,
	show_criterias : '<?php echo json_encode($this->show_criterias); ?>'
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if($('loadingimgepetition-wrapper'))
	sesJqueryObject ('#loadingimgepetition-wrapper').hide();
	DeleteMarkers_<?php echo $randonNumber ?>();
	if(responseHTML){
	  var mapData = sesJqueryObject.parseJSON(responseHTML);
	  if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
	    newMapData_<?php echo $randonNumber ?> = mapData;
	    mapFunction_<?php echo $randonNumber?>();
	  }
	}
	sesJqueryObject('#loadingimgepetition-wrapper').hide();
      }
      })).send();	
    }
    var newMapData_<?php echo $randonNumber ?> = [];		 
    function mapFunction_<?php echo $randonNumber?>(){
      if(!map_<?php echo $randonNumber;?> || loadMap_<?php echo $randonNumber;?>){
	initialize_<?php echo $randonNumber?>();
	loadMap_<?php echo $randonNumber;?> = false;
      }
      if(!newMapData_<?php echo $randonNumber ?>){
	return false;
      }
      google.maps.event.trigger(map_<?php echo $randonNumber;?>, "resize");
      markerArrayData_<?php echo $randonNumber?> = newMapData_<?php echo $randonNumber ?>;
      if(markerArrayData_<?php echo $randonNumber?>.length)
      newMarkerLayout_<?php echo $randonNumber?>();
      newMapData_<?php echo $randonNumber ?> = '';
      sesJqueryObject('#map-data_<?php echo $randonNumber;?>').addClass('checked');
    }
    window.addEvent('domready', function() {
      var mapData = sesJqueryObject.parseJSON(document.getElementById('map-data_<?php echo $randonNumber;?>').innerHTML);
      if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
					newMapData_<?php echo $randonNumber ?> = mapData;
					mapFunction_<?php echo $randonNumber?>();
      }else{
					initialize_<?php echo $randonNumber?>();
			}
      sesJqueryObject('#locationSesList').val('<?php echo $this->location; ?>');
      sesJqueryObject('#latSesList').val('<?php echo $this->lat; ?>');
      sesJqueryObject('#lngSesList').val('<?php echo $this->lng; ?>');
    });
  </script>
<?php } ?>
<?php if(!$this->is_ajax){ ?>
	<script type="application/javascript">
		var tabId_loc = <?php echo $this->identity; ?>;
			window.addEvent('domready', function() {
			tabContainerHrefSesbasic(tabId_loc);	
		});
	</script>
	<div id="map-data_location_widget_epetition" style="display:none;"><?php echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ?></div>
	<div id="map-canvas-location_widget_epetition" class="map sesbasic_large_map sesbm sesbasic_bxs epetition_browse_map"></div>
	<?php }else{ echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ; die;} ?>
