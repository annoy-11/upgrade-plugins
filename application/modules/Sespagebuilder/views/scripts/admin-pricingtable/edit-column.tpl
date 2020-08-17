<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit-column.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sespagebuilder/views/scripts/dismiss_message.tpl';?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/styles/font-awesome.css'); ?>
<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sespagebuilder', 'controller' => 'pricingtable', 'action' => 'manage-tables','content_id' => $this->content_id), $this->translate("Back to Manage Pricing Table Columns"), array('class'=>'sesbasic_icon_back buttonlink')) ?>
<br /><br />
<div class='clear sesbasic_admin_form sespagebuilder_tabs_content_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script type="text/javascript">

  <?php 
    $tableId = Zend_Controller_Front::getInstance()->getRequest()->getParam('content_id', 0);
    $rowCount = Engine_Api::_()->getItem('sespagebuilder_content', $tableId)->num_row;
    $tabs_count = array();
    for ($i = 1; $i <= $rowCount; $i++) {
      $tabs_count[] =  $i;
    }
  ?>

  <?php foreach($this->showElements as $key => $elementValue):?>
      showMoreOption('<?php echo $key?>', '<?php echo str_replace('""','',Zend_Json_Encoder::encode($elementValue))?>', '1');
  <?php endforeach;?>
  
  var showAllOptions = 0;
  function showAllOption() {
    
    if(showAllOptions == '0') {
      jqueryObjectOfSes('.text_row').parent().parent().show();
      jqueryObjectOfSes('.wrap').parent().parent().parent().addClass('collapse');
      document.getElementById('expand_all-element').innerHTML = '<p class="description collapse"><a onclick="showAllOption()" href="javascript:void(0);">Collapse all Rows</a></p>';
      showAllOptions = 1;
    }
    else {
      jqueryObjectOfSes('.text_row').parent().parent().hide();
      jqueryObjectOfSes('.wrap').parent().parent().parent().removeClass('collapse');
      document.getElementById('expand_all-element').innerHTML = '<p class="description expand"><a onclick="showAllOption()" href="javascript:void(0);">Expand all Rows</a></p>';
      showAllOptions = 0;
    }
  }
  
  function showMoreOption(id, elementValue, showElement) {

    var removeColumnArray = ['column_name','column_title', 'column_width','column_row_color','column_row_text_color', 'icon_position', 'currency', 'show_currency', 'currency_value', 'currency_duration', 'column_description', 'footer_text','footer_text_color','footer_bg_color','column_text_color', 'text_url', 'column_color', 'show_highlight'];
    var checkColumn = removeColumnArray.indexOf(id);
    if(checkColumn != '-1')
    return;
   
    if(document.getElementById(id +'-wrapper')) {
      var res = id.split("_").pop(-1); 
      if(res == 'tabshowhide')
      id = id.replace("_tabshowhide", "");
      if(showElement == '1') {
	if(elementValue != '')
	document.getElementById(id +'-wrapper').style.display = 'block';
	else
	document.getElementById(id +'-wrapper').style.display = 'none';
      }
      else {		
	if(document.getElementById(id + '_text-wrapper').getStyle('display') == 'block') {
	  document.getElementById(id + '_tabshowhide-wrapper').removeClass('collapse');
	  document.getElementById(id + '_text-wrapper').style.display = 'none';
	  document.getElementById(id + '_description-wrapper').style.display = 'none';
	}
	else {
	  document.getElementById(id + '_tabshowhide-wrapper').addClass('collapse');	
	  document.getElementById(id + '_text-wrapper').style.display = 'block';
	  document.getElementById(id + '_description-wrapper').style.display = 'block';
	}
      }
    }
  }
  
  function showIconOption() {

    if(document.getElementById('row1_file_id-wrapper').getStyle('display') == 'block') {
     jqueryObjectOfSes('.upload_icon_row').parent().parent().hide();
     jqueryObjectOfSes('.preview_icon_row').parent().parent().hide();
     jqueryObjectOfSes('.remove_icon_row').parent().parent().hide();
     jqueryObjectOfSes('.file-wrap').parent().parent().parent().removeClass('collapse');
    }
    else {
      jqueryObjectOfSes('.upload_icon_row').parent().parent().show();
      jqueryObjectOfSes('.preview_icon_row').parent().parent().show();
      jqueryObjectOfSes('.remove_icon_row').parent().parent().show();
      jqueryObjectOfSes('.file-wrap').parent().parent().parent().addClass('collapse');
    }
  }

  function showReadImage(input, id) {
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg" || ext == 'PNG' || ext == 'JPEG' || ext == 'JPG')) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $(id + '-wrapper').style.display = 'block';
        $(id).setAttribute('src', e.target.result);
      }
      $(id + '-wrapper').style.display = 'block';
      reader.readAsDataURL(input.files[0]);
    }
  }
  
  window.addEvent('domready', function() {
    showLabel('<?php echo $this->showElements->show_label;?>');
  });
  
  jqueryObjectOfSes('.upload_icon_row').parent().parent().hide();
  
  function showLabel(value) {
  
    if(value == '1') {
      if(document.getElementById('label_text-wrapper'))
      document.getElementById('label_text-wrapper').style.display = 'block';
      if(document.getElementById('label_text_color-wrapper'))
      document.getElementById('label_text_color-wrapper').style.display = 'block';
      if(document.getElementById('label_color-wrapper'))
      document.getElementById('label_color-wrapper').style.display = 'block';
      if(document.getElementById('label_position-wrapper'))
      document.getElementById('label_position-wrapper').style.display = 'block';
    }
    else {
      if(document.getElementById('label_text-wrapper'))
      document.getElementById('label_text-wrapper').style.display = 'none';
      if(document.getElementById('label_text_color-wrapper'))
      document.getElementById('label_text_color-wrapper').style.display = 'none';
      if(document.getElementById('label_color-wrapper'))
      document.getElementById('label_color-wrapper').style.display = 'none';
      if(document.getElementById('label_position-wrapper'))
      document.getElementById('label_position-wrapper').style.display = 'none';
    }
  }
  
   <?php foreach($tabs_count as $tab):?>
    if ($('row'+'<?php echo $tab;?>'+'_icon_preview-wrapper')) {
      var checkFileId = '<?php echo Engine_Api::_()->sespagebuilder()->isFileIdExist("row$tab", $this->column_id);?>';
      if(checkFileId == '0') {
	$('row'+'<?php echo $tab;?>'+'_icon_preview-wrapper').style.display = 'none'; 
      }
      if(checkFileId == '1')
      jqueryObjectOfSes('.upload_icon_row').parent().parent().show();
    }
   <?php endforeach;?>
  
</script>