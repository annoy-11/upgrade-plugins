<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-settings.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesariana/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form ariana_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

window.addEvent('domready', function() {
  socialmedialinks("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.socialenable', 1); ?>");
});

function socialmedialinks(value){
  if(value == 1){
    if($('sesariana_facebookurl-wrapper'))
      $('sesariana_facebookurl-wrapper').style.display = 'block';
    if($('sesariana_googleplusurl-wrapper'))
      $('sesariana_googleplusurl-wrapper').style.display = 'block';
    if($('sesariana_twitterurl-wrapper'))
      $('sesariana_twitterurl-wrapper').style.display = 'block';
    if($('sesariana_pinteresturl-wrapper'))
      $('sesariana_pinteresturl-wrapper').style.display = 'block';
  } else {
    if($('sesariana_facebookurl-wrapper'))
      $('sesariana_facebookurl-wrapper').style.display = 'none';
    if($('sesariana_googleplusurl-wrapper'))
      $('sesariana_googleplusurl-wrapper').style.display = 'none';
    if($('sesariana_twitterurl-wrapper'))
      $('sesariana_twitterurl-wrapper').style.display = 'none';
    if($('sesariana_pinteresturl-wrapper'))
      $('sesariana_pinteresturl-wrapper').style.display = 'none';
  }
}
</script>