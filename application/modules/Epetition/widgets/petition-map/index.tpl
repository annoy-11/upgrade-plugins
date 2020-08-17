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
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('epetition.enable.location', 1)):?>
	<?php $headScript = new Zend_View_Helper_HeadScript();?>
	<?php $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));?>
<?php endif;?>
<script type="text/javascript">
	var latLngSes;
	function initializeMapSes12() {
		var latLngSes = new google.maps.LatLng(<?php echo $this->locationLatLng->lat; ?>,<?php echo $this->locationLatLng->lng; ?>);
		var myOptions = {
			zoom: 13,
			center: latLngSes,
			navigationControl: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(document.getElementById("epetition_map_container1"), myOptions);
		var map1 = new google.maps.Map(document.getElementById("epetition_location_googleMap"), myOptions);
        var marker1 = new google.maps.Marker({
            position: latLngSes,
            map: map1,
            zoom:26,
        });
		var marker = new google.maps.Marker({
			position: latLngSes,
			map: map,
		});
		//trigger map resize on every call
		sesJqueryObject(document).on('click','ul#main_tabs li.tab_layout_epetition_petition_map',function (event) {
			google.maps.event.trigger(map, 'resize');
			map.setZoom(13);
			map.setCenter(latLngSes);
		});
		google.maps.event.addListener(map, 'click', function() {
			google.maps.event.trigger(map, 'resize');
			map.setZoom(13);
			map.setCenter(latLngSes);
		});
	}
</script>
<div class="epetition_profile_map_container sesbasic_clearfix">
	<div class="epetition_profile_map sesbasic_clearfix sesbd" id="epetition_map_container1"></div>
	<div class="epetition_profile_map_address_box sesbasic_bxs">
		<b><a href="<?php echo $this->url(array('resource_id' => $this->subject->epetition_id,'resource_type'=>'epetition','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox"><i class="fa fa-map-marker"></i><?php echo $this->subject->location ?></a></b>
	</div>

    <div id="epetition_location_googleMap" style="width:100%;height:400px;"></div>
</div>
<script type="text/javascript">
	var tabId_map = <?php echo $this->identity; ?>;
		window.addEvent('domready', function() {
		tabContainerHrefSesbasic(tabId_map);	
	});
	window.addEvent('domready', function() {
		initializeMapSes12();
	});
</script>
