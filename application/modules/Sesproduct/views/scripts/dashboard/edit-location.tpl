<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-location.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php
$enableglocation = Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1);
$optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}'));
?>
<?php if(!$this->is_ajax) {
  echo $this->partial('dashboard/left-bar.tpl', 'sesproduct', array('product' => $this->product));	
?>
<div class="estore_dashboard_content sesbm sesbasic_clearfix">
<?php }  ?>
	
  <div class="estore_edit_location_form estore_dashboard_form sesbm sesbasic_clearfix sesbasic_bxs"><?php echo $this->form->render($this) ?></div>
  
<?php if(!$this->is_ajax) { ?>
	</div>
  </div>
<?php } ?>

<script type="application/javascript">

<?php if(!$enableglocation) { ?>
  en4.core.runonce.add(function() {
    sesJqueryObject('#mapcanvasdiv-wrapper').hide();
    <?php if(!in_array('country', $optionsenableglotion)) { ?>
      sesJqueryObject('#ses_country-wrapper').hide();
    <?php } ?>
    <?php if(!in_array('state', $optionsenableglotion)) { ?>
      sesJqueryObject('#ses_state-wrapper').hide();
    <?php } ?>
    <?php if(!in_array('city', $optionsenableglotion)) { ?>
      sesJqueryObject('#ses_city-wrapper').hide();
    <?php } ?>
    <?php if(!in_array('zip', $optionsenableglotion)) { ?>
      sesJqueryObject('#ses_zip-wrapper').hide();
    <?php } ?>
    <?php if(!in_array('lat', $optionsenableglotion)) { ?>
      sesJqueryObject('#ses_lat-wrapper').hide();
    <?php } ?>
    <?php if(!in_array('lng', $optionsenableglotion)) { ?>
      sesJqueryObject('#ses_lng-wrapper').hide();
    <?php } ?>
  });
<?php } ?>

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
	<?php if($this->locationLatLng){ ?>
	  var latlng = new google.maps.LatLng(<?php echo $this->locationLatLng->lat; ?>,<?php echo $this->locationLatLng->lng; ?>);
   <?php }else{ ?>
   var latlng = new google.maps.LatLng(54.818,-2.438);
   <?php } ?>
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
<?php if($this->locationLatLng){ ?>
  var myLatlng = new google.maps.LatLng(<?php echo $this->locationLatLng->lat; ?>,<?php echo $this->locationLatLng->lng; ?>);
<?php }else{ ?>
  var myLatlng = new google.maps.LatLng(54.818,-2.438);
<?php } ?>
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
