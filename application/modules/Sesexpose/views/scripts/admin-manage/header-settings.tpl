<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-settings.tpl 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesexpose/views/scripts/dismiss_message.tpl';?>

<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesexpose', 'controller' => 'manage', 'action' => 'header-settings'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesexpose', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesexpose', 'controller' => 'manage', 'action' => 'manage-search'), $this->translate('Manage Search Module')) ?>
    </li>
  </ul>
</div>

<div class='clear sesbasic_admin_form exp_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

window.addEvent('domready', function() {
  showSocialShare("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexpose.show.socialshare', 1); ?>");
  showOption("<?php echo Engine_Api::_()->sesexpose()->getContantValueXML('exp_header_type'); ?>");
});

function showOption(value) {
  if(value == 3) {
    $('sesexpose_header_fixed-wrapper').style.display = 'none';
    $('sesexp_enable_footer-wrapper').style.display = 'block';
    $('exp_menu_logo_top_space-wrapper').style.display = 'block';
  } else {
    $('sesexpose_header_fixed-wrapper').style.display = 'block';
    $('exp_menu_logo_top_space-wrapper').style.display = 'block';
    $('sesexp_enable_footer-wrapper').style.display = 'none';
  }
  
  if(value == 1) {
    $('exp_menu_logo_top_space-wrapper').style.display = 'none';
  }
}

function showSocialShare(value) {

  if(value == 1) {
    if($('sesexp_facebookurl-wrapper'))
      $('sesexp_facebookurl-wrapper').style.display = 'block';
    if($('sesexp_googleplusurl-wrapper'))
      $('sesexp_googleplusurl-wrapper').style.display = 'block';
    if($('sesexp_twitterurl-wrapper'))
      $('sesexp_twitterurl-wrapper').style.display = 'block';
    if($('sesexp_pinteresturl-wrapper'))
      $('sesexp_pinteresturl-wrapper').style.display = 'block';

  } else {
    if($('sesexp_facebookurl-wrapper'))
      $('sesexp_facebookurl-wrapper').style.display = 'none';
    if($('sesexp_googleplusurl-wrapper'))
      $('sesexp_googleplusurl-wrapper').style.display = 'none';
    if($('sesexp_twitterurl-wrapper'))
      $('sesexp_twitterurl-wrapper').style.display = 'none';
    if($('sesexp_pinteresturl-wrapper'))
      $('sesexp_pinteresturl-wrapper').style.display = 'none';
  }

} 

</script>