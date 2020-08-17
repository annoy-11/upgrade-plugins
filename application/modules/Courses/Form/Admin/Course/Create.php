<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Create.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Admin_Course_Create extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Course Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of courses on your website. The settings enabled or disabled will affect Course creation page and edit page');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->addElement('Radio', 'courses_page_redirect', array(
          'label' => 'Redirection After Course Creation',
          'description'=>'Choose from below where you want to redirect users after a Course is successfully created.',
          'multiOptions' => array(0 => 'On Course Dashboard',1 => 'On Course Profile Page'),
          'value' => $settings->getSetting('courses.page.redirect', 1),
    ));
    $this->addElement('Radio', 'courses_create_accordian', array(
        'label' => 'Create Course Form Type',
        'description' => 'What type of Form you want to show on Create New Course?',
        'multiOptions' => array(0 => 'Default SE Form',1 => 'Designed Form'),
        'value' => $settings->getSetting('course.create.accordian', 1),
    ));
    $this->addElement('Select', 'courses_autoopenpopup', array(
        'label' => 'Auto-Open Advanced Share Popup',
        'description' => 'Do you want the "Advanced Share Popup" to be auto-populated after the Course is created? [Note: This setting will only work if you have placed Advanced Share widget on Course View or Course Dashboard, wherever user is redirected just after Course creation.]',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.autoopenpopup', 1),
    ));
    $this->addElement('Radio', 'courses_enable_description', array(
        'label' => 'Enable Course Description',
        'description' => 'Do you want to enable description of Course on your website?',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.enable.description', 1),
        'onclick' => 'showCourseDescription(this.value);',
    ));
    $this->addElement('Radio', 'courses_wysiwyg_editor', array(
        'label' => 'Enable WYSIWYG editor for description',
        'description' => 'Do you want to enable the WYSIWYG Editor for the Course description? If you choose No, then simple text area will be displayed.',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.wysiwyg.editor', 1),
    ));
    $this->addElement('Radio', 'courses_description_mandatory', array(
        'label' => 'Make Course Description Mandatory',
        'description' => 'Do you want to make Description field mandatory when users create or edit their Course ?',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.description.mandatory', 0),
    ));
    $this->addElement('Radio', 'courses_enable_category', array(
        'label' => 'Enable Category',
        'description'=>'Do you want to enable category of Course on your website?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.enable.category', 0),
        'onclick' => 'showCourseCategory(this.value);',
    ));
    $this->addElement('Radio', 'courses_category_mandatory', array(
        'label' => 'Make Course Category Mandatory',
        'description'=>'Do you want to make category field mandatory when users create or edit their Course ?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.category.mandatory', 0),
    ));
    $this->addElement('Radio', 'courses_main_photo', array(
        'label' => 'Enable Main Photo Courses',
        'description' => 'Do you want to enable main photo field in create form?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.main.photo', 1),
        'onclick' => 'showCoursePhoto(this.value);',
    ));
    $this->addElement('Radio', 'courses_mainPhoto_mandatory', array(
        'label' => 'Make Course Main Photo Mandatory',
        'description' => 'Do you want to make course main photo field mandatory when users create or edit their Course ?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.mainPhoto.mandatory', 1),
    ));
    $this->addElement('Radio', 'courses_enable_addcourseshortcut', array(
            'label' => 'Show "Create New Course" Icon',
            'description' => 'Do you want to show "Create New Course" icon in the bottom right side of all pages of this plugin?',
            'multiOptions' => array('1' => 'Yes','0' => 'No'),
            'value' => $settings->getSetting('courses.enable.addcourseshortcut', 1),
            'onclick'=>'showQuickOption(this.value);'
    ));
    $this->addElement('Radio', 'courses_icon_open_smoothbox', array(
        'label' => 'Page or Popup From Create Icon',
        'description' => "Do you want to open the 'Create New Course' form in popup or page, when users click on the 'Create New Course Icon' in the bottom right side of all pages of this plugin?",
        'multiOptions' => array('1' => 'Open Create Course Form in popup','0' => 'Open Create Course Form in page',),
        'value' => $settings->getSetting('courses.icon.open.smoothbox', 1),
    ));
    $this->addElement('Radio', 'courses_coursetags', array(
        'label' => 'Enable Tags',
        'description' => 'Do you want to enable tags for the Courses on your website?',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.coursetags', 1),
    ));
    $this->addElement('Radio', 'courses_enable_discount', array(
        'label' => 'Enable Discount',
        'description' => 'Do you want to enable discounts for courses on your website? If you choose Yes, then Course owners can configure discounts for their courses.',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.enable.discount', 1),
    ));
    $this->addElement('Radio', 'courses_purchasenote', array(
        'label' => 'Enable Purchase Note',
        'description' => 'Do you want to enable to enter PurchaseNote for the Courses? If selected yes then in  course dashboard Purchase note field will display and the entered text will display on Corse view page.',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.purchasenote', 1),
    ));
    $this->addElement('Radio', 'courses_start_date', array(
        'label' => 'Enable Custom Course Start Date',
        'description' => 'Do you want to enable custom start date for courses?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.start.date', 1),
    ));
    $this->addElement('Radio', 'courses_end_date', array(
        'label' => 'Enable Custom End Date',
        'description' => 'Do you want to enable custom end date for courses?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.end.date', 1),
    ));
    $this->addElement('Radio', 'courses_search', array(
        'label' => 'Enable "People can search for this Course" Field',
        'description' => 'Do you want to enable “People can search for this Course” field while creating and editing Course on your website?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.search', 1),
    ));
// 		$this->addElement('Radio', 'courses_guidelines', array(
//         'label' => 'Enter Guidelines for Course',
//         'description' => 'Do you want to provide course owners with some Guidelines? If yes, then the box containing the guidelines will remain static on the top right of the create form when user scroll down the form.',
//         'multiOptions' => array(
//             1 => 'Yes',
//             0 => 'No',
//         ),
//         'value' => $settings->getSetting('courses.guidelines', 1),
//         'onclick' => 'showGuideEditor(this.value)',
//     ));
// 
//     $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';
// 
//     $editorOptions = array(
//         'html' => (bool) $allowed_html,
//     );
//     $editorOptions['plugins'] = array(
//         'preview', 'code',
//     );
//     $this->addElement('TinyMce', 'courses_message_guidelines', array(
//         'label' => 'Enter Guidelines',
//         'class' => 'tinymce',
//         'editorOptions' => $editorOptions,
//         'value' => $settings->getSetting('courses.message.guidelines', ''),
//     ));

       // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));

  }

}
