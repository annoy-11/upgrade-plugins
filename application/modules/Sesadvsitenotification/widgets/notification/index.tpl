<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<script type="text/javascript">
 function notificationActionSes(msg,title,click_action,icon,iconImage,firstTitle,lightbox_type,getImageHref,imageSource){
  var shortCutFunction ='success';
  toastr.options = {
      closeButton: true,
      debug:false,
      newestOnTop:true,
      rtl:false,
      positionClass:'<?php echo $this->position; ?>',
      preventDuplicates:false,
      onclick: null
  };
  //click event
  toastr.options.onclick = function () {
    if(lightbox_type == 'video'){
     getRequestedVideoForImageViewer(imageSource,getImageHref);
    }else if(lightbox_type == 'photo'){
      getRequestedAlbumPhotoForImageViewer(imageSource,getImageHref);  
    }else{
     window.location.href = click_action;
    }
  };
  //close btn click
  toastr.options.onCloseClick = function () {
    //silence
  };
<?php if($this->autohide){
    $duration = $this->autohideduration; 
  }else
    $duration = 0;
 ?>
  toastr.options.timeOut =  parseInt(<?php echo $duration; ?>);
  var $toast = toastr[shortCutFunction](msg, title,icon,iconImage,firstTitle);
}
var notification_id_sesbrowser = 0;
setInterval(getNotificationData,5000);
  var currentRequestSesnotification = null; 
function getNotificationData(){
  currentRequestSesnotification = sesJqueryObject.ajax({
    type: 'POST',
    data: "notification_id="+notification_id_sesbrowser,
    url: 'sesadvsitenotification/index/notification',
    beforeSend : function()    {           
      if(currentRequestSesnotification != null) {
        currentRequestSesnotification.abort();
      }
    },
    success: function(response) {
      response = sesJqueryObject.parseJSON(response);
      notification_id_sesbrowser = response.notification_id;      
      notification = response.notifications;
      if(notification.length){
        for(var i=0;i<notification.length;i++){
          var msg = notification[i].body;
          var title = notification[i].title;
          var click_action  = notification[i].click_action;
          var image = notification[i].icon;
          var iconImage = notification[i].type;
          var firstTitle = notification[i].parentNodeValue;
          var lightbox_type = notification[i].lightbox_type;
          var getImageHref = notification[i].getImageHref;
          var imageSource = notification[i].imageSource;
          notificationActionSes(msg,title,click_action,image,iconImage,firstTitle,lightbox_type,getImageHref,imageSource);
        }
      }
    },
    error:function(e){
      // Error
    }
});
  
}
</script>