
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesloginpopup/externals/styles/magnific-page4.css'); ?>

   <div class="sesloginpopup_loginpage">
      <div class="sesloginpopup_loginbox">
          <div class="loginbox_form signup_page_four" style="background-image:url(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpoup.page.photo', ''); ?>);">
            <div class="sesloginpopup_loginpage_content clearfix"">
            <div class="sesloginpopup_popup_content_left sesloginpopup_popup_signup">
            <div class="sesloginpage_top">
              <h2><?php echo $this->translate("Create Your Account");?></h2>
              </div>
              <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>
              <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "sesloginpopup", array('disableContent'=>true)) ?>
              <?php } ?>
              <?php echo Zend_Controller_Front::getInstance()->getResponse()->getBody() ?>
              <p class="frome_signup"><?php if($controllerName != 'auth' && $actionName != 'login') { ?>
                <a href="login"><?php echo $this->translate("Already registered? Login");?></a>
              <?php } ?></p>
            </div>
            <?php if(!empty($showSeparator)):?>
              <div class="sesloginpopup_popup_content_sep">
                <span><?php echo $this->translate("OR");?></span>
              </div>
              <div class="sesloginpopup_popup_content_right">
                <span class="sesbasic_text_light"><?php echo $this->translate("Sign in with your social profile");?></span>
                <div class="sesloginpopup_quick_popup_social">
                  <?php  if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
                    <?php if (!$facebook):?>
                      <?php  return; ?>
                    <?php  endif;?>
                    <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
                    <a href="<?php echo $href;?>" id="fbLogin"><i class="fa fa-facebook"></i> <span><?php echo $this->translate("Sign up with ");?><b><?php echo $this->translate("Facebook");?></b></a>
                  <?php endif;?>
                  <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none')
                   && $settings->core_twitter_secret):?>
                    <?php $href = Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble(array('module' => 'user', 'controller' => 'auth',
                    'action' => 'twitter'), 'default', true);?>
                    <a href="<?php echo $href;?>" id="googleLogin"><i class="fa fa-twitter"></i> <span><?php echo $this->translate("Sign up with ");?><b><?php echo $this->translate("Twitter");?></b></a>
                  <?php endif;?>
                </div>
              </div>  
            <?php endif;?>
           </div>
         </div>
      </div>
</div>
<script type="application/javascript">
sesJqueryObject(document).ready(function(){
	var htmlElement = document.getElementsByTagName("body")[0];
  htmlElement.addClass('sesloginpopup_page_four');
	sesJqueryObject('#global_content').css('padding-top',0);
	sesJqueryObject('#global_wrapper').css('padding-top',0);	
});
</script>