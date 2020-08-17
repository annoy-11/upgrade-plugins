<?php

?>
<form class="global_form_popup">
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
        <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum_enable_location', 1)){ ?>
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
        <span style="display:none" id="sesgroup_location_data_list"><?php echo $this->photo->location; ?></span>
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
<script type="text/javascript">
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupalbum_enable_location', 1)){ ?>
	sesJqueryObject('#mapcanvas-label').attr('id','map-canvas-list');
	sesJqueryObject('#map-canvas-list').css('height','250px');
	sesJqueryObject('#ses_location-label').attr('id','sesgroup_location_data_list');
	sesJqueryObject('#ses_location-wrapper').css('display','none');
	initializeSesGroupAlbumMapList();
	sesJqueryObject( window ).load(function() {
		editGroupSetMarkerOnMapList();
	});
	<?php } ?>
  sesJqueryObject(document).on('click','#execute',function(e){
		e.preventDefault();
    var photo_id = '<?php echo $this->photo_id;?>';
    request = new Request.JSON({
      'format' : 'json',
      'url' : '<?php echo $this->url(Array('module' => 'sesgroupalbum','controller' => 'index', 'action' => 'save-information'), 'default',true) ?>/photo_id/'+photo_id,
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
    request.send();
		return false;		
  });
</script> 