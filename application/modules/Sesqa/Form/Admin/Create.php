<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Form_Admin_Create extends Engine_Form {

  public function init() {

    $this->setTitle('Create Settings')
            ->setDescription('These settings affect all members in your community.');
    $settings = Engine_Api::_()->getApi('settings', 'core');

    
    $this->addElement('Radio', 'qanda_allow_category', array(
        'description' => 'Do you want to enable categories for the Questions posted on your site?',
        'label' => 'Enable Category',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('qanda.allow.category', '1'),
    ));
    
    $this->addElement('Radio', 'qanda_category_mandatory', array(
        'description' => 'Do you want to make category field mandatory when users create or edit their Questions?',
        'label' => 'Make Question Categories Mandatory',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('qanda.category.mandatory', '1'),
    ));
    
    $this->addElement('Radio', 'qanda_enable_poll', array(
         'description' => 'Do you want to enable question owners to add Poll type answers to their questions on your site?',
        'label' => 'Enable Poll Answers',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('qanda.enable.poll', '1'),
    ));
    
    $this->addElement('Radio', 'qanda_polltype_questions', array(
        'description' => 'Do you want users to select Multiple Answers in questions with poll type answers?',
        'label' => 'Multi-select in Poll Answers',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value' => $settings->getSetting('qanda.polltype.questions', '0'),
    ));
    
    $this->addElement('MultiCheckbox', 'qanda_create_mediaoptions', array(
        'description' => 'Choose the media types that you want to enable for questions on your site. If you do not want any media, then simply do not choose any option.',
        'label' => 'Enable Media',
        'multiOptions'=>array('image'=>'Image','video'=>'Video'),
        'value' => $settings->getSetting('qanda.create.mediaoptions', array('image','video')),
    ));
    
    $this->addElement('Radio', 'qanda_create_editor', array(
        'description' => 'Choose from below the Editor of the form for Question Create Page. ',
        'label' => 'Create Question Form Type',
        'multiOptions'=>array('editor'=>'WYSIWYG Editor','simple'=>'Simple Textarea'),
        'value'=>$settings->getSetting('qanda_create_editor', 'editor'),
    ));
    $this->addElement('Radio', 'qanda_create_tags', array(
        'description' => 'Do you want to enable tags for the Questions on your website?',
        'label' => 'Enable Tags',
        'multiOptions'=>array('1'=>'Yes','0'=>'No'),
        'value'=>$settings->getSetting('qanda_create_tags', '1'),
    ));
    
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    
  }

}
