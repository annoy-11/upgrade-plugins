<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-photo.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
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
          <div id="description-wrapper" class="form-wrapper">
            <div id="description-label" class="form-label">
              <label for="description" class="optional"><?php echo $this->translate('Image Caption');?></label>
            </div>
            <div id="description-element" class="form-element">
              <textarea name="description" id="description" cols="120" rows="2"><?php echo $this->photo->description;  ?></textarea>
            </div>
          </div>
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

  sesJqueryObject(document).on('click','#execute',function(e){
		e.preventDefault();
    var photo_id = '<?php echo $this->photo_id;?>';
    request = new Request.JSON({
      'format' : 'json',
      'url' : '<?php echo $this->url(Array('module' => 'sescrowdfunding','controller' => 'album', 'action' => 'save-information'), 'default',true) ?>/photo_id/'+photo_id,
      'data': {
        'photo_id' : photo_id,
        'description' : document.getElementById('description').value,
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
