<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Questionstatus.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

 
class Sesqa_Form_Admin_Questionstatus extends Engine_Form {

  public function init() {
  
    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'externals/ses-scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'externals/ses-scripts/jquery.min.js');
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $this->addElement(
          'Text',
          'fontSize',
          array(
              'label' => "Enter the font size for the Question Status(px)",
              'value' => '15',
              'required'=>true,
              'allowEmpty'=>false,
              'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
              )
          )
      );
      $this->addElement(
          'Text',
          'colorOpen',
          array(
              'label' => "Enter the color of the background of the Question Status(Open).",
              'value' => '#ffdfa1',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
       $this->addElement(
          'Text',
          'textColorOpen',
          array(
              'label' => "Enter the color of the text of the Question Status(Open).",
              'value' => '#000',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      $this->addElement(
          'Text',
          'colorClose',
          array(
              'label' => "Enter the color of the background of the Question Status(Closed).",
              'value' => '#ffdfa1',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
      $this->addElement(
          'Text',
          'textColorClose',
          array(
              'label' => "Enter the color of the text of the Question Status(Close).",
              'value' => '#000',
              'class' => 'SEScolor',
              'required'=>true,
              'allowEmpty'=>false,
          )
      );
  }
}