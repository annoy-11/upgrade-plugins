<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-template.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sessportz/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manage', 'action' => 'header-template'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'settings', 'action' => 'manage-search'), $this->translate('Manage Modules for Search')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessportz', 'controller' => 'menu'), $this->translate('Mini Menu')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form sessportz_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>

  showLimitOption(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sessportz.searchleftoption', 1);?>);
  show_headerdesign(<?php echo Engine_Api::_()->sessportz()->getContantValueXML('sessportz_header_design') ?>);
  function show_headerdesign(value) {
	   if(value == 3)
     document.getElementById('sessportz_limit-wrapper').style.display = 'none';
	     else
     document.getElementById('sessportz_limit-wrapper').style.display = 'block';
     
     if(value == 5) {
       document.getElementById('header_five-wrapper').style.display = 'block';
       document.getElementById('sessportz_header_height-wrapper').style.display = 'block';
       document.getElementById('sessportz_navigation_position-wrapper').style.display = 'block';
     }
     else {
      document.getElementById('header_five-wrapper').style.display = 'none';
      document.getElementById('sessportz_header_height-wrapper').style.display = 'none';
      document.getElementById('sessportz_navigation_position-wrapper').style.display = 'none';
     }
  }
  function showLimitOption(value) {
    if(value == 1)
     document.getElementById('sessportz_search_limit-wrapper').style.display = 'block';
     else
     document.getElementById('sessportz_search_limit-wrapper').style.display = 'none';
  }
</script>
