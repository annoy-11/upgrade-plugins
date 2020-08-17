<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Policy.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Dashboard_Policy extends Engine_Form {

  public function init() {
    $this->setTitle('Change Classroom Policies')
            ->setDescription('These fields display on Checkout page when clicked on Terms & Condition link.')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
            ->setMethod('POST');
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
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
    $this->addElement('TinyMce', 'term_and_condition', array(
        'label' => 'Terms and Conditions',
        'description' => 'Compose the “Terms and Conditions” for your Classroom.',
        'placeholder'=>'Start writing your course terms & conditions.',
        'editorOptions' => $editorOptions,
    ));
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
		$request = Zend_Controller_Front::getInstance()->getRequest();
    $controllerName = $request->getControllerName();
		if($controllerName != 'dashboard'){
			$this->addElement('Cancel', 'cancel', array(
					'label' => 'cancel',
					'link' => true,
					'prependText' => ' or ',
					'href' => '',
					'onclick' => 'parent.Smoothbox.close();',
					'decorators' => array(
							'ViewHelper'
					)
			));
			$this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
		}
  }

}
