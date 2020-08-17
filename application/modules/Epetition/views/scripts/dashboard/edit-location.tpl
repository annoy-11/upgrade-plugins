<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: edit-location.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php //echo $this->partial('dashboard/left-bar.tpl', 'epetition', array('petition' => $this->petition));	?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'epetition', array('petition' => $this->petition));
?>
<div class="sesbasic_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
	
	<p><?php echo $this->translate("Here you can manage your petition's location. This page will display location of the petition. The saved location will display on petiton profile page."); ?></p><br />
  <div class="epetition_edit_location_form sesbasic_dashboard_form sesbm sesbasic_clearfix sesbasic_bxs"><?php echo $this->form->render($this) ?></div>
  
<?php if(!$this->is_ajax) { ?>
	</div>
  </div>
<?php } ?>

<script type="application/javascript">

var input = document.getElementById('ses_edit_location');
  var autocomplete =  new google.maps.places.Autocomplete(input)
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    var place = autocomplete.getPlace();
    if (!place.geometry)
    return;
    document.getElementById('ses_lng').value = lngGetOpn = place.geometry.location.lng();
    document.getElementById('ses_lat').value = latGetOpn = place.geometry.location.lat();
		myLatlng = new google.maps.LatLng(place.geometry.location.lat(),place.geometry.location.lng());
		marker.setPosition(myLatlng);
		map.panTo(myLatlng);
		getLocationData(place.geometry.location.lat(),place.geometry.location.lng());
   
	});
	
	 var latlng = new google.maps.LatLng(<?php echo $this->locationLatLng->lat; ?>,<?php echo $this->locationLatLng->lng; ?>);
	 map = new google.maps.Map(document.getElementById('locationSesEdit'), {
						zoom: 14,
						center: latlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
				 });
	var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        zoom:25,
        title: 'Current Location',
        draggable:true,
});

google.maps.event.addListener(marker,'drag',function(event) {
    document.getElementById('ses_lat').value = event.latLng.lat();
    document.getElementById('ses_lng').value = event.latLng.lng();
});
var lngGetOpn = '<?php echo $this->locationLatLng->lng; ?>';
var latGetOpn = '<?php echo $this->locationLatLng->lat; ?>';
google.maps.event.addListener(marker,'dragend',function(event) 
  {
    document.getElementById('ses_lat').value = latGetOpn =  event.latLng.lat();
    document.getElementById('ses_lng').value = lngGetOpn = event.latLng.lng();
		myLatlng = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng());
		getLocationData(event.latLng.lat(),event.latLng.lng());
});
var myLatlng = new google.maps.LatLng(<?php echo $this->locationLatLng->lat; ?>,<?php echo $this->locationLatLng->lng; ?>);
google.maps.event.addListener(marker, 'click', function() {
    var infowindow = new google.maps.InfoWindow({
        content: 'Latitude: ' + latGetOpn + '<br>Longitude: ' + lngGetOpn
      });
    infowindow.open(map,marker);
});
function getLocationData(lat, lng){
	 var geocoder = new google.maps.Geocoder(); 
	 var city = state = country = postalCode = '';
    geocoder.geocode({'latLng': new google.maps.LatLng(lat, lng)}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK && results.length) {
				sesJqueryObject('#ses_edit_location').val(results[0].formatted_address);
			if (results[0]) {
				if(typeof results[0].address_components != 'undefined'){
					for(var i=0; i<results[0].address_components.length; i++) {
						var postalCode = results[0].address_components[i].long_name;
					}
				}
			}
			if (results[1]) {
				var indice=0;
				for (var j=0; j<results.length; j++)
				{
						if (results[j].types[0]=='locality')
						{
								indice=j;
								break;
						}
				}
				if(typeof results[j].address_components != 'undefined'){
					for (var i=0; i<results[j].address_components.length; i++) {
						if (results[j].address_components[i].types[0] == "locality") {
							//this is the object you are looking for
							city = results[j].address_components[i].long_name;
						}
						if (results[j].address_components[i].types[0] == "administrative_area_level_1") {
							//this is the object you are looking for
							state = results[j].address_components[i].long_name;
						}
						if (results[j].address_components[i].types[0] == "country") {
							//this is the object you are looking for
							country = results[j].address_components[i].long_name;
						}
					}
				}
				if(postalCode)
					sesJqueryObject('#ses_zip').val(postalCode);
				else
					sesJqueryObject('#ses_zip').val('');
				if(city)
					sesJqueryObject('#ses_city').val(city);
				else
					sesJqueryObject('#ses_city').val('');
				if(state)
				 sesJqueryObject('#ses_state').val(state);
				else
					sesJqueryObject('#ses_state').val('');
				if(country)
				 sesJqueryObject('#ses_country').val(country);
				else
					sesJqueryObject('#ses_country').val('');
			}
		} else{
			sesJqueryObject('#ses_edit_location').val('');
			sesJqueryObject('#ses_zip').val('');
			sesJqueryObject('#ses_city').val('');
			sesJqueryObject('#ses_state').val('');
			sesJqueryObject('#ses_country').val('');
		}
  });	
}
</script>
