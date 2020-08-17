<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Findquestions.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

 
class Sesqa_Form_Admin_Findquestions extends Engine_Form {

  public function init() {
  
    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'externals/ses-scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'externals/ses-scripts/jquery.min.js');
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      
          $this->addElement (
                    'MultiCheckbox',
                    'enableTabs',
                    array(
                        'label' => "Choose the criteria for contests.",
                        'multiOptions' => array(
                            'today' => 'Today',
                            'week' => 'This Week',
                            'month' => 'This Month',
                            'dateCriteria' => 'Choose Date [Calendar will get open at user end for choosing dates]',
                            'category' => 'Categories',
                        ),
                    )
                
                );
                $this->addElement (
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of categories to show in Less view)',
                        'value' => 5,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                );
                $this->addElement (
                    'Radio',
                    'viewMore',
                    array(
                        'label' => "Do you want to give More / Less option for category display in this widget?",
                        'multiOptions' => array(
                            'yes' => 'Yes',
                            'no' => 'No',
                        ),
                        'value' => 'yes',
                    )
                );
        
      $this->addElement(
          'Text',
          'thisweek',
          array(
              'label' => "Enter the background color of 'This Week' block.",
              'value' => '#f35369',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      $this->addElement(
          'Text',
          'thisweekTextColor',
          array(
              'label' => "Enter the text color of 'This Week' block.",
              'value' => '#fff',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      
      $this->addElement(
          'Text',
          'today',
          array(
              'label' => "Enter the background color of 'Today' block.",
              'value' => '#4267b2',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      $this->addElement(
          'Text',
          'todayTextColor',
          array(
              'label' => "Enter the text color of 'Today' block.",
              'value' => '#fff',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      
      $this->addElement(
          'Text',
          'thismonth',
          array(
              'label' => "Enter the background color of 'This Month' block.",
              'value' => '#39c355',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      $this->addElement(
          'Text',
          'thismonthTextColor',
          array(
              'label' => "Enter the text color of 'This Month' block.",
              'value' => '#fff',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      
      $this->addElement(
          'Text',
          'choosedate',
          array(
              'label' => "Enter the background color of 'Choose Date' block.",
              'value' => '#bec2c9',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      $this->addElement(
          'Text',
          'choosedateTextColor',
          array(
              'label' => "Enter the text color of 'Choose Date' block.",
              'value' => '#fff',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
  }
}