<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Notification.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Form_Dashboard_Notification extends Engine_Form {

  public function init() {
    $this->setTitle('Manage Notifications')
            ->setAttrib('id', 'manage_classroom')
            ->setDescription('Here, you can select the activities on your Classroom for which you want to receive notifications.')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $options['site_notification'] = "Site Notifications";
    $options['email_notification'] = "Email Notifications";
    $options['both'] = "Both";
    $options['turn_off'] = "Turn Off Notifications";
    $this->addElement('Radio', 'notification_type', array(
        'label' => 'Select the type of notifications you want to enable.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions'=>$options,
        'value'=>'both'
    ));
    $notification['new_post'] = "New Post from users";
    $notification['content_create_user'] = "New Photo Album created in Classroom";
    $notification['new_mention_classroom'] = "New Mention of Classroom";
    $notification['new_tagging_classroom'] = "New Tagging of Classroom";
    $notification['new_comment'] = "New Comments on Classroom Marketplace post";
    $notification['new_follow'] = "New Follow";
    $notification['new_favourite'] = "New Favourite";
    $notification['new_joinee'] = "New member Joining";
    $notification['new_like'] = "New Like";
    $notification['edit_post'] = "Edits to Posts you have written";
    $this->addElement('MultiCheckbox', 'notifications', array(
        'label' => 'Select the type of notifications you want to enable.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions'=>$notification,
        'value'=>array_keys($notification)
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
