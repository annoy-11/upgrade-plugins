<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdating	
 * @package    Sesdating
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-settings.tpl  2018-09-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesdating/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form dating_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

window.addEvent('domready', function() {
  socialmedialinks("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdating.socialenable', 1); ?>");
});

function socialmedialinks(value){
  if(value == 1){
    if($('sesdating_facebookurl-wrapper'))
      $('sesdating_facebookurl-wrapper').style.display = 'block';
    if($('sesdating_googleplusurl-wrapper'))
      $('sesdating_googleplusurl-wrapper').style.display = 'block';
    if($('sesdating_twitterurl-wrapper'))
      $('sesdating_twitterurl-wrapper').style.display = 'block';
    if($('sesdating_pinteresturl-wrapper'))
      $('sesdating_pinteresturl-wrapper').style.display = 'block';
  } else {
    if($('sesdating_facebookurl-wrapper'))
      $('sesdating_facebookurl-wrapper').style.display = 'none';
    if($('sesdating_googleplusurl-wrapper'))
      $('sesdating_googleplusurl-wrapper').style.display = 'none';
    if($('sesdating_twitterurl-wrapper'))
      $('sesdating_twitterurl-wrapper').style.display = 'none';
    if($('sesdating_pinteresturl-wrapper'))
      $('sesdating_pinteresturl-wrapper').style.display = 'none';
  }
}
</script>
