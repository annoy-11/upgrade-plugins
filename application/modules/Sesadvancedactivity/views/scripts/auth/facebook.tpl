<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedactivity
 * @package    Sesadvancedactivity
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: facebook.tpl  2017-01-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<style>
body{ display:none !important;}
</style>
<script type="application/javascript">
<?php if($this->success){ ?>
  sesJqueryObject(document).ready(function(){
    window.opener.$('compose-facebook-form-input').set('checked', !window.opener.$('compose-facebook-form-input').get('checked'));
    window.opener.sesJqueryObject('.composer_facebook_toggle').removeClass('openWindowFacebook');
    window.opener.sesJqueryObject('.composer_facebook_toggle').addClass('composer_facebook_toggle_active');});
    setTimeout(function(){
       window.close();
    }, 300);
<?php }else{ ?>
  window.close();
<?php } ?>
</script>