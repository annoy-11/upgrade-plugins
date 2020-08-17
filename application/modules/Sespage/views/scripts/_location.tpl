<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _location.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php
$enableglocation = Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1);
$optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}')); ?>
<?php $location = isset($_POST['location']) ? $_POST['location'] : (isset($this->page) && !empty($this->page->location) ? $this->page->location : '') ; ?>
<?php $venue_name = isset($_POST['venue_name']) ? $_POST['venue_name'] : (isset($this->itemlocation) && !empty($this->itemlocation->venue) ? $this->itemlocation->venue : '') ; ?>
<?php $lat = isset($_POST['lat']) ? $_POST['lat'] : (isset($this->itemlocation) && !empty($this->itemlocation->lat) ? $this->itemlocation->lat : '') ; ?>
<?php $lng = isset($_POST['lng']) ? $_POST['lng'] : (isset($this->itemlocation) && !empty($this->itemlocation->lng) ? $this->itemlocation->lng : '') ; ?>
<?php $address = isset($_POST['address']) ? $_POST['address'] : (isset($this->itemlocation) && !empty($this->itemlocation->address) ? $this->itemlocation->address : '') ; ?>
<?php $address2 = isset($_POST['address2']) ? $_POST['address2'] : (isset($this->itemlocation) && !empty($this->itemlocation->address2) ? $this->itemlocation->address2 : '') ; ?>
<?php $city = isset($_POST['city']) ? $_POST['city'] : (isset($this->itemlocation) && !empty($this->itemlocation->city) ? $this->itemlocation->city : '') ; ?>
<?php $state = isset($_POST['state']) ? $_POST['state'] : (isset($this->itemlocation) && !empty($this->itemlocation->state) ? $this->itemlocation->state : '') ; ?>
<?php $country = isset($_POST['country']) ? $_POST['country'] : (isset($this->itemlocation) && !empty($this->itemlocation->country) ? $this->itemlocation->country : '') ; ?>
<?php $zip = isset($_POST['zip']) ? $_POST['zip'] : (isset($this->itemlocation) && !empty($this->itemlocation->zip) ? $this->itemlocation->zip : '') ; ?>
<script>var checkinD = false;</script>
<div id="seslocation-wrapper" class="form-wrapper">
    <div id="location-label" class="form-label">
      <label for="locationSes" class="<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.location.isrequired', 1)):?>required<?php endif;?>"><?php echo $this->translate("Location"); ?></label>
    </div>
    <div id="location-element" class="form-element">
      <input type="text" name="location" id="locationSes" value="<?php echo $location; ?>" />
    </div>
	</div>
	<div id="online_page-wrapper" class="form-wrapper" style="display:none;">
    <div id="online_page-label" class="form-label">
      <label for="online_page" class="optional"><?php echo $this->translate("Location"); ?></label>
    </div>
    <div id="online_page-element" class="form-element">
      <div class="tip"><span><?php echo $this->translate("This is an online page"); ?></span></div>
    </div>
  </div>
	<div id="sespage_location_data-wrapper" class="sespage_create_map_box form-wrapper" style="display:none;">
  	<div class="form-label"></div>
    <div class="form-element">  
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
        <div id="sespage_location_map_data" class="sespage_create_map_container sesbm" style="display:none;">
          <div id="sespage_default_map" class="sespage_create_blank_map centerT" style="display:none">
            <i class="fa fa-map-marker sesbasic_text_light"></i>
            <span class="sesbasic_text_light">No Map</span>
          </div>
          <div id="sespage_location_map" class="sespage_create_map" style="display:none"></div>
        </div>
      <?php } ?>
      <div class="sespage_create_location_details sesbasic_bxs">
        <div id="venue_name-wrapper" class="sespage_create_location_field _full">
          <input type="text" name="venue_name" class="location_value" id="venue_name" value="<?php echo $venue_name; ?>" placeholder="<?php echo $this->translate("Venue Name"); ?>" />
        </div>
        <div id="address-wrapper" class="sespage_create_location_field ">
          <input type="text" name="address" class="location_value" id="address" value="<?php echo $address; ?>" placeholder="<?php echo $this->translate("Address"); ?>" />
        </div>
        <div id="address2-wrapper" class="sespage_create_location_field">
          <input type="text" name="address2" class="location_value" id="address2" value="<?php echo $address2; ?>" placeholder="<?php echo $this->translate("Address 2"); ?>" />
        </div>
        <div id="city-wrapper" class="sespage_create_location_field">
          <input type="text" name="city" class="location_value" id="city" value="<?php echo $city; ?>" placeholder="<?php echo $this->translate("City"); ?>" />
        </div>
        <div id="state-wrapper" class="sespage_create_location_field">
          <input type="text" name="state" class="location_value" id="state" value="<?php echo $state; ?>" placeholder="<?php echo $this->translate("State"); ?>" />
        </div>
        <div id="zip-wrapper" class="sespage_create_location_field">
          <input type="text" name="zip" class="location_value" id="zip" value="<?php echo $zip; ?>" placeholder="<?php echo $this->translate("Zip"); ?>" />
        </div>
        <?php if($this->countrySelect != ''){ ?>
          <div id="country-wrapper" class="sespage_create_location_field">
            <select name="country" class="location_value" id="country">
              <?php echo $this->countrySelect; ?>
            </select>
          </div>
        <?php } ?>
        <!-- Lat lng wrapper -->
        <div id="sespagelat-wrapper" class="sespage_create_location_field">
          <input type="text" name="lat" class="location_value" id="latSes" value="<?php echo $lat; ?>" placeholder="<?php echo $this->translate("Latitude"); ?>" />
        </div>
        <div id="sespagelng-wrapper" class="sespage_create_location_field">
          <input type="text" name="lng" class="location_value" id="lngSes" value="<?php echo $lng; ?>" placeholder="<?php echo $this->translate("Longitude"); ?>" />
        </div>
      </div>
      <div id="location_options" class="clear _links">
        <a id="sespage_enter_address" href="javascript:;" class="form-link" style="display:none;"><i class="fa fa-map-marker"></i><?php echo $this->translate("Enter Address"); ?></a>
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
          <a id="sespage_reset_location" style="display:none" href="javascript:;" class="form-link"><i class="fa fa-refresh"></i><?php echo $this->translate("Reset Location"); ?></a>
        <?php } ?>
      </div>
    </div>
  </div>


<script type="application/javascript">
  en4.core.runonce.add(function() {
    <?php if(!$enableglocation) { ?>
      <?php if(!in_array('country', $optionsenableglotion)) { ?>
        sesJqueryObject('#country-wrapper').hide();
      <?php } ?>
      <?php if(!in_array('state', $optionsenableglotion)) { ?>
        sesJqueryObject('#state-wrapper').hide();
      <?php } ?>
      <?php if(!in_array('city', $optionsenableglotion)) { ?>
        sesJqueryObject('#city-wrapper').hide();
      <?php } ?>
      <?php if(!in_array('zip', $optionsenableglotion)) { ?>
        sesJqueryObject('#zip-wrapper').hide();
      <?php } ?>
      <?php if(!in_array('lat', $optionsenableglotion)) { ?>
        sesJqueryObject('#sespagelat-wrapper').hide();
      <?php } else { ?>
        sesJqueryObject('#sespagelat-wrapper').show();
      <?php } ?>
      <?php if(!in_array('lng', $optionsenableglotion)) { ?>
        sesJqueryObject('#sespagelng-wrapper').hide();
      <?php } else { ?>
        sesJqueryObject('#sespagelng-wrapper').show();
      <?php } ?>
    <?php } ?>
  
    if(typeof locationcreatedata == 'undefined'){
      locationcreatedata = true;
      sesJqueryObject(document).on('click','#sespage_enter_address',function(){
        sesJqueryObject('#seslocation-wrapper').show();
        sesJqueryObject('#sespage_location_data-wrapper').show();
        sesJqueryObject('#sespage_enter_address').hide();
        sesJqueryObject('#sespage_reset_location').show();
        var lat = sesJqueryObject('#latSes').val();
        var lng = sesJqueryObject('#lngSes').val();
        if(lat && lng ){
          sesJqueryObject('#sespage_location_map_data').show();
          sesJqueryObject('#sespage_location_map').show();
          sesJqueryObject('#sespage_default_map').hide();
          createPageLoadMap();
        }else{
          sesJqueryObject('#sespage_location_map_data').show();
          sesJqueryObject('#sespage_location_map').hide();
          sesJqueryObject('#sespage_default_map').show();
        }
      });
      sesJqueryObject(document).on('click','#sespage_reset_location',function(){
        var confirmAc = confirm('Are you sure that you want to reset this location? It will not be recoverable after being deleted.');
        if(confirmAc == true){
          sesJqueryObject('#sespage_location_map_data').hide();
          sesJqueryObject('#seslocation-wrapper').show();
          sesJqueryObject('#online_page-wrapper').hide();
          sesJqueryObject('#sespage_location_data-wrapper').hide();
          sesJqueryObject('#sespage_reset_location').hide();
          sesJqueryObject('.location_value').val('');
          sesJqueryObject('#locationSes').val('');
          sesJqueryObject('#lngSes').val('');
          sesJqueryObject('#latSes').val('');
        }
        return false;
      });
    }
    <?php if($location != '' && ($venue_name != '' || $city != '' || $state != '' || $country != '' || $zip != '' || $address != '' || $address2 != '')){ ?>
      checkinD = true;
      sesJqueryObject('#sespage_enter_address').trigger('click');
    <?php } ?>
    mapLoad_page = false;
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) { ?>
      initializeSesPageMapList();
    <?php } else { ?>
      sesJqueryObject('#sespage_location_data-wrapper').show();
      sesJqueryObject('#venue_name-wrapper').hide();
      sesJqueryObject('#address-wrapper').hide();
      sesJqueryObject('#address2-wrapper').hide();
    <?php } ?>
  });
  function createPageLoadMap() {
    var lat = sesJqueryObject('#latSes').val();
    var lng = sesJqueryObject('#lngSes').val();
    if(lat && lng && sesJqueryObject('#sespage_location_map_data').css('display') == 'none'){
      sesJqueryObject('#sespage_enter_address').trigger('click');
    }
	if(lat && lng && sesJqueryObject('#sespage_location_map_data').css('display') == 'block'){
      sesJqueryObject('#sespage_location_map').show();
      sesJqueryObject('#sespage_default_map').hide();
      var myLatlng = new google.maps.LatLng(lat, lng);
      var myOptions = {
       zoom: 17,
       center: myLatlng,
       mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var mapLocationCreate = new google.maps.Map(document.getElementById("sespage_location_map"), myOptions);
      var marker = new google.maps.Marker({
        position: myLatlng,
        map: mapLocationCreate,
      });
      google.maps.event.addListener(mapLocationCreate, 'click', function() {
        google.maps.event.trigger(mapLocationCreate, 'resize');
        mapLocationCreate.setZoom(17);
        mapLocationCreate.setCenter(myLatlng);
      });
      if(checkinD){
        checkinD = false;
        return ;
      }
	  var geocoder = new google.maps.Geocoder(); 
      geocoder.geocode({'latLng': new google.maps.LatLng(lat, lng)}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK && results.length) {
          if (results[0]) {
            for(var i=0; i<results[0].address_components.length; i++){
              var postalCode = results[0].address_components[i].long_name;
             }
           }					
            if (results[1]) {
             var indice=0;
             for (var j=0; j<results.length; j++){
               if (results[j].types[0]=='locality'){
                 indice=j;
                 break;
               }
             }
              var city = state = country = "";
              if(typeof results[indice] != "undefines"){
                for (var i=0; i<results[indice].address_components.length; i++){
                  if (results[indice].address_components[i].types[0] == "locality") {
                    //this is the object you are looking for
                    city = results[indice].address_components[i].long_name;
                  }
                  if (results[indice].address_components[i].types[0] == "administrative_area_level_1") {
                    //this is the object you are looking for
                    state = results[indice].address_components[i].long_name;
                  }
                  if (results[indice].address_components[i].types[0] == "country") {
                    //this is the object you are looking for
                    country = results[indice].address_components[i].long_name;
                  }
                }
              }
             if(postalCode != "")
                  sesJqueryObject('#zip').val(postalCode);
              else
                  sesJqueryObject('#zip').val('');
              if(city != "")
                 sesJqueryObject('#city').val(city);
              else
                 sesJqueryObject('#city').val('');
              if(state != "")
                sesJqueryObject('#state').val(state);
              else
                sesJqueryObject('#state').val('');
              if(country != "")
                sesJqueryObject('#country').val(country);
              else
                sesJqueryObject('#country').val('');
			}
		  } 
       });		
	}
 }
</script>
