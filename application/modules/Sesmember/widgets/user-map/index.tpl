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
<?php $getUserInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($this->subject->user_id); ?>
<?php
if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.enable.location', 1)) {
$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));
}
?>
<?php
  $href = $this->subject->getHref();
  $imageURL = $this->subject->getPhotoUrl('thumb.profile');
?>
<script type="text/javascript">
    var latLngSes;
    function initializeMapSes() {
        var latLngSes = new google.maps.LatLng(<?php echo $this->locationLatLng->lat; ?>,<?php echo $this->locationLatLng->lng; ?>);
        var myOptions = {
            zoom: 13,
            center: latLngSes,
            navigationControl: true,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
				
        var map = new google.maps.Map(document.getElementById("sesmember_map_container"), myOptions);
			

        var marker = new google.maps.Marker({
            position: latLngSes,
            map: map,
        });

				//trigger map resize on every call
       sesJqueryObject(document).on('click','ul#main_tabs li.tab_layout_sesmember_user_map',function (event) {
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
<div class="sesmember_profile_map_container sesbasic_clearfix">
	<div class="sesmember_profile_map sesbasic_clearfix sesbd" id="sesmember_map_container" style="height:<?php echo is_numeric($this->height) ? $this->height.'px' : $this->height ?>;"></div>
        
	<div class="sesmember_profile_map_address_box sesbasic_bxs">
		<b><a href="<?php echo $this->url(array('resource_id' => $this->subject->user_id,'resource_type'=>'user','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox"><?php echo $getUserInfoItem->location ?></a></b>
	</div>
</div>	
<script type="text/javascript">
var tabId_map = <?php echo $this->identity; ?>;
window.addEvent('domready', function() {
	tabContainerHrefSesbasic(tabId_map);	
});
    window.addEvent('domready', function() {
        initializeMapSes();
    });
</script>
