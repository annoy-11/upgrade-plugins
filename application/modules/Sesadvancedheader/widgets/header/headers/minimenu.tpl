<?php ?>

<?php $enablePopUp = $settings->getSetting('sesadvancedheader_popupsign', 1);  ?>
<?php $showPopup = $settings->getSetting('sesadvancedheader.popup.enable', 1);?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>

<?php if($this->viewer->getIdentity() == 0) : ?>
  <script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesadvancedheader/externals/scripts/jquery-latest.min.js"></script>
  <script>var ses = $.noConflict();</script>
  <script src="<?php echo $baseUrl; ?>application/modules/Sesadvancedheader/externals/scripts/jquery.magnific-popup.js"></script>
  <link href="<?php echo $baseUrl; ?>application/modules/Sesadvancedheader/externals/styles/magnific-popup.css" rel="stylesheet" />
<?php endif;?>

<?php $showSeparator = 0;?> 
<?php $facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();?>
<?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret && $facebook):?>
  <?php $showSeparator = 1;?>
<?php elseif ('none' != $settings->getSetting('core_twitter_enable', 'none') && $settings->core_twitter_secret):?>
  <?php $showSeparator = 1;?>
<?php endif;?>
  
<?php $siteTitle = $settings->getSetting('core.general.site.title','1');?>
<?php $sesloginpopup = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesloginpopup'); ?>
<?php if($this->viewer->getIdentity() == 0 && !$sesloginpopup):?>
    <?php if(!empty($showSeparator)) { ?>
  	<div id="small-dialog" class="zoom-anim-dialog mfp-hide sesadvheader_quick_popup sesadvheader_quick_login_popup sesbasic_bxs">
    <?php } else { ?>
      <div id="small-dialog" class="zoom-anim-dialog mfp-hide sesadvheader_quick_popup sesadvheader_quick_login_popup sesbasic_bxs _nosbtns">
    <?php } ?>
    <div class="sesadvheader_popup_header sesbasic_clearfix">
      <?php if($this->loginsignup_logo): ?>
        <div class="sesadvheader_popup_header_logo">
          <img src="<?php echo $this->baseUrl() . '/'. $this->loginsignup_logo; ?>" alt="My Community">
        </div>
      <?php endif; ?>
      <div class="sesadvheader_popup_header_btns">
        <?php if($controllerName != 'auth' && $actionName != 'login'){ ?>
          <a href="javascript:void(0);" class="active"><?php echo $this->translate("Sign In");?></a>
      	<?php } ?>
        <?php if($controllerName != 'signup'){ ?>
        	<a class="popup-with-move-anim tab-link" href="#user_signup_form"><?php echo $this->translate("Sign Up");?></a>
        <?php } ?>
      </div>  
    </div>
    
    <div class="sesadvheader_popup_content clearfix" style="background-image:url(<?php echo $this->loginsignupbgimage; ?>);">
    	<div class="sesadvheader_popup_content_left sesadvheader_popup_login">
        <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
          <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle(); ?>
          <div class="sesadvheader_social_login_btns <?php if($numberOfLogin < 3):?>social_login_btns_label<?php endif;?>">
            <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
          </div>
        <?php endif; ?>
        <?php echo $this->content()->renderWidget("sesadvancedheader.login-or-signup")?>
      </div>
      <?php if(!empty($showSeparator)):?>
        <div class="sesadvheader_popup_content_sep">
          <span><?php echo $this->translate("OR");?></span>
        </div>
        <div class="sesadvheader_popup_content_right">
          <?php if(!Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
            <span class="sesbasic_text_light"><?php echo $this->translate("Sign in with your social profile");?></span>
            <div class="sesadvheader_quick_popup_social">
              <?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
                <?php if (!$facebook):?>
                <?php return; ?>
                <?php endif;?>
              <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
                <a href="<?php echo $href;?>" id="fbLogin"><img src="application/modules/Sesadvancedheader/externals/images/facebook.png" alt="Facebook" /></a>
              <?php endif;?>
              <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none') && $settings->core_twitter_secret):?>
                <?php $href = Zend_Controller_Front::getInstance()->getRouter()
                ->assemble(array('module' => 'user', 'controller' => 'auth',
                'action' => 'twitter'), 'default', true);?>
                <a href="<?php echo $href;?>" id="googleLogin"><img src="application/modules/Sesadvancedheader/externals/images/twitter.png" alt="Twitter" /></a>
              <?php endif;?>
            </div>
          <?php endif; ?>
        </div>
      <?php endif;?>
    </div>
  </div>

  <?php if($controllerName != 'signup' && !$sesloginpopup) { ?>
  	<?php if(!empty($showSeparator)){?>
    	<div id="user_signup_form" class="zoom-anim-dialog mfp-hide sesadvheader_quick_popup sesbasic_bxs sesadvheader_quick_signup_popup">
    <?php } else { ?>
      <div id="user_signup_form" class="zoom-anim-dialog mfp-hide sesadvheader_quick_popup sesbasic_bxs sesadvheader_quick_signup_popup _nosbtns">
    <?php }; ?>
      <div class="sesadvheader_popup_header sesbasic_clearfix">
        <?php if($this->loginsignup_logo): ?>
          <div class="sesadvheader_popup_header_logo">
            <img src="<?php echo $this->baseUrl() . '/'. $this->loginsignup_logo; ?>" alt="My Community">
          </div>
        <?php endif; ?>
        <div class="sesadvheader_popup_header_btns">
          <?php if($controllerName != 'auth' && $actionName != 'login') { ?>
            <a class="popup-with-move-anim tab-link" href="#small-dialog"><?php echo $this->translate("Sign In");?></a>
          <?php } ?>
          <?php if($controllerName != 'signup') { ?>
            <a href="javascript:void(0);" class="active"><?php echo $this->translate("Sign Up");?></a>
          <?php } ?>
        </div>  
      </div>
      
    	<div class="sesadvheader_popup_content clearfix" style="background-image:url(<?php echo $this->loginsignupbgimage ?>);">
      	<div class="sesadvheader_popup_content_left sesadvheader_popup_signup">
          <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>
          <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : "sesadvancedheader", array('disableContent'=>true)) ?>
          <?php } ?>
        </div>
        <?php if(!empty($showSeparator)):?>
          <div class="sesadvheader_popup_content_sep">
            <span><?php echo $this->translate("OR");?></span>
          </div>
          <div class="sesadvheader_popup_content_right">
          	<span class="sesbasic_text_light"><?php echo $this->translate("Sign in with your social profile");?></span>
            <div class="sesadvheader_quick_popup_social">
              <?php  if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret):?>
                <?php if (!$facebook):?>
                  <?php  return; ?>
                <?php  endif;?>
                <?php $href = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'user', 'controller' => 'auth','action' => 'facebook'), 'default', true);?>
                <a href="<?php echo $href;?>" id="fbLogin"><img src="application/modules/Sesadvancedheader/externals/images/facebook.png" alt="Facebook" /></a>
              <?php endif;?>
              <?php if ('none' != $settings->getSetting('core_twitter_enable', 'none')
               && $settings->core_twitter_secret):?>
                <?php $href = Zend_Controller_Front::getInstance()->getRouter()
                ->assemble(array('module' => 'user', 'controller' => 'auth',
                'action' => 'twitter'), 'default', true);?>
                <a href="<?php echo $href;?>" id="googleLogin"><img src="application/modules/Sesadvancedheader/externals/images/twitter.png" alt="Twitter" /></a>
              <?php endif;?>
            </div>
          </div>  
        <?php endif;?>
      </div>
    </div>
  <?php } ?>
<?php endif;?>

<script type="application/javascript">
if('<?php echo $this->viewer()->getIdentity();?>' == 0) {
    ses(document).ready(function() {
		<?php $forcehide =  $settings->getSetting('sesadvancedheader.popupfixed', false);    ?>
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
    });    
		
		ses.magnificPopup.instance.close = function () {
   var day = '<?php echo $settings->getSetting('sesadvancedheader.popup.day', 5);?>';
   if(day != 0)
			setCookie("is_popup_sesadv_header",'popo',day);
			sesJqueryObject(document.body).removeClass('login-signup-popup-open');
			ses.magnificPopup.proto.close.call(this);	
		}
		
		jqueryObjectOfSes(document).ready(function(e){
			jqueryObjectOfSes('#signup_account_form input,#signup_account_form input[type=email]').each(
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

		jqueryObjectOfSes(document).ready(function(e){
			jqueryObjectOfSes('#sesadvancedheader_form_login input,#sesadvancedheader_form_login input[type=email]').each(
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
  var popUpShow=getCookie('is_popup_sesadv_header');
  if('<?php echo $this->viewer()->getIdentity();?>' == 0 && popUpShow == '' && '<?php echo $actionName != 'login' ;?>' && '<?php echo $controllerName != 'signup' ;?>') {
    ses(document).ready(function() {
      if('<?php echo $showPopup;?>' == '1' && '<?php echo $enablePopUp ?>' == 1) 
      document.getElementById("popup-login").click(); 
    });
  }
</script>
<ul>
  <?php
    // Reverse the navigation order (they are floating right)
    $count = count($this->navigation);
    foreach( $this->navigation->getPages() as $item ) $item->setOrder(--$count);
  ?>
  <?php foreach( $this->navigation as $item ) { ?>
    <?php $className = explode(' ', $item->class); ?>
    <?php if(end($className) == 'core_mini_signup'):?>
      <li class="sesadvheader_minimenu_link sesadvheader_minimenu_signup">
        <?php if($controllerName != 'signup') { ?>
        <a id="popup-signup" <?php if($this->poupup){ ?> <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?> class="popup-with-move-anim" <?php } ?> <?php } ?> href="<?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>#user_signup_form<?php }else{ echo 'signup'; } ?>">
            <span><?php echo $this->translate($item->getLabel());?></span>
          </a>
        <?php } ?>
      </li>
    <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() == 0): ?>
      <?php if($controllerName != 'auth'  && $actionName != 'login') { ?>
        <li class="sesadvheader_minimenu_link sesadvheader_minimenu_login">
        <a id="popup-login" <?php if($this->poupup){ ?> class="popup-with-move-anim" <?php } ?> href="<?php if($this->poupup){ ?>#small-dialog <?php }else{ echo 'login'; } ?>">
            <span><?php echo $this->translate($item->getLabel());?></span>
          </a>
        </li>
      <?php } ?>
    <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() != 0):?>
      <?php continue;?>
    <?php elseif(end($className) == 'core_mini_friends'):?>
      <?php if($this->viewer->getIdentity()):?>
        <li class="sesadvheader_minimenu_request sesadvheader_minimenu_icon">
          <?php if($this->requestCount):?>
            <span id="request_count_new" class="sesadvheader_minimenu_count"><?php echo $this->requestCount ?></span>
          <?php else:?>
            <span id="request_count_new"></span>
          <?php endif;?>
          <span onclick="toggleUpdatesPulldown(event, this, '4', 'friendrequest');" style="display:block;" class="friends_pulldown">
            <div id="friend_request" class="sesadvheader_pulldown_contents_wrapper">
              <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
              <div class="sesadvheader_pulldown_header">
                <?php echo $this->translate('Requests'); ?>
              </div>
              <div id="sesadvheader_friend_request_content" class="sesadvheader_pulldown_contents clearfix">
                <div class="pulldown_loading" id="friend_request_loading">
                  <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                </div>
              </div>
            </div>
            <?php
              $minimenu_frrequest_normal = $settings->getSetting('minimenu.frrequest.normal', 0); 
              $minimenu_frrequest_mouseover = $settings->getSetting('minimenu.frrequest.mouseover', 0);
            ?>
            <?php if(empty($minimenu_frrequest_normal) && empty($minimenu_frrequest_mouseover)):?>
              <a href="javascript:void(0);" id="show_request" class="fa fa-user-plus" title="<?php echo $this->translate("Friend Requests");?>"></a>
            <?php else:?>
              <a href="javascript:void(0);" class="sesadvheader_mini_menu_friendrequest" id="show_request" title="<?php echo $this->translate("Friend Requests");?>"><i id="show_request"></i></a>
            <?php endif;?>
          </span>
        </li>
      <?php endif;?>
    <?php elseif(end($className) == 'core_mini_notification'):?>
      <?php if($this->viewer->getIdentity()):?>
        <li id='core_menu_mini_menu_update' class="sesadvheader_minimenu_updates sesadvheader_minimenu_icon">
          <?php if($this->notificationCount):?>
            <span id="notification_count_new" class="sesadvheader_minimenu_count">
              <?php echo $this->notificationCount ?>
            </span>
          <?php else:?>
            <span id="notification_count_new"></span>
          <?php endif;?>
          <span onclick="toggleUpdatesPulldown(event, this, '4', 'notifications');" style="display:block;" class="updates_pulldown">
            <div class="sesadvheader_pulldown_contents_wrapper">
              <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
              <div class="sesadvheader_pulldown_header">
                <?php echo $this->translate('Notifications'); ?>
              </div>
              <div class="sesadvheader_pulldown_contents pulldown_content_list">
                <ul class="notifications_menu" id="notifications_menu">
                  <div class="pulldown_loading" id="notifications_loading">
                    <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                  </div>
                </ul>
              </div>
              <div class="pulldown_options">
                <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'activity', 'controller' => 'notifications'), $this->translate('View All Updates'), array('id' => 'notifications_viewall_link')) ?>
                <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Mark All Read'), array('id' => 'notifications_markread_link')); ?>
              </div>
            </div>
            <?php 
              $minimenu_notification_normal = $settings->getSetting('minimenu.notification.normal', ''); 
              $minimenu_notification_mouseover = $settings->getSetting('minimenu.notification.mouseover', 0);
            ?>
            <?php if(empty($minimenu_notification_normal) && empty($minimenu_notification_mouseover)):?>
              <a href="javascript:void(0);"  id="show_update" class="fa fa-bell" title="<?php echo $this->translate("Notificatons");?>">
                <span <?php if($this->notificationCount == 0) { ?> style="display:none" <?php } ?>  id="updates_toggle"><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span>
              </a>
            <?php else:?>
              <a href="javascript:void(0);" id="show_update" class="<?php if( $this->notificationCount ):?>new_updates<?php endif;?> sesadvheader_mini_menu_notification" title="<?php echo $this->translate("Notificatons");?>"><i id="show_update"></i>
              <span <?php if($this->notificationCount == 0) { ?> style="display:none" <?php } ?> id="updates_toggle"><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span></a>
            <?php endif;?>
          </span>
        </li>
      <?php endif;?>
    <?php elseif(end($className) == 'core_mini_settings'):?>
      <li class="sesadvheader_minimenu_setting sesadvheader_minimenu_icon">
        <span style="display:block;" class="settings_pulldown" onclick="toggleUpdatesPulldown(event, this, '4', 'settings');">
          <div id="user_settings" class="sesadvheader_pulldown_contents_wrapper ariana-mini-menu-settings-pulldown">
            <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
            <div id="sesadvheader_user_settings_content" class="sesadvheader_pulldown_contents clearfix">
              <ul>
                <li class="core_mini_menu_myprofile"><a href="<?php echo $this->viewer->getHref(); ?>">
                  <?php if($this->viewer->photo_id) { ?>
                    <img src="<?php echo $this->viewer->getPhotoUrl('thumb.icon'); ?>" />
                  <?php } else { ?>
                    <img src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" />
                  <?php } ?>
                <span><?php echo $this->translate("My Profile");?></span></a></li>
              </ul>
              <?php echo $this->navigation()->menu()->setContainer($this->settingNavigation)->render();?>
              <ul class="sesadvheader_minimenu_admin_list">
                <?php if($this->viewer->level_id == 1 || $this->viewer->level_id == 2):?>
                  <li>
                    <a href="<?php echo $this->url(array(), 'admin_default', true)?>"><i class="fa fa-user"></i>
                    <span><?php echo $this->translate('Administrator');?></span></a>
                  </li>
                <?php endif;?>
              </ul>
              <ul class="sesadvheader_minimenu_logout_list">
                <li class="user_signout">
                  <a href="<?php echo $this->url(array(), 'user_logout', true)?>"><span><?php echo $this->translate('Logout');?></span><i class="fa fa-sign-out"></i></a>
                </li>
              </ul>
            </div>
          </div>
          <?php $userPhoto = $settings->getSetting('sesadvancedheader.miniuserphotoround',1); ?>
          <a <?php if(empty($userPhoto)) { ?> class="img_thumb" <?php } ?> href="javascript:void(0);" id="show_settings_img" title="<?php echo $this->viewer->getTitle(); ?>">
            <?php if($this->viewer->photo_id) { ?>
              <img src="<?php echo $this->viewer->getPhotoUrl('thumb.icon'); ?>" id="show_settings_img" />
            <?php } else { ?>
              <img src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" id="show_settings_img" />
            <?php } ?>
          </a>
        </span>
      </li>
    <?php elseif(end($className) == 'core_mini_messages'):?>
      <li class="sesadvheader_minimenu_message sesadvheader_minimenu_icon">
        <?php if($this->messageCount):?>
          <span id="message_count_new" class="sesadvheader_minimenu_count"><?php echo $this->messageCount ?></span>
        <?php else:?>
          <span id="message_count_new"></span>
        <?php endif;?>
        <span onclick="toggleUpdatesPulldown(event, this, '4', 'message');" style="display:block;" class="messages_pulldown">
          <div id="sesadvheader_user_messages" class="sesadvheader_pulldown_contents_wrapper ariana-mini-menu-messages-pulldown">
            <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
            <div class="sesadvheader_pulldown_header">
              <?php echo $this->translate('Messages'); ?>
              <a class="icon_message_new righticon fa fa-plus" title="<?php echo $this->translate('Compose New Message'); ?>" href="<?php echo $this->url(array('action' => 'compose'), 'messages_general') ?>"></a>
            </div>
            <div id="sesadvheader_user_messages_content" class="sesadvheader_pulldown_contents clearfix">
              <div class="pulldown_loading">
                <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
              </div>
            </div>
          </div>
          <?php
            $minimenu_message_normal = $settings->getSetting('minimenu.message.normal', 0); 
            $minimenu_message_mouseover = $settings->getSetting('minimenu.message.mouseover', 0);
          ?>
          <?php if(empty($minimenu_message_normal) && empty($minimenu_message_mouseover)):?>
            <a href="javascript:void(0);" id="show_message" class="fa fa-comments" title="<?php echo $this->translate("Messages");?>"></a>
          <?php else:?>
            <a href="javascript:void(0);" class="sesadvheader_mini_menu_message" id="show_message" title="<?php echo $this->translate("Messages");?>"><i id="show_message"></i></a>
          <?php endif;?>
        </span>
      </li>
    <?php elseif(end($className) == 'core_mini_admin'):?>
      <?php continue;?>
    <?php else:?>
      <li class="sesadvheader_minimenu_link">
        <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), array_filter(array( 'class' => ( !empty($item->class) ? $item->class : null ), 'alt' => ( !empty($item->alt) ? $item->alt : null ), 'target' => ( !empty($item->target) ? $item->target : null )))); ?>
      </li>
    <?php endif;?>
  <?php } ?>
  <?php if(in_array('search',$this->header_options)) { ?>
    <li class="mobile_search">
      <a href="javascript:void(0)" class="mobile_search_btn fa fa-search"></a>
      <?php 
        $searchText = "";
        if(!empty($_GET['query']) && $actionName == "index" && $controllerName == "search")
          $searchText = $_GET['query'];
      ?>
      <?php include 'search.tpl'; ?>
    </li>
  <?php } ?>
</ul>