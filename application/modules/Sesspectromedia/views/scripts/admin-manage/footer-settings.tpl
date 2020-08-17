<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-settings.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<?php include APPLICATION_PATH .  '/application/modules/Sesspectromedia/views/scripts/dismiss_message.tpl';?>

<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'footer-settings'), $this->translate('Footer Settings')) ?>
    </li>
    <li >
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'footer-links'), $this->translate('Footer Links')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesspectromedia', 'controller' => 'manage', 'action' => 'footer-social-icons'), $this->translate('Social Site Links')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form sm_footer_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>
  window.addEvent('domready', function() {
    show_settings("<?php echo Engine_Api::_()->sesspectromedia()->getContantValueXML('sm_footer_design'); ?>", '');
  });
  
  function show_settings(value) {
    if(value == '2' || value == '4') {
      if($('sesspectromedia_footer_aboutheading-wrapper'))
      $('sesspectromedia_footer_aboutheading-wrapper').style.display = 'block';
      if($('sesspectromedia_footer_aboutdes-wrapper'))
      $('sesspectromedia_footer_aboutdes-wrapper').style.display = 'block';
    } else if(value == '1' || value == '3') {
      if($('sesspectromedia_footer_aboutheading-wrapper'))
      $('sesspectromedia_footer_aboutheading-wrapper').style.display = 'none';
      if($('sesspectromedia_footer_aboutdes-wrapper'))
      $('sesspectromedia_footer_aboutdes-wrapper').style.display = 'none';
    }
    
  } 
</script>