<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdating	
 * @package    Sesdating
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-settings.tpl  2018-09-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesdating/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdating', 'controller' => 'manage', 'action' => 'header-settings'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdating', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdating', 'controller' => 'manage', 'action' => 'mini-menu-icons'), $this->translate('Mini Menu icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesdating', 'controller' => 'menu'), $this->translate('Mini Menu')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form dating_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

window.addEvent('domready', function() {
  showSocialShare("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdating.show.socialshare', 1); ?>");
  showHidePanel("<?php echo Engine_Api::_()->sesdating()->getContantValueXML('sesdating_sidepanel_effect'); ?>");
  showHeaderDesigns("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdating.header.design', 1); ?>");
});

function showHidePanel(value) {
  if(value == 1) {
    if($('sesdating_sidepanel_showhide-wrapper'))
      $('sesdating_sidepanel_showhide-wrapper').style.display = 'none';
  } else if(value == 2) {
    if($('sesdating_sidepanel_showhide-wrapper'))
      $('sesdating_sidepanel_showhide-wrapper').style.display = 'block';
  }
}

function showHeaderDesigns(value) {

  if(value == 1) {
    if($('sesdating_menu_img-wrapper'))
      $('sesdating_menu_img-wrapper').style.display = 'none';
    if($('sesdating_sidepanel_effect-wrapper'))
      $('sesdating_sidepanel_effect-wrapper').style.display = 'none';
    if($('sesdating_menuinformation_img-wrapper'))
      $('sesdating_menuinformation_img-wrapper').style.display = 'none';
    if($('sesdating_sidepanel_showhide-wrapper'))
      $('sesdating_sidepanel_showhide-wrapper').style.display = 'none';
    if($('sesdating_limit-wrapper'))
      $('sesdating_limit-wrapper').style.display = 'block';
    if($('sesdating_moretext-wrapper'))
      $('sesdating_moretext-wrapper').style.display = 'block';
  } else {
    if($('sesdating_menu_img-wrapper'))
      $('sesdating_menu_img-wrapper').style.display = 'block';
    if($('sesdating_sidepanel_effect-wrapper'))
      $('sesdating_sidepanel_effect-wrapper').style.display = 'block';   
    if($('sesdating_menuinformation_img-wrapper'))
      $('sesdating_menuinformation_img-wrapper').style.display = 'block';
    if($('sesdating_sidepanel_effect').value == 1){
      if($('sesdating_sidepanel_showhide-wrapper'))
        $('sesdating_sidepanel_showhide-wrapper').style.display = 'none';
    } else {
      if($('sesdating_sidepanel_showhide-wrapper'))
        $('sesdating_sidepanel_showhide-wrapper').style.display = 'block';
    }
    if($('sesdating_limit-wrapper'))
      $('sesdating_limit-wrapper').style.display = 'none';
    if($('sesdating_moretext-wrapper'))
      $('sesdating_moretext-wrapper').style.display = 'none';
  }
}

function showSocialShare(value) {

  if(value == 1) {
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
