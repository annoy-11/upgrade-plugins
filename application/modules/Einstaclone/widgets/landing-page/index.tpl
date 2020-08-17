<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/themes/einstaclone/landing_page.css'); ?>
<div class="landing_page_main">
  <div class="landing_page_inner">
     <div class="landing_page_left" style="background-image:url(<?php echo $this->landingpagelogo ? Engine_Api::_()->einstaclone()->getFileUrl($this->landingpagelogo) : 'application/modules/Einstaclone/externals/images/lp.jpg'; ?>);">
        <div class="lp_text_overlay">
        <?php if($this->textblock1) { ?>
          <h1><?php echo $this->translate($this->textblock1); ?></h1>
        <?php } ?>
        <?php if($this->textblock2) { ?>
          <h2><?php echo $this->translate($this->textblock2); ?></h2>
        <?php } ?>
        </div>
     </div>
     <div class="landing_page_right">
       <div class="landing_page_right_inner">
         <div class="header_logo">
          <?php if($this->headerlogo): ?>
              <?php $headerlogo = Engine_Api::_()->einstaclone()->getFileUrl($this->headerlogo); ?>
              <a href=""><img alt="" src="<?php echo $headerlogo ?>"></a>
          <?php else: ?>
              <a href=""><?php echo $this->siteTitle; ?></a>
          <?php endif; ?>
         </div>
          <?php if($this->rightheading) { ?>
            <h3 class="einstaclone_text_light"><?php echo $this->translate($this->rightheading); ?></h3>
          <?php } ?>
          <?php echo $this->content()->renderWidget("einstaclone.login-or-signup")?>
          <div class="no_acc"><?php echo $this->translate("Don't Have Account ? "); ?><a href="signup"><?php echo $this->translate("Sign up."); ?></a></div>
      </div>
      <?php if($this->ioslink || $this->androidlink) { ?>
        <div class="lp_app_section">
          <div class="_head"><?php echo $this->translate("Get the App"); ?></div>
          <div class="_links">
            <?php if($this->ioslink) { ?>
            <a href="<?php echo $this->ioslink; ?>" target="_blank"><img src="application/modules/Einstaclone/externals/images/app-store.png" alt="" /></a>
            <?php } ?>
            <?php if($this->androidlink) { ?>
            <a href="<?php echo $this->androidlink; ?>" target="_blank"><img src="application/modules/Einstaclone/externals/images/google-play.png" alt="" /></a>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
     </div>
  </div>
</div>

