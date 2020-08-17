<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/themes/sestwitterclone/landing_page.css'); ?>
<div class="landing_page_main">
  <div class="landing_page_inner">
     <div class="landing_page_left">
        <ul>
          <?php if($this->textblock1) { ?>
          <li><img src="<?php echo $this->block1icon ? $this->block1icon : 'application/modules/Sestwitterclone/externals/images/search.png'; ?>" /><?php echo $this->translate($this->textblock1); ?></li>
          <?php } ?>
          <?php if($this->textblock2) { ?>
          <li><img src="<?php echo $this->block2icon ? $this->block2icon : 'application/modules/Sestwitterclone/externals/images/user.png'; ?>" /><?php echo $this->translate($this->textblock2); ?></li>
          <?php } ?>
          <?php if($this->textblock3) { ?>
          <li><img src="<?php echo $this->block3icon ? $this->block3icon : 'application/modules/Sestwitterclone/externals/images/chat.png'; ?>" /><?php echo $this->translate($this->textblock3); ?></li>
          <?php } ?>
        </ul>
     </div>
     <div class="landing_page_right">
        <?php if($this->loginform) { ?>
          <?php echo $this->content()->renderWidget("sestwitterclone.login-or-signup")?>
        <?php } ?>
        <div class="landing_page_right_inner">
         <div class="lp_right_header">
            <div class="lp_logo">
               <img src="<?php echo $this->landingpagelogo ? $this->landingpagelogo : 'application/modules/Sestwitterclone/externals/images/lp-logo.png'; ?>" />
            </div>
         </div>
         <?php if(!empty($this->rightheading)) { ?>
          <div class="lp_title"><?php echo $this->translate($this->rightheading); ?></div>
         <?php } ?>
         <div class="lp_right_btm">
            <?php if($this->rightdes) { ?>
              <div class="lp_subtitle"><?php echo $this->translate($this->rightdes); ?></div>
            <?php } ?>
            <a href="signup" class="lp_signup"><?php echo $this->translate("Sign Up"); ?></a>
            <a href="login" class="lp_login"><?php echo $this->translate("Login"); ?></a>
         </div>
        </div>
     </div>
  </div>
</div>
<style>
.layout_page_header{
display:none;
}
</style>
