<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmediaimporter/externals/styles/styles.css'); ?> 

<div class="sesmdimp_import_popup sesbasic_bxs">
  <form action="" method="post" id="sesmediatype">
   <div>
    <div>
    <h3><?php echo $this->translate("Import Selected Photos"); ?></h3>
    <p class="form-description"><?php echo $this->translate("Imported the selected photos from the social network and enrich your profile at this site."); ?></p>
    <div class="form-elements">
      <div class="sesbasic_loading_container"></div>
      <div class="message"></div>
      <input type="hidden" name="mediadata" id="mediadata" value="">
      <input type="hidden" name="sesmediaimporter" value="1">
      <div class="form-wrapper" id="buttons-wrapper" style="display: none;">
        <fieldset id="fieldset-buttons">
          <button name="_continue" id="_continue" type="submit"><?php echo $this->translate("Continue"); ?></button>
            or <a name="cancel" id="cancel" type="button" href="javascript:void(0);" onclick="parent.Smoothbox.close();"><?php echo $this->translate("cancel"); ?></a>
        </fieldset>
      </div>
    </div>
    </div>
   </div>
  </form>
</div>  
<script type="application/javascript">
 sesJqueryObject(document).ready(function(){
  var type = parent.sesJqueryObject('ul#sesmediaimportermainmenu').find('li.active').data('type');
  var mediatype = parent.sesJqueryObject('#importsesmediaimporter input[type=checkbox]:checked');
  var zipData = "";
  if(type == "zip"){
    mediaType = "zip";
    zipData = new FormData(parent.sesJqueryObject('#zip_upload')[0]);
    zipData.append('mediatypeData',mediaType);
    zipData.append('typeData',type);
    getMediaImporterZipData(zipData);
    return;
  }else if(parent.sesJqueryObject(mediatype[0]).attr('id').indexOf("album") >= 0){
    mediaType = 'album';  
  }else
    mediaType = 'photo';
  var formData = parent.sesJqueryObject('#importsesmediaimporter').serialize();
  getMediaImporterData(type,mediaType,formData,zipData);
 });
 
 function getMediaImporterZipData(zipData){
    sesJqueryObject.ajax({
      type: 'post',
      contentType:false,
      processData: false,
      cache: false,
      url: 'sesmediaimporter/import/media-data',
      data: zipData,
      success: function( data ) {
        var result = sesJqueryObject.parseJSON(data);
        sesJqueryObject('#buttons-wrapper').show();
        sesJqueryObject('.sesbasic_loading_container').remove();
        sesJqueryObject('.message').html(result.message);
        sesJqueryObject('#mediadata').val(JSON.encode(result.data));
        <?php if(Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesalbum'))){ ?>
          sesJqueryObject('#sesmediatype').attr('action','sesalbum/index/create/typeMedia/'+result.type+'?format=smoothbox');
        <?php }else{ ?>
          sesJqueryObject('#sesmediatype').attr('action','sesmediaimporter/index/album-create/typeMedia/'+result.type+'?format=smoothbox');
        <?php } ?>
      }
  });
}
 
function getMediaImporterData(type,mediaType,formData){
    sesJqueryObject.ajax({
      type: 'post',
      url: 'sesmediaimporter/import/media-data',
      data: {
         typeData: type,
         mediatypeData:mediaType,
         formData:formData,
      },
      success: function( data ) {
        var result = sesJqueryObject.parseJSON(data);
        sesJqueryObject('#buttons-wrapper').show();
        sesJqueryObject('.sesbasic_loading_container').remove();
        sesJqueryObject('.message').html(result.message);
        sesJqueryObject('#mediadata').val(JSON.encode(result.data));
        <?php if(Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesalbum'))){ ?>
          sesJqueryObject('#sesmediatype').attr('action','sesalbum/index/create/typeMedia/'+result.type+'?format=smoothbox');
        <?php }else{ ?>
          sesJqueryObject('#sesmediatype').attr('action','sesmediaimporter/index/album-create/typeMedia/'+result.type+'?format=smoothbox');
        <?php } ?>
      }
  });
}
</script>