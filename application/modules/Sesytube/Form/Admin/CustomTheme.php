<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CustomTheme.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Form_Admin_CustomTheme extends Engine_Form {

  public function init() {

    $this->setTitle('Add New Custom Theme');
    $this->setMethod('post');

    $this->addElement('Text', 'name', array(
        'label' => 'Enter the new custom theme name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'sesytube')->getCustomThemes(array('all' => 1));
    foreach($getCustomThemes as $getCustomTheme){
      $sestheme[$getCustomTheme['customtheme_id']] = $getCustomTheme['name'];
    }

    $this->addElement('Select', 'customthemeid', array(
        'label' => 'Choose From Existing Theme',
        'multiOptions' => $sestheme,
        'escape' => false,
    ));

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
