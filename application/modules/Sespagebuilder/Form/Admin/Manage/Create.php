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
class Sespagebuilder_Form_Admin_Manage_Create extends Engine_Form {

  public function init() {

    $this->setTitle('Create New Widgetized Page')->setDescription('Here, you can create widgetized pages on your website using the WYSIWYG editor and for all the Languages on your website. Below, you can choose a short URL for your page, visibility, and add Meta tags which will help you in SEO.');

    $this->addElement('Text', 'title', array(
        'label' => 'Page Title',
        'description' => 'Enter a title for this page. [Note: This title will be used for your indicative purpose in “Manage Pages” section, but, if you want to show this title on the page too, then you can choose Yes for showing the title in the “Widgetized Page” widget on associated widgetized page.',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_StringLength(array('max' => '63'))
        ),
        'autofocus' => 'autofocus',
    ));

    $this->addElement('Text', 'pagebuilder_url', array(
        'label' => 'Page URL',
        'description' => 'Enter a short URL for this page.',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_StringLength(array('max' => '63'))
        ),
        'autofocus' => 'autofocus',
    ));
    $this->pagebuilder_url->getDecorator("Description")->setOption("placement", "append");

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

    $languageList = Zend_Registry::get('Zend_Translate')->getList();
    foreach ($languageList as $key => $language) {
      if ($defaultLanguage != $key)
        continue;
      $key = explode('_', $key);
      $key = $key[0];
      if ($language == 'en')
        $coulmnName = 'body';
      else
        $coulmnName = $language . '_body';
      if (count($languageList) == '1')
        $label = 'Page Content';
      else
        $label = 'Page Content for ' . $languages[$key];
      $this->addElement('TinyMce', $coulmnName, array(
          'label' => $label,
          'required' => true,
          'allowEmpty' => false,
          'editorOptions' => $editorOptions,
      ));
    }

    foreach ($languageList as $key => $language) {
      if ($defaultLanguage == $key)
        continue;
      $key = explode('_', $key);
      $key = $key[0];
      if ($language == 'en')
        $coulmnName = 'body';
      else
        $coulmnName = $language . '_body';

      if (count($languageList) == '1')
        $label = 'Page Content';
      else
        $label = 'Page Content for ' . $languages[$key];
      $this->addElement('TinyMce', $coulmnName, array(
          'label' => $label,
          'editorOptions' => $editorOptions,
      ));
    }

    $this->addElement('Radio', 'show_menu', array(
        'label' => 'Display Page Menu Item',
        'description' => 'Choose from below where do you want to display this page’s menu item link on your website? [If you want to show this page link somewhere else instead of Main, Mini or Footer menus, then choose “None of the above.” option.]',
        'multiOptions' => array(
            0 => 'In Mini Navigation Menu Bar.',
            1 => 'In Main Navigation Menu Bar.',
            2 => 'In Footer Menu Bar.',
            3 => 'None of the above.',
        ),
        'value' => 0,
    ));

    $levelOptions = array();
    $levelValues = array();
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
      $levelOptions[$level->level_id] = $level->getTitle();
      $levelValues[] = $level->level_id;
    }
    // Select Member Levels
    $this->addElement('multiselect', 'member_levels', array(
        'label' => 'Member Levels',
        'multiOptions' => $levelOptions,
        'description' => 'Choose the Member Levels to which this Page will be displayed.',
        'value' => $levelValues,
    ));

    $networkOptions = array();
    $networkValues = array();
    foreach (Engine_Api::_()->getDbtable('networks', 'network')->fetchAll() as $network) {
      $networkOptions[$network->network_id] = $network->getTitle();
      $networkValues[] = $network->network_id;
    }

    // Select Networks
    $this->addElement('multiselect', 'networks', array(
        'label' => 'Networks',
        'multiOptions' => $networkOptions,
        'description' => 'Choose the Networks to which this Page will be displayed.',
        'value' => $networkValues,
    ));

    $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('user');
    if (count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type') {
      $profileTypeField = $topStructure[0]->getChild();
      $options = $profileTypeField->getOptions();
      if (count($options) > 1) {
        $options = $profileTypeField->getElementParams('user');
        unset($options['options']['order']);
        unset($options['options']['multiOptions']['']);
        $optionValues = array();
        foreach ($options['options']['multiOptions'] as $key => $option) {
          $optionValues[] = $key;
        }

        $this->addElement('multiselect', 'profile_types', array(
            'label' => 'Profile Types',
            'multiOptions' => $options['options']['multiOptions'],
            'description' => 'Which Profile Types do you want to see this Slideshow?',
            'value' => $optionValues
        ));
      } else if (count($options) == 1) {
        $this->addElement('Hidden', 'profile_types', array(
            'value' => $options[0]->option_id
        ));
      }
    }

//     $this->addElement('Radio', 'show_page', array(
//         'label' => 'Show to Non-logged in Users',
//         'description' => 'Do you want to show this Page to non-logged in users of your website?',
//         'multiOptions' => array(
//             '1' => 'Yes',
//             '0' => 'No',
//         ),
//         'value' => "1",
//     ));

    $this->addElement('Text', 'html_title', array(
        'label' => 'Meta Title',
        'description' => 'Enter the HTML Meta Title of this Page.',
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_StringLength(array('max' => '63'))
        ),
        'autofocus' => 'autofocus',
    ));

    $this->addElement('Text', 'description', array(
        'label' => 'Meta Description',
        'description' => 'Enter the HTML Meta Description of this Page.',
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
        ),
        'autofocus' => 'autofocus',
    ));

    $this->addElement('Text', 'html_keywords', array(
        'label' => 'Meta Keywords',
        'description' => 'Enter the HTML Meta Keywords of this Page.',
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_StringLength(array('max' => '63'))
        ),
        'autofocus' => 'autofocus',
    ));

    $this->addElement('Checkbox', 'search', array(
        'label' => 'Yes, show this page in search results.',
        'description' => 'Show In Search',
    ));

    $this->addElement('Checkbox', 'enable', array(
        'label' => 'Yes, enable this page.',
        'description' => 'Enable This Page',
    ));

    $this->addElement('Radio', 'draft', array(
        'label' => 'Choose Status',
        'multiOptions' => array("1" => "Save As Draft", "0" => "Published"),
        'description' => 'If this entry is published, it cannot be switched back to draft mode.',
        'value' => ''
    ));

    // Add submit button
    $this->addElement('Button', 'save', array(
        'label' => 'Save Changes',
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
