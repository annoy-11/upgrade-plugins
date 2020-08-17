<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-settings.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sessportz/views/scripts/dismiss_message.tpl';?>

<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manage', 'action' => 'footer-settings'), $this->translate('Footer Settings')) ?>
    </li>
   <!-- <li >
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manage', 'action' => 'footer-links'), $this->translate('Footer Links')) ?>
    </li>-->
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manage', 'action' => 'footer-social-icons'), $this->translate('Social Site Links')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form sessportz_footer_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>
  window.addEvent('domready', function() {
    show_settings('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.foshow', 1) ?>');
  });
  
  function show_settings(value) {
    if(value == '1') {
      if($('sessportz_fo_module-wrapper'))
      $('sessportz_fo_module-wrapper').style.display = 'block';
      if($('sessportz_fo_popularitycriteria-wrapper'))
      $('sessportz_fo_popularitycriteria-wrapper').style.display = 'block';
    } else {
      if($('sessportz_fo_module-wrapper'))
      $('sessportz_fo_module-wrapper').style.display = 'none';
      if($('sessportz_fo_popularitycriteria-wrapper'))
      $('sessportz_fo_popularitycriteria-wrapper').style.display = 'none';
    }
    
  } 
</script>
