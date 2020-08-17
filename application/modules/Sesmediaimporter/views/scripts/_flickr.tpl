<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _flickr.tpl 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesmdimp_app_view_container sesbasic_clearfix">
  <div class="sesmdimp_app_view_left">
  <?php 
    $fbData =  $_SESSION['sesmediaimporter_flickr'];
  ?>
   <?php if($fbData['inphoto_url']){ ?>
    <div class="sesmdimp_app_view_left_img">
      <img src="<?php echo $fbData['inphoto_url']; ?>" alt="" align="left" />
    </div>
   <?php } ?>
    <div class="sesmdimp_app_view_left_txt">
      <a href="<?php echo $fbData['in_username']; ?>" target="_blank"><?php echo $fbData['in_name']; ?></a>
    </div>
    <div class="sesmdimp_app_view_left_btn">
      <a class="sesbasic_animation" href="<?php echo $this->url(array('action'=>'index'),'sesmediaimporter_general',true) ?>">
        <i class="fa fa-arrow-left"></i>
        <span><?php echo $this->translate("Back"); ?></span>
      </a>
      <a class="sesbasic_animation" data-href="<?php echo $this->url(array('action'=>'flickr-logout'),'sesmediaimporter_general',true) ?>">
      	<i class="fa fa-power-off"></i>
        <span><?php echo $this->translate("Disconnect"); ?></span>
      </a>  
    </div>
  </div>
  
  <div class="sesmdimp_app_view_right">
    <div class="sesbasic_profile_subtabs clear sesbasic_clearfix hidefb"style="display:none;">
      <ul id="sesmediaimporter_flickr_select">        
        <li class="sesmediaimporter_flickr_getPhotos sesbasic_tab_selected">
          <a href="javascript:;" class=""><?php echo $this->translate("Photo Stream"); ?></a>
        </li>
        <!--<li class="sesmediaimporter_flickr_sets">
          <a href="javascript:;" class="">Sets</a>
        </li>-->
         <li class="sesmediaimporter_flickr_favorite">
          <a href="javascript:;" class=""><?php echo $this->translate("Favourites"); ?></a>
        </li>
         <li class="sesmediaimporter_flickr_galleries">
          <a href="javascript:;" class=""><?php echo $this->translate("Galleries"); ?></a>
        </li>
      </ul>
    </div>
    <?php echo $this->partial('_options.tpl','sesmediaimporter',array()); ?>  
   	<div id="flickr_album"></div>
    <div class="sesmdimp_app_view_right_options_footer"><?php echo $this->partial('_options.tpl','sesmediaimporter',array()); ?></div>
	</div>
</div>  
<script type="text/javascript">
  function getFlAlbums(param){
    document.getElementById("flickr_album").innerHTML = '<div class="sesbasic_loading_container" id="fb-spinner"></div>';
    //Makes An AJAX Request On Load which retrieves the albums
    sesJqueryObject.ajax({
          type: 'post',
          url: 'sesmediaimporter/index/load-flickr-photo',
          data: {
             type: 'getPhotos'
          },
          success: function( data ) {
            //Hide The Spinner
            sesJqueryObject('.hidefb').show();
              document.getElementById("fb-spinner").style.display = "none";
              //Put the Data in the Div
              sesJqueryObject('#flickr_album').html(data);
          }
      });
  }
 sesJqueryObject(document).ready(function(e){
  getFlAlbums('');  
 })
</script>