<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CustomTheme.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_Form_Admin_CustomTheme extends Engine_Form {

  public function init() {

    $this->setTitle('Add New Custom Theme');
    $this->setMethod('post');

    $this->addElement('Text', 'name', array(
        'label' => 'Enter the new custom theme name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);
    if(empty($customtheme_id)) {
        $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'sestwitterclone')->getCustomThemes(array('all' => 1));
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
