<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Managetab_Create extends Engine_Form {

  public function init() {

    $this->setTitle('Create New Accordion or Tab')->setDescription('Below, create a tab container for all languages on your website and choose the various display criterias in the “Accordion and Tab Container” widget or while getting the shortcode.');

    $this->addElement('Text', 'name', array(
        'label' => 'Tab Name',
        'description' => 'Enter the tab name. This name is for your indication only and will not be shown at user side.',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_StringLength(array('max' => '63'))
        ),
        'autofocus' => 'autofocus',
    ));

    $this->addElement('Dummy', 'expand_all', array(
        'description' => "<a href='javascript:void(0);' onclick=\"showAllOption()\">Expand All</a>",
    ));
    $this->expand_all->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $tabs_count = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);

    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'manage', 'action' => "upload-image"), 'admin_default', true);

    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

    $editorOptions = array(
        'upload_url' => $upload_url,
        'html' => (bool) $allowed_html,
    );

    if (!empty($upload_url)) {
      $editorOptions['plugins'] = array(
          'table', 'fullscreen', 'media', 'preview', 'paste',
          'code', 'image', 'textcolor', 'jbimages', 'link'
      );

      $editorOptions['toolbar1'] = array(
          'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
          'media', 'image', 'jbimages', 'link', 'fullscreen',
          'preview'
      );
    }

    $localeObject = Zend_Registry::get('Locale');
    $languages = Zend_Locale::getTranslationList('language', $localeObject);
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if ($defaultLanguage == 'auto')
      $defaultLanguage = 'en';

    $languageList = Zend_Registry::get('Zend_Translate')->getList();
    foreach ($tabs_count as $tab) {

      foreach ($languageList as $key => $language) {
        if ($defaultLanguage != $key)
          continue;
        $key = explode('_', $key);
        $key = $key[0];
        if ($language == 'en')
          $id = "tab$tab";
        else
          $id = $language . "_tab$tab";
        $labelName = $languages[$key];

        $dummyid = $id . "_tabshowhide";
        $this->addElement('Dummy', $dummyid, array(
            'description' => "<a href='javascript:void(0);' onclick=\"showMoreOption('$dummyid', '', '')\" class=\"wrap\">Tab $tab for $labelName</a>",
        ));
        $this->$dummyid->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

        $this->addElement('Text', $id . '_name', array(
            'label' => "Tab $tab Title For $labelName",
            'description' => "Enter the title for Tab $tab for $labelName language.",
            'class' => 'upload_icon_row',
        ));

        $this->addElement('TinyMce', $id . '_body', array(
            'label' => "Tab $tab Content for $labelName",
            'description' => "Enter the content for Tab $tab for $labelName language.",
            'editorOptions' => $editorOptions,
            'class' => 'upload_icon_row',
        ));
      }

      foreach ($languageList as $key => $language) {
        if ($defaultLanguage == $key)
          continue;
        $key = explode('_', $key);
        $key = $key[0];
        if ($language == 'en')
          $id = "tab$tab";
        else
          $id = $language . "_tab$tab";
        $labelName = $languages[$key];
        $dummyid = $id . "_tabshowhide";
        $this->addElement('Dummy', $dummyid, array(
            'description' => "<a href='javascript:void(0);' onclick=\"showMoreOption('$dummyid')\" class=\"wrap\">Tab $tab for $labelName</a>",
        ));
        $this->$dummyid->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

        $this->addElement('Text', $id . '_name', array(
            'label' => "Tab $tab Title For $labelName",
            'description' => "Enter the title for Tab $tab for $labelName language.",
            'class' => 'upload_icon_row',
        ));

        $this->addElement('TinyMce', $id . '_body', array(
            'label' => "Tab $tab Content for $labelName",
            'editorOptions' => $editorOptions,
            'description' => "Enter the content for Tab $tab for $labelName language.",
            'class' => 'upload_icon_row',
        ));
      }
    }

    $this->addElement('Radio', 'short_code', array(
        'label' => "Use As Short Code",
        'description' => "Do you want to use this as a short code? [Note: If you choose “Yes”, then you will be able to configure various design settings. You can choose from Simple Accordion, Fixed Accordion or Tab Container while getting the shortcode.]",
        'multioptions' => array('1' => 'Yes', '0' => 'No'),
        'value' => 0,
        'onclick' => "showSettings(this.value);",
    ));

    $this->addElement('Text', 'height', array(
        'label' => 'Enter the height(in px).',
    ));

    $this->addElement('Text', 'headingBgColor', array(
        'label' => 'Heading Background Color',
        'description' => 'Heading Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'descriptionBgColor', array(
        'label' => 'Description Background Color',
        'description' => 'Description Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabBgColor', array(
        'label' => 'Background Color',
        'description' => 'Tab Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabActiveBgColor', array(
        'label' => 'Tab Active Background Color',
        'description' => 'Tab Active Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabTextBgColor', array(
        'label' => 'Tab Text Background Color',
        'description' => 'Tab Text Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabActiveTextColor', array(
        'label' => 'Tab Active Text Color',
        'description' => 'Tab Active Text Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'tabTextFontSize', array(
        'label' => "Tab Text Font Size.",
        'value' => '14'
    ));

    $this->addElement('Text', 'width', array(
        'label' => "Enter the width of widget(in px).",
        'value' => '100',
    ));

    // Add submit button
    $this->addElement('Button', 'save', array(
        'label' => 'Create',
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
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('save', 'submit', 'cancel'), 'buttons');
  }

}
