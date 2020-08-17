<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-template.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesspectromedia/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'header-template'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'settings', 'action' => 'manage-search'), $this->translate('Manage Modules for Search')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'manage-photos'), $this->translate('Header Background Images')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form sm_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>

  showLimitOption(<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesspectromedia.searchleftoption', 1);?>);
  show_headerdesign(<?php echo Engine_Api::_()->sesspectromedia()->getContantValueXML('sm_header_design') ?>);
  function show_headerdesign(value) {
	   if(value == 3)
     document.getElementById('sesspectromedia_limit-wrapper').style.display = 'none';
	     else
     document.getElementById('sesspectromedia_limit-wrapper').style.display = 'block';
     
     if(value == 5) {
       document.getElementById('header_five-wrapper').style.display = 'block';
       document.getElementById('sm_header_height-wrapper').style.display = 'block';
       document.getElementById('sm_navigation_position-wrapper').style.display = 'block';
     }
     else {
      document.getElementById('header_five-wrapper').style.display = 'none';
      document.getElementById('sm_header_height-wrapper').style.display = 'none';
      document.getElementById('sm_navigation_position-wrapper').style.display = 'none';
     }
  }
  function showLimitOption(value) {
    if(value == 1)
     document.getElementById('sesspectromedia_search_limit-wrapper').style.display = 'block';
     else
     document.getElementById('sesspectromedia_search_limit-wrapper').style.display = 'none';
  }
</script>