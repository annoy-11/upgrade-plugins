
<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seslinkedin/externals/styles/component.css'); ?>
<?php if($this->viewer->getIdentity() == 0) : ?>
  <script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Seslinkedin/externals/scripts/jquery-latest.min.js"></script>
  <script>var ses = $.noConflict();</script>
  <script src="<?php echo $baseUrl; ?>application/modules/Seslinkedin/externals/scripts/jquery.magnific-popup.js"></script>
  <link href="<?php echo $baseUrl; ?>application/modules/Seslinkedin/externals/styles/magnific-popup.css" rel="stylesheet" />
<?php endif;?>


<?php $enablePopUp = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.popupsign', 1);  ?>
<?php $showPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.popup.enable', 1);?>

<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
<?php $moduleName = $request->getModuleName();?>

<?php $showSeparator = 0;?> 
<?php $settings = Engine_Api::_()->getApi('settings', 'core');?>
<?php $facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();?>
<?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret && $facebook):?>
  <?php $showSeparator = 1;?>
<?php elseif ('none' != $settings->getSetting('core_twitter_enable', 'none') && $settings->core_twitter_secret):?>
  <?php $showSeparator = 1;?>
<?php endif;?>
  
<?php $siteTitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title','1');?>
<?php if($this->viewer->getIdentity() == 0): ?>
    <?php if(!empty($showSeparator)) { ?>
  	<div id="small-dialog" class="zoom-anim-dialog mfp-hide seslinkedin_quick_popup seslinkedin_quick_login_popup sesbasic_bxs">
    <?php } else { ?>
      <div id="small-dialog" class="zoom-anim-dialog mfp-hide seslinkedin_quick_popup seslinkedin_quick_login_popup sesbasic_bxs _nosbtns">
    <?php } ?>
    <div class="seslinkedin_popup_header clearfix">
      <div class="seslinkedin_popup_header_title"><?php echo $this->translate("Sign In");?></div>  
    </div>
    
    <div class="seslinkedin_popup_content clearfix">
      <div class="seslinkedin_popup_social">
          <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
          <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle(); ?>
          <div class="seslinkedin_social_login_btns <?php if($numberOfLogin < 3):?>social_login_btns_label<?php endif;?>">
            <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
          </div>
        <?php endif; ?>
        </div>
    	<div class="seslinkedin_quick_popup_form seslinkedin_popup_login">
        <?php echo $this->content()->renderWidget("seslinkedin.login-or-signup") ?>
      </div>
    </div>
    <div class="seslinkedin_popup_footer clearfix">
			<?php if($controllerName != 'signup'){ ?>
      	<span>
            <?php echo $this->translate("No account yet?");?> <a class="popup-with-move-anim tab-link" href="#user_signup_form"><?php echo $this->translate("Sign Up Now!");?></a>
        </span>
      <?php } ?>
    </div>
  </div>

  <?php if($controllerName != 'signup'){ ?>
  	<?php if(!empty($showSeparator)){ ?>
    	<div id="user_signup_form" class="zoom-anim-dialog mfp-hide seslinkedin_quick_popup sesbasic_bxs seslinkedin_quick_signup_popup">
    <?php } else { ?>
      <div id="user_signup_form" class="zoom-anim-dialog mfp-hide seslinkedin_quick_popup sesbasic_bxs seslinkedin_quick_signup_popup _nosbtns">
    <?php }; ?>
      <div class="seslinkedin_popup_header clearfix">
        <div class="seslinkedin_popup_header_title"><?php echo $this->translate("Join Now");?></div>
      </div>
    	<div class="seslinkedin_popup_content clearfix">
       <div class="seslinkedin_popup_social">
           <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
          <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle(); ?>
          <div class="seslinkedin_social_login_btns <?php if($numberOfLogin < 3):?>social_login_btns_label<?php endif;?>">
            <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
          </div>
        <?php endif; ?>
            </div>
      	<div class="seslinkedin_quick_popup_form seslinkedin_popup_signup">
          <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>
            <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : 'seslinkedin', array('disableContent'=>true)) ?>
          <?php } ?>
          <div class="seslinkedin_popup_footer clearfix">
        <span><?php echo $this->translate("Already a member? ");?><a class="popup-with-move-anim tab-link" href="#small-dialog"><?php echo $this->translate("Sign In");?></a></span>
      </div>
        </div>
      </div>
    </div>
  <?php } ?>
<?php endif; ?>

<?php if($this->viewer->getIdentity()){ ?>
<div class="header sesbasic_bxs sesbasic_clearfix">
  <?php if($this->show_logo) { ?>
    <?php if($this->headerlogo): ?>
      <div class="header_logo">
        <?php $headerlogo = $this->baseUrl() . '/' . $this->headerlogo; ?>
        <a href=""><img alt="" src="<?php echo $headerlogo ?>"></a>
      </div>
    <?php else: ?>
      <div class="header_logo">
        <a href=""><?php echo $this->siteTitle; ?></a>
      </div>
    <?php endif; ?>
  <?php } ?>
  <?php if($this->show_search) { ?>
    <div>
      <?php
        if( Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('advancedsearch')){
           echo $this->content()->renderWidget("advancedsearch.search");
      } else { ?>
        <?php  echo $this->content()->renderWidget("seslinkedin.search"); ?>
      <?php } ?>
    </div>
  <?php } ?>
  <div class="header_menus sesbasic_bxs sesbasic_clearfix">
    <?php if($this->show_mini) { ?>
      <div class="menu_middle">
        <?php
          // Reverse the navigation order (they are floating right)
          $count = count($this->navigation);
          foreach( $this->navigation->getPages() as $item ) $item->setOrder(--$count);
        ?>
        <ul>
        
         <li class="seslinkedin_minimenu_link <?php echo $actionName == 'home' ? 'active' : ''; ?> "><a href=""><i class="seslinkedin_home"></i><span><?php echo $this->translate("Home") ;?></span></a></li>
          <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sesjob')): ?>
            <li class="seslinkedin_minimenu_link <?php echo $actionName == 'create' && $controllerName == 'index' ? 'active' : ''; ?>"><a href="<?php echo $this->url(array('action' => 'create'),'sesjob_general',true); ?>"><i class="seslinkedin_job"></i><span><?php echo $this->translate("Post New Job") ;?></span></a></li>
          <?php endif; ?>
          <?php foreach( $this->navigation as $item ) { ?>
            <?php $className = explode(' ', $item->class); ?>
            
            <?php if(end($className) == 'core_mini_signup'):?>
              <li class="seslinkedin_minimenu_link seslinkedin_minimenu_signup">
                <?php if($controllerName != 'signup') { ?>
                  <a id="popup-signup" <?php if($this->poupup){ ?> <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?> class="popup-with-move-anim" <?php } ?> <?php } ?> href="<?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>#user_signup_form<?php } else{ echo 'signup'; } ?>">
                    <span><?php echo $this->translate($item->getLabel());?></span>
                  </a>
                <?php }  ?>
              </li>
              
            <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() == 0): ?>
              <?php if($controllerName != 'auth'  && $actionName != 'login') { ?>
                <li class="seslinkedin_minimenu_link seslinkedin_minimenu_login">
                 <a id="popup-login" <?php if($this->poupup){ ?> class="popup-with-move-anim" <?php } ?> href="<?php if($this->poupup){ ?>#small-dialog <?php } else{ echo 'login'; } ?>">
                    <span><?php echo $this->translate($item->getLabel());?></span>
                  </a>
                </li>
              <?php } ?>
            <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() != 0):?>
              <?php continue;?>

            <?php elseif(end($className) == 'core_mini_friends'):?>
              <?php if($this->viewer->getIdentity()):?>
                <li class="seslinkedin_minimenu_request seslinkedin_minimenu_icon">
                  <?php if($this->requestCount):?>
                    <span id="request_count_new" class="seslinkedin_minimenu_count"><?php echo $this->requestCount ?></span>
                  <?php else:?>
                    <span id="request_count_new"></span>
                  <?php endif;?>
                  <span onclick="toggleUpdatesPulldown(event, this, '4', 'friendrequest');" style="display:block;" class="friends_pulldown">
                    <div id="friend_request" class="seslinkedin_pulldown_contents_wrapper">
                      <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                      <div class="seslinkedin_pulldown_header">
                        <?php echo $this->translate('Requests'); ?>
                      </div>
                      <div id="seslinkedin_friend_request_content" class="seslinkedin_pulldown_contents clearfix">
                        <div class="pulldown_loading" id="friend_request_loading">
                          <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                        </div>
                      </div>
                    </div>
                    <?php
                      $minimenu_frrequest_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.normal', 0); 
                      $minimenu_frrequest_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.mouseover', 0);
                    ?>
                    <?php if(empty($minimenu_frrequest_normal) && empty($minimenu_frrequest_mouseover)):?>
                      <a href="javascript:void(0);" id="show_request" class="fa fa-user-plus" title="<?php echo $this->translate($item->getLabel());?>"><span><?php echo $this->translate($item->getLabel()); ?></span></a>
                    <?php else:?>
                      <a href="javascript:void(0);" class="seslinkedin_mini_menu_friendrequest" id="show_request" title="<?php echo $this->translate($item->getLabel());?>"><span><?php echo $this->translate($item->getLabel()); ?></span></a>
                    <?php endif;?>
                  </span>
                </li>
              <?php endif;?>
             <?php elseif(end($className) == 'core_mini_messages'):?>
              <li class="seslinkedin_minimenu_message seslinkedin_minimenu_icon">
                <?php if($this->messageCount):?>
                  <span id="message_count_new" class="seslinkedin_minimenu_count"><?php echo $this->messageCount ?></span>
                <?php else:?>
                  <span id="message_count_new"></span>
                <?php endif;?>
                <span onclick="toggleUpdatesPulldown(event, this, '4', 'message');" style="display:block;" class="messages_pulldown">
                  <div id="seslinkedin_user_messages" class="seslinkedin_pulldown_contents_wrapper ariana-mini-menu-messages-pulldown">
                    <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                    <div class="seslinkedin_pulldown_header">
                      <?php echo $this->translate('Messages'); ?>
                      <a class="icon_message_new righticon fa fa-plus" title="<?php echo $this->translate('Compose New Message'); ?>" href="<?php echo $this->url(array('action' => 'compose'), 'messages_general') ?>"></a>
                    </div>
                    <div id="seslinkedin_user_messages_content" class="seslinkedin_pulldown_contents clearfix">
                      <div class="pulldown_loading">
                        <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                      </div>
                    </div>
                  </div>
                  <?php
                    $minimenu_message_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.message.normal', 0); 
                    $minimenu_message_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.message.mouseover', 0);
                  ?>
                  <?php if(empty($minimenu_message_normal) && empty($minimenu_message_mouseover)): ?>
                    <a href="javascript:void(0);" id="show_message" class="fa fa-comments" title="<?php echo $this->translate($item->getLabel());?>">
                       <span><?php echo $this->translate($item->getLabel()); ?></span>
                    </a>
                  <?php else:?>
                    <a href="javascript:void(0);" class="seslinkedin_mini_menu_message" id="show_message" title="<?php echo $this->translate($item->getLabel());?>"><i id="show_message"></i><span><?php echo $this->translate($item->getLabel()); ?></span></a>
                  <?php endif;?>
                </span>
              </li>
            <?php elseif(end($className) == 'core_mini_notification'):?>
              <?php if($this->viewer->getIdentity()):?>
                <li id='core_menu_mini_menu_update' class="seslinkedin_minimenu_updates seslinkedin_minimenu_icon">
                  <?php if($this->notificationCount):?>
                    <span id="notification_count_new" class="seslinkedin_minimenu_count">
                      <?php echo $this->notificationCount ?>
                    </span>
                  <?php else:?>
                    <span id="notification_count_new"></span>
                  <?php endif;?>
                  <span onclick="toggleUpdatesPulldown(event, this, '4', 'notifications');" style="display:block;" class="updates_pulldown">
                    <div class="seslinkedin_pulldown_contents_wrapper">
                      <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                      <div class="seslinkedin_pulldown_header">
                        <?php echo $this->translate('Notifications'); ?>
                      </div>
                      <div class="seslinkedin_pulldown_contents pulldown_content_list">
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
                      $minimenu_notification_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.notification.normal', ''); 
                      $minimenu_notification_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.notification.mouseover', 0);
                    ?>
                    <?php if(empty($minimenu_notification_normal) && empty($minimenu_notification_mouseover)):?>
                      <a href="javascript:void(0);"  id="show_update" class="fa fa-bell" title="<?php echo $this->translate($item->getLabel());?>">
                        <span><?php echo $this->translate($item->getLabel()); ?></span>
                      </a>
                    <?php else:?>
                      <a href="javascript:void(0);" id="show_update" class="<?php if( $this->notificationCount ):?>new_updates<?php endif;?> seslinkedin_mini_menu_notification" title="<?php echo $this->translate($item->getLabel());?>"><i id="show_update"></i>
                      <span <?php if($this->notificationCount == 0) { ?> style="display:none" <?php } ?> id="updates_toggle"><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span></a>
                    <?php endif;?>
                  </span>
                </li>
              <?php endif;?>
            <?php elseif(end($className) == 'core_mini_settings'):?>
              <li class="seslinkedin_minimenu_setting seslinkedin_minimenu_icon">
                <span style="display:block;" class="settings_pulldown" onclick="toggleUpdatesPulldown(event, this, '4', 'settings');">
                  <div id="user_settings" class="seslinkedin_pulldown_contents_wrapper ariana-mini-menu-settings-pulldown">
                    <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                    <div class="seslinkedin_pulldown_header">
                      <?php echo $this->translate('Account & Settings');?>
                    </div>
                    <div id="seslinkedin_user_settings_content" class="seslinkedin_pulldown_contents clearfix">
                      <ul>
                        <li><a href="<?php echo $this->viewer->getHref(); ?>"><?php echo $this->translate("My Profile");?></a></li>
                      </ul>
                      <ul>
                        <?php foreach( $this->settingNavigation as $link ): ?>
                          <li>
                            <?php echo $this->htmlLink($link->getHref(), $this->translate($link->getLabel()), array(
                              'class' => 'buttonlink' . ( $link->getClass() ? ' ' . $link->getClass() : '' ),
                              'style' => $link->get('icon') ? 'background-image: url('.$link->get('icon').');' : '',
                              'target' => $link->get('target'),
                            )) ?>
                          </li>
                        <?php endforeach; ?>
                      </ul>
                      <?php //echo $this->navigation()->menu()->setContainer($this->settingNavigation)->render();?>
                      <ul>
                        <?php if($this->viewer->level_id == 1 || $this->viewer->level_id == 2):?>
                          <li>
                            <a href="<?php echo $this->url(array(), 'admin_default', true)?>"><?php echo $this->translate('Administrator');?></a>
                          </li>
                        <?php endif;?>
                        <li>
                          <a href="<?php echo $this->url(array(), 'user_logout', true)?>"><?php echo $this->translate('Logout');?></a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <a href="javascript:void(0);" id="show_settings_img" title="<?php echo $this->translate('Account & Settings');?>"><?php if($this->viewer->photo_id) { ?>
                  <img src="<?php echo $this->viewer->getPhotoUrl('thumb.icon'); ?>" class="item_photo_user" />
                <?php } else { ?>
                  <img src="application/modules/User/externals/images/nophoto_user_thumb_icon.png" class="item_photo_user" />
                <?php } ?>
                <span>Me <i id='' class="fa fa-caret-down"></i></span></a>
                </span>
              </li>
            <?php elseif(end($className) == 'core_mini_admin'):?>
              <?php continue;?>
            <?php else:?>
              <li class="seslinkedin_minimenu_link">
                <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), array_filter(array( 'class' => ( !empty($item->class) ? $item->class : null ), 'alt' => ( !empty($item->alt) ? $item->alt : null ), 'target' => ( !empty($item->target) ? $item->target : null )))); ?>
              </li>
            <?php endif;?>
          <?php } ?>
        </ul>
      </div>
    <?php } ?>
    <?php  if($this->show_menu) { ?>
      <div class="menu_right">
        <ul>
          <li id="st-trigger-effects" class="main_menu_link st-pusher">
            <a onclick="showMenuLinkedin();" href="javascript:void(0);" class="slide_btn" id="slide_btn" data-effect="st-effect-4"><i class="fa fa-th"></i></a>
          </li>
        </ul>
      </div>
    <?php } ?>
  </div>
</div>
<?php } else { ?>
  <div class="header_guest sesbasic_bxs">
    <div class="header_guest_main">
      <?php if($this->show_logo) { ?>
        <div class="_logo">
         <?php if($this->headerlogo){ ?>
            <?php $headerlogo = $this->baseUrl() . '/' . $this->headerlogo; ?>
           <a href=""><img alt="" src="<?php echo $headerlogo ?>"></a>
          <?php } else { ?>
            <a href=""><?php echo $this->siteTitle; ?></a>
          <?php } ?>
        </div>
      <?php } ?>
        <?php if(($this->viewer->getIdentity() == 0) && $this->show_mini): ?>
          <?php if($controllerName != 'auth'  && $actionName != 'login') { ?>
            <div class="_loginform">
              <div class="_links">
                <a id="login_link" <?php if($this->poupup){ ?> class="popup-with-move-anim" <?php } ?> href="<?php if($this->poupup){ ?>#small-dialog <?php }else{ echo 'login'; } ?>" class="login_link"><?php echo $this->translate("Sign In"); ?></a>
              </div>
            </div>
          <?php } ?>
        <?php endif; ?>
        <?php if($this->show_mini) { ?>
        <?php if($this->viewer->getIdentity() == 0): ?>
          <?php if($controllerName != 'signup') { ?>
            <div class="menu_signup">
              <a id="popup-signup" <?php if($this->poupup){ ?> <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?> class="popup-with-move-anim" <?php } ?> <?php } ?> href="<?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>#user_signup_form<?php }else{ echo 'signup'; } ?>"><?php echo $this->translate("Join Now");?></a>
            </div>
          <?php } ?>
        <?php endif; ?>
      <?php } ?>
    </div>
  </div>
<script type='text/javascript'>
  sesJqueryObject(document).on('click','#login_link',function(){
  if(sesJqueryObject (this).hasClass('active')){
   sesJqueryObject (this).removeClass('active');
   sesJqueryObject ('#sesabasic_form_login').removeClass('_showform');
  }else{
   sesJqueryObject (this).addClass('active');
   sesJqueryObject ('#sesabasic_form_login').addClass('_showform');
  }
});
</script>
<?php } ?>
<div id="update_count" style="display:none;"></div>
<nav class="st-menu st-effect-4" id="show_main_menu">
  <div class="menus_searh_close" style="display:none;">
   <div class="menu_search_box">
      <input autocomplete="off" placeholder="<?php echo $this->translate('Search'); ?>" id="seslinkedinside_search" type="text" name="name" />
      <a onclick="javascript:showAllSearchResultsSide();" href="javascript:void(0);"><i class="fa fa-search"></i></a>      
    </div>
  </div>
  
  <div id="menu_left_panel" class="menu_right_panel mCustomScrollbar" data-mcs-theme="minimal-dark">
  
    <ul class="menu_right_list_links">
      <?php foreach( $this->mainMenuNavigation as $navigationMenu ): ?>
        <?php $class = explode(' ', $navigationMenu->class); ?>
        <?php $navClass = end($class); ?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php if($navClass == 'core_main_invite'):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
          <?php elseif($navClass == 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
          <?php elseif($navClass == 'core_main_chat' && ($this->viewer->getIdentity() != 0)): ?>
            <a class= "<?php echo $navigationMenu->class ?>" href='chat'>
          <?php else:?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
          <?php endif;?>
          <i class="fa <?php echo $navigationMenu->get('icon') ? $navigationMenu->get('icon') : 'fa-star' ?>"></i>
          <span><?php echo $this->translate($navigationMenu->label); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <?php if($this->footersidepanel) { ?>
      <div class="menu_footer">
        <div class="menu_footer_links">
          <ul>
            <?php foreach( $this->footerNavigation as $item ): ?>
              <li><a href="<?php echo $item->getHref(); ?>"><?php echo $this->translate($item->getLabel()); ?></a></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="menu_copy_lang">
          <p class="menu_copyright"><?php echo $this->translate('Copyright &copy; %s', date('Y')) ?></p>
          <?php if( 1 !== count($this->languageNameList) ): ?>
            <div class="footer_lang">
              <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
                <?php $selectedLanguage = $this->translate()->getLocale() ?>
                <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
                <?php echo $this->formHidden('return', $this->url()) ?>
              </form>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php } ?>
    
  </div>
</nav>

<script type='text/javascript'>

  function scrollingLinkedin() {

    var height = sesJqueryObject( window ).height();
    if(document.getElementById("menu_left_panel")) {
      document.getElementById("menu_left_panel").setStyle("max-height", height+"px");
    }
    var heightPannel = sesJqueryObject("#menu_left_panel").height() - 51;
    sesJqueryObject('#global_content').css('min-height',heightPannel+'px');
  }
  
  sesJqueryObject(document).ready(function(){
    scrollingLinkedin();
  });

  function showSearch() { 
    if(document.getElementById('show_linkedin_search').style.display == 'block') {
      document.getElementById('show_linkedin_search').style.display = 'none';
    }
    else {
      document.getElementById('show_linkedin_search').style.display = 'block';
    }
  }

  function showMenuLinkedin() {
    if(document.getElementById('show_main_menu').style.display != 'block') {
      <?php if($this->sidepaneldesign == 1) { ?>
        $(document.body).addClass("st-menu-open-design1");
      <?php } else { ?>
        $(document.body).addClass("st-menu-open-design2");
      <?php } ?>
      
    }
  }
  function hideSidePanel() {
    <?php if($this->sidepaneldesign == 1) { ?>
      $(document.body).removeClass("st-menu-open-design1");
    <?php } else { ?>
      $(document.body).removeClass("st-menu-open-design2");
    <?php } ?>
  }
	
		window.addEvent('domready', function() {
			$(document.body).addEvent('click', function(event) {
	
				if(event.target.className != 'fa fa-th' && event.target.id != 'seslinkedinside_search' && event.target.className != 'menu_footer_links' && event.target.className != 'fa fa-th' && event.target.id != 'language') {
					//$(document.body).removeClass("st-menu-open");
					<?php if($this->sidepaneldesign == 1) { ?>
						$(document.body).removeClass("st-menu-open-design1");
					<?php } else { ?>
						$(document.body).removeClass("st-menu-open-design2");
					<?php } ?>
				}
			});
		});
  
	<?php if($this->viewer->getIdentity()){?>
		var notificationUpdater;
		en4.core.runonce.add(function(){
	
			if($('notifications_markread_link')){
				$('notifications_markread_link').addEvent('click', function() {
					$('notification_count_new').setStyle('display', 'none');
					en4.activity.hideNotifications('<?php echo $this->string()->escapeJavascript($this->translate("0 Updates"));?>');
				});
			}
	
			<?php if ($this->updateSettings && $this->viewer->getIdentity()): ?>
				notificationUpdater = new NotificationUpdateHandler({
					'delay' : <?php echo $this->updateSettings;?>
				});
				notificationUpdater.start();
				window._notificationUpdater = notificationUpdater;
			<?php endif;?>
		});
		
		var previousMenu;
		var abortRequest;
		var toggleUpdatesPulldown = function(event, element, user_id, menu) {
		
			if (typeof(abortRequest) != 'undefined') {
				abortRequest.cancel();
			}
	
			if(event.target.className == 'seslinkedin_pulldown_header')
				return;
				if(event.target.getParent('ul').querySelector('.active'))
            event.target.getParent('ul').querySelector('.active').removeClass('active');
			var hideNotification = 0;
			var hideMessage = 0;
			var hideSettings = 0;
			var hideFriendRequests = 0;
			
			if($$(".updates_pulldown_selected").length > 0) {
				$$('.updates_pulldown_selected').set('class', 'updates_pulldown');
				var hideNotification = 1;
			}
	
			if($$(".messages_pulldown_selected").length > 0) {
				$$('.messages_pulldown_selected').set('class', 'messages_pulldown');
				hideMessage = 1;
			}
			if($$(".settings_pulldown_selected").length > 0) {
				$$('.settings_pulldown_selected').set('class', 'settings_pulldown');
				hideSettings = 1;
			}
			if($$(".settings_pulldown_selected").length > 0) {
				$$('.settings_pulldown_selected').set('class', 'settings_pulldown');
				hideSettings = 1;
			}
			
			if($$(".friends_pulldown_selected").length > 0) {
				$$('.friends_pulldown_selected').set('class', 'friends_pulldown');
				hideFriendRequests = 1;
			}
		
			if(menu == 'notifications' && hideNotification == 0) {
				
				if(element.className=='updates_pulldown') {
					element.className= 'updates_pulldown_selected';
					showNotifications();
				} else
					element.className='updates_pulldown';
			}
			else if(menu == 'message' && hideMessage == 0) {
				if( element.className=='messages_pulldown' ) {
					element.className= 'messages_pulldown_selected';
					showMessages();
				} else {
					element.className='messages_pulldown';
				}
			}
			else if(menu == 'settings' && hideSettings == 0) {
	
				if( element.className=='settings_pulldown' ) {
					element.className = 'settings_pulldown_selected';
				} else {
					element.className='settings_pulldown';
				}
			}
			else if(menu == 'friendrequest' && hideFriendRequests == 0) {
				if( element.className=='friends_pulldown' ) {
					element.className= 'friends_pulldown_selected';
					showFriendRequests();
				} else {
					element.className='friends_pulldown';
				}
			}
			event.target.getParent('li').addClass('active');
			previousMenu = menu;
		}
		
		var showNotifications = function() {
	
			en4.activity.updateNotifications();
			abortRequest = new Request.HTML({
				'url' : en4.core.baseUrl + 'seslinkedin/notifications/pulldown',
				'data' : {
					'format' : 'html',
					'page' : 1
				},
				'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
					if( responseHTML ) {
						// hide loading iconsignup
						if($('notifications_loading')) $('notifications_loading').setStyle('display', 'none');
	
						$('notifications_menu').innerHTML = responseHTML;
						$('notifications_menu').addEvent('click', function(event){
							event.stop(); //Prevents the browser from following the link.
	
							var current_link = event.target;
							var notification_li = $(current_link).getParent('li');
	
							// if this is true, then the user clicked on the li element itself
							if( notification_li.id == 'core_menu_mini_menu_update' ) {
								notification_li = current_link;
							}
	
							var forward_link;
							if( current_link.get('href') ) {
								forward_link = current_link.get('href');
							} else{
								forward_link = $(current_link).getElements('a:last-child').get('href');
							}
	
							if( notification_li.get('class') == 'notifications_unread' ){
								notification_li.removeClass('notifications_unread');
								en4.core.request.send(new Request.JSON({
									url : en4.core.baseUrl + 'activity/notifications/markread',
									data : {
										format     : 'json',
										'actionid' : notification_li.get('value')
									},
									onSuccess : function() {
										window.location = forward_link;
									}
								}));
							} else {
								window.location = forward_link;
							}
						});
					} else {
						$('notifications_loading').innerHTML = '<?php echo $this->string()->escapeJavascript($this->translate("You have no new updates."));?>';
					}
					document.getElementById('notification_count_new').innerHTML = '';
					document.getElementById('notification_count_new').removeClass('seslinkedin_minimenu_count');
				}
			});
			en4.core.request.send(abortRequest, {
				'force': true
			});
		}
	
		function showMessages() {
	
			abortRequest = new Request.HTML({
				url : en4.core.baseUrl + 'seslinkedin/index/inbox',
				data : {
					format : 'html'
				},
				onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
				{
				 document.getElementById('seslinkedin_user_messages_content').innerHTML = responseHTML;
				 document.getElementById('message_count_new').innerHTML = '';
				 document.getElementById('message_count_new').removeClass('seslinkedin_minimenu_count');
				}
			}); 
			en4.core.request.send(abortRequest, {
			'force': true
			});
		}
	
		function showFriendRequests() {
	
			abortRequest = new Request.HTML({
				url : en4.core.baseUrl + 'seslinkedin/index/friendship-requests',
				data : {
					format : 'html'
				},
				onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
				{
				 if(responseHTML) {
					 document.getElementById('seslinkedin_friend_request_content').innerHTML = responseHTML;
					 document.getElementById('request_count_new').innerHTML = '';
					 document.getElementById('request_count_new').removeClass('seslinkedin_minimenu_count');
				 }
				 else {
					$('friend_request_loading').innerHTML = '<?php echo $this->string()->escapeJavascript($this->translate("You have no new friend request."));?>';
				 }
				}
			}); 
			en4.core.request.send(abortRequest, {
				'force': true
			});
		}
	
		window.addEvent('domready', function() {
		
			$(document.body).addEvent('click', function(event) {
	

				
				if(event.target.className != 'fa fa-search' && event.target.id != 'seslinkedin_search') {
					if($('show_linkedin_search').style.display == 'block') {
						$('show_linkedin_search').style.display = 'none';
					}
				}
				if(event.target.id != 'show_message' && event.target.id != 'show_request' && event.target.id != 'show_update' &&  event.target.id != 'show_settings_img' && event.target.className != 'seslinkedin_pulldown_header' && event.target.className != 'pulldown_loading' && event.target.className != 'fa fa-caret-down' && event.target.parentElement.id != 'show_message' && event.target.parentElement.id != 'show_request' && event.target.parentElement.id != 'show_update' && event.target.parentElement.id != 'show_settings_img') {
					if($$(".updates_pulldown_selected").length > 0)
						$$('.updates_pulldown_selected').set('class', 'updates_pulldown');
	
					if($$(".messages_pulldown_selected").length > 0)
						$$('.messages_pulldown_selected').set('class', 'messages_pulldown');
	
					if($$(".settings_pulldown_selected").length > 0)
						$$('.settings_pulldown_selected').set('class', 'settings_pulldown');
				
					if($$(".friends_pulldown_selected").length > 0)
						$$('.friends_pulldown_selected').set('class', 'friends_pulldown');  
				}
			});
			
			<?php if($this->viewer->getIdentity() != 0) : ?>
				setInterval(function() {
					newUpdates();
				},20000);
			
				window.setInterval(function() {
					newMessages();
				},30000);
			
				window.setInterval(function() {
					newFriendRequests();
				},10000);
			<?php endif; ?>
		});
	
		
		function newFriendRequests() {
	
			en4.core.request.send(new Request.JSON({
				url : en4.core.baseUrl + 'seslinkedin/index/new-friend-requests',
				method : 'POST',
				data : {
					format : 'json'
				},
				onSuccess : function(responseJSON) {
					if( responseJSON.requestCount && $("request_count_new") ) {
						$('updates_toggle').addClass('new_updates');
						$("request_count_new").style.display = 'block';
						if(responseJSON.requestCount > 0 && responseJSON.requestCount != '')
							$("request_count_new").addClass('seslinkedin_minimenu_count');
						$("request_count_new").innerHTML = responseJSON.requestCount;
					}
				}
			}));
		}
		
		function newUpdates() {
			en4.core.request.send(new Request.JSON({
				url : en4.core.baseUrl + 'seslinkedin/index/new-updates',
				method : 'POST',
				data : {
					format : 'json'
				},
				onSuccess : function(responseJSON) {
					if( responseJSON.notificationCount && $("notification_count_new") ) {
						$('updates_toggle').addClass('new_updates');
						$("notification_count_new").style.display = 'block';
						$("notification_count_new").innerHTML = responseJSON.notificationCount;
						if(responseJSON.notificationCount > 0 && responseJSON.notificationCount != '')
							$("notification_count_new").addClass('seslinkedin_minimenu_count');
					}
				}
			}));
		}
		
		function newMessages() {
			en4.core.request.send(new Request.JSON({
				url : en4.core.baseUrl + 'seslinkedin/index/new-messages',
				method : 'POST',
				data : {
					format : 'json'
				},
				onSuccess : function(responseJSON) {
	
					if( responseJSON.messageCount && $("message_count_new") ) {
						$('updates_toggle').addClass('new_updates');
						$("message_count_new").style.display = 'block';
						if(responseJSON.messageCount > 0 && responseJSON.messageCount != '')
						$("message_count_new").addClass('seslinkedin_minimenu_count');
						$("message_count_new").innerHTML = responseJSON.messageCount;
					}
				}
			}));
		}
		
		//Search
		
   <?php } ?>
	
	sesJqueryObject(window).ready(function(e){
		var height = sesJqueryObject(".layout_page_header").height();
		if($("global_wrapper")) {
			$("global_wrapper").setStyle("margin-top", height+"px");
		}
	});
	
	function showRecentloginPopup() {
    if($('seslinkedin_switch_user').style.display == 'block') {
      $('seslinkedin_switch_user').style.display = 'none';
      sesJqueryObject('#switch_user_pulldown').removeClass('switch_user_pulldown_selected');
    } else {
      $('seslinkedin_switch_user').style.display = 'block';
      sesJqueryObject('#switch_user_pulldown').addClass('switch_user_pulldown_selected');
    }
	}
	
  function removeRecentUser(user_id) {
  
    var url = en4.core.baseUrl + 'seslinkedin/index/removerecentlogin';
    sesJqueryObject('#recent_login_'+user_id).fadeOut("slow", function(){
      setTimeout(function() {
        sesJqueryObject('#recent_login_'+user_id).remove();
      }, 2000);
    });
    (new Request.JSON({
      url: url,
      data: {
          format: 'json',
          user_id: user_id,
      },
      onSuccess: function () {
          window.location.replace('<?php echo $this->url(array(), 'default', true) ?>');
      }
    })).send();
  }
  
  function loginAsLinkedinUser(user_id, password) {
    var url = en4.core.baseUrl + 'seslinkedin/index/login';
    (new Request.JSON({
      url : url,
      data : {
        format : 'json',
        user_id : user_id,
        password: password,
      },
      onSuccess : function() {
        window.location.replace('members/home/');
      }
    })).send();
  }
  
if('<?php echo $this->viewer->getIdentity();?>' == 0) {
    ses(document).ready(function() {
		<?php $forcehide =  Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.popupfixed', false);    ?>
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
   var day = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('seslinkedin.popup.day', 5);?>';
   if(day != 0)
			setCookie("is_popup",'popo',day);
    else 
      setCookie("is_popup",'',day);
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
			jqueryObjectOfSes('#sesabasic_form_login input,#sesabasic_form_login input[type=email]').each(
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
  function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var linkedin = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + linkedin;
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
	ses(document).ready(function() {
    if('<?php echo $showPopup;?>' == '1' && '<?php echo $enablePopUp ?>' == 1) 
		document.getElementById("login_link").click(); 
	});
}
</script>
<?php $header_fixed = Engine_Api::_()->seslinkedin()->getContantValueXML('seslinkedin_header_fixed_layout'); 

if($header_fixed == '1'):

?>
<script>
	jqueryObjectOfSes(document).ready(function(e){
	var height = jqueryObjectOfSes('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', height+"px");
	  }
	});
	</script>
<?php endif; ?>
<?php  

if($header_fixed == '2'):

?>
<script>
	jqueryObjectOfSes(document).ready(function(e){
	var height = jqueryObjectOfSes('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', "0");
	  }
	});
	</script>
<?php endif; ?>
