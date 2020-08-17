<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AddRecord.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Profile_AddRecord extends Engine_Form {

  public function init() { 
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    
    $getSpeciality = Engine_Api::_()->getDbTable('specialties', 'sesprofilefield')->getSpeciality(array('user_id' => $viewer_id));
    $athletic_specialties = json_decode($getSpeciality->athletic_specialties);
  
    $this->setTitle('Add Personal Records')
        ->setDescription('')
        ->setAttrib('name', 'sesprofilefield_addrecord')
        ->setAttrib('class', 'sesprofilefield_formcheck global_form');
    
    $adminspecialties = Engine_Api::_()->getDbtable('adminspecialties', 'sesprofilefield')->getSpecialty(array('column_name' => '*', 'param' => 'athletic'));
    
    foreach($adminspecialties as $specialty) {
      
      if(in_array($specialty->adminspecialty_id , $athletic_specialties)) {
      
        $subspecialty = Engine_Api::_()->getDbtable('adminspecialties', 'sesprofilefield')->getModuleSubspecialty(array('column_name' => "*", 'adminspecialty_id' => $specialty->adminspecialty_id));
        
        if(count($subspecialty) > 0 ) {
          $this->addElement('dummy', 'recordsmain_'.$specialty->adminspecialty_id.'_main', array(
            'content' => $specialty->name,
          ));
          
          foreach($subspecialty as $sub_specialty) {

            $subsubspecialty = Engine_Api::_()->getDbtable('adminspecialties', 'sesprofilefield')->getModuleSubsubspecialty(array('column_name' => "*", 'adminspecialty_id' => $sub_specialty->adminspecialty_id));
            
            $this->addElement('dummy', 'recordsmainsub_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id, array(
              'content' => $sub_specialty->name,
            ));
            
            foreach ($subsubspecialty as $subsub_specialty) {
        
              $type = json_decode($subsub_specialty->type);
              if(count($type) > 0) {

              //  $this->addElement('dummy', $specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id, array(
//                  'content' => $subsub_specialty->name,
//                ));
                
                
                if(in_array('minutes', $type)) {
                  $this->addElement('Text','records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_minutes', array(
										'label' => $subsub_specialty->name,
                    'placeholder' => "Minutes",
                  ));
                } 
                
                if(in_array('seconds', $type)) {
                  $this->addElement('Text','records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_seconds', array(
										'label' => $subsub_specialty->name,
                    'placeholder' => "Seconds",
                  ));
                }
                
                if(in_array('reps', $type)) {
                  $this->addElement('Text','records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_reps', array(
										'label' => $subsub_specialty->name,
                    'placeholder' => "REPS",
                  ));
                }
                if(in_array('lbs', $type)) {
                  $this->addElement('Text','records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_lbs', array(
										'label' => $subsub_specialty->name,
                    'placeholder' => "LBS",
                  ));
                }
                if(in_array('lbskg', $type)) {
                  $this->addElement('Text','records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_lbskg', array(
										'label' => $subsub_specialty->name,
                    'placeholder' => "LBS or KG",
                  ));
                }    
              }
							
							$this->addDisplayGroup(array('records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_minutes','records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_seconds','records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_reps','records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_lbs', 'records_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_lbskg'), $specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_recordgroup', array('disableLoadDefaultDecorators' => true));
              $education = $this->getDisplayGroup($specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_recordgroup');
              $education->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'recordsgrp_'.$specialty->adminspecialty_id.'_'.$sub_specialty->adminspecialty_id.'_'.$subsub_specialty->adminspecialty_id.'_recordgroup', 'style' => 'position:relative'))));
            }
          }
        }
      }
    }
    
/*    
    for($i = 0;$i <= 5; $i++) {
      
      $this->addElement('Text',.$i.'["minutes"]', array(
        'placeholder' => "Minutes",
      ));
      
      $this->addElement('Text', 'benchmark_'.$i.'["seconds"]', array(
        'placeholder' => "Seconds",
      ));
      
		  $this->addDisplayGroup(array('benchmark_minute_' . $i,'benchmark_seconds_' . $i), 'benchmark_'.$i, array('disableLoadDefaultDecorators' => true));
	    $benchmark = $this->getDisplayGroup('benchmark_'.$i);
	    $benchmark->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'benchmark_'.$i, 'style' => 'position:relative'))));
        
    }*/


    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'Cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'javascript:sessmoothboxclose();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}