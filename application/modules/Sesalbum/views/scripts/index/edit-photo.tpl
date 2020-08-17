<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesalbum
 * @package    Sesalbum
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-photo.tpl 2015-06-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesalbum/externals/styles/styles.css'); ?>
<div class="sesalbum_edit_photo_popup sesbasic_bxs">
  <form class="global_form">
    <div>
      <div>
        <h3><?php echo $this->translate('Edit Photo'); ?></h3>
        <div class="form-elements">
          <div id="title-wrapper" class="form-wrapper">
            <div id="title-label" class="form-label">
              <label for="title" class="optional"><?php echo $this->translate('Title');?></label>
            </div>
            <div id="title-element" class="form-element">
              <input type="text" name="title" id="title" value="<?php  echo $this->photo->title;  ?>">
            </div>
          </div>
          <div id="description-wrapper" class="form-wrapper">
            <div id="description-label" class="form-label">
              <label for="description" class="optional"><?php echo $this->translate('Image Description');?></label>
            </div>
            <div id="description-element" class="form-element">
              <textarea name="description" id="description" cols="120" rows="2"><?php echo $this->photo->description;  ?></textarea>
            </div>
          </div>
          <?php  if((Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) && (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesalbum_enable_location', 1))){ ?>
          <div id="location-wrapper" class="form-wrapper">
            <div id="location-label" class="form-label">
              <label for="location" class="optional"><?php echo $this->translate('Location');?></label>
            </div>
            <div id="location-element" class="form-element">
              <input type="text" name="location" placeholder="<?php echo $this->translate("Enter a location"); ?>" id="locationSesList" value="<?php  echo $this->photo->location;  ?>" >
              <input type="hidden" name="lat" id="latSesList" value="" >
              <input type="hidden" name="lng" id="lngSesList" value="" >
            </div>
          </div>
          <div class="form-wrapper" id="mapcanvas-wrapper" style="margin-top:10px;">
            <div class="form-label" id="mapcanvas-label">&nbsp;</div>
            <div class="form-element" id="map-canvas-list"></div>
          </div>
          <span style="display:none" id="ses_location_data_list"><?php echo $this->photo->location; ?></span>
          <?php } else if(empty(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) && (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesalbum_enable_location', 1))){?>
          	<div class="form-wrapper">
              <div class="form-label">
              	<label for="location" class="optional"><?php echo $this->translate('Location');?></label>
              </div>
              <div class="form-element sesalbum-location-fields">
              	<div class="sesalbum-location-fields-wrap">
                  <input type="text" id="locationName" value="<?php echo $this->photo->location; ?>" name="location" placeholder="<?php echo $this->translate('Location'); ?>">
                  <input type="text" id="countryName" value="<?php echo $this->locationData->country; ?>" name="country" placeholder="<?php echo $this->translate('Country'); ?>">
                  <input type="text" id="stateName" value="<?php echo $this->locationData->state; ?>" name="state" placeholder="<?php echo $this->translate('State'); ?>">
                  <input type="text" id="cityName" value="<?php echo $this->locationData->city; ?>" name="city" placeholder="<?php echo $this->translate('City'); ?>">
                  <input type="text" id="zipCode" value="<?php echo $this->locationData->zip; ?>" name="zip" placeholder="<?php echo $this->translate('Zip'); ?>">
                  <input type="text" id="latValue" value="<?php echo $this->locationData->lat; ?>" name="latValue" placeholder="<?php echo $this->translate('Latitude'); ?>">
                  <input type="text" id="lngValue" value="<?php echo $this->locationData->lng; ?>" name="lngValue" placeholder="<?php echo $this->translate('Longitude'); ?>">
                </div>
             </div>
        	</div>   
        <?php } ?>
          <div class="form-wrapper" id="buttons-wrapper">
            <fieldset id="fieldset-buttons">
              <button name="execute" id="execute" ><?php echo $this->translate('Save Changes');?></button>
              or <a name="cancel" id="cancel" type="button" href="javascript:void(0);" onclick="parent.Smoothbox.close();"><?php echo $this->translate('cancel'); ?></a>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript">
<?php  if((Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) && (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesalbum_enable_location', 1))){ ?>
	sesJqueryObject('#mapcanvas-label').attr('id','map-canvas-list');
	sesJqueryObject('#map-canvas-list').css('height','250px');
	sesJqueryObject('#ses_location-label').attr('id','ses_location_data_list');
	sesJqueryObject('#ses_location-wrapper').css('display','none');
  sesJqueryObject('#mapcanvas-wrapper').css('display','none');
	initializeSesAlbumMapList();
	sesJqueryObject( window ).load(function() {
		editSetMarkerOnMapList();
	});
	<?php } ?>
  sesJqueryObject(document).on('click','#execute',function(e){
		e.preventDefault();
    var photo_id = '<?php echo $this->photo_id;?>';
     <?php  if((Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) && (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesalbum_enable_location', 1))){ ?>
    request = new Request.JSON({
      'format' : 'json',
      'url' : '<?php echo $this->url(Array('controller' => 'index', 'action' => 'save-information'), 'sesalbum_extended',true) ?>/photo_id/'+photo_id,
      'data': {
        'photo_id' : photo_id,
        'title' : document.getElementById('title').value,
        'description' : document.getElementById('description').value,
				'location' : sesJqueryObject('#locationSesList').val(),
				'lat' : sesJqueryObject('#latSesList').val(),
				'lng' : sesJqueryObject('#lngSesList').val()
      },
     'onSuccess' : function(responseJSON) {
       parent.Smoothbox.close();
       return false;
      }
    });
     <?php } else if(empty(Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) && (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesalbum_enable_location', 1))){?>
      request = new Request.JSON({
      'format' : 'json',
      'url' : '<?php echo $this->url(Array('controller' => 'index', 'action' => 'save-information'), 'sesalbum_extended',true) ?>/photo_id/'+photo_id,
      'data': {
        'photo_id' : photo_id,
        'title' : document.getElementById('title').value,
        'description' : document.getElementById('description').value,
        'location' : sesJqueryObject('#locationName').val(),
        'latValue' : sesJqueryObject('#latValue').val(),
        'lngValue' : sesJqueryObject('#lngValue').val(),
        'country' : sesJqueryObject('#countryName').val(),
        'state' : sesJqueryObject('#stateName').val(),
        'city' : sesJqueryObject('#cityName').val(),
        'zip' : sesJqueryObject('#zipCode').val(),
      },
     'onSuccess' : function(responseJSON) {
       parent.Smoothbox.close();
       return false;
      }
    });
     <?php } ?>
    request.send();
		return false;		
  });
</script> 