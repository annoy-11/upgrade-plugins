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
    <?php 
      $fbData =  $_SESSION['sesmediaimporter_px500'];
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
      <a class="sesbasic_animation" href="<?php echo $this->url(array('action'=>'px500-logout'),'sesmediaimporter_general',true) ?>">
      	<i class="fa fa-power-off"></i>
        <span><?php echo $this->translate("Disconnect"); ?></span>
      </a>
    </div>
  </div>
  
  <div class="sesmdimp_app_view_right">
    <div class="sesbasic_profile_subtabs clear sesbasic_clearfix hidefb"style="display:none;">
      <ul id="sesmediaimporter_500px_select">        
        <li class="sesmediaimporter_500px_yourphotos sesbasic_tab_selected">
          <a href="javascript:;" data-url="ownphotos" class="500px_imp_cls"><?php echo $this->translate("Your Photos"); ?></a>
        </li>
        <li class="sesmediaimporter_500px_yourfavphotos">
          <a href="javascript:;" data-url="favphotos" class="500px_imp_cls">Your Favorite Photos</a>
        </li>
        <li class="sesmediaimporter_500px_yourfriendphotos">
          <a href="javascript:;" data-url="friendphotos" class="500px_imp_cls">Your Friend Photos</a>
        </li>
      </ul>
    </div>

    <?php echo $this->partial('_options.tpl','sesmediaimporter',array()); ?>
   	<div id="500px_album"></div>
    <div class="sesmdimp_app_view_right_options_footer"><?php echo $this->partial('_options.tpl','sesmediaimporter',array()); ?></div>
	</div>
</div>  
  
<script type="text/javascript">
 sesJqueryObject(document).ready(function(e){
  get500photos('ownphotos');  
 })
</script>