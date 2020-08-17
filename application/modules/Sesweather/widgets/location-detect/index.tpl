<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<script type="application/javascript">
  <?php if(empty($this->cookiedata['location'])){ ?>
    window.addEvent('domready', function() {getLocation();});	
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      }
    }
    function showPosition(position) {
      var latMap = position.coords.latitude;
      var lngMap = position.coords.longitude;
      codeLatLng(latMap,lngMap);
    }
    function codeLatLng(lat, lng) {
      var latlng = new google.maps.LatLng(lat, lng);
      var 	geocoder = new google.maps.Geocoder();
      var mylocation;
        geocoder
      .geocode({'latLng' : latlng},
      function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
              var arrAddress = results;
              //iterate through address_component array
              sesJqueryObject.each(arrAddress,
                function(i, address_component) {
                if(i == 0){
                  mylocation = address_component.formatted_address;
                }
              });
            } 
            if(mylocation){
              setCookie('sesbasic_location_data',mylocation,30);
              //set lat in cookie
              setCookie('sesbasic_location_lat',lat,30);
              //set lng in cookie		
              setCookie('sesbasic_location_lng',lng,30);
              window.location.reload();
            }
          } 
      });
    }
  <?php } ?>
 
 function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires+"; path=/"; 
 } 
</script>