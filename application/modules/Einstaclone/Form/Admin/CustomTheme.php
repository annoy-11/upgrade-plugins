<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: CustomTheme.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_Form_Admin_CustomTheme extends Engine_Form {

  public function init() {

    $this->setTitle('Add New Custom Theme');
    $this->setMethod('post');

    $this->addElement('Text', 'name', array(
        'label' => 'Enter the new custom theme name.',
        'allowEmpty' => false,
        'required' => true,
    ));
    $einstaclone_adminmenu = Zend_Registry::isRegistered('einstaclone_adminmenu') ? Zend_Registry::get('einstaclone_adminmenu') : null;
    
    if($einstaclone_adminmenu) {
      $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);
      if(empty($customtheme_id)) {
          $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'einstaclone')->getCustomThemes(array('all' => 1));
          if(count($getCustomThemes) > 0) {
              foreach($getCustomThemes as $getCustomTheme){
              $sestheme[$getCustomTheme['theme_id']] = $getCustomTheme['name'];
              }

              $this->addElement('Select', 'customthemeid', array(
                  'label' => 'Choose From Existing Theme',
                  'multiOptions' => $sestheme,
                  'escape' => false,
              ));
          }
      }
    }
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}
