<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditSiteTeam.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupteam_Form_EditSiteTeam extends Sesgroupteam_Form_AddSiteTeam {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    parent::init();
    $this->setTitle('Edit Team')
      ->setDescription('')
      ->setAttrib('name', 'sesgroupteam_addteam')
      ->setAttrib('class', 'sesgroupteam_formcheck global_form');
    if ($type != 'nonsitemember') {
      $team_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('team_id', null);
      $user_id = Engine_Api::_()->getItem('sesgroupteam_team', $team_id)->user_id;
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
