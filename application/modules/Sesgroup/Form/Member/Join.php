<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Join.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_Form_Member_Join extends Engine_Form {

  public function init() {
    $this->setTitle('Join Group')
            ->setDescription('Would you like to join this group?')
            ->setMethod('POST')
            ->setAction($_SERVER['REQUEST_URI']);
    $this->addElement('Button', 'submit', array(
        'label' => 'Join Group',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
        'type' => 'submit'
    ));
    $this->addElement('Cancel', 'cancel', array(
        'prependText' => ' or ',
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'onclick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
