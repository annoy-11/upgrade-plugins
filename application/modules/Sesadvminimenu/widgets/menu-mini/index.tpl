<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $showPopup = 1; //Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.popup.enable', 1);
$settings = Engine_Api::_()->getApi('settings', 'core');
$popShow = 1; //Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.popupshow', 1);
 
?>
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>

<?php //include 'login-or-signup.tpl'; ?>
<div id='core_menu_mini_menu'>
  <?php 
    // Reverse the navigation order (they are floating right)
    $count = count($this->navigation);
    foreach( $this->navigation->getPages() as $item ) $item->setOrder(--$count);
  ?>
    <ul class="sesadvminimenu_minimenu_links">
    <?php foreach( $this->navigation as $item ): $class = explode(' ', $item->class); ?>
      <?php if(end($class) == 'sesadvminimenu_mini_signup'):  ?>
        <?php if(empty($popShow)): ?>
		      <li class="sesadvminimenu_minimenu_link sesadvminimenu_minimenu_link_signup">
	          <?php //if($controllerName != 'signup'){ ?>
	            <a class="signup-link" href="signup" <?php if($controllerName == 'signup'): ?> style="display:none;" <?php endif; ?>>
	              <?php echo $this->translate($item->getLabel());?>
	            </a>
	          <?php //} ?>
	        </li>
	        <?php ?>
        <?php else: ?>
	        <li class="sesadvminimenu_minimenu_link sesadvminimenu_minimenu_link_signup">
	          <?php //if($controllerName != 'signup'){ ?>
	            <a id="popup-signup" data-effect="mfp-zoom-in" class="signup-link popup-with-move-anim" href="#user_signup_form" <?php if($controllerName == 'signup'): ?> style="display:none;" <?php endif; ?>>
	              <?php echo $this->translate($item->getLabel());?>
	            </a>
	          <?php //} ?>
	        </li>
        <?php endif; ?>
      <?php elseif(end($class) == 'sesadvminimenu_mini_auth' && $this->viewer->getIdentity() == 0):  ?>
        <?php if(empty($popShow)): ?>
	        <li class="sesadvminimenu_minimenu_link sesadvminimenu_minimenu_link_login">
	        <?php //if($controllerName != 'auth' && $actionName != 'login'){ ?>
	          <a class="auth-link" href="login" <?php if($controllerName == 'auth' && $actionName == 'login'): ?> style="display:none; <?php endif; ?>">
	            <?php echo $this->translate($item->getLabel()); ?>
	          </a>
	        <?php //} ?>
	        </li>
        <?php else: ?>
	        <li class="sesadvminimenu_minimenu_link sesadvminimenu_minimenu_link_login">
	        <?php //if($controllerName != 'auth' && $actionName != 'login'){ ?>
	          <a id="popup-login" data-effect="mfp-zoom-in" class="auth-link popup-with-move-anim" href="#small-dialog" <?php if($controllerName == 'auth' && $actionName == 'login'): ?> style="display:none; <?php endif; ?>">
	            <?php echo $this->translate($item->getLabel()); ?>
	          </a>
	        <?php //} ?>
	        </li>
        <?php endif;  ?>
        <?php elseif(end($class) == 'sesadvminimenu_mini_auth' && $this->viewer->getIdentity() != 0):?>
          <?php continue;?>
        <?php  elseif(end($class) == 'sesadvminimenu_mini_friends'): ?>
           <?php $friendRequestIcon = Engine_Api::_()->getApi('menus', 'sesadvminimenu')->getIconsMenu('sesadvminimenu_mini_friends'); ?>
           <?php if($this->viewer->getIdentity()):?>
            <li class="sesadvminimenu_minimenu_request sesadvminimenu_minimenu_icon" title="<?php echo $this->translate('Friends Invitation');?>">
              <?php if($this->requestCount):?>
                <span id="request_count_new" class="sesadvminimenu_minimenu_count"><?php echo $this->requestCount ?></span>
              <?php else:?>
                <span id="request_count_new"></span>
              <?php endif;?>
              <span onclick="toggleUpdatesPulldown(event, this, '4', 'friendrequest');" style="display:block;" class="friends_pulldown">
                <div id="friend_request" class="sesadvminimenu_pulldown_contents_wrapper">
                  <div class="sesadvminimenu_dropdown_caret"><span class="sesadvminimenu_caret_outer"></span><span class="sesadvminimenu_caret_inner"></span></div>
                  <div class="sesadvminimenu_pulldown_header">
                    <?php echo $this->translate('Requests'); ?>
                  </div>
                  <div id="sesadvminimenu_friend_request_content" class="sesadvminimenu_pulldown_contents">
                    <div class="pulldown_loading" id="friend_request_loading">
                      <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                    </div>
                  </div>
                </div>
                <?php if(empty($friendRequestIcon)):?>
                  <a href="javascript:void(0);" id="show_request">
                    <?php echo $this->translate('Friends Invitation');?>
                  </a>
                <?php else:?>
                  <a href="javascript:void(0);" id="show_request" style="background-image:url(<?php echo $this->storage->get($friendRequestIcon, '')->getPhotoUrl(); ?>);">
                    <?php echo $this->translate('Friends Invitation');?>
                  </a>
                <?php endif;?>
              </span>
            </li>
          <?php endif;?>
        <?php elseif(end($class) == 'sesadvminimenu_mini_notification'): ?>
        <?php $notificationIcon = Engine_Api::_()->getApi('menus', 'sesadvminimenu')->getIconsMenu('sesadvminimenu_mini_notification');?>
        <?php if($this->viewer->getIdentity()):?>
          <li id='sesadvminimenu_menu_mini_menu_update' class="sesadvminimenu_minimenu_updates sesadvminimenu_minimenu_icon" title="<?php echo $this->translate('Notifications');?>">
              <?php if($this->notificationCount):?>
                <span id="notification_count_new" class="sesadvminimenu_minimenu_count">
                  <?php echo $this->notificationCount ?>
                </span>
              <?php else:?>
                <span id="notification_count_new"></span>
              <?php endif;?>
            <span onclick="toggleUpdatesPulldown(event, this, '4', 'notifications');" style="display:block;" class="updates_pulldown">
              <div class="sesadvminimenu_pulldown_contents_wrapper">
                <div class="sesadvminimenu_dropdown_caret"><span class="sesadvminimenu_caret_outer"></span><span class="sesadvminimenu_caret_inner"></span></div>
                <div class="sesadvminimenu_pulldown_header">
                  <?php echo $this->translate('Notifications'); ?>
                </div>
                <div class="sesadvminimenu_pulldown_contents pulldown_content_list">
                  <ul class="notifications_menu" id="notifications_menu">
                    <div class="pulldown_loading" id="notifications_loading">
                      <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                    </div>
                  </ul>
                </div>
                <div class="sesadvminimenu_pulldown_options">
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'activity', 'controller' => 'notifications'),
                     $this->translate('View All Updates'),
                     array('id' => 'notifications_viewall_link')) ?>
                  <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Mark All Read'), array(
                    'id' => 'notifications_markread_link',
                  )) ?>
                </div>
              </div>
              <?php if(empty($notificationIcon)):?>
              <a href="javascript:void(0);" id="updates_toggle" <?php if( $this->notificationCount ):?> class="new_updates"<?php endif;?>>
              <span><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span>
              
              </a>
              <?php else:?>
                 <a href="javascript:void(0);" id="updates_toggle" <?php if( $this->notificationCount ):?> class="new_updates"<?php endif;?> style="background-image:url(<?php echo $this->storage->get($notificationIcon, '')->getPhotoUrl(); ?>);">
              <span><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span></a>
              <?php endif;?>
            </span>
          </li>
        <?php endif;?>
      <?php elseif(end($class) == 'sesadvminimenu_mini_profile'):?>
        <li class="sesadvminimenu_minimenu_profile" title="<?php echo $this->translate('My Profile');?>">
          <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($this->viewer(), 'thumb.icon')) ?>
        </li>
      <?php elseif(end($class) == 'sesadvminimenu_mini_settings'): ?>
        <?php $settingIcon = Engine_Api::_()->getApi('menus', 'sesadvminimenu')->getIconsMenu('sesadvminimenu_mini_settings');?>
        <li class="sesadvminimenu_minimenu_setting sesadvminimenu_minimenu_icon" title="<?php echo $this->translate('Settings');?>">
          <span onclick="toggleUpdatesPulldown(event, this, '4', 'settings');" style="display:block;" class="settings_pulldown">
            <div id="user_settings" class="sesadvminimenu_pulldown_contents_wrapper sm-mini-menu-settings-pulldown">
              <div class="sesadvminimenu_dropdown_caret"><span class="sesadvminimenu_caret_outer"></span><span class="sesadvminimenu_caret_inner"></span></div>
              
                <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesusercoverphoto')) { ?>
                  <?php 
                  $defaultCoverPhoto = Engine_Api::_()->authorization()->getPermission($this->viewer, 'sesusercoverphoto', 'defaultcoverphoto');
                  if($defaultCoverPhoto)
                    $defaultCoverPhoto = $defaultCoverPhoto;
                  else
                    $defaultCoverPhoto = 'application/modules/Sesusercoverphoto/externals/images/default_cover.jpg';
                  if(isset($this->viewer->cover) && $this->viewer->cover != 0 && $this->viewer->cover != '') { 
                    $memberCover =	Engine_Api::_()->storage()->get($this->viewer->cover, ''); 
                    if($memberCover)
                      $memberCover = $memberCover->map();
                  } else
                    $memberCover = $defaultCoverPhoto;        
                  ?>
                <?php } ?>
              
                <div class="sesadvminimenu_pulldown_header" <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesusercoverphoto')) { ?> style="background-image:url(<?php echo $memberCover; ?>);" <?php } ?>>
                <a href="<?php echo $this->viewer->getHref(); ?>"><span class="sesmaterial_username"><?php echo $this->viewer->getTitle(); ?></span></a>
                <!--<span class="sesmaterial_user_status">Registered User</span>-->
              </div>
              <div id="sesadvminimenu_user_settings_content" class="sesadvminimenu_pulldown_contents">
	              <?php echo $this->navigation()->menu()->setContainer($this->settingNavigation)->render();?>
								<?php $viewer = Engine_Api::_()->user()->getViewer();?>
                <?php if($viewer->getIdentity()) { ?>
                  <ul class="navigation">
                    <?php if($viewer->level_id == 1 || $viewer->level_id == 2):?>
                      <li>
                        <a href="<?php echo $this->url(array(), 'admin_default', true)?>"><?php echo $this->translate('Administrator');?></a>
                      </li>
                    <?php endif;?>
                    <li>
                      <a href="<?php echo $this->url(array(), 'user_logout', true)?>"><?php echo $this->translate('Logout');?></a>
                    </li>
                  </ul>
                 <?php } ?>
              </div>
            </div>
            <?php if(empty($settingIcon)):?>
              <a href="javascript:void(0);" id="show_settings">
              <?php echo $this->translate($item->getLabel());?>
              </a>
            <?php else:?>
            
              <a href="javascript:void(0);" id="show_settings" style="background-image:url(<?php echo $this->storage->get($settingIcon, '')->getPhotoUrl(); ?>);">
              <?php echo $this->translate($item->getLabel());?>
              </a>
            <?php endif;?>
          </span>
        </li>
      <?php elseif(end($class) == 'sesadvminimenu_mini_messages'):  ?>
        <?php $messageIcon = Engine_Api::_()->getApi('menus', 'sesadvminimenu')->getIconsMenu('sesadvminimenu_mini_messages');?>
        <li class="sesadvminimenu_minimenu_message sesadvminimenu_minimenu_icon" title="<?php echo $this->translate('Messages');?>">
          <?php if($this->messageCount):?>
            <span id="message_count_new" class="sesadvminimenu_minimenu_count"><?php echo $this->messageCount ?></span>
          <?php else:?>
            <span id="message_count_new"></span>
          <?php endif;?>
          <span onclick="toggleUpdatesPulldown(event, this, '4', 'message');" style="display:block;" class="messages_pulldown">
            <div id="sesadvminimenu_user_messages" class="sesadvminimenu_pulldown_contents_wrapper sm-mini-menu-messages-pulldown">
              <div class="sesadvminimenu_dropdown_caret"><span class="sesadvminimenu_caret_outer"></span><span class="sesadvminimenu_caret_inner"></span></div>
              <div class="sesadvminimenu_pulldown_header">
                <?php echo $this->translate('Messages'); ?>
                <a class="icon_message_new righticon fa fa-plus-square-o" title="<?php echo $this->translate('Compose New Message'); ?>" href="<?php echo $this->url(array('action' => 'compose'), 'messages_general') ?>"></a>
              </div>
              <div id="sesadvminimenu_user_messages_content" class="sesadvminimenu_pulldown_contents">
                <div class="pulldown_loading">
                  <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                </div>
              </div>
            </div>
            <?php if(empty($messageIcon)):?>
              <a href="javascript:void(0);" id="show_message">
              <?php echo $this->translate($item->getLabel());?>
              </a>
            <?php else:?>
              <a href="javascript:void(0);" id="show_message" style="background-image:url(<?php echo $this->storage->get($messageIcon, '')->getPhotoUrl(); ?>);">
              <?php echo $this->translate($item->getLabel());?>
              </a>
            <?php endif;?>
          </span>
        </li>
      <?php elseif(end($class) == 'sesadvminimenu_mini_admin'): ?>
        <?php continue;?>
      <?php else:?>
        <li class="sesadvminimenu_minimenu_link">
          <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), array_filter(array(
          'class' => ( !empty($item->class) ? $item->class : null ),
          'alt' => ( !empty($item->alt) ? $item->alt : null ),
          'target' => ( !empty($item->target) ? $item->target : null ),
          ))) ?>
        </li>
      <?php endif;?>
    <?php endforeach; ?>
  </ul>
</div>

<script type='text/javascript'>

var notificationUpdater;
en4.core.runonce.add(function(){

  if($('notifications_markread_link')){
    $('notifications_markread_link').addEvent('click', function() {
      //$('notifications_markread').setStyle('display', 'none');
      $('notification_count_new').setStyle('display', 'none');
      hideNotificationsSes('<?php echo $this->string()->escapeJavascript($this->translate("0 Updates"));?>');
    });
  }
  
  function hideNotificationsSes(reset_text){
  (new Request.JSON({
    'url' : en4.core.baseUrl + 'sesadvminimenu/notifications/hide'
  })).send();
  $('updates_toggle').set('html', reset_text).removeClass('new_updates');

  /*
  var notify_link = $('sesadvminimenu_menu_mini_menu_updates_count').clone();
  $('new_notification').destroy();
  notify_link.setAttribute('id', 'sesadvminimenu_menu_mini_menu_updates_count');
  notify_link.innerHTML = "0 updates";
  notify_link.inject($('sesadvminimenu_menu_mini_menu_updates'));
  $('sesadvminimenu_menu_mini_menu_updates').setAttribute('id', '');
  */
  if($('notifications_main')){
    var notification_children = $('notifications_main').getChildren('li');
    notification_children.each(function(el){
        el.setAttribute('class', '');
    });
  }

  if($('notifications_menu')){
    var notification_children = $('notifications_menu').getChildren('li');
    notification_children.each(function(el){
        el.setAttribute('class', '');
    });
  }
  //$('sesadvminimenu_menu_mini_menu_updates').setStyle('display', 'none');
  
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

  if(event.target.className == 'sesadvminimenu_pulldown_header')
  return;
 
  var hideNotification = 0;
  var hideMessage = 0;
  var hideSettings = 0;
  var hideFriendRequests = 0;
  if($$(".updates_pulldown_active").length > 0) {
    $$('.updates_pulldown_active').set('class', 'updates_pulldown');
    var hideNotification = 1;
  }

  if($$(".messages_pulldown_active").length > 0) {
    $$('.messages_pulldown_active').set('class', 'messages_pulldown');
    hideMessage = 1;
  }
  
  if($$(".settings_pulldown_active").length > 0) {
    $$('.settings_pulldown_active').set('class', 'settings_pulldown');
    hideSettings = 1;
  }
  
  if($$(".friends_pulldown_active").length > 0) {
    $$('.friends_pulldown_active').set('class', 'friends_pulldown');
    hideFriendRequests = 1;
  }
 
  if(menu == 'notifications' && hideNotification == 0) {
    
    if( element.className=='updates_pulldown') {
      element.className= 'updates_pulldown_active';
      showNotifications();
    } 
    else
      element.className='updates_pulldown';
  }
  else if(menu == 'message' && hideMessage == 0) {
    if( element.className=='messages_pulldown' ) {
      element.className= 'messages_pulldown_active';
      showMessages();
    } 
    else {
      element.className='messages_pulldown';
    }
  }
  else if(menu == 'settings' && hideSettings == 0) {
    if( element.className=='settings_pulldown' ) {
      element.className= 'settings_pulldown_active';
      document.getElementById('sesadvminimenu_user_settings_content').style.display = 'block';
    } 
    else {
      element.className='settings_pulldown';
    }
  }
  else if(menu == 'friendrequest' && hideFriendRequests == 0) {
    if( element.className=='friends_pulldown' ) {
      element.className= 'friends_pulldown_active';
      showFriendRequests();
    } 
    else {
      element.className='friends_pulldown';
    }
  }
  previousMenu = menu;
}

var showNotifications = function() {

  en4.activity.updateNotifications();
  abortRequest = new Request.HTML({
    'url' : en4.core.baseUrl + 'sesadvminimenu/notifications/pulldown',
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
          if( notification_li.id == 'sesadvminimenu_menu_mini_menu_update' ) {
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
      document.getElementById('notification_count_new').removeClass('sesadvminimenu_minimenu_count');
    }
  });  
  en4.core.request.send(abortRequest, {
    'force': true
  });
}

function showSettings() {

  abortRequest = new Request.HTML({
    url : en4.core.baseUrl + 'sesadvminimenu/index/general-setting',
    data : {
      format : 'html'
    },
    onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
    {
     document.getElementById('sesadvminimenu_user_settings_content').innerHTML = responseHTML;
    }
  });
  en4.core.request.send(abortRequest, {
    'force': true
  });
}

function showMessages() {

  abortRequest = new Request.HTML({
    url : en4.core.baseUrl + 'sesadvminimenu/index/inbox',
    data : {
      format : 'html'
    },
    onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
    {
     document.getElementById('sesadvminimenu_user_messages_content').innerHTML = responseHTML;
     document.getElementById('message_count_new').innerHTML = '';
     document.getElementById('message_count_new').removeClass('sesadvminimenu_minimenu_count');
    }
  }); 
  en4.core.request.send(abortRequest, {
    'force': true
  });
}

function showFriendRequests() {

  abortRequest = new Request.HTML({
    url : en4.core.baseUrl + 'sesadvminimenu/index/friendship-requests',
    data : {
      format : 'html'
    },
    onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
    {
     if(responseHTML) {
       document.getElementById('sesadvminimenu_friend_request_content').innerHTML = responseHTML;
       document.getElementById('request_count_new').innerHTML = '';
       document.getElementById('request_count_new').removeClass('sesadvminimenu_minimenu_count');
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
  $(document.body).addEvent('click', function(event){
    if(event.target.id != 'show_message' && event.target.id != 'show_request' && event.target.id != 'updates_toggle' &&  event.target.id != 'show_settings' && event.target.className != 'sesadvminimenu_pulldown_header' && event.target.className != 'pulldown_loading') {
      if($$(".updates_pulldown_active").length > 0)
      $$('.updates_pulldown_active').set('class', 'updates_pulldown');

      if($$(".messages_pulldown_active").length > 0)
      $$('.messages_pulldown_active').set('class', 'messages_pulldown');

      if($$(".settings_pulldown_active").length > 0)
      $$('.settings_pulldown_active').set('class', 'settings_pulldown');
    
      if($$(".friends_pulldown_active").length > 0)
      $$('.friends_pulldown_active').set('class', 'friends_pulldown');  
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
    url : en4.core.baseUrl + 'sesadvminimenu/index/new-friend-requests',
    method : 'POST',
    data : {
      format : 'json'
    },
    onSuccess : function(responseJSON) 
    {
      if( responseJSON.requestCount && $("request_count_new") ) {
        $('updates_toggle').addClass('new_updates');
        $("request_count_new").style.display = 'block';
        if(responseJSON.requestCount > 0 && responseJSON.requestCount != '')
          $("request_count_new").addClass('sesadvminimenu_minimenu_count');
        $("request_count_new").innerHTML = responseJSON.requestCount;
        
      }
    }
  }));
}
function newUpdates() {
  en4.core.request.send(new Request.JSON({
    url : en4.core.baseUrl + 'sesadvminimenu/index/new-updates',
    method : 'POST',
    data : {
      format : 'json'
    },
    onSuccess : function(responseJSON) 
    {
      if( responseJSON.notificationCount && $("notification_count_new") ) {
        $('updates_toggle').addClass('new_updates');
        $("notification_count_new").style.display = 'block';
        $("notification_count_new").innerHTML = responseJSON.notificationCount;
			  if(responseJSON.notificationCount > 0 && responseJSON.notificationCount != '')
        	$("notification_count_new").addClass('sesadvminimenu_minimenu_count');
      }
    }
  }));
}  
function newMessages() {
  en4.core.request.send(new Request.JSON({
    url : en4.core.baseUrl + 'sesadvminimenu/index/new-messages',
    method : 'POST',
    data : {
      format : 'json'
    },
    onSuccess : function(responseJSON) 
    {
      if( responseJSON.messageCount && $("message_count_new") ) {
        $('updates_toggle').addClass('new_updates');
        $("message_count_new").style.display = 'block';
        if(responseJSON.messageCount > 0 && responseJSON.messageCount != '')
        $("message_count_new").addClass('sesadvminimenu_minimenu_count');
        $("message_count_new").innerHTML = responseJSON.messageCount;
      }
    }
  }));
}
</script>