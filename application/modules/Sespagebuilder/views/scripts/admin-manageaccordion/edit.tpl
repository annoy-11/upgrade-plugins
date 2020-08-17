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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<div>
  <?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate("Back to Manage Accordion Menus"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />
<div class="settings"><?php echo $this->form->render($this); ?></div>

<script type="text/javascript">

  window.addEvent('domready', function() {
    showSettings('<?php echo $this->show_short_code;?>');
  });
  
  function showSettings(value) {
  
    if(value == '1') {
      if(document.getElementById('accTabBgColor-wrapper'))
      document.getElementById('accTabBgColor-wrapper').style.display = 'block';
      if(document.getElementById('accTabTextColor-wrapper'))
      document.getElementById('accTabTextColor-wrapper').style.display = 'block';
      if(document.getElementById('accTabTextFontSize-wrapper'))
      document.getElementById('accTabTextFontSize-wrapper').style.display = 'block';
      if(document.getElementById('subaccTabBgColor-wrapper'))
      document.getElementById('subaccTabBgColor-wrapper').style.display = 'block';
      if(document.getElementById('subaccTabTextColor-wrapper'))
      document.getElementById('subaccTabTextColor-wrapper').style.display = 'block';
      if(document.getElementById('subaccTabTextFontSize-wrapper'))
      document.getElementById('subaccTabTextFontSize-wrapper').style.display = 'block';
      if(document.getElementById('show_accordian-wrapper'))
      document.getElementById('show_accordian-wrapper').style.display = 'block';
      if(document.getElementById('subaccorImage-wrapper'))
      document.getElementById('subaccorImage-wrapper').style.display = 'block';
      if(document.getElementById('accorImage-wrapper'))
      document.getElementById('accorImage-wrapper').style.display = 'block';
      if(document.getElementById('width-wrapper'))
      document.getElementById('width-wrapper').style.display = 'block';
    }
    else {
      if(document.getElementById('accTabBgColor-wrapper'))
      document.getElementById('accTabBgColor-wrapper').style.display = 'none';
      if(document.getElementById('accTabTextColor-wrapper'))
      document.getElementById('accTabTextColor-wrapper').style.display = 'none';
      if(document.getElementById('accTabTextFontSize-wrapper'))
      document.getElementById('accTabTextFontSize-wrapper').style.display = 'none';
      if(document.getElementById('subaccTabBgColor-wrapper'))
      document.getElementById('subaccTabBgColor-wrapper').style.display = 'none';
      if(document.getElementById('subaccTabTextColor-wrapper'))
      document.getElementById('subaccTabTextColor-wrapper').style.display = 'none';
      if(document.getElementById('subaccTabTextFontSize-wrapper'))
      document.getElementById('subaccTabTextFontSize-wrapper').style.display = 'none';
      if(document.getElementById('show_accordian-wrapper'))
      document.getElementById('show_accordian-wrapper').style.display = 'none';
      if(document.getElementById('subaccorImage-wrapper'))
      document.getElementById('subaccorImage-wrapper').style.display = 'none';
      if(document.getElementById('accorImage-wrapper'))
      document.getElementById('accorImage-wrapper').style.display = 'none';
      if(document.getElementById('width-wrapper'))
      document.getElementById('width-wrapper').style.display = 'none';
    }
  }
  
</script>