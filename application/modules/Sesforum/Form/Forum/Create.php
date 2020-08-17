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

class Sesforum_Form_Forum_Create extends Engine_Form
{
  public function init()
  {
    $this->setTitle('Create Forum');

    // Element: title
    $this->addElement('Text', 'title', array(
      'label' => 'Forum Title',
      'order' => 1,
    ));

    // Element: description
    $this->addElement('Text', 'description', array(
      'label' => 'Forum Description',
      'order' => 2,
    ));

    // Element: category_id
    $category_id = new Engine_Form_Element_Select('category_id', array(
      'label' => 'Category',
      'order' => 3,
    ));

    $this->addElement($category_id);
    $categories = Engine_Api::_()->getItemTable('sesforum_category')->fetchAll();
    foreach( $categories as $category ) {
      $category_id->addMultiOption($category->getIdentity(), $category->title);
    }

    // Element: submit
    $this->addElement('Button', 'execute', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper'),
      'order' => 20,
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
      'order' => 21,
    ));

    $this->addDisplayGroup(array(
      'execute',
      'cancel'
    ), 'buttons', array(
      'order' => 22,
    ));
  }
}
