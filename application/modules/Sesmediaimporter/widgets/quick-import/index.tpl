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
<?php
 $settings = Engine_Api::_()->getApi('settings', 'core');
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmediaimporter/externals/styles/styles.css'); ?> 
<div class="sesmdimp_quick_links sesbasic_bxs">
  <p class="sesmdimp_quick_links_title"><?php echo $this->translate("Import and Add Photos");?></p>
  <p class="sesmdimp_quick_links_des"><?php echo $this->translate("Add your photos from almost anywhere.");?></p>
  <ul>
  <?php $facebookText = $settings->getSetting('sesmediaimporter.facebook') ? 'Facebook,' : '';?>
  <?php $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sesmediaimporter'); ?>
  <?php if($facebookTable->enable() && !empty($_SESSION['sesmediaimporter_fb_enable'])){ ?>
    <li>
    <?php
      $facebookApi = $facebookTable->getApi();
      // Disabled
      $status = true;
      if( !$facebookApi || empty($_SESSION['sesmediaimporter_facebook'])) {
       $status =  false;
      }
      // Not logged in
      if( !$facebookTable->isConnected() ) {
        $status = false;
      }
      // Not logged into correct facebook account
      if( !$facebookTable->checkConnection() ) {
        $status = false; 
      }
    ?>      
      <a href="<?php echo $this->url(array("action"=>"service","type"=>"facebook"),"sesmediaimporter_general",true); ?>">
        <i><img src="application/modules/Sesmediaimporter/externals/images/facebook.png" alt="" /></i>
        <span><?php echo $this->translate("Facebook")?></span>	
      </a>  
    </li>
  <?php } ?>
  <?php 
    $instagramTable = Engine_Api::_()->getDbtable('instagram', 'sesmediaimporter');
    if($instagramTable->enable() && !empty($_SESSION['sesmediaimporter_int_enable'])){ ?>
    <?php        
      $instagramApi = $instagramTable->getApi();
      $status = true;
      if( !$instagramApi || empty($_SESSION['sesmediaimporter_instagram'])) {
       $status =  false;
      }
      // Not logged in
      if( !$instagramTable->isConnected() ) {
        $status = false;
      }
    ?>          
    <li class="sesmdimp_main_apps_list sesbasic_clearfix">
      <a href="<?php echo $this->url(array("action"=>"service","type"=>"instagram"),"sesmediaimporter_general",true); ?>">
        <i><img src="application/modules/Sesmediaimporter/externals/images/instagram.png" alt="" /></i>
        <span><?php echo $this->translate("Instagram")?></span>
      </a>
    </li>      
  <?php } ?>
  <?php
      $flickrTable = Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter');
      if($flickrTable->enable() && !empty($_SESSION['sesmediaimporter_flr_enable'])){
      $flickrApi = $flickrTable->getApi();
      $status = true;
      if( !$flickrApi || !$_SESSION["phpFlickr_auth_token"]) {
       $status =  false;
      }
      // Not logged in
      if( !$flickrTable->isConnected() ) {
        $status = false;
      }
    ?>
      <li class="sesmdimp_main_apps_list sesbasic_clearfix">
        <a href="<?php echo $this->url(array("action"=>"service","type"=>"flickr"),"sesmediaimporter_general",true); ?>">
          <i><img src="application/modules/Sesmediaimporter/externals/images/flickr.png" alt="" /></i>
          <span><?php echo $this->translate("Flickr")?></span>
        </a>
      </li>
    <?php
    }
      $googleTable = Engine_Api::_()->getDbtable('google', 'sesmediaimporter');
      if($googleTable->enable() && !empty($_SESSION['sesmediaimporter_gll_enable'])){
      $googleApi = $googleTable->getApi();
      $status = true;
      if( !$googleApi || empty($_SESSION['sesmediaimporter_google'])) {
       $status =  false;
      }
      // Not logged in
      if( !$googleTable->isConnected() ) {
        $status = false;
      }
    ?>
      <li class="sesmdimp_main_apps_list sesbasic_clearfix">
        <a href="<?php echo $this->url(array("action"=>"service","type"=>"google"),"sesmediaimporter_general",true); ?>">
          <i><img src="application/modules/Sesmediaimporter/externals/images/google.png" alt="" /></i>
          <span><?php echo $this->translate("Google")?></span>
        </a>
      </li>
    <?php } 
    
      $px500 = Engine_Api::_()->getDbtable('px500', 'sesmediaimporter');
      if($px500->enable() && !empty($_SESSION['sesmediaimporter_px_enable'])){
      $px500Api = $px500->getApi();
      $status = true;
      if( !$px500Api || !$px500->isConnected()) {
       $status =  false;
      }
    ?>
      <li class="sesmdimp_main_apps_list sesbasic_clearfix">
        <a href="<?php echo $this->url(array("action"=>"service","type"=>"px500"),"sesmediaimporter_general",true); ?>">
          <i><img src="application/modules/Sesmediaimporter/externals/images/500px.png" alt="" /></i>
          <span><?php echo $this->translate("500px")?></span>
        </a> 
      </li>
    <?php } ?>
    <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.zip.enable',0) && !empty($_SESSION['sesmediaimporter_zip_enable'])){ ?>
      <li class="sesmdimp_main_apps_list sesbasic_clearfix">
        <a href="<?php echo $this->url(array("action"=>"service","type"=>"zip"),"sesmediaimporter_general",true); ?>">
          <i><img src="application/modules/Sesmediaimporter/externals/images/zip.png" alt="" /></i>
          <span><?php echo $this->translate("ZIP")?></span>
        </a> 
      </li>
    <?php } ?>
  </ul>
</div>
