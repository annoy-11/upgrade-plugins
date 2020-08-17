<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sescrowdfunding.enable.location', 1)):?>
	<?php $headScript = new Zend_View_Helper_HeadScript();?>
	<?php $headScript->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', ''));?>
<?php endif;?>
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
		var map = new google.maps.Map(document.getElementById("sescrowdfunding_map_container"), myOptions);
		var marker = new google.maps.Marker({
			position: latLngSes,
			map: map,
		});
		//trigger map resize on every call
		sesJqueryObject(document).on('click','ul#main_tabs li.tab_layout_sescrowdfunding_map',function (event) {
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
<?php $location = $this->location; ?>
<div class="sesbasic_clearfix">
  <div class="sescf_profile_map_container sesbasic_clearfix">
    <div class="sescf_profile_map sesbasic_clearfix sesbd" id="sescrowdfunding_map_container"></div>
  </div>
  <div class="profile_fields">
  	<h4><span><?php echo $this->translate("Location Information"); ?></span></h4>
    <ul>
    	<li>
      	<span><?php echo $this->translate("Location:"); ?></span>
        <span><?php echo $this->subject->location ?>&nbsp;&nbsp;<a href="<?php echo $this->url(array('resource_id' => $this->subject->crowdfunding_id,'resource_type'=>'crowdfunding','action'=>'get-direction'), 'sesbasic_get_direction', true); ?>" class="openSmoothbox fa fa-external-link-square" style="text-decoration:none;"></a></span>
      </li>
      <?php if($location->city) { ?>
        <li>
          <span><?php echo $this->translate("City:"); ?></span>
          <span><?php echo $location->city; ?></span>
        </li>
      <?php } ?>
      <?php if($location->state) { ?>
      <li>
      	<span><?php echo $this->translate("State:"); ?></span>
        <span><?php echo $location->state; ?></span>
      </li>
      <?php } ?>
      <?php if($location->country) { ?>
      <li>
      	<span><?php echo $this->translate("Country:"); ?></span>
        <span><?php echo $location->country; ?></span>
      </li>
      <?php } ?>
      <?php if($location->zip) { ?>
      <li>
      	<span><?php echo $this->translate("ZIP Code:"); ?></span>
        <span><?php echo $location->zip; ?></span>
      </li>
      <?php } ?>
    </ul>
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
