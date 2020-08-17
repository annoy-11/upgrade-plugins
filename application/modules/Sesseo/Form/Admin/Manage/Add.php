<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Form_Admin_Manage_Add extends Engine_Form {

  public function init() {

    $this->setTitle('Integrate New Page')
            ->setDescription('Here, you can configure the required details for the page to be integrated.');

    $getAllPages = Engine_Api::_()->getDbtable('managemetatags', 'sesseo')->getAllPages();
    $getAllPageIds = array();
    foreach($getAllPages as $getAllPage) {
      $getAllPageIds[] = $getAllPage['page_id'];
    }

    $select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0);
    if($getAllPageIds) {
      $select->where('page_id NOT IN (?)', $getAllPageIds);
    }
    $results = $select->query()->fetchAll();

    $allpages = array();
    foreach($results as $result) {
      if(empty($result['title'])) continue;
      $allpages[$result['page_id']] = $result['title'];
    }

    $this->addElement('Select', 'page_id', array(
      'label' => 'Choose Widgitize Page',
      'description' => 'Below, you can choose widgitize page.',
      'allowEmpty' => false,
      'multiOptions' => $allpages,
    ));

    $this->addElement('Text', "meta_title", array(
        'label' => 'Meta Title',
        'description' => "Enter the meta title for this page.",
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Textarea', "meta_description", array(
        'label' => 'Meta Description',
        'description' => "Enter meta description for this page.",
        'maxlength' => '300',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '300')),
            new Engine_Filter_EnableLinks(),
        ),
    ));

    $this->addElement('File', 'photo_id', array(
        'label' => 'Meta Photo',
        'description' => "Choose a meta photo for this page.",
    ));
    $this->photo_id->addValidator('Extension', false, 'jpg,jpeg,png,gif,PNG,GIF,JPG,JPEG');

    $this->addElement('Checkbox', 'enabled', array(
        'description' => 'Enable This Plugin?',
        'label' => 'Yes, enable this plugin now.',
        'value' => 1,
    ));

    $this->addElement('Button', 'execute', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'prependText' => ' or ',
        'ignore' => true,
        'link' => true,
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'decorators' => array('ViewHelper'),
    ));
  }
}
