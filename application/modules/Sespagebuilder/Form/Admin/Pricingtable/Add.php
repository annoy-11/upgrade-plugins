<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Pricingtable_Add extends Engine_Form {

  public function init() {

    $this->setMethod('post');
    $this->setTitle('Add New Column')->setDescription('Below, add new column for the pricing table and fill entries for the rows of this column. You can also choose various design settings for column.');

    $column_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    $content_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('content_id', 0);
    if ($column_id)
      $column = Engine_Api::_()->getItem('sespagebuilder_pricingtables', $column_id);

    $rowCount = Engine_Api::_()->getItem('sespagebuilder_content', $content_id)->num_row;

    $this->addElement('Text', 'column_title', array(
        'label' => 'Column Name',
        'description' => 'Enter the name of this column. This name is for your indication only and will not be shown at user side.',
        'allowEmpty' => false,
        'required' => true,
    ));
    
    $this->addElement('Text', 'column_width', array(
        'label' => 'Column Width',
        'description' => 'Enter the width of this column in pixels.'
    ));

    $this->addElement('Text', 'column_margin', array(
        'label' => 'Column Space',
        'description' => 'Enter the margin space to the right of this column in pixels.'
    ));
    
    $this->addElement('Radio', 'icon_position', array(
        'label' => 'Content Alignment',
        'description' => 'Choose the alignment of content of this column.',
        'multioptions' => array('1' => 'Center', '0' => 'Left'),
        'value' => '1'
    ));
    
    $this->addElement('Checkbox', 'show_highlight', array(
        'label' => "Do you want to highlight this column?",
        'description'=> 'Highlight This Column',
        'value' => '',
    ));

    $this->addElement('Radio', 'show_label', array(
        'label' => 'Show Tilted Label',
        'description' => 'Do you want to show tilted label in this column? If you choose “Yes”, then you will be able to configure details for the highlight label.',
        'multioptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => '0',
        'onclick' => 'showLabel(this.value);'
    ));
    
    $this->addElement('Text', 'label_text', array(
        'label' => 'Label Text',
        'description' => 'Enter the text for the label which will be shown as tilted strip.'
    ));
    
    $this->addElement('Text', 'label_color', array(
        'label' => 'Label Background Color',
        'description' => 'Choose and enter the label background color.',
        'class' => 'SEScolor',
    ));
    
    $this->addElement('Text', 'label_text_color', array(
        'label' => 'Label Text Color',
        'description' => 'Choose and enter the label text color.',
        'class' => 'SEScolor',
    ));
    
    $this->addElement('Radio', 'label_position', array(
        'label' => 'Label Alignment',
        'description' => 'Choose the alignment of label.',
        'multioptions' => array('1' => 'Right', '0' => 'Left'),
        'value' => '1',
    ));
    
    $this->addElement('Dummy', 'coulmn_header', array(
        'label' => "Column Header",
    ));
    
    $this->addElement('Text', 'column_name', array(
        'label' => 'Column Header Title',
        'description' => 'Enter the title of header of this column'
    ));
    
    $this->addElement('Select', 'currency', array(
        'label' => 'Currency',
        'value' => 'USD',
        'description' => 'Choose currency belonging to which icon will be shown in the header of this column.',
    ));

    $this->addElement('Text', 'currency_value', array(
        'label' => 'Price',
        'description' => 'Choose price for this column.'
    ));

    $this->addElement('Text', 'currency_duration', array(
        'label' => 'Duration',
        'description' => 'Choose duration for this column.'
    ));
    
    $this->addElement('Textarea', 'column_description', array(
        'label' => 'Description',
        'description' => 'Enter the description about this column. [You can choose the height of this field in the “Pricing Table” widget settings in Layout Editor.]',
        'maxlength' => '80'
    ));
    
    $this->addElement('Text', 'column_color', array(
        'label' => 'Background Color of Header',
        'description' => 'Choose and enter the background color of header of this column.',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'column_text_color', array(
        'label' => 'Text Color of Header',
        'description' => 'Choose and enter the text color of header of this column.',
        'class' => 'SEScolor',
    ));
    
    $this->addElement('Dummy', 'row_content', array(
        'label' => "Row Content",
    ));
    
    $this->addElement('Dummy', 'expand_all', array(
        'description' => "<a href='javascript:void(0);' onclick=\"showAllOption()\">Expand all Rows</a>",
    ));
    $this->expand_all->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    
    $tabs_count = array();

    for ($i = 1; $i <= $rowCount; $i++) {
      $tabs_count[] = $i;
    }

    $localeObject = Zend_Registry::get('Locale');
    $languages = Zend_Locale::getTranslationList('language', $localeObject);
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');

    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    foreach ($tabs_count as $tab) {

      foreach ($languageList as $key => $language) {
        if ($defaultLanguage != $key)
          continue;
        $key = explode('_', $key);
        $key = $key[0];
        if ($language == 'en')
          $id = "row$tab";
        else
          $id = $language . "_row$tab";
        $labelName = $languages[$key];

        $dummyid = $id . "_tabshowhide";

        $this->addElement('Dummy', $dummyid, array(
            'description' => "<a href='javascript:void(0);' onclick=\"showMoreOption('$dummyid', '', '')\" class=\"wrap\">Row $tab for $labelName</a>",
        ));
        $this->$dummyid->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

        $this->addElement('Text', $id . '_text', array(
            'label' => "Row $tab Content For $labelName",
            'description' => "Enter the content for row $tab for $labelName language.",
            'class' => 'text_row',
        ));

        $this->addElement('Textarea', $id . '_description', array(
            'label' => "Row $tab Hint for $labelName",
            'description' => "Enter the hint text for row $tab for $labelName language. [A question-mark icon will be shown to display this text on mouse-over of the icon.]",
            'maxlength' => '120',
            'class' => 'text_row',
        ));
      }

      foreach ($languageList as $key => $language) {
        if ($defaultLanguage == $key)
          continue;
        $key = explode('_', $key);
        $key = $key[0];
        if ($language == 'en')
          $id = "row$tab";
        else
          $id = $language . "_row$tab";
        $labelName = $languages[$key];

        $dummyid = $id . "_tabshowhide";

        $this->addElement('Dummy', $dummyid, array(
            'description' => "<a href='javascript:void(0);' onclick=\"showMoreOption('$dummyid', '', '')\" class=\"wrap\">Row $tab for $labelName</a>",
        ));
        $this->$dummyid->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

        $this->addElement('Text', $id . '_text', array(
            'label' => "Row $tab Content For $labelName",
            'description' => "Enter the content for row $tab for $labelName language.",
            'class' => 'text_row',
        ));

        $this->addElement('Textarea', $id . '_description', array(
            'label' => "Row $tab Hint for $labelName",
            'description' => "Enter the hint text for row $tab for $labelName language. [A question-mark icon will be shown to display this text on mouse-over of the icon.]",
            'maxlength' => '120',
            'class' => 'text_row',
        ));
      }
    }
    
    $this->addElement('Text', 'column_row_color', array(
        'label' => 'Background Color of Row Content',
        'description' => 'Choose and enter the background color of row content of this column.',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'column_row_text_color', array(
        'label' => 'Text Color of Row Content',
        'description' => 'Choose and enter the text color of row content of this column.',
        'class' => 'SEScolor',
    ));
    
    foreach ($tabs_count as $tab) {
      $this->addElement('Dummy', 'icon_upload', array(
          'description' => "<a href='javascript:void(0);' onclick=\"showIconOption('')\" class=\"file-wrap\">Upload Icon For Rows</a>",
      ));
      $this->icon_upload->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

      $iconId = 'row' . $tab . '_file_id';
      $previewId = 'row' . $tab . '_icon_preview';
      $this->addElement('File', $iconId, array(
          'label' => "Icon for Row $tab",
          'description' => "Upload an icon for row $tab. (Recommended dimensions of the icon are 16x16 px.)",
          'onchange' => "showReadImage(this,'$previewId')",
          'class' => 'upload_icon_row',
      ));
      $this->$iconId->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

      if (isset($column) && isset($column->$iconId) && $column->$iconId) {
        $img_path = Engine_Api::_()->storage()->get($column->$iconId, '')->getPhotoUrl();
        $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
        if (isset($path) && !empty($path)) {
          $this->addElement('Image', $previewId, array(
              'src' => $path,
              'class' => 'preview_icon_row',
          ));
        }
        $this->addElement('Checkbox', 'remove_row' . $tab . '_icon', array(
            'label' => 'Yes, delete this column icon.',
            'class' => 'remove_icon_row',
        ));
      } else {
        $this->addElement('Image', $previewId, array(
            'label' => "Preview Icon Preview for Row $tab",
            'width' => 16,
            'height' => 16,
            'disable' => true
        ));
      }
    }
    
    $this->addElement('Dummy', 'column_footer', array(
        'label' => "Column Footer",
    ));
    
    $this->addElement('Text', 'footer_text', array(
        'label' => 'Column Footer Title',
        'description' => 'Enter the title of footer of this column.'
    ));
    
    $this->addElement('Text', 'footer_bg_color', array(
        'label' => 'Background Color for Footer',
        'description' => 'Choose and enter the background color of footer of this column.',
        'class' => 'SEScolor',
    ));
    
    $this->addElement('Text', 'footer_text_color', array(
        'label' => 'Text Color for Footer',
        'description' => 'Choose and enter the text color of footer of this column.',
        'class' => 'SEScolor',
    ));
    
    $this->addElement('Text', 'text_url', array(
        'label' => 'Redirect URL',
        'description' => "Enter the URL on which users will be redirected when they click on the footer.",
    ));
    
    $this->addElement('Button', 'save', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Save & Exit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage-tables', 'content_id' => $content_id)),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('save', 'submit', 'cancel'), 'buttons');
  }

}
