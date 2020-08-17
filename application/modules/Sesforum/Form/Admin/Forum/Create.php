<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Form_Admin_Forum_Create extends Engine_Form
{
  public function init()
  {
    parent::init();
     $this->setTitle('Create Forum');
    // Element: title
    $this->addElement('Text', 'title', array(
      'label' => 'Forum Title',
       'allowEmpty' => false,
       'required' => true,
    ));

    // Element: description
    $this->addElement('Text', 'description', array(
      'label' => 'Forum Description',
    ));

    // Element: category_id
//     $category_id = new Engine_Form_Element_Select('category_id', array(
//       'label' => 'Category',
//     ));
//
//     $this->addElement($category_id);
//     $categories = Engine_Api::_()->getItemTable('sesforum_category')->fetchAll();
//     foreach( $categories as $category ) {
//       $category_id->addMultiOption($category->getIdentity(), $category->title);
   // }


    $getCategoriesAssoc = Engine_Api::_()->getDbTable('categories', 'sesforum')->getCategories();
    if(count($getCategoriesAssoc) > 1) {

        $this->addElement('Select', 'category_id', array(
            'label' => 'Choose Category',
            'allowEmpty' => false,
            'required' => true,
            'multiOptions' => $getCategoriesAssoc,
            'onchange'=>"getSubCategory(this.value,'subcat_id')",
            'registerInArrayValidator' => false,
        ));
         $this->addElement('Select', 'subcat_id', array(
            'label' => 'Choose  Sub Category',
            'id'=>'subcat_id',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions'=>array('0'=>''),
            'onchange'=>"getSubSubCategory(this.value,'subsubcat_id')",
            'registerInArrayValidator' => false,

        ));

        $this->addElement('Select', 'subsubcat_id', array(
            'label' => 'Choose Sub Sub Category',
            'id'=>'subsubcat_id',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions'=>array('0'=>''),
            'registerInArrayValidator' => false,

        ));
    }

    // Element: levels
    $levels = Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll();
    $multiOptions = array();
    foreach( $levels as $level ) {
      $multiOptions[$level->getIdentity()] = $level->getTitle();
    }
    reset($multiOptions);
    $this->addElement('Multiselect', 'levels', array(
      'label' => 'Member Levels',
      'multiOptions' => $multiOptions,
      'value' => array_keys($multiOptions),
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('File', 'forum_icon', array(
      'label' => 'Forum Icon (The icon will be resized to 100px * 100px)',
    ));

    // Element: submit
    $this->addElement('Button', 'execute', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper'),
    ));

    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick' => 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      ),
    ));

    $this->addDisplayGroup(array(
      'execute',
      'cancel'
    ), 'buttons', array(
    ));

  }
}
