<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-template.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesmaterial/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'manage', 'action' => 'header-template'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'settings', 'action' => 'manage-search'), $this->translate('Manage Modules for Search')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmaterial', 'controller' => 'menu'), $this->translate('Mini Menu')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form sesmaterial_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>

  showLimitOption(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmaterial.searchleftoption', 1);?>);
  show_headerdesign(<?php echo Engine_Api::_()->sesmaterial()->getContantValueXML('sesmaterial_header_design') ?>);
  function show_headerdesign(value) {
	   if(value == 3)
     document.getElementById('sesmaterial_limit-wrapper').style.display = 'none';
	     else
     document.getElementById('sesmaterial_limit-wrapper').style.display = 'block';
     
     if(value == 5) {
       document.getElementById('header_five-wrapper').style.display = 'block';
       document.getElementById('sesmaterial_header_height-wrapper').style.display = 'block';
       document.getElementById('sesmaterial_navigation_position-wrapper').style.display = 'block';
     }
     else {
      document.getElementById('header_five-wrapper').style.display = 'none';
      document.getElementById('sesmaterial_header_height-wrapper').style.display = 'none';
      document.getElementById('sesmaterial_navigation_position-wrapper').style.display = 'none';
     }
  }
  function showLimitOption(value) {
    if(value == 1)
     document.getElementById('sesmaterial_search_limit-wrapper').style.display = 'block';
     else
     document.getElementById('sesmaterial_search_limit-wrapper').style.display = 'none';
  }
</script>
