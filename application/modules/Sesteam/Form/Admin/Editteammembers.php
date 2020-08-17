<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editteammembers.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesteam_Form_Admin_Editteammembers extends Sesteam_Form_Admin_Addteammembers {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    parent::init();
    $this->setTitle('Edit Team Member')
            ->setDescription('Below, you can edit this team member. Here, you can not choose a different team member. If you want to choose any other team member, then first remove this member and then add a new one.')
            ->setMethod('POST');

    if ($type != 'nonsitemember') {
      $team_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('team_id', null);
      $user_id = Engine_Api::_()->getItem('sesteam_teams', $team_id)->user_id;
      $userDisplayname = Engine_Api::_()->getItem('user', $user_id)->displayname;
      $this->addElement('Text', "name", array(
          'label' => 'Member Name',
          'description' => "Display member name.",
          'disable' => true,
          'value' => $userDisplayname,
      ));
    }
  }

}