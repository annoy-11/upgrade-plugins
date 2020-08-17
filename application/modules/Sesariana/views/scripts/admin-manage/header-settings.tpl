<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-settings.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php include APPLICATION_PATH .  '/application/modules/Sesariana/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesariana', 'controller' => 'manage', 'action' => 'header-settings'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesariana', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesariana', 'controller' => 'manage', 'action' => 'mini-menu-icons'), $this->translate('Mini Menu icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesariana', 'controller' => 'menu'), $this->translate('Mini Menu')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form ariana_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

window.addEvent('domready', function() {
  showSocialShare("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.show.socialshare', 1); ?>");
  showHidePanel("<?php echo Engine_Api::_()->sesariana()->getContantValueXML('sesariana_sidepanel_effect'); ?>");
  showHeaderDesigns("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.header.design', 1); ?>");
});

function showHidePanel(value) {
  if(value == 1) {
    if($('sesariana_sidepanel_showhide-wrapper'))
      $('sesariana_sidepanel_showhide-wrapper').style.display = 'none';
  } else if(value == 2) {
    if($('sesariana_sidepanel_showhide-wrapper'))
      $('sesariana_sidepanel_showhide-wrapper').style.display = 'block';
  }
}

function showHeaderDesigns(value) {

  if(value == 1) {
    if($('sesariana_menu_img-wrapper'))
      $('sesariana_menu_img-wrapper').style.display = 'none';
    if($('sesariana_sidepanel_effect-wrapper'))
      $('sesariana_sidepanel_effect-wrapper').style.display = 'none';
    if($('sesariana_menuinformation_img-wrapper'))
      $('sesariana_menuinformation_img-wrapper').style.display = 'none';
    if($('sesariana_sidepanel_showhide-wrapper'))
      $('sesariana_sidepanel_showhide-wrapper').style.display = 'none';
    if($('sesariana_limit-wrapper'))
      $('sesariana_limit-wrapper').style.display = 'block';
    if($('sesariana_moretext-wrapper'))
      $('sesariana_moretext-wrapper').style.display = 'block';
  } else {
    if($('sesariana_menu_img-wrapper'))
      $('sesariana_menu_img-wrapper').style.display = 'block';
    if($('sesariana_sidepanel_effect-wrapper'))
      $('sesariana_sidepanel_effect-wrapper').style.display = 'block';   
    if($('sesariana_menuinformation_img-wrapper'))
      $('sesariana_menuinformation_img-wrapper').style.display = 'block';
    if($('sesariana_sidepanel_effect').value == 1){
      if($('sesariana_sidepanel_showhide-wrapper'))
        $('sesariana_sidepanel_showhide-wrapper').style.display = 'none';
    } else {
      if($('sesariana_sidepanel_showhide-wrapper'))
        $('sesariana_sidepanel_showhide-wrapper').style.display = 'block';
    }
    if($('sesariana_limit-wrapper'))
      $('sesariana_limit-wrapper').style.display = 'none';
    if($('sesariana_moretext-wrapper'))
      $('sesariana_moretext-wrapper').style.display = 'none';
  }
}

function showSocialShare(value) {

  if(value == 1) {
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
