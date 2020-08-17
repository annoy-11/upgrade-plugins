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

class Sesforum_Form_Admin_Category_Create extends Engine_Form
{
  public function init()
  {
    parent::init();
    $this->setTitle('Create Category');

    // Element: title
    $this->addElement('Text', 'title', array(
      'label' => 'Category Title',
      'required' => true,
      'id'=>'tag-name',
      'allowEmpty' => false,
    ));

    $this->addElement('Text', 'slug', array(
        'label' => 'Slug',
        'allowEmpty' => false,
        'id'=>'tag-slug',
        'required' => true,
    ));

    $this->addElement('Text', 'description', array(
      'label' => 'Category Description'
    ));


    $getCategoriesAssoc = Engine_Api::_()->getDbTable('categories', 'sesforum')->getCategories();
    if(count($getCategoriesAssoc) > 1) {

        $this->addElement('Select', 'subcat_id', array(
            'label' => 'Choose Parent Category',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions' => $getCategoriesAssoc,
            'onchange'=>"getSubCategory(this.value,'subsubcat_id')",
            'registerInArrayValidator' => false,
        ));
         $this->addElement('Select', 'subsubcat_id', array(
            'label' => 'Choose Parent Sub Category',
            'id'=>'subsubcat_id',
            'allowEmpty' => true,
            'required' => false,
            'multiOptions'=>array('0'=>''),
            'registerInArrayValidator' => false,

        ));
    }

    $this->addElement('File', 'cat_icon', array(
      'label' => 'Category Icon (The icon will be resized to 48px * 48px)'
    ));

    // View Privacy Setting
    $levelOptions = array();
    foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
        $levelOptions[$level->level_id] = $level->getTitle();
    }
    $this->addElement('Multiselect', 'privacy', array(
        'label' => 'Who can view this category',
        'description' => 'Choose the member levels to which this category will be displayed. (Ctrl + Click to select multiple member levels.)',
        'allowEmpty' => true,
        'required' => false,
        'multiOptions' => $levelOptions,
        'value' => array_keys($levelOptions),
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick'=> 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));

    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
