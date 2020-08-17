<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Notifications.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Dashboard_Notification extends Engine_Form {

  public function init() {
    $this->setTitle('Manage Notifications')
            ->setAttrib('id', 'manage_business')
            ->setDescription('Here, you can select the activities on your Business for which you want to receive notifications.')
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
    $notification['content_create_user'] = "New Photo Album created in Business";
    $notification['new_mention_business'] = "New Mention of Business";
    $notification['new_tagging_business'] = "New Tagging of Business";
    //$notification['new_review'] = "New Reviews";
    $notification['new_comment'] = "New Comments on Business Directory post";
    $notification['new_follow'] = "New Follow";
    $notification['new_favourite'] = "New Favourite";
    $notification['new_joinee'] = "New member Joining";
    $notification['new_like'] = "New Like";
    $notification['edit_post'] = "Edits to Posts you have written";
    //$notification['new_share'] = "New Shares on Business Directory posts";

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
