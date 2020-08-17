<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _facebook.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesmdimp_app_view_container sesbasic_clearfix">
  <div class="sesmdimp_app_view_left">
  <?php 
    $fbData =  $_SESSION['sesmediaimporter_facebook'];
  ?>
   <?php if($fbData['fbphoto_url']){ ?>
    <div class="sesmdimp_app_view_left_img">
      <img src="<?php echo $fbData['fbphoto_url']; ?>" alt="" align="left" />
    </div>
   <?php } ?>
    <div class="sesmdimp_app_view_left_txt">
      <a href="<?php echo "https://www.facebook.com/".$fbData['fb_id']; ?>" target="_blank"><?php echo $fbData['fb_name']; ?></a>
    </div>
    <div class="sesmdimp_app_view_left_btn">
      <a class="sesbasic_animation" href="<?php echo $this->url(array('action'=>'index'),'sesmediaimporter_general',true) ?>">
        <i class="fa fa-arrow-left"></i>
        <span><?php echo $this->translate("Back"); ?></span>
      </a>
      <a class="sesbasic_animation" href="<?php echo $this->url(array('action'=>'fb-logout'),'sesmediaimporter_general',true) ?>">
        <i class="fa fa-power-off"></i>
        <span><?php echo $this->translate("Disconnect"); ?></span>
      </a>
    </div>
  </div>
  
  <div class="sesmdimp_app_view_right">
    <div class="sesbasic_profile_subtabs clear sesbasic_clearfix hidefb"style="display:none;">
      <ul id="sesmediaimporter_facebook_select">
        <li class="sesbasic_tab_selected sesmediaimporter_album_tab">
          <a href="javascript:;"><?php echo $this->translate("Albums"); ?></a>
        </li>
        <li class="sesmediaimporter_album_yourphotos">
          <a href="javascript:;" class=""><?php echo $this->translate("Your Photos"); ?></a>
        </li>
        <li class="sesmediaimporter_album_taggedphotos">
          <a href="javascript:;" class=""><?php echo $this->translate("Photos of You"); ?></a>
        </li>
      </ul>
    </div>
    
    <?php echo $this->partial('_options.tpl','sesmediaimporter',array()); ?>
 		<div id="facebook_album"></div>
    <div class="sesmdimp_app_view_right_options_footer"><?php echo $this->partial('_options.tpl','sesmediaimporter',array()); ?></div>
	</div>    
</div>
  
<script type="text/javascript">
  function getFbAlbums(param){
    document.getElementById("facebook_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject.ajax({
          type: 'post',
          url: 'sesmediaimporter/index/load-fb-gallery',
          data: {
             extra_params: param
          },
          success: function( data ) {
            //Hide The Spinner
            sesJqueryObject('.hidefb').show();
              document.getElementById("fb-spinner").style.display = "none";
              //Put the Data in the Div
              sesJqueryObject('#facebook_album').html(data);
          }
      });
  }
 sesJqueryObject(document).ready(function(e){
  getFbAlbums('');  
 })
</script>