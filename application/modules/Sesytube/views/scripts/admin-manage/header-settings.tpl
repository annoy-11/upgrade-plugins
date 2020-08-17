<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-settings.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesytube/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage', 'action' => 'header-settings'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'manage', 'action' => 'mini-menu-icons'), $this->translate('Mini Menu icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesytube', 'controller' => 'menu'), $this->translate('Mini Menu')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form ytube_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

window.addEvent('domready', function() {
  showSocialShare("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.show.socialshare', 1); ?>");
  showHeaderDesigns("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.header.design', 1); ?>");
});


function showSocialShare(value) {

  if(value == 1) {
    if($('sesytube_facebookurl-wrapper'))
      $('sesytube_facebookurl-wrapper').style.display = 'block';
    if($('sesytube_googleplusurl-wrapper'))
      $('sesytube_googleplusurl-wrapper').style.display = 'block';
    if($('sesytube_twitterurl-wrapper'))
      $('sesytube_twitterurl-wrapper').style.display = 'block';
    if($('sesytube_pinteresturl-wrapper'))
      $('sesytube_pinteresturl-wrapper').style.display = 'block';
  } else {
    if($('sesytube_facebookurl-wrapper'))
      $('sesytube_facebookurl-wrapper').style.display = 'none';
    if($('sesytube_googleplusurl-wrapper'))
      $('sesytube_googleplusurl-wrapper').style.display = 'none';
    if($('sesytube_twitterurl-wrapper'))
      $('sesytube_twitterurl-wrapper').style.display = 'none';
    if($('sesytube_pinteresturl-wrapper'))
      $('sesytube_pinteresturl-wrapper').style.display = 'none';
  }
}
</script>
