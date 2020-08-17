<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditSiteTeam.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageteam_Form_EditSiteTeam extends Sespageteam_Form_AddSiteTeam {

  public function init() {
  
    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    parent::init();
    $this->setTitle('Edit Team')
      ->setDescription('')
      ->setAttrib('name', 'sespageteam_addteam')
      ->setAttrib('class', 'sespageteam_formcheck global_form');
    if ($type != 'nonsitemember') {
      $team_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('team_id', null);
      $user_id = Engine_Api::_()->getItem('sespageteam_team', $team_id)->user_id;
      $userDisplayname = Engine_Api::_()->getItem('user', $user_id)->displayname;
      $this->addElement('Text', "name", array(
          'label' => 'Member Name',
          'description' => "Display member name.",
          'disable' => true,
          'value' => $userDisplayname,
      ));
    }
    $this->submit->setLabel('Save Changes');
  }
}