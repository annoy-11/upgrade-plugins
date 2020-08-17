<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Notifications.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Dashboard_Notification extends Engine_Form {

  public function init() {
    $this->setTitle('Manage Notifications')
            ->setAttrib('id', 'manage_store')
            ->setDescription('Here, you can select the activities on your Store for which you want to receive notifications.')
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
    $notification['content_create_user'] = "New Photo Album created in Store";
    $notification['new_mention_store'] = "New Mention of Store";
    $notification['new_tagging_store'] = "New Tagging of Store";
    //$notification['new_review'] = "New Reviews";
    $notification['new_comment'] = "New Comments on Store Marketplace post";
    $notification['new_follow'] = "New Follow";
    $notification['new_favourite'] = "New Favourite";
    $notification['new_joinee'] = "New member Joining";
    $notification['new_like'] = "New Like";
    $notification['edit_post'] = "Edits to Posts you have written";
    //$notification['new_share'] = "New Shares on Store Directory posts";

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
