<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Form_Admin_Review_Category_Add extends Engine_Form {

  public function init() {
		

    $category_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    if ($category_id)
      $category = Engine_Api::_()->getItem('sesrecipe_category', $category_id);

    $this->setMethod('post');

    $this->addElement('Text', 'category_name', array(
        'label' => 'Category Name',
        'description' => 'The name is how it appears on your site.',
				'attribs'    => array('disabled' => 'disabled'),
        'allowEmpty' => false,
        'required' => true,
    ));
    
    $profiletype = array();
    $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('sesrecipe_review');
    if (count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type') {
      $profileTypeField = $topStructure[0]->getChild();
      $options = $profileTypeField->getOptions();
      $options = $profileTypeField->getElementParams('sesrecipe_review');
      unset($options['options']['order']);
      unset($options['options']['multiOptions']['0']);
      $profiletype = $options['options']['multiOptions'];
    }
    $this->addElement('Select', 'profile_type_review', array(
        'label' => 'Review Profile Type',
        'description' => 'Map this category with the profile type, so that questions belonging to the mapped profile type will appear to users while creating / editing their albums when they choose the associated Category.',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $profiletype
    ));
   
    $this->addElement('Button', 'submit', array(
        'label' => 'Add',
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
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }

}
