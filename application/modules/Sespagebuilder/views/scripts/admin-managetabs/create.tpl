<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: create.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/font-awesome.css'); ?>
<div>
  <?php echo $this->htmlLink(array('action' => 'index', 'reset' => false), $this->translate("Back to Manage Accordion or Tab"),array('class' => 'buttonlink sesbasic_icon_back')) ?>
</div>
<br />

<div class='clear sesbasic_admin_form sespagebuilder_tabs_content_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="text/javascript">

  <?php $showId = '0';?>
  <?php $tabs_count = array(1,2,3,4,5,6,7,8,9,10,11,12);?>
  <?php foreach($tabs_count as $tab):?>
    <?php    
      $localeObject = Zend_Registry::get('Locale');
      $languages = Zend_Locale::getTranslationList('language', $localeObject);
      $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
      $translate = Zend_Registry::get('Zend_Translate');
      $languageList = $translate->getList();
    ?>
    <?php foreach ($languageList as $key => $language):?>
      <?php $key = explode('_', $key);?>
      <?php $key = $key[0];?>
      <?php if ($language == 'en'):?>
	<?php $id = "tab$tab";?>
      <?php else:?>
	<?php $id = $language."_tab$tab";?>
      <?php endif;?>
      <?php if($tab == '1' && $defaultLanguage == $language):?>
        <?php $showId = $id;?>
      <?php endif;?>
      document.getElementById('<?php echo $id?>'+'_name-wrapper').style.display = 'none';
      document.getElementById('<?php echo $id?>'+'_body-wrapper').style.display = 'none';
    <?php endforeach;?>
  <?php endforeach;?>
  
  if(document.getElementById('<?php echo $showId?>'+'_name-wrapper')) {
    document.getElementById('<?php echo $showId?>'+'_name-wrapper').style.display = 'block';
    document.getElementById('<?php echo $showId?>'+'_body-wrapper').style.display = 'block';
  }
  
  <?php foreach($this->showElements as $key => $elementValue):?>
    showMoreOption('<?php echo $key?>', '<?php echo Zend_Json_Encoder::encode($elementValue)?>', '1');
  <?php endforeach;?>
  
  var showAllOptions = 0;
  function showAllOption() {
    
    if(showAllOptions == '0') {
      jqueryObjectOfSes('.upload_icon_row').parent().parent().show();
			jqueryObjectOfSes('.wrap').parent().parent().parent().addClass('collapse');
      document.getElementById('expand_all-element').innerHTML = '<p class="description collapse"><a onclick="showAllOption()" href="javascript:void(0);">Collapse All</a></p>';
      showAllOptions = 1;
    }
    else {
      jqueryObjectOfSes('.upload_icon_row').parent().parent().hide();
      jqueryObjectOfSes('.wrap').parent().parent().parent().removeClass('collapse');
      document.getElementById('expand_all-element').innerHTML = '<p class="description expand"><a onclick="showAllOption()" href="javascript:void(0);">Expand All</a></p>';
      showAllOptions = 0;
    }
  }
  
  function showMoreOption(id, elementValue, fullId) {
  
    if(fullId == '1')
    document.getElementById(id +'-wrapper').style.display = 'block';
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
  
  
  window.addEvent('domready', function() {
    showSettings(0);
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