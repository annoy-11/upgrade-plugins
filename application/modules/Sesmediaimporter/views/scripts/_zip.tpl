<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _500px.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesmdimp_app_view_container sesbasic_clearfix">
  <div class="sesmdimp_app_view_left">
  	<div class="sesmdimp_app_view_left_img sesmdimp_app_view_left_img_zip">
  		<img src="application/modules/Sesmediaimporter/externals/images/zip-thumb.png">
  	</div>
  </div>
  <div class="sesmdimp_app_view_right">
  	<div class="sesmdimp_zip_upload_form">
      <form id="zip_upload" method="post">
        <div class="sesmdimp_zip_upload_form_field">
        	<input type="file" id="upload_zip" name="upload_zip" accept="application/x-zip-compressed" />
        	<span class="error_message" style="display:none;"><?php echo $this->translate('Please select valid zip file.'); ?></span>
        </div>
        <div class="sesmdimp_zip_upload_form_field">  
        	<button type="submit" name="submit"><?php echo $this->translate('Import Zip'); ?></button>
      	</div>
      </form>
    </div>
  </div>
</div>
 <script type="application/javascript">
  sesJqueryObject('#zip_upload').submit(function(e){
    e.preventDefault();
    if(!sesJqueryObject('#upload_zip').val()){
      sesJqueryObject('.error_message').show();
      return false;   
    }else if(sesJqueryObject('#upload_zip').val().indexOf('.zip') < 0){
        sesJqueryObject('.error_message').show();
      return false; 
    }
    sesJqueryObject('.error_message').hide();
    Smoothbox.open("sesmediaimporter/import/index/");
	  parent.Smoothbox.close;
  });
 </script>