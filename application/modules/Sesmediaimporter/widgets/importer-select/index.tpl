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

<div class="sesmdimp_main_wrapper sesbasic_bxs sesbasic_clearfix">

	<div class="sesmdimp_main_top">
    <h2><?php echo $this->translate("How It Works?");?></h2>
  </div>
  <div class="sesmdimp_hiw sesbasic_clearfix">
  	<div>
    	<section>
      	<i><img src="application/modules/Sesmediaimporter/externals/images/login.png" alt="" /></i>
        <h3><?php echo $this->translate("Login")?></h3>
        <p><?php echo $this->translate("Login to this site. If you still don’t have account, signup for free.")?></p>
      </section>
    </div>
  	<div>
    	<section>
      	<i><img src="application/modules/Sesmediaimporter/externals/images/connect.png" alt="" /></i>
        <h3><?php echo $this->translate("Connect")?></h3>
        <p><?php echo $this->translate('Connect to the desired service site using the "Connect" button.')?></p>
      </section>
    </div>
  	<div>
    	<section>
      	<i><img src="application/modules/Sesmediaimporter/externals/images/select.png" alt="" /></i>
        <h3><?php echo $this->translate("Select")?></h3>
        <p><?php echo $this->translate('Select the photos from the service which you want to import on this site.')?></p>
      </section>
    </div>
  	<div>
    	<section>
      	<i><img src="application/modules/Sesmediaimporter/externals/images/import.png" alt="" /></i>
        <h3><?php echo $this->translate("Import")?></h3>
        <p><?php echo $this->translate('Click on the "Import Photos" button and import photos to existing albums or new album.')?></p>
      </section>
    </div>
  
  </div>
	<div class="sesmdimp_main_des">
    <p><?php echo $this->translate("Add photos to SocialEngineSolutions from almost anywhere and manage them at only 1 place. No more hectic to remember various login details for other websites."); ?></p> 
    <p><?php echo $this->translate("Get Unlimited storage for Free Lifetime!"); ?></p>
	</div>
  
  <div class="sesmdimp_main_apps">
    <div class="sesmdimp_main_top">
      <h2><?php echo $this->translate("Connect to the service below and start importing");?></h2>
    </div>
  	<ul>
    <?php $facebookText = $settings->getSetting('sesmediaimporter.facebook') ? 'Facebook,' : '';?>
    <?php $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sesmediaimporter');?>
    <?php if($facebookTable->enable() && !empty($_SESSION['sesmediaimporter_fb_enable'])){ ?>
    	<li class="sesmdimp_main_apps_list sesbasic_clearfix">
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
      	<div class="sesmdimp_main_apps_list_inner sesbm">
          <div class="sesmdimp_main_apps_icon">
            <a href="<?php echo $this->url(array("action"=>"service","type"=>"facebook"),"sesmediaimporter_general",true); ?>">
            	<img src="application/modules/Sesmediaimporter/externals/images/facebook.png">
            </a>
          </div>
          <div class="sesmdimp_main_apps_info">
          	<div class="sesmdimp_main_apps_info_title">
            	<a href="<?php echo $this->url(array("action"=>"service","type"=>"facebook"),"sesmediaimporter_general",true); ?>"><?php echo $this->translate("Facebook"); ?></a>
            </div>
            <?php if($status){ ?>
            <div class="sesmdimp_main_apps_info_cont">
             
            <?php 
              $fbData =  $_SESSION['sesmediaimporter_facebook'];
            ?>
            <?php if($fbData['fbphoto_url']){ ?>
            	<img src="<?php echo $fbData['fbphoto_url']; ?>" />
            <?php } ?>
            	<p><?php echo $this->translate("You are connected as"); ?> <a href="<?php echo "https://www.facebook.com/".$fbData['fb_id']; ?>" target="_blank"><?php echo $fbData['fb_name']; ?></a></p>
            </div>
             <?php }else{ ?>
            <div class="sesmdimp_main_apps_info_cont">
            	<p><?php echo $this->translate("Connect and import photos from facebook"); ?></p>
            </div>	
            <?php } ?>
          </div>
          <div class="sesmdimp_main_apps_btn">
          <?php if($this->viewer()->getIdentity() == 0){ ?>
            <button class="" onClick="window.location = 'login';" ><?php echo $this->translate("Login"); ?></button>
          <?php }else if(!$status){ ?>
          	<button class="showloginpopup" data-href="<?php echo $facebookTable->loginButton(); ?>"><?php echo $this->translate("Connect"); ?></button>
            <?php }else{ ?>
            <button class="_btndisconnect showservicepage" data-href="<?php echo $this->url(array('action'=>'fb-logout'),'sesmediaimporter_general',true) ?>"><?php echo $this->translate("Disconnect"); ?></button>
            <?php } ?>
          </div>
        </div>  
      </li>
    <?php } ?>
    <?php 
      $instagramTable = Engine_Api::_()->getDbtable('instagram', 'sesmediaimporter');
      if($instagramTable->enable()){ ?>
      <?php        
        $instagramApi = $instagramTable->getApi();
        $status = true;
        if( !$instagramApi || empty($_SESSION['sesmediaimporter_instagram'])) {
         $status =  false;
        }
        // Not logged in
        if( !$instagramTable->isConnected() && !empty($_SESSION['sesmediaimporter_int_enable'])) {
          $status = false;
        }
      ?>          
      <li class="sesmdimp_main_apps_list sesbasic_clearfix">
      	<div class="sesmdimp_main_apps_list_inner sesbm">
          <div class="sesmdimp_main_apps_icon">
            <a href="<?php echo $this->url(array("action"=>"service","type"=>"instagram"),"sesmediaimporter_general",true); ?>">
            	<img src="application/modules/Sesmediaimporter/externals/images/instagram.png">
            </a>
          </div>
          <div class="sesmdimp_main_apps_info">
          	<div class="sesmdimp_main_apps_info_title">
            	<a href="<?php echo $this->url(array("action"=>"service","type"=>"instagram"),"sesmediaimporter_general",true); ?>"><?php echo $this->translate("Instagram"); ?></a>
            </div>
            	
          <?php if($status){ ?>
            <div class="sesmdimp_main_apps_info_cont">
            <?php 
              $inData =  $_SESSION['sesmediaimporter_instagram'];
            ?>
            <?php if($inData['inphoto_url']){ ?>
            	<img src="<?php echo $inData['inphoto_url']; ?>" />
            <?php } ?>
            	<p><?php echo $this->translate("You are connected as"); ?> <a href="<?php echo "https://www.instagram.com/".$inData['in_username']; ?>" target="_blank"><?php echo $inData['in_name']; ?></a></p>
            </div>
             <?php }else{ ?>
            <div class="sesmdimp_main_apps_info_cont">
            	<p><?php echo $this->translate("Connect and import photos from instagram"); ?></p>
            </div>	
            <?php } ?>
          </div>
          <div class="sesmdimp_main_apps_btn">
          <?php if($this->viewer()->getIdentity() == 0){ ?>
            <button class="" onClick="window.location = 'login';" ><?php echo $this->translate("Login"); ?></button>
          <?php }else if(!$status){ ?>
          	<button class="showloginpopup" data-href="<?php echo $instagramTable->loginButton(); ?>"><?php echo $this->translate("Connect"); ?></button>
            <?php }else{ ?>
            <button class="_btndisconnect showservicepage" data-href="<?php echo $this->url(array('action'=>'instagram-logout'),'sesmediaimporter_general',true) ?>"><?php echo $this->translate("Disconnect"); ?></button>
            <?php } ?>
          </div>
        </div>  
      </li>      
    <?php } ?>
    <?php
        $flickrTable = Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter');
        if($flickrTable->enable()){
        $flickrApi = $flickrTable->getApi();
        $status = true;
        if( !$flickrApi || !$_SESSION["phpFlickr_auth_token"]) {
         $status =  false;
        }
        // Not logged in
        if( !$flickrTable->isConnected() && !empty($_SESSION['sesmediaimporter_flr_enable'])) {
          $status = false;
        }
      ?>
        <li class="sesmdimp_main_apps_list sesbasic_clearfix">
          <div class="sesmdimp_main_apps_list_inner sesbm">
            <div class="sesmdimp_main_apps_icon">
              <a href="<?php echo $this->url(array("action"=>"service","type"=>"flickr"),"sesmediaimporter_general",true); ?>">
                <img src="application/modules/Sesmediaimporter/externals/images/flickr.png">
              </a>
            </div>
            <div class="sesmdimp_main_apps_info">
              <div class="sesmdimp_main_apps_info_title">
                <a href="<?php echo $this->url(array("action"=>"service","type"=>"flickr"),"sesmediaimporter_general",true); ?>"><?php echo $this->translate("Flickr"); ?></a>
              </div>
                
            <?php if($status){ ?>
              <div class="sesmdimp_main_apps_info_cont">
               
              <?php 
                $inData =  $_SESSION['sesmediaimporter_flickr'];
              ?>
              <?php if($inData['inphoto_url']){ ?>
                <img src="<?php echo $inData['inphoto_url']; ?>" />
              <?php } ?>
                <p><?php echo $this->translate("You are connected as"); ?> <a href="<?php echo $inData['in_username']; ?>" target="_blank"><?php echo $inData['in_name']; ?></a></p>
              </div>
               <?php }else{ ?>
              <div class="sesmdimp_main_apps_info_cont">
                <p><?php echo $this->translate("Connect and import photos from flickr"); ?></p>
              </div>	
              <?php } ?>
            </div>
            <div class="sesmdimp_main_apps_btn">
            <?php if($this->viewer()->getIdentity() == 0){ ?>
            <button class="" onClick="window.location = 'login';" ><?php echo $this->translate("Login"); ?></button>
          <?php }else if(!$status){ ?>
              <button class="showloginpopup" data-href="<?php echo $flickrTable->loginButton(); ?>"><?php echo $this->translate("Connect"); ?></button>
              <?php }else{ ?>
              <button class="_btndisconnect showservicepage" data-href="<?php echo $this->url(array('action'=>'flickr-logout'),'sesmediaimporter_general',true) ?>"><?php echo $this->translate("Disconnect"); ?></button>
              <?php } ?>
            </div>
          </div>  
        </li>
      <?php
      }
        $googleTable = Engine_Api::_()->getDbtable('google', 'sesmediaimporter');
        if($googleTable->enable()){
        $googleApi = $googleTable->getApi();
        $status = true;
        if( !$googleApi || empty($_SESSION['sesmediaimporter_google'])) {
         $status =  false;
        }
        // Not logged in
        if( !$googleTable->isConnected() && !empty($_SESSION['sesmediaimporter_gll_enable'])) {
          $status = false;
        }
      ?>
        <li class="sesmdimp_main_apps_list sesbasic_clearfix">
          <div class="sesmdimp_main_apps_list_inner sesbm">
            <div class="sesmdimp_main_apps_icon">
              <a href="<?php echo $this->url(array("action"=>"service","type"=>"google"),"sesmediaimporter_general",true); ?>">
                <img src="application/modules/Sesmediaimporter/externals/images/google.png">
              </a>
            </div>
            <div class="sesmdimp_main_apps_info">
              <div class="sesmdimp_main_apps_info_title">
                <a href="<?php echo $this->url(array("action"=>"service","type"=>"google"),"sesmediaimporter_general",true); ?>"><?php echo $this->translate("Google"); ?></a>
              </div>
                
            <?php if($status){ ?>
              <div class="sesmdimp_main_apps_info_cont">
               
              <?php 
                $inData =  $_SESSION['sesmediaimporter_google'];
              ?>
              <?php if($inData['inphoto_url']){ ?>
                <img src="<?php echo $inData['inphoto_url']; ?>" />
              <?php } ?>
                <p><?php echo $this->translate("You are connected as"); ?> <a href="<?php echo $inData['in_username']; ?>" target="_blank"><?php echo $inData['in_name']; ?></a></p>
              </div>
               <?php }else{ ?>
              <div class="sesmdimp_main_apps_info_cont">
                <p><?php echo $this->translate("Connect and import photos from google"); ?></p>
              </div>	
              <?php } ?>
            </div>
            <div class="sesmdimp_main_apps_btn">
            <?php if($this->viewer()->getIdentity() == 0){ ?>
            <button class="" onClick="window.location = 'login';" ><?php echo $this->translate("Login"); ?></button>
          <?php }else if(!$status){ ?>
              <button class="showloginpopup" data-href="<?php echo $googleTable->loginButton(); ?>"><?php echo $this->translate("Connect"); ?></button>
              <?php }else{ ?>
              <button class="_btndisconnect showservicepage" data-href="<?php echo $this->url(array('action'=>'google-logout'),'sesmediaimporter_general',true) ?>"><?php echo $this->translate("Disconnect"); ?></button>
              <?php } ?>
            </div>
          </div>  
        </li>
      <?php } 
      
        $px500 = Engine_Api::_()->getDbtable('px500', 'sesmediaimporter');
        if($px500->enable() && !empty($_SESSION['sesmediaimporter_gll_enable'])){
        $px500Api = $px500->getApi();
        $status = true;
        if( !$px500Api || !$px500->isConnected()) {
         $status =  false;
        }
      ?>
        <li class="sesmdimp_main_apps_list sesbasic_clearfix">
          <div class="sesmdimp_main_apps_list_inner sesbm">
            <div class="sesmdimp_main_apps_icon">
              <a href="<?php echo $this->url(array("action"=>"service","type"=>"px500"),"sesmediaimporter_general",true); ?>">
                <img src="application/modules/Sesmediaimporter/externals/images/500px.png" alt="" />
              </a>
            </div>
            <div class="sesmdimp_main_apps_info">
              <div class="sesmdimp_main_apps_info_title">
                <a href="<?php echo $this->url(array("action"=>"service","type"=>"px500"),"sesmediaimporter_general",true); ?>"><?php echo $this->translate("500px"); ?></a>
              </div>
                
            <?php if($status){ ?>
              <div class="sesmdimp_main_apps_info_cont">
               
              <?php 
                $inData =  $_SESSION['sesmediaimporter_px500'];
              ?>
              <?php if($inData['inphoto_url']){ ?>
                <img src="<?php echo $inData['inphoto_url']; ?>" />
              <?php } ?>
                <p><?php echo $this->translate("You are connected as"); ?> <a href="<?php echo $inData['in_username']; ?>" target="_blank"><?php echo $inData['in_name']; ?></a></p>
              </div>
               <?php }else{ ?>
              <div class="sesmdimp_main_apps_info_cont">
                <p><?php echo $this->translate("Connect and import photos from 500px"); ?></p>
              </div>	
              <?php } ?>
            </div>
            <div class="sesmdimp_main_apps_btn">
            <?php if($this->viewer()->getIdentity() == 0){ ?>
            <button class="" onClick="window.location = 'login';" ><?php echo $this->translate("Login"); ?></button>
          <?php }else if(!$status){ ?>
              <button class="showloginpopup" data-href="<?php echo $px500->loginButton(); ?>"><?php echo $this->translate("Connect"); ?></button>
              <?php }else{ ?>
              <button class="_btndisconnect showservicepage" data-href="<?php echo $this->url(array('action'=>'px500-logout'),'sesmediaimporter_general',true) ?>"><?php echo $this->translate("Disconnect"); ?></button>
              <?php } ?>
            </div>
          </div>  
        </li>
      <?php } ?>
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.zip.enable',0) && !empty($_SESSION['sesmediaimporter_zip_enable'])){ ?>
        <li class="sesmdimp_main_apps_list sesbasic_clearfix">
          <div class="sesmdimp_main_apps_list_inner sesbm">
            <div class="sesmdimp_main_apps_icon">
              <a href="<?php echo $this->url(array("action"=>"service","type"=>"zip"),"sesmediaimporter_general",true); ?>">
                <img src="application/modules/Sesmediaimporter/externals/images/zip.png" style="height:64px;width:64px;">
              </a>
            </div>
            <div class="sesmdimp_main_apps_info">
              <div class="sesmdimp_main_apps_info_title">
                <a href="<?php echo $this->url(array("action"=>"service","type"=>"zip"),"sesmediaimporter_general",true); ?>"><?php echo $this->translate("Zip Upload"); ?></a>
              </div>
                
              <div class="sesmdimp_main_apps_info_cont">
                <p><?php echo $this->translate("Upload photos from zip"); ?></p>
              </div>	
            </div>
            <div class="sesmdimp_main_apps_btn">
             <?php if($this->viewer()->getIdentity() == 0){ ?>
            <button class="" onClick="window.location = 'login';" ><?php echo $this->translate("Login"); ?></button>
          <?php }else{ ?>
             <button class="ziplink"><?php echo $this->translate("Upload"); ?></button>
             <?php } ?>
            </div>
          </div>  
        </li>
      <?php } ?>
      
    </ul>
  </div>
</div>
<?php if($this->full_width){ ?>
<script type="text/ecmascript">
sesJqueryObject('.ziplink').click(function(){
  window.location = "<?php echo $this->url(array("action"=>"service","type"=>"zip"),"sesmediaimporter_general",true); ?>";
})
</script>
<?php } ?>
