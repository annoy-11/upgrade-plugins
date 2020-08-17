<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/styles/darkbox.css'); ?>

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/customscrollbar.css'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js'); ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/customscrollbar.concat.min.js'); ?>

<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbusiness/externals/scripts/darkbox.js'); ?>

<script type='text/javascript'>
  function viewMap(lat,lng,element) {
     var myLatlng = new google.maps.LatLng(lat, lng);console.log(lat,lng,element);
   new google.maps.LatLng(lat, lng);
      var myOptions = {
       zoom: 17,
       center: myLatlng,
       mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var mapLocationCreate = new google.maps.Map(document.getElementById(sesJqueryObject(element).attr('id')), myOptions);
      var marker = new google.maps.Marker({
        position: myLatlng,
        map: mapLocationCreate,
      });
      sesJqueryObject(element).removeClass('createMap');
    }
    function createMap() {
      var elment = sesJqueryObject('.mapCreate').each(function(){
        viewMap(sesJqueryObject(this).data('lat'),sesJqueryObject(this).data('lng'),sesJqueryObject(this));
      })
    }
    sesJqueryObject(document).ready(function() {
      createMap();
  });
  </script>

<div class="sesbusiness_locations sesbusiness_profile_locations sesbasic_bxs">
  <?php $googleKey = Engine_Api::_()->getApi('settings', 'core')->getSetting('ses.mapApiKey', '');?>
  <?php foreach($this->paginator as $location):?>
    <div class="sesbusiness_locations_item sesbasic_clearfix">
      <div class="_map mapCreate" data-lat="<?php echo $location->lat;?>" data-lng="<?php echo $location->lng;?>" id="view_map_<?php echo $location->location_id;?>">
      </div>
      <div class="_cont">
        <div class="_title sesbasic_clearfix">
          <?php echo $location->title;?>
        </div>
        <div class="_info">
          <div class="_infof">
            <span><?php echo $this->translate("Location:");?></span>
            <span><?php echo $location->location;?> - <a href="<?php echo $this->url(array('resource_id' => $this->business->business_id,'resource_type'=>'businesses','action'=>'get-direction'), 'sesbasic_get_direction', true);?>" class="openSmoothbox"><?php echo $this->translate('View Map');?></a></span> 
          </div>
          <?php if(!empty($location->venue)):?>
            <div class="_infof">
              <span><?php echo $this->translate("Venue");?></span>
              <span><?php echo $location->venue;?></span>
            </div>
          <?php endif;?>
          <?php if(!empty($location->address)):?>
            <div class="_infof">
              <span><?php echo $this->translate("Address:");?></span>
              <span><?php echo $location->address;?></span>
            </div>
          <?php endif;?>
          <?php if(!empty($location->address2)):?>
            <div class="_infof">
              <span><?php echo $this->translate("Street Address:");?></span>
              <span><?php echo $location->address2;?></span>
            </div>
          <?php endif;?>
          <div class="_infof">
            <p>
              <span><?php echo $this->translate("City:");?></span>
              <span><?php echo $location->city;?></span>
            </p>  
            <p>
              <span><?php echo $this->translate("Zipcode:");?></span>
              <span><?php echo $location->zip;?></span>
            </p>
          </div>
          <div class="_infof">
            <p>
              <span><?php echo $this->translate("State:");?></span>
              <span><?php echo $location->state;?></span>
            </p>
            <p>
              <span><?php echo $this->translate("Country:");?></span>
              <span><?php echo $location->country;?></span>
            </p>  
          </div>
        </div>
        <div class="_photos sesbasic_clearfix sesbasic_horrizontal_scroll">
          <div id="sesbusiness_location_<?php echo $location->location_id;?>">
            <?php $locationPhotos = Engine_Api::_()->getDbTable('locationphotos','sesbusiness')->getLocationPhotos(array('business_id'=> $this->business->business_id,'location_id' => $location->location_id));?>
            <?php foreach($locationPhotos as $photo):?>
              <div class="_thumb" id="sesbusiness_locationphoto_<?php echo $photo->locationphoto_id;?>">
								<span class="bg_item_photo" style="background-image:url(<?php echo $photo->getPhotoUrl('thumb.normal'); ?>);" data-darkbox="<?php echo $photo->getPhotoUrl('thumb.main'); ?>" data-darkbox-business="locationphotos_<?php echo $location->location_id;?>"></span>
              </div>
            <?php endforeach;?>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach;?>
</div>
<?php if($this->is_ajax) die; ?>
