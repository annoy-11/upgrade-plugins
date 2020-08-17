<?php  include APPLICATION_PATH .  '/application/modules/Epetition/views/scriptfile.tpl';?>
<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Emessages
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Level.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */


class Emessages_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
  public function init()
  {
    parent::init();
    // My stuff
    $this
      ->setTitle('Member Level Settings')
      ->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

    // Element: view
    if( !$this->isModerator() ) {
      unset($this->view->options[2]);
    }

    if( !$this->isPublic() ) {
	  //  $usersAllowed = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('messages', $viewer->level_id, 'auth');

      $this->addElement('Radio', 'lastseen', array(
        'label' => 'Enable Last Seen?',
        'description' => 'Do you want to enable last seen time of users? If you select Yes, then members will be able to choose to display their last seen to other members in Message Settings.',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
        ),
        'value' => 1,
      ));

      $this->addElement('Radio', 'online', array(
        'label' => 'Enable Online status?',
        'description' => 'Do you want to allow members to enable/disable their Online status?  If you select Yes, then members will be able to choose to display their Online status to other members in Message Settings.',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No',
        ),
        'value' => 1,
      ));

      $this->addElement('Radio', 'gifyview', array(
        'description' => 'Do you want to enable integration with Giphy to enable GIF in messages on your website?',
        'label' => 'Enable Giphy Integration for GIFs?',
        'multiOptions' => array(
            1=>'Yes',
            0=>'No'
        ),
        'value' => 1,
       ));

	    $this->addElement('Radio', 'messages_auth', array
	    (
		    'label' => 'Allow messaging?',
		    'description' => 'Do you want to allow members to message each other?',
		    'multiOptions' => array(
			    'everyone' => 'Everyone',
			    'friends'  => 'Friends Only',
			    'none' => 'Disable messaging',
		    ),
	    ));

      $this->addElement('Radio', 'editmessage', array(
        'label' => 'Allow to Edit Messages?',
        'description' => 'Do you want to allow members to edit their messages?',
        'multiOptions' => array(
          1=>'Yes',
          0=>'No'
        ),
        'value' => 0,
      ));

      $this->addElement('Radio', 'deletemessage', array(
        'label' => 'Delete Messages?',
        'description' => ' Do you want to allow members to delete messages.',
        'multiOptions' => array(
          1=>'Yes',
          0=>'No'
        ),
        'value' => 1,
      ));

      $this->addElement('Radio', 'groupadmin', array(
        'label' => 'Allow Group  admin?',
        'description' => 'Do you want to allow Group admin to mark member as admin in group ? If Yes selected then admin of group mark member as admin and more than 1 admin in group exists and the added admin can also add members in group. Also anytime group admin can unmark & remove added admin from group.',
        'multiOptions' => array(
          1=>'Yes',
          0=>'No'
        ),
        'value' => 1,
      ));

    }
  }
}

