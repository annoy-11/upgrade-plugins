<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Avatars.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_Form_Avatars extends Engine_Form {

  public function init() {

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


    $this->addElement('Cancel', 'remove', array(
      'label' => 'Remove Avatar',
      'link' => true,
      'prependText' => ' or ',
      'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array(
          'action' => 'remove-photo',
      )),
      'onclick' => null,
      'class' => 'smoothbox',
      'decorators' => array(
        'ViewHelper'
      ),
    ));

    $this->addDisplayGroup(array('submit', 'remove'), 'buttons');
  }
}
