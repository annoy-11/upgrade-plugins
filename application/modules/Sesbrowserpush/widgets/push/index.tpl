<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesbrowserpush
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<style>
#iframe_sesbrowserpush_notification{display:none;}
</style>
<?php echo $this->script; ?>
<script type="application/javascript">
function checkBrowser(){
  var status = false;
  if (navigator.userAgent.search("Chrome") >= 0 && navigator.userAgent.search("OPR") < 0){
      // For some reason in the browser identification Chrome contains the word "Safari" so when detecting for Safari you need to include Not Chrome
      var position = navigator.userAgent.search("Chrome") + 7;
      var end = navigator.userAgent.search(" Safari");
      var version = navigator.userAgent.substring(position,end);
      if(version.search('.') >= 0){
        version = version.split('.');
        version = version[0];
      }
      var BrowserName = 'Chrome';
      if(version >= 42)
        status = true;
  }else if (navigator.userAgent.search("Firefox") >= 0){
      var position = navigator.userAgent.search("Firefox") + 8;
      var version = navigator.userAgent.substring(position);
      if(version.search('.') >= 0){
        version = version.split('.');
        version = version[0];
      }
      var BrowserName = 'Firefox';
      if(version >= 44)
        status = true;
  }else if (navigator.userAgent.search("OPR") >= 0){
      var position = navigator.userAgent.search("Version") + 8;
      var version = navigator.userAgent.substring(position);
      if(version.search('.') >= 0){
        version = version.split('.');
        version = version[0];
      }
      var BrowserName = 'Opera';
      if(version >= 42)
        status = true;
  }else
    return ['','',status];  
  
    return [BrowserName,version,status];
}
</script>
<?php if(!$this->siteSSL){ ?>
<script type="application/javascript">
window.addEvent('load',function(){
  var checkBrowserSe = encodeURI(checkBrowser());
   var appKey = encodeURI(config.apiKey);
   var authDomain = encodeURI(config.authDomain);
   var databaseURL = encodeURI(config.databaseURL);
   var storageBucket = encodeURI(config.storageBucket);
   var messagingSenderId = config.messagingSenderId;
});
 window.addEventListener('message', function (event) {
   try{
   var data = JSON.parse(event.data);
   if(typeof data.status == 'undefined' && typeof data.token == 'undefined')
    return;
   }catch(err) {
     return;  
   }
   if(typeof data.token == 'undefined' && data.status == 1){
    var appKey = encodeURI(config.apiKey);
    var authDomain = encodeURI(config.authDomain);
    var databaseURL = encodeURI(config.databaseURL);
    var storageBucket = encodeURI(config.storageBucket);
    var messagingSenderId = config.messagingSenderId;
    var url = "https://push.notifyupdates.com/token.php?apikey="+appKey+'&authDomain='+authDomain+'&databaseURL='+databaseURL+'&storageBucket='+storageBucket+'&messagingSenderId='+messagingSenderId;
    var x = screen.width/2 - 300/2;
    var y = screen.height/2 - 200/2;
     window.open(url,'_blank', 'toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,left='+x+', top='+y+', width=400, height=400, visible=none', ''); 
     return;
   }else if(typeof data.token == 'undefined' && data.status == 2){
     var token = (window.localStorage.getItem('sitesubscriber'));
     if(token){
        updateNotification(token);
     }
   }else if(typeof data.token != 'undefined'){
     window.localStorage.setItem('sitesubscriber', data.token);
     updateNotification(data.token);
   }
 });
function updateNotification(token){
  var browser = checkBrowser();
  sesJqueryObject.post(en4.core.baseUrl+'sesbrowserpush/index/update/',{token:token,browser:browser[0]},function(result){
    if(result){
      //console.log('User Subscribed Successfully');  
    }else{
      //console.log('Error While Subscribing User'); 
    }
   });  
}
</script>
<?php }else{ ?>
<link rel="manifest" href="/manifest.json">
<script type="application/javascript">
  var browserDays = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbrowserpush.days', 5); ?>';
  var browser_ispopup=getCookieBrowserPush('browser_ispopup');
  sesJqueryObject (document).ready(function(){
    if (Notification.permission === "granted") {
      //sesJqueryObject('#sesbrowserpush_tip').hide();
      if('<?php echo $this->bellalways; ?>' == '0') {
        sesJqueryObject('#browserpush_bell').hide();
      }
      
      if(sesJqueryObject('#subscribe_browertip')) {
        sesJqueryObject('#subscribe_browertip').html('Click to Unsubscribe');
      }
    } else {
      sesJqueryObject('#sesbrowserpush_tip').show();
      if(sesJqueryObject('#sesbrowsepush_browser_permission_container'))
      sesJqueryObject('#sesbrowsepush_browser_permission_container').hide();
      if(sesJqueryObject('#sesbrowsepush_browser_permission_box'))
      sesJqueryObject('#sesbrowsepush_browser_permission_box').hide();
    }
    if(browser_ispopup != '' && browserDays == '0') {
      setCookie('browser_ispopup','',0);
    }
    if(browser_ispopup != '') {
      sesJqueryObject('#sesbrowserpush_tip').hide();
    }

  });
 
  const messaging = firebase.messaging();
  // Callback fired if Instance ID token is updated.
  messaging.onTokenRefresh(function() {
    var status = 2;
    messageNotification(status,'*');
  });
  messaging.onMessage(function(payload) {

    var payload = payload.data;
    
    messaging.getToken().then(function (currentToken) {
      if (currentToken) {
        {
        console.log(payload, currentToken);
        sesJqueryObject.post(en4.core.baseUrl+'sesbrowserpush/index/notifications/',{scheduled_id:payload.scheduled_id,token:currentToken,param:'1'},function(result){
          if(result) {
            //console.log('User Subscribed Successfully');  
          }else{
            //console.log('Error While Subscribing User'); 
          }
        });  
        }
      }
    }).then(function () {
    }).catch(function (err) {
        console.log(err);
    });
    
    const notificationTitle = payload.title;
    const notificationOptions = {
      body: payload.body,
      icon: payload.icon
    };
    var notification = new Notification(notificationTitle, notificationOptions);
    if(payload.click_action != '') {
      notification.addEventListener("click", function (event) {
      console.log(payload, '12');
      
      messaging.getToken().then(function (currentToken) {
        if (currentToken) {
          {
          console.log(payload, currentToken);
          sesJqueryObject.post(en4.core.baseUrl+'sesbrowserpush/index/notifications/',{scheduled_id:payload.scheduled_id,token:currentToken,param:'2'},function(result){
            if(result) {
              //console.log('User Subscribed Successfully');  
            }else{
              //console.log('Error While Subscribing User'); 
            }
          });  
          }
        }
      }).then(function () {
      }).catch(function (err) {
          console.log(err);
      });
        
        window.open(payload.click_action);
      }, false);
    }
  });
  
  sesJqueryObject(window).load(function(){
    <?php if($this->type == '0') { ?>
      requestPermission();  
    <?php } ?>
    <?php if($this->type == '1') { ?>
      if(browser_ispopup == '') {
      requestPermission();
      }
      sesJqueryObject ('.hide_push_popup').hide();
    <?php } ?>
  });
  
  function requestPermission() {
    //if already subscribed
    if (Notification.permission === "granted") {
        var status = 2;
        messageNotification(status,'*');
        return;
    } else if(Notification.permission == 'default') {
      if(sesJqueryObject('#sesbrowsepush_browser_permission_container'))
        sesJqueryObject('#sesbrowsepush_browser_permission_container').show();
      if(sesJqueryObject('#sesbrowsepush_browser_permission_box'))
        sesJqueryObject('#sesbrowsepush_browser_permission_box').show();
      if(sesJqueryObject('#sesbrowserpush_notification_bubble'))
        sesJqueryObject('#sesbrowserpush_notification_bubble').hide();
    }
    
    Notification.requestPermission(function (state) {

      if(state == 'default') {
        if(sesJqueryObject('#sesbrowsepush_browser_permission_container'))
        sesJqueryObject('#sesbrowsepush_browser_permission_container').hide();
        if(sesJqueryObject('#sesbrowsepush_browser_permission_box'))
        sesJqueryObject('#sesbrowsepush_browser_permission_box').hide();
        if(sesJqueryObject('#sesbrowserpush_notification_bubble'))
          sesJqueryObject('#sesbrowserpush_notification_bubble').hide();
      } else if(state == 'granted') {
        if(sesJqueryObject('#sesbrowsepush_browser_permission_container'))
        sesJqueryObject('#sesbrowsepush_browser_permission_container').hide();
        if(sesJqueryObject('#sesbrowsepush_browser_permission_box'))
        sesJqueryObject('#sesbrowsepush_browser_permission_box').hide();
        
        if(sesJqueryObject('#subscribe_browertip')) {
          sesJqueryObject('#subscribe_browertip').html('Click to Unsubscribe');
          sesJqueryObject('#sesbrowserpush_tip').removeClass('showpulldown');
          sesJqueryObject('#browserpush_bell').attr('data-active', '0');
        }
      } else if(state == 'denied') {
        if(sesJqueryObject('#sesbrowsepush_browser_permission_container'))
          sesJqueryObject('#sesbrowsepush_browser_permission_container').hide();
        if(sesJqueryObject('#sesbrowsepush_browser_permission_box'))
          sesJqueryObject('#sesbrowsepush_browser_permission_box').hide();
      }
      // call message event handler of parent window
      var status = 1;
      messageNotification(status,'*');
    });
  }
  function messageNotification(status,token){
    messaging.getToken().then(function (currentToken) {
        if (currentToken) {
          {
              window.localStorage.setItem('sitesubscriber', currentToken);
              updateNotification(currentToken);
          }
        }
    }).then(function () {
    }).catch(function (err) {
        console.log(err);
    });
 };
function updateNotification(token){
  var browser = checkBrowser();
  sesJqueryObject.post(en4.core.baseUrl+'sesbrowserpush/index/update/',{token:token,browser:browser[0]},function(result){
    if(result){
      //console.log('User Subscribed Successfully');  
    }else{
      //console.log('Error While Subscribing User'); 
    }
   });  
}
</script>
<?php } ?>
