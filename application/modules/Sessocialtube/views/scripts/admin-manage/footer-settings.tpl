<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-settings.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sessocialtube/views/scripts/dismiss_message.tpl';?>

<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'footer-settings'), $this->translate('Footer Settings')) ?>
    </li>
    <li >
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'footer-links'), $this->translate('Footer Links')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sessocialtube', 'controller' => 'manage', 'action' => 'footer-social-icons'), $this->translate('Social Site Links')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form socialtube_footer_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>
  window.addEvent('domready', function() {
    show_settings("<?php echo Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_footer_design'); ?>", '');
  });
  
  function show_settings(value) {
    if(value == '2' || value == '4') {
      if($('sessocialtube_footer_aboutheading-wrapper'))
      $('sessocialtube_footer_aboutheading-wrapper').style.display = 'block';
      if($('sessocialtube_footer_aboutdes-wrapper'))
      $('sessocialtube_footer_aboutdes-wrapper').style.display = 'block';
    } else if(value == '1' || value == '3') {
      if($('sessocialtube_footer_aboutheading-wrapper'))
      $('sessocialtube_footer_aboutheading-wrapper').style.display = 'none';
      if($('sessocialtube_footer_aboutdes-wrapper'))
      $('sessocialtube_footer_aboutdes-wrapper').style.display = 'none';
    }
    
  } 
</script>