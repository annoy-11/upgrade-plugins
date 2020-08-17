<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Messages.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Otpsms_Form_Admin_Messages extends Engine_Form
{
  public function init()
  {
    
    $this
      ->setTitle('Manage & Send Messages')
      ->setDescription('Here, you can send messages to the members of your website who have signed up via phone numbers. The message will be sent as SMS on their phones.')
      ->setAttribs(array(
        'id' => '',
        'class' => '',
      ))
      ->setMethod('POST');

   
    $type = new Zend_Form_Element_Select('type');
    $this->addElement('Select','type',array(
      'label'=>'Dependent On',
      'multiOptions'=>array('profiletype'=>'Profile Types','memberlevel'=>'Member Levels')
    ));
    
    
    // Element: profile_type
    $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('user');
    if( count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type' ) {
      $profileTypeField = $topStructure[0]->getChild();
      $options = $profileTypeField->getOptions();
      $options_array = array();
      foreach( $options as $value )
        $options_array[] = $value['option_id'];
      if( count($options) > 1 ) {
        $options = $profileTypeField->getElementParams('user');
        unset($options['options']['order']);
        unset($options['options']['required']);
        $profiletype = new Zend_Form_Element_Select('profiletype');
        $this->addElement('Select','profiletype',array(
          'label'=>'Profile Type',
          'multiOptions'=>$options['options']['multiOptions']
        ));
       
      } else if( count($options) == 1 ) {
        $this->addElement('Hidden','profiletype',array(
          'value'=>$options[0]['option_id'],
			'order'=>99999
        ));
      }
    }
    
    

    $levelOptions = array();
    $levelOptions[0] = "All member levels";
    foreach( Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level ) {
      $levelOptions[$level->level_id] = $level->getTitle();
    }

    $this->addElement('Select','memberlevel',array(
      'label'=>'Member Level',
      'multiOptions'=>$levelOptions
    ));
   
    $this->addElement('Select','sendto',array(
      'label'=>'Send To',
      'multiOptions'=>array(''=>'All Members','specific'=>'Specific Member')
    ));
    
    $this->addElement('Text','user',array(
      'label'=>'Member Name',
      'description' => 'Start typing the name of the member and choose the member from the auto-suggest list in below field.',
    ));
    
  
    
    $user_id = new Zend_Form_Element_Hidden('user_id');
    $this->addElement('Hidden','user_id');
    $this->addElement('Textarea','message',array(
      'label'=>'Message',
      'allowEmpty'=>false,
      'required'=>'true'
    ));
   
    $this->addElement('Button', 'submit', array(
        'label' => 'Send Message',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    
    
    
    
    
  }
}