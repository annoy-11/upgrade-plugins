<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Avatar.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_Form_Avatar extends Engine_Form {

  public function init() {

    $userId = Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id', 0);
    $rowExists = Engine_Api::_()->getDbTable('avatars', 'sesavatar')->rowExists($userId);

    $hours = 0;
    if(!empty($rowExists)) {
      $creation_date = $rowExists->creation_date;

      $date1 = $creation_date;
      $date2 = date('Y-m-d H:i:s');
      $seconds = strtotime($date2) - strtotime($date1);
      $hours = $seconds / 60;
    }

    if(empty($rowExists)) {

      $this->setTitle('Choose Avatar')
              ->setDescription('From below you can choose avatar.');

      $images = Engine_Api::_()->getDbtable('images', 'sesavatar')->getImages(array('enabled' => 1, 'fetchAll' => 1));

      $options = array();
      foreach ($images as $image) {

        $imageItem = Engine_Api::_()->getItem('sesavatar_image', $image->image_id);
        $photo = Engine_Api::_()->storage()->get($image->file_id, '');
        if($photo)
        $options[$image->file_id] = '<img src="'.$photo->getPhotoUrl().'" alt="" />';
      }

      $this->addElement('Radio', 'image_id', array(
        //'label' => 'Choose Avatar',
        'multiOptions' => $options,
        'escape' => false,
      ));

      $this->addElement('Button', 'submit', array(
        'label' => 'Save',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
      ));
      $this->addElement('Cancel', 'cancel', array(
          'label' => 'Cancel',
          'link' => true,
          'prependText' => ' or ',
          'onclick' => 'javascript:parent.Smoothbox.close()',
          'decorators' => array(
              'ViewHelper',
          ),
      ));
      $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');

    } else {

      $this->setTitle('Choose Avatar');

      if($hours < 10) {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('You have already gone to Avatar mode, Now you can go only after 24 hours.') . "</span></div>";
        $this->addElement('Dummy', 'sesavatar_tip', array(
            'description' => $description,
        ));
        $this->sesavatar_tip->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      }

      $this->addElement('Cancel', 'cancel', array(
          'label' => 'Cancel',
          'link' => true,
          'onclick' => 'javascript:parent.Smoothbox.close()',
          'decorators' => array(
              'ViewHelper',
          ),
      ));
    }
  }
}
