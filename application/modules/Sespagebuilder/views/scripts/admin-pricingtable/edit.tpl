<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>

<div>
  <?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate("Back to Manage Table"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />

<div class='clear sesbasic_admin_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="text/javascript">

  window.addEvent('domready', function() {
    showSettings('<?php echo $this->show_short_code;?>');
  });
  
  function showSettings(value) {
  
    if(value == '1') {
      if(document.getElementById('row_height-wrapper'))
      document.getElementById('row_height-wrapper').style.display = 'block';
      if(document.getElementById('description_height-wrapper'))
      document.getElementById('description_height-wrapper').style.display = 'block';
      if(document.getElementById('price_header-wrapper'))
      document.getElementById('price_header-wrapper').style.display = 'block';
      if(document.getElementById('description_header-wrapper'))
      document.getElementById('description_header-wrapper').style.display = 'block';
    }
    else {
      if(document.getElementById('row_height-wrapper'))
      document.getElementById('row_height-wrapper').style.display = 'none';
      if(document.getElementById('description_height-wrapper'))
      document.getElementById('description_height-wrapper').style.display = 'none';
      if(document.getElementById('price_header-wrapper'))
      document.getElementById('price_header-wrapper').style.display = 'none';
      if(document.getElementById('description_header-wrapper'))
      document.getElementById('description_header-wrapper').style.display = 'none';
    }
  }
</script>