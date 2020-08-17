<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: index.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<div class="epetition-recent"></div>  <!-- Here update recent signature code by ajax -->
<script>
    sesJqueryObject(document).ready(function () {
        updaterecent(1);
    });
    window.setInterval(function(){
        updaterecent(2);
    }, <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.notificationupdate');  ?>);
  function updaterecent(type)
  {
      var url=en4.core.baseUrl+"epetition/index/ajaxcallforrecent";
      sesJqueryObject.ajax({
          url: url,
          type: "POST",
          data: {id : '<?php echo $this->epetition_id;  ?>'},
          dataType: "json",
          success: function(html){
              if(html['status'])
              {
                 for(var i=0;i<parseInt(html['length']); i++)
                 {
                   if(type==1)
                   {
                     sesJqueryObject(".epetition-recent").append('<div class="'+i+'" id='+html[i]['id']+'><div class="epetition-sign-recent-image">'+html[i]['profile_photo']+' </div><div class="epetition-sign-recent-name">'+html[i]['name']+' is signed '+html[i]['create_date']+' </div></div>').show('slow');
                   }
                   else if(type==2)
                   {
                       var getid=sesJqueryObject("."+i).attr('id');
                       if(parseInt(getid)!=parseInt(html[i]['id']))
                       {
                           if(parseInt(sesJqueryObject("."+i).length)>0)
                           {
                               sesJqueryObject("." + i).hide('slow').remove();
                           }
                           sesJqueryObject(".epetition-recent").append('<div class="'+i+'" id='+html[i]['id']+'><div class="epetition-sign-recent-image">'+html[i]['profile_photo']+' </div><div class="epetition-sign-recent-name">'+html[i]['name']+' is signed '+html[i]['create_date']+' </div></div>').show('slow');
                       }
                   }
                 }
              }
          }
      });
  }
</script>