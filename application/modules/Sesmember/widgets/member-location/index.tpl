<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if(!$this->is_ajax){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/styles.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/richMarker.js');
}?>
<?php $randonNumber = "location_widget_sesmember"; ?>
<?php $locationArray = array();$counter = 0;?>
<?php foreach( $this->paginator as $member ): ?>
  <?php $followButton = $likeMainButton = $friend = $memberType = '';?>
	<?php if(isset($this->profileTypeActive)): ?>            
		<?php $memberType = '<div class="sesmember_list_stats sesmember_list_membertype "> <span class="widthfull"><i class="fa fa-user"></i><span>' .Engine_Api::_()->sesmember()->getProfileType($member). '</span></span></div>'; ?>
	<?php endif; ?>
	<?php $memberAge =  $this->partial('_userAge.tpl', 'sesmember', array('ageActive' => $this->ageActive, 'member' => $member)); ?>

	<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->friendButtonActive)):?>
		<?php $friend =   $this->partial('_addfriend.tpl', 'sesbasic', array('subject' => $member)); ?>
	<?php endif;?>

	<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likemainButtonActive)):?>
		<?php $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($member->user_id,$member->getType());?>
		<?php $likeClass = (!$LikeStatus) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;?>
		<?php $likeText = ($LikeStatus) ?  $this->translate('Unlike') : $this->translate('Like') ;?>
		<?php $likeMainButton = "<a href='javascript:;' data-url='".$member->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_button_like_user sesmember_button_like_user_". $member->user_id."'><i class='fa ".$likeClass."'></i><span><i class='fa fa-caret-down'></i>$likeText</span></a>";?>
	<?php endif;?>

	<?php if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->followButtonActive) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.active',1) && Engine_Api::_()->user()->getViewer()->getIdentity() != $member->getIdentity()):?>
		<?php $FollowUser = Engine_Api::_()->sesmember()->getFollowStatus($member->user_id);?>
		<?php $followClass = (!$FollowUser) ? 'fa-check' : 'fa-times' ;?>
		<?php $followText = ($FollowUser) ? $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.unfollowtext','Unfollow')) : $this->translate(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.follow.followtext','Follow')) ;?>
		<?php $followButton =  "<span><a href='javascript:;' data-url='".$member->getIdentity()."' class='sesbasic_btn sesmember_add_btn sesmember_follow_user sesmember_follow_user_".$member->getIdentity()."'><i class='fa ".$followClass."'  title='$followText'></i> <span><i class='fa fa-caret-down'></i>$followText</span></a></span>"; ?>
	<?php endif;?>
	
	<?php $message = '';?>
	<?php if (Engine_Api::_()->sesbasic()->hasCheckMessage($member) && isset($this->messageActive)): ?>
		<?php $baseUrl = $this->baseUrl();?>
		<?php $messageText = $this->translate('Message');?>
		<?php $message = "<a href=\"$baseUrl/messages/compose/to/$member->user_id\" target=\"_parent\" title=\"$messageText\" class=\"smoothbox sesbasic_btn sesmember_add_btn\"><i class=\"fa fa-commenting-o\"></i><span><i class=\"fa fa-caret-down\"></i>Message</span></a>"; ?>
	<?php endif; ?> 

	<?php if($member->lat): ?>
	<?php // Show Label
			$labels = '';
			if(isset($this->featuredLabelActive) || isset($this->sponsoredLabelActive)) {
				$labels .= "<div class=\"sesmember_labels\">";
				if(isset($this->featuredLabelActive) && $member->featured == 1) {
		$labels .= "<p class=\"sesmember_label_featured\">".$this->translate('FEATURED')."</p>";
				}
				if(isset($this->sponsoredLabelActive) && $member->sponsored == 1) {
		$labels .= "<p class=\"sesmember_label_sponsored\">".$this->translate('SPONSORED')."</p>";
				}
				$labels .= "</div>";
     
			}
			$location = '';
      $vlabel = '';
      ?>
      <?php 
     		if(isset($this->verifiedLabelActive) && $member->user_verified == 1) {
					$vlabel = "<i class=\"sesmember_verified_sign fa fa-check-circle\" title=\"VERIFIED\"></i>";
				}
      ?>
		<?php if(isset($this->locationActive) && $member->location && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.enable.location', 1)):?>
			<?php $locationText = $this->translate('Location');?>
			<?php $locationvalue = $member->location;?>
			<?php $location = "<div class=\"sesmember_list_stats sesmember_list_location\">
			<span class=\"widthfull\">
			<i class=\"fa fa-map-marker\" title=\"$locationText\"></i>
			<span title=\"$locationvalue\"><a href='".$this->url(array('resource_id' => $member->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true)."' class=\"opensmoothboxurl\">$locationvalue</a></span>
			</span>
			</div>"; 
			?>
	<?php endif;?>
  <?php 
    $likeButton = '';
    if(Engine_Api::_()->user()->getViewer()->getIdentity() != 0 &&  isset($this->likeButtonActive)){
      $LikeStatus = Engine_Api::_()->sesbasic()->getLikeStatus($member->user_id,$member->getType());
      $likeClass = ($LikeStatus) ? ' button_active' : '' ;
      $likeButton = '<a href="javascript:;" data-url="'.$member->getIdentity().'" class="sesbasic_icon_btn sesbasic_icon_btn_count sesbasic_icon_like_btn sesmember_like_user_'. $member->user_id.' sesmember_like_user '.$likeClass .'"> <i class="fa fa-thumbs-up"></i><span>'.$member->like_count.'</span></a>';
    }
    $user = Engine_Api::_()->getItem('user',$member->user_id);
    $memberratingstar= '';
    if(Engine_Api::_()->getApi('core', 'sesmember')->allowReviewRating() && isset($this->ratingActive)){
    	$memberratingstar = $this->partial('_userRating.tpl', 'sesmember', array('rating' => $member->rating));
    }
    $urlencode = urlencode(((!empty($_SERVER["HTTPS"]) &&  strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $member->getHref());
		
    $stats = $ratings.'<div class="sesmember_list_stats sesbasic_clearfix">';
    if(isset($this->viewActive)){
      $stats .= '<span title="'. $this->translate(array('%s view', '%s views', $member->view_count), $this->locale()->toNumber($member->view_count)).'"><i class="fa fa-eye"></i>'.$member->view_count.'</span>';
    }
    if(isset($this->likeActive)){
      $stats .= '<span title="'.$this->translate(array('%s like', '%s likes', $member->like_count), $this->locale()->toNumber($member->like_count)).'"><i class="fa fa-thumbs-up"></i>'.$member->like_count.'</span> ';
    }
    $stats .= '</div>';
    
    $socialShare = $this->partial('_socialShareIcons.tpl','sesbasic',array('resource' => $member, 'param' => 'feed', 'socialshare_enable_plusicon' => $this->socialshare_enable_plusicon, 'socialshare_icon_limit' => $this->socialshare_icon_limit));
    if(isset($this->socialSharingActive)){
      $socialshare = '<div class="sesmember_grid_btns">'.$socialShare.$likeButton.'</div>';

    }else
    $socialshare = $likeButton;
    $locationArray[$counter]['id'] = $member->getIdentity();
    $locationArray[$counter]['location'] = $location;
    $locationArray[$counter]['vlabel'] = $vlabel;
    $locationArray[$counter]['labels'] = $labels;
    $locationArray[$counter]['stats'] = $stats;
    $locationArray[$counter]['memberratingstar'] = $memberratingstar;
    $locationArray[$counter]['memberType'] = $memberType;
    $locationArray[$counter]['memberAge'] = $memberAge;
    $locationArray[$counter]['socialshare'] = $socialshare;
    $locationArray[$counter]['friendButton'] = $friend;
		$locationArray[$counter]['followButton'] = $followButton;
		$locationArray[$counter]['message'] = $message;
		$locationArray[$counter]['likeMainButton'] = $likeMainButton;
    $locationArray[$counter]['lat'] = $member->lat;
    $locationArray[$counter]['lng'] = $member->lng;
    $locationArray[$counter]['iframe_url'] = '';
    $locationArray[$counter]['image_url'] = $member->getPhotoUrl();
    $locationArray[$counter]['title'] = '<a href="'.$member->getHref().'">'.$member->displayname.'</a>';   
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
      zoom: 2,
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
	var images = '<div class="image sesmember_map_thumb_img"><img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'"  /></div>';		
	var labels = markerArrayData_<?php echo $randonNumber?>[i]['labels'];
	var location = markerArrayData_<?php echo $randonNumber?>[i]['location'];
	var stats = markerArrayData_<?php echo $randonNumber?>[i]['stats'];
	var socialshare = markerArrayData_<?php echo $randonNumber?>[i]['socialshare'];
	var friendButton = markerArrayData_<?php echo $randonNumber?>[i]['friendButton'];
	var followButton = markerArrayData_<?php echo $randonNumber?>[i]['followButton'];
	var message = markerArrayData_<?php echo $randonNumber?>[i]['message'];
	var likeMainButton = markerArrayData_<?php echo $randonNumber?>[i]['likeMainButton'];
	var memberratingstar = markerArrayData_<?php echo $randonNumber?>[i]['memberratingstar'];
	var memberType = markerArrayData_<?php echo $randonNumber?>[i]['memberType'];
	var memberAge = markerArrayData_<?php echo $randonNumber?>[i]['memberAge'];
	var marker_html = '<div class="pin public marker_'+countMarker_<?php echo $randonNumber;?>+'" data-lat="'+ markerArrayData_<?php echo $randonNumber?>[i]['lat']+'" data-lng="'+ markerArrayData_<?php echo $randonNumber?>[i]['lng']+'">' +
	'<div class="wrapper">' +
	'<div class="small">' +
	'<img src="'+markerArrayData_<?php echo $randonNumber?>[i]['image_url']+'" style="height:48px;width:48px;" alt="" />' +
	'</div>' +
	'<div class="large"><div class="sesmember_map_thumb sesmember_grid_btns_wrap">' +
	images+labels+socialshare+
	'</div><div class="sesbasic_large_map_content sesmember_large_map_content sesbasic_clearfix">' +
	'<div class="sesbasic_large_map_content_title">'+markerArrayData_<?php echo $randonNumber?>[i]['title']+markerArrayData_<?php echo $randonNumber?>[i]['vlabel']+'</div>'+memberratingstar+memberType + memberAge + location+stats +'<div class="sesmember_list_stats_btn clearfix clear"><span>'+friendButton+'</span><span>'+followButton+'</span><span>'+message+'</span><span>'+likeMainButton+'</span></div></div></div>'+'<a class="icn close" href="javascript:;" title="Close"><i class="fa fa-close"></i></a>' + 
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
      'url': en4.core.baseUrl + "widget/index/mod/sesmember/name/<?php echo $this->widgetName; ?>",
      'data': {
	format: 'html',
	is_ajax : 1,
	searchParams:searchParams,
	show_criterias : '<?php echo json_encode($this->show_criterias); ?>'
      },
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
	if($('loadingimgsesmember-wrapper'))
	sesJqueryObject ('#loadingimgsesmember-wrapper').hide();
	DeleteMarkers_<?php echo $randonNumber ?>();
	if(responseHTML){
	  var mapData = sesJqueryObject.parseJSON(responseHTML);
	  if(sesJqueryObject.isArray(mapData) && sesJqueryObject(mapData).length) {
	    newMapData_<?php echo $randonNumber ?> = mapData;
	    mapFunction_<?php echo $randonNumber?>();
	  }
	}
	sesJqueryObject('#loadingimgsesmember-wrapper').hide();
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

<div id="map-data_location_widget_sesmember" style="display:none;"><?php echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ?></div>
<div id="map-canvas-location_widget_sesmember" class="map sesbasic_large_map sesbm sesbasic_bxs sesmember_browse_map"></div>
<?php }else{ echo json_encode($locationArray,JSON_HEX_QUOT | JSON_HEX_TAG); ; die;} ?>
