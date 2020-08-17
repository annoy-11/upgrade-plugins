<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php 
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesadvancedheader/externals/styles/styles.css');
  
  $settings = Engine_Api::_()->getApi('settings', 'core');
  
  $request = Zend_Controller_Front::getInstance()->getRequest();
  $controllerName = $request->getControllerName();
  $actionName = $request->getActionName();
  
  include("headers/header".$this->headerdesign.".php");
?>
<?php if(in_array('search',$this->header_options)) { ?>
  <?php 
    $searchText = "";
    if(!empty($_GET['query']) && $actionName == "index" && $controllerName == "search")
      $searchText = $_GET['query'];
  ?>
<?php } ?>

<?php if($this->sesadvancedheader_header_fixed) { ?>
  <style>
    .header_fixed_scroll .header_background_opacity {
      opacity:<?php echo $this->sesadvancedheader_header_opacity; ?>;
      background-color:#<?php  echo $this->sesadvancedheader_header_bgcolor; ?>;
      color:#<?php  echo $this->sesadvancedheader_header_textcolor; ?>;
    }
  </style>
<?php } ?>

<script>

  <?php if($this->sesadvancedheader_minimenu_transparent){ ?>
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('minimenu_transparent');
  <?php } ?>
  var sesAdvancedHeaderHeightDefault = sesJqueryObject('.advance_header_main').height();
  
  <?php if($this->sesadvancedheader_header_fixed) { ?>
 // en4.core.runonce.add(function() {
      var htmlElement = document.getElementsByTagName("body")[0];
      htmlElement.addClass('header_fixed_outside');
      sesJqueryObject(window).scroll(function(){
        if(sesJqueryObject('.sesadvancedheader_banner_container_wrapper').height() > 0){
          var aTop = sesJqueryObject('.sesadvancedheader_banner_container_wrapper').height() - sesAdvancedHeaderHeightDefault;
        }else if(sesJqueryObject('.sesadvancedbanner_banner_container_wrapper').height() > 0){
          var aTop = sesJqueryObject('.sesadvancedbanner_banner_container_wrapper').height() - sesAdvancedHeaderHeightDefault;
        }else{
          var aTop = sesAdvancedHeaderHeightDefault;
        }
        if(sesJqueryObject(this).scrollTop() > 100){
            var htmlElement = document.getElementsByTagName("body")[0];
            htmlElement.addClass('header_fixed_scroll');
        } else {
            var htmlElement = document.getElementsByTagName("body")[0];
            htmlElement.removeClass('header_fixed_scroll');  
        }
      });
      //header_fixed_scroll
 // });
  <?php } ?>

  function showSearch() {
    if($('show_sesadvheader_search').style.display == 'block') {
      $('show_sesadvheader_search').style.display = 'none';
    }else {
      $('show_sesadvheader_search').style.display = 'block';
    }
  }
	
  function showSearch() {
    if($('header_searchbox').style.display == 'block') {
      $('header_searchbox').style.display = 'none';
    }
    else {
      $('header_searchbox').style.display = 'block';
    }
  }
	
  var notificationUpdater;
  en4.core.runonce.add(function() {
    if($('notifications_markread_link')) {
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
    if(event.target.className == 'sesadvheader_pulldown_header')
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
      
      if(element.className=='updates_pulldown') {
        element.className= 'updates_pulldown_active';
        showNotifications();
      } else
        element.className='updates_pulldown';
    }
    else if(menu == 'message' && hideMessage == 0) {
      if( element.className=='messages_pulldown' ) {
        element.className= 'messages_pulldown_active';
        showMessages();
      } else {
        element.className='messages_pulldown';
      }
    }
    else if(menu == 'settings' && hideSettings == 0) {

      if( element.className=='settings_pulldown' ) {
        element.className = 'settings_pulldown_active';
      } else {
        element.className='settings_pulldown';
      }
    }
    else if(menu == 'friendrequest' && hideFriendRequests == 0) {
      if( element.className=='friends_pulldown' ) {
        element.className= 'friends_pulldown_active';
        showFriendRequests();
      } else {
        element.className='friends_pulldown';
      }
    }
    previousMenu = menu;
  }
  var showNotifications = function() {
    en4.activity.updateNotifications();
    abortRequest = new Request.HTML({
      'url' : en4.core.baseUrl + 'sesadvancedheader/notifications/pulldown',
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
        document.getElementById('notification_count_new').removeClass('sesadvheader_minimenu_count');
      }
    });
    en4.core.request.send(abortRequest, {
      'force': true
    });
  }

  function showMessages() {

    abortRequest = new Request.HTML({
      url : en4.core.baseUrl + 'sesadvancedheader/index/inbox',
      data : {
        format : 'html'
      },
      onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
      {
       document.getElementById('sesadvheader_user_messages_content').innerHTML = responseHTML;
       document.getElementById('message_count_new').innerHTML = '';
       document.getElementById('message_count_new').removeClass('sesadvheader_minimenu_count');
      }
    }); 
    en4.core.request.send(abortRequest, {
    'force': true
    });
  }

  function showFriendRequests() {

    abortRequest = new Request.HTML({
      url : en4.core.baseUrl + 'sesadvancedheader/index/friendship-requests',
      data : {
        format : 'html'
      },
      onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
      {
       if(responseHTML) {
         document.getElementById('sesadvheader_friend_request_content').innerHTML = responseHTML;
         document.getElementById('request_count_new').innerHTML = '';
         document.getElementById('request_count_new').removeClass('sesadvheader_minimenu_count');
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
<?php //if(!empty($this->disableheader)) { ?>
// sesJqueryObject(document).ready(function(){
//     sesJqueryObject("body").addClass("global_header_hidden");
// }); 
<?php //} ?>
</script>
