<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: add-location.tpl 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<div class="sesmember_edit_location_popup"><?php echo $this->form->render($this) ?></div>
<script type="application/javascript">

var input = document.getElementById('ses_location');
  var autocomplete =  new google.maps.places.Autocomplete(input)
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    var place = autocomplete.getPlace();
    if (!place.geometry)
    return;
    document.getElementById('ses_lng').value = lngGetOpn = place.geometry.location.lng();
    document.getElementById('ses_lat').value = latGetOpn = place.geometry.location.lat();
		myLatlng = new google.maps.LatLng(place.geometry.location.lat(),place.geometry.location.lng());

		map.panTo(myLatlng);
		getLocationData(place.geometry.location.lat(),place.geometry.location.lng());
   
	});
	


function getLocationData(lat, lng){
	 var geocoder = new google.maps.Geocoder(); 
	 var city = state = country = postalCode = '';
    geocoder.geocode({'latLng': new google.maps.LatLng(lat, lng)}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK && results.length) {
				sesJqueryObject('#ses_location').val(results[0].formatted_address);
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
			sesJqueryObject('#ses_location').val('');
			sesJqueryObject('#ses_zip').val('');
			sesJqueryObject('#ses_city').val('');
			sesJqueryObject('#ses_state').val('');
			sesJqueryObject('#ses_country').val('');
		}
  });	
}
</script>