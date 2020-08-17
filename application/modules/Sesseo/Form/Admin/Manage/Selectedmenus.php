<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Selectedmenus.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Form_Admin_Manage_Selectedmenus extends Engine_Form {

  public function init() {

    $content_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('content_id', 0);
    $content = Engine_Api::_()->getItem('sesseo_content', $content_id);


    $menustable = Engine_Api::_()->getDbTable('menus', 'core');
    $select = $menustable->select();
    $allmenus = $menustable->fetchAll($select);

    $finalArray = array();
    foreach($allmenus as $allmenu) {
        $finalArray[$allmenu->id] = $allmenu->title;
    }

    $sesseo_select_menus = Engine_Api::_()->getApi('settings','core')->getSetting('sesseo_select_menus','');

    $this->setTitle("Select Menu for Sitemap");
    $this->setDescription("Below, you can select menu that you want to add in to sitemap.");

    $this->addElement('MultiCheckbox', 'sesseo_select_menus', array(
      'label' => 'Select Menus',
      'description' => 'You can select menus.',
      //'allowEmpty' => false,
      'multiOptions' => $finalArray,
      'value' => json_decode($sesseo_select_menus),
    ));

    $this->addElement('Button', 'execute', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => "javascript:parent.Smoothbox.close();",
        'href' => "javascript:void(0);",
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }
}
