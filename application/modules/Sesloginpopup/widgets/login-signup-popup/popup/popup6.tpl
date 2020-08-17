<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesloginpopup
 * @package    Sesloginpopup
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: popup6.tpl  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $enablePopUp = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupsign', 1);  ?>
<?php $showPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popup.enable', 1);?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if($this->viewer->getIdentity() == 0) : ?>
  <script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesbasic/externals/scripts/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesloginpopup/externals/scripts/jquery-latest.min.js"></script>
  <script>var ses = $.noConflict();</script>
  <script src="<?php echo $baseUrl; ?>application/modules/Sesloginpopup/externals/scripts/jquery.magnific-popup.js"></script>
  <link href="<?php echo $baseUrl; ?>application/modules/Sesloginpopup/externals/styles/magnific-popup6.css" rel="stylesheet" />
<?php endif;?>
  
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
  
<?php $showSeparator = 0;?> 
<?php $settings = Engine_Api::_()->getApi('settings', 'core');?>
<?php $facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();?>
<?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret && $facebook):?>
  <?php $showSeparator = 1;?>
<?php elseif ('none' != $settings->getSetting('core_twitter_enable', 'none') && $settings->core_twitter_secret):?>
  <?php $showSeparator = 1;?>
<?php endif;?>

<?php if($this->viewer->getIdentity() == 0):?>
    <?php if(!empty($showSeparator)) { ?>
  	<div id="small-dialog" class="zoom-anim-dialog mfp-hide sesloginpopup_quick_popup sesloginpopup_quick_login_popup sesbasic_bg sesbasic_bxs sesbasic_clearfix">
    <?php } else { ?>
      <div id="small-dialog" class="zoom-anim-dialog mfp-hide sesloginpopup_quick_popup sesloginpopup_quick_login_popup sesbasic_bg sesbasic_bxs sesbasic_clearfix _nosbtns">
    <?php } ?>
    <div class="sesloginpopup_popup_header clearfix">
      <?php if($this->loginsignup_logo): ?>
        <div class="sesloginpopup_popup_header_logo">
          <img src="<?php echo $this->baseUrl() . '/'. $this->loginsignup_logo; ?>" alt="My Community">
        </div>
      <?php endif; ?>
      <div class="login_popup_title">
      	<h4><?php echo $this->translate("LOGIN");?></h4>
      </div>  
    </div>
    
    <div class="sesloginpopup_popup_content clearfix">
      <div class="sesloginpopup_popup_content_left sesloginpopup_popup_login">
        <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
          <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle(); ?>
          <div class="sesloginpopup_social_login_btns <?php if($numberOfLogin < 3):?>social_login_btns_label<?php endif;?>">
            <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
          </div>
        <?php endif; ?>
        <?php echo $this->content()->renderWidget("sesloginpopup.login-or-signup")?>
         <p class="frome_signup"><?php if($controllerName != 'signup'){ ?>
        	<a class="popup-with-move-anim tab-link" href="#user_signup_form"><?php echo $this->translate("New User? Sign Up Here.");?></a>
       <?php } ?></p>
      </div>
      <?php if(!empty($showSeparator)):?>
        <div class="sesloginpopup_popup_content_sep">
          <span><?php echo $this->translate("OR");?></span>
        </div>
        <div class="sesloginpopup_popup_content_right">
          
          <?php if(!Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
            <div class="sesloginpopup_quick_popup_social">
              <?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
                <?php if (!$facebook):?>
                <?php return; ?>
                <?php endif;?>
              <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
                <a href="<?php echo $href;?>" id="fbLogin"><i class="fa fa-facebook"></i> <span><?php echo $this->translate("Facebook");?></span></a>
              <?php endif;?>
              <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none') && $settings->core_twitter_secret):?>
                <?php $href = Zend_Controller_Front::getInstance()->getRouter()
                ->assemble(array('module' => 'user', 'controller' => 'auth',
                'action' => 'twitter'), 'default', true);?>
                <a href="<?php echo $href;?>" id="googleLogin"><i class="fa fa-twitter"></i><span><?php echo $this->translate("Twitter");?></span></a>
              <?php endif;?>
            </div>
          <?php endif; ?>
        </div>
        <div class="sesloginpopup_popup_header_btns">
        <?php if($controllerName != 'auth' && $actionName != 'login'){ ?>
          <a href="javascript:void(0);" class="active"><?php echo $this->translate("Sign In");?></a>
      	<?php } ?>
        <?php if($controllerName != 'signup'){ ?>
        	<a class="popup-with-move-anim tab-link" href="#user_signup_form"><?php echo $this->translate("Sign Up");?></a>
        <?php } ?>
      </div>
      <?php endif;?>
    </div>
  </div>

  <?php if($controllerName != 'signup') { ?>
  	<?php if(!empty($showSeparator)){?>
    	<div id="user_signup_form" class="zoom-anim-dialog mfp-hide sesloginpopup_quick_popup sesbasic_bg sesbasic_bxs sesloginpopup_quick_signup_popup sesbasic_clearfix">
    <?php } else { ?>
      <div id="user_signup_form" class="zoom-anim-dialog mfp-hide sesloginpopup_quick_popup sesbasic_bg sesbasic_bxs sesloginpopup_quick_signup_popup _nosbtns sesbasic_clearfix">
    <?php }; ?>
      <div class="sesloginpopup_popup_header clearfix">
        <?php if($this->loginsignup_logo): ?>
          <div class="sesloginpopup_popup_header_logo">
            <img src="<?php echo $this->baseUrl() . '/'. $this->loginsignup_logo; ?>" alt="My Community">
          </div>
        <?php endif; ?>
        <div class="login_popup_title">
      	<h4><?php echo $this->translate("SIGNUP");?></h4>
      </div>
        <div class="sesloginpopup_popup_header_btns">
          <?php if($controllerName != 'signup') { ?>
            <a href="javascript:void(0);" class="active"><?php echo $this->translate("Sign Up");?></a>
          <?php } ?>
          <?php if($controllerName != 'auth' && $actionName != 'login') { ?>
            <a class="popup-with-move-anim tab-link" href="#small-dialog"><?php echo $this->translate("Sign In");?></a>
          <?php } ?>
        </div>  
      </div>
      
    	<div class="sesloginpopup_popup_content clearfix">
      	<div class="sesloginpopup_popup_content_left sesloginpopup_popup_signup">
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupsign', 1) && $controllerName != 'auth' && $actionName != 'login'){ ?>
          <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "sesloginpopup", array('disableContent'=>true)) ?>
          <?php } ?>
           <p class="frome_signup"><?php if($controllerName != 'auth' && $actionName != 'login') { ?>
            <a class="popup-with-move-anim tab-link" href="#small-dialog"><?php echo $this->translate("Existing User? Log In");?></a>
          <?php } ?></p>
        </div>
        <?php if(!empty($showSeparator)):?>
          <div class="sesloginpopup_popup_content_sep">
            <span><?php echo $this->translate("OR");?></span>
          </div> 
          <div class="sesloginpopup_popup_content_right">
          	<!--<span class="sesbasic_text_light"><?php echo $this->translate("Sign in with your social profile");?></span>-->
            <div class="sesloginpopup_quick_popup_social">
              <?php  if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
                <?php if (!$facebook):?>
                  <?php  return; ?>
                <?php  endif;?>
                <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
                <a href="<?php echo $href;?>" id="fbLogin"><i class="fa fa-facebook"></i> <span><?php echo $this->translate("Sign up with Facebook");?></a>
              <?php endif;?>
              <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none')
               && $settings->core_twitter_secret):?>
                <?php $href = Zend_Controller_Front::getInstance()->getRouter()
                ->assemble(array('module' => 'user', 'controller' => 'auth',
                'action' => 'twitter'), 'default', true);?>
                <a href="<?php echo $href;?>" id="googleLogin"><i class="fa fa-twitter"></i> <span><?php echo $this->translate("Sign up with Twitter");?></a>
              <?php endif;?>
            </div>
          </div>  
        <?php endif;?>
      </div>
    </div>
  <?php } ?>
<?php endif;?>
<div id='core_menu_mini_menu'>
  <?php
    $this->viewer = Engine_Api::_()->user()->getViewer();
    // Reverse the navigation order (they are floating right)
    $count = count($navigation);
    if($count > 0):
      foreach( $navigation->getPages() as $item ) $item->setOrder(--$count);
    endif;
  ?>
    <ul class="sesloginpopup_minimenu_links">
    <?php foreach( $navigation as $item ): 
      $className = explode(' ', $item->class);
    ?>
      <?php if(end($className) == 'core_mini_signup'):?>
        <li class="sesloginpopup_minimenu_link sesloginpopup_minimenu_signup">
          <?php if($controllerName != 'signup') { ?>
            <a id="popup-signup" <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupsign', 1)){ ?> <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupsign', 1) && $controllerName != 'auth' && $actionName != 'login'){ ?> class="popup-with-move-anim" <?php } ?> <?php } ?> href="<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupsign', 1) && $controllerName != 'auth' && $actionName != 'login'){ ?>#user_signup_form<?php }else{ echo 'signup'; } ?>">
            	<i class="fa fa-plus"></i>
              <span><?php echo $this->translate($item->getLabel());?></span>
            </a>
          <?php } ?>
        </li>
      <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() == 0): ?>
        <?php if($controllerName != 'auth'  && $actionName != 'login'){ ?>
          <li class="sesloginpopup_minimenu_link sesloginpopup_minimenu_login">
            <a id="popup-login" <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupsign', 1)){ ?> class="popup-with-move-anim" <?php } ?> href="<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupsign', 1)){ ?>#small-dialog <?php }else{ echo 'login'; } ?>">
              <i class="fa fa-user"></i>
              <span><?php echo $this->translate($item->getLabel());?></span>
            </a>
          </li>
        <?php } ?>
      <?php endif;?>
    <?php endforeach; ?>
  </ul>
</div>
<script type='text/javascript'>
  if('<?php echo $this->viewer->getIdentity();?>' == 0) {
    sesJqueryObject(document).ready(function() {
		<?php $forcehide =  Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popupfixed', false);    ?>
   	popUp=ses('.popup-with-move-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
				enableEscapeKey:<?php echo $forcehide ? "false" : "true" ; ?>,
				showCloseBtn:<?php echo $forcehide ? "false" : "true"; ?>,
				closeOnBgClick: <?php echo $forcehide ? "false" : "true"; ?>, // allow opening popup on middle mouse click. Always set it to true if you don\'t provide alternative source.
        closeBtnInside: true,
        preloader: true,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-slide-bottom'
      });
      if(ses(".payment_form_signup"))
      ses(".payment_form_signup").attr('action',en4.core.baseUrl + 'signup');
       ses.magnificPopup.instance.close = function () {
        var day = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesloginpopup.popup.day', 5);?>';
        if(day != 0)
          setCookie("is_popup",'popo',day);
          sesJqueryObject(document.body).removeClass('login-signup-popup-open');
          ses.magnificPopup.proto.close.call(this);	
      }
    });
  
		sesJqueryObject(document).ready(function(e){
			jqueryObjectOfSes('#signup_account_form input,#signup_account_form input[type=email]').each(
        function(index){
          var input = jqueryObjectOfSes(this);
          if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().length && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements') {
            if(jqueryObjectOfSes(this).prop('type') == 'email' || jqueryObjectOfSes(this).prop('type') == 'text' || jqueryObjectOfSes(this).prop('type') == 'password'){
              jqueryObjectOfSes(this).attr('placeholder',jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').html());
            }
          }
        }
      )
		});

		sesJqueryObject(document).ready(function(e){
			jqueryObjectOfSes('#sesloginpopup_form_login input,#sesloginpopup_form_login input[type=email]').each(
        function(index){
          var input = jqueryObjectOfSes(this);
          if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().length && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements'){	
            if(jqueryObjectOfSes(this).prop('type') == 'email' || jqueryObjectOfSes(this).prop('type') == 'text' || jqueryObjectOfSes(this).prop('type') == 'password'){
              jqueryObjectOfSes(this).attr('placeholder',jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').html());
            }
          }
        }
      )
		});
  }

  // cookie get and set function
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var arianaires = "arianaires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + arianaires;
  }
  
  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
  }
  
  // end cookie get and set function.
  var popUpShow=getCookie('is_popup');
  if('<?php echo $this->viewer->getIdentity();?>' == 0 && popUpShow == '' && '<?php echo $actionName != 'login' ;?>' && '<?php echo $controllerName != 'signup' ;?>') {
    sesJqueryObject(document).ready(function() {
      if('<?php echo $showPopup;?>' == '1' && '<?php echo $enablePopUp ?>' == 1) 
      document.getElementById("popup-login").click(); 
    });
  }
</script>
