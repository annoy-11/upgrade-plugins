<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Claim.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_Form_Claim extends Engine_Form
{
 
  public function init() { 
  
    $this->setTitle('Claim For Article')
      ->setDescription('')
      ->setAttrib('name', 'sesarticle_calim')
      ->setAttrib('id', 'sesarticle_claim_create');

    $viewer = Engine_Api::_()->user()->getViewer();
      
    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'placeholder' => 'Enter Article Title',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '63'))
      ),
      'autofocus' => 'autofocus',
    ));
    $this->addElement('Hidden', 'article_id', array());
    
		$this->addElement('Text', 'user_name', array(
			'label' => 'Your Name',
			'allowEmpty' => false,
			'required' => true,
			'filters' => array(
				new Engine_Filter_Censor(),
				new Engine_Filter_HtmlSpecialChars(),
			),
			'value'=>$viewer->displayname,
		));
		$this->addElement('Text', 'user_email', array(
			'label' => 'Your Email',
			'required' => true,
			'allowEmpty' => false,
			'validators' => array(
				'EmailAddress'
			),
			'filters' => array(
				new Engine_Filter_Censor(),
				new Engine_Filter_HtmlSpecialChars(),
			),
			'value'=>$viewer->email,
		));
		
		$this->addElement('Text', 'contact_number', array(
      'label' => 'Contact Number',
    ));
    
    $this->addElement('textarea', 'description', array(
      'label' => 'Reason For Claim',
      'required' => true,
			'allowEmpty' => false,
    ));
    
    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Submit',
      'type' => 'submit',
    ));
  }
}
