<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesemailverification
 * @package    Sesemailverification
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php 
$settings = Engine_Api::_()->getApi('settings', 'core');
$tipbgcolor = $settings->getSetting('sesemailverification.tipbgcolor', '#fe2e26');
$tipfontcolor = $settings->getSetting('sesemailverification.tipfontcolor','#fff');
?>
<div class="sesemailverification_tip" id="sesemail_tip">
  <?php $url = 'sesemailverification/index/resend/token/'.$this->token; ?>
  <?php echo $this->translate($this->tipmessage, '<a href="'.$url.'">'.$this->translate($this->tipmessage1).'</a>'); ?> 
  
  <!--<a href="<?php //echo $this->url(array('module' => 'sesemailverification', 'controller' => 'index', 'action' => 'resend', 'token'=> $this->token), 'default', true); ?>"><?php //echo $this->translate($this->tipmessage1); ?></a>-->
  
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.show', 1)) { ?>
    <a href="javascript:void(0);" class="sesemailverification_tip_close fa fa-times" onclick="sesemailverificationTipHide();" id="sesemailverification_tip" title="<?php echo $this->translate("Close"); ?>"></a>
  <?php } ?>
</div>
<style type="text/css">
	.sesemailverification_tip{background-color:<?php echo $tipbgcolor ?>;color:<?php echo $tipfontcolor ?>;}
	.sesemailverification_tip a{color:<?php echo $tipfontcolor ?>;}
</style>
<script>

  sesJqueryObject(document).ready(function() {
    if(document.getElementById("sesemail_tip")) {
      var elmnt = document.getElementById("sesemail_tip");
    }
  });

  var sesemailShow = getCookieEmail('is_emailverfication');
  if(sesemailShow == '') {
    sesJqueryObject(document).ready(function() {
      sesJqueryObject('#sesemail_tip').show();
    });
  } else {
    sesJqueryObject(document).ready(function() {
      sesJqueryObject('#sesemail_tip').hide();
      
    });
  }
  
  function sesemailverificationTipHide() {
    sesJqueryObject('#sesemail_tip').hide();
    var day = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesemailverification.day', 5);?>';
    //sesJqueryObject('html').removeClass('pagefixed');
    if(day != 0) {
      setCookieEmail("is_emailverfication",'emailveri',day);
    }
  }
  
  // cookie get and set function
  function setCookieEmail(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    //document.cookie = cname + "=" + cvalue + "; " + expires;
    document.cookie = cname + "=" + cvalue + "; " + expires+"; path=/"; 
  }
  
  function getCookieEmail(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
  }
</script>
