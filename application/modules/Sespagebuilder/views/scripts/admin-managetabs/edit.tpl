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
  <?php echo $this->htmlLink(array('route' => 'admin_default','module' => 'sespagebuilder','controller' => 'managetabs'), $this->translate("Back to Manage Accordion or Tab"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />

<div class='clear sesbasic_admin_form sespagebuilder_tabs_content_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="text/javascript">

  <?php foreach($this->showElements as $key => $elementValue):?>
      showMoreOption('<?php echo $key?>', '<?php echo str_replace('""','',Zend_Json_Encoder::encode($elementValue))?>', '1');
  <?php endforeach;?>
  
  var showAllOptions = 0;
  function showAllOption() {
    
    if(showAllOptions == '0') {
      jqueryObjectOfSes('.upload_icon_row').parent().parent().show();
			jqueryObjectOfSes('.wrap').parent().parent().parent().addClass('collapse');
      document.getElementById('expand_all-element').innerHTML = '<p class="description"><a onclick="showAllOption()" href="javascript:void(0);">Collapse All</a></p>';
      showAllOptions = 1;
    }
    else {
      jqueryObjectOfSes('.upload_icon_row').parent().parent().hide();
			jqueryObjectOfSes('.wrap').parent().parent().parent().removeClass('collapse');
      document.getElementById('expand_all-element').innerHTML = '<p class="description"><a onclick="showAllOption()" href="javascript:void(0);">Expand All</a></p>';
      showAllOptions = 0;
    }
  }
  
  function showMoreOption(id, elementValue, showElement) {

    if(document.getElementById(id +'-wrapper')) {
   
      if(showElement == '1') {
	if(elementValue != '')
	document.getElementById(id +'-wrapper').style.display = 'block';
	else
	document.getElementById(id +'-wrapper').style.display = 'none';
      }
      else {
	var res = id.split("_").pop(-1); 
	if(res == 'tabshowhide')
	id = id.replace("_tabshowhide", "");
	if(document.getElementById(id + '_name-wrapper').getStyle('display') == 'block') {
		document.getElementById(id + '_tabshowhide-wrapper').removeClass('collapse');
	  document.getElementById(id + '_name-wrapper').style.display = 'none';
	  document.getElementById(id + '_body-wrapper').style.display = 'none';
	}
	else {
          document.getElementById(id + '_tabshowhide-wrapper').addClass('collapse');
	  document.getElementById(id + '_name-wrapper').style.display = 'block';
	  document.getElementById(id + '_body-wrapper').style.display = 'block';
	}
      }
    }
  }
  
  window.addEvent('domready', function() {
    showSettings('<?php echo $this->showElements->short_code;?>');
  });
  
  function showSettings(value) {
  
    if(value == '1') {
      if(document.getElementById('height-wrapper'))
      document.getElementById('height-wrapper').style.display = 'block';
      if(document.getElementById('headingBgColor-wrapper'))
      document.getElementById('headingBgColor-wrapper').style.display = 'block';
      if(document.getElementById('descriptionBgColor-wrapper'))
      document.getElementById('descriptionBgColor-wrapper').style.display = 'block';
      if(document.getElementById('tabBgColor-wrapper'))
      document.getElementById('tabBgColor-wrapper').style.display = 'block';
      if(document.getElementById('tabActiveBgColor-wrapper'))
      document.getElementById('tabActiveBgColor-wrapper').style.display = 'block';
      if(document.getElementById('tabTextBgColor-wrapper'))
      document.getElementById('tabTextBgColor-wrapper').style.display = 'block';
      if(document.getElementById('tabActiveTextColor-wrapper'))
      document.getElementById('tabActiveTextColor-wrapper').style.display = 'block';
      if(document.getElementById('tabTextFontSize-wrapper'))
      document.getElementById('tabTextFontSize-wrapper').style.display = 'block';
      if(document.getElementById('width-wrapper'))
      document.getElementById('width-wrapper').style.display = 'block';
    }
    else {
      if(document.getElementById('height-wrapper'))
      document.getElementById('height-wrapper').style.display = 'none';
      if(document.getElementById('headingBgColor-wrapper'))
      document.getElementById('headingBgColor-wrapper').style.display = 'none';
      if(document.getElementById('descriptionBgColor-wrapper'))
      document.getElementById('descriptionBgColor-wrapper').style.display = 'none';
      if(document.getElementById('tabBgColor-wrapper'))
      document.getElementById('tabBgColor-wrapper').style.display = 'none';
      if(document.getElementById('tabActiveBgColor-wrapper'))
      document.getElementById('tabActiveBgColor-wrapper').style.display = 'none';
      if(document.getElementById('tabTextBgColor-wrapper'))
      document.getElementById('tabTextBgColor-wrapper').style.display = 'none';
      if(document.getElementById('tabActiveTextColor-wrapper'))
      document.getElementById('tabActiveTextColor-wrapper').style.display = 'none';
      if(document.getElementById('tabTextFontSize-wrapper'))
      document.getElementById('tabTextFontSize-wrapper').style.display = 'none';
      if(document.getElementById('width-wrapper'))
      document.getElementById('width-wrapper').style.display = 'none';
    }
  }
  
</script>