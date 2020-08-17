<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Photo.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Form_Edit_Photo extends Engine_Form {

    public function init() {

        $this->setTitle('Edit Photo')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setAttrib('name', 'EditPhoto');

        $this->addElement('Image', 'current', array(
            'label' => 'Current Photo',
            'ignore' => true,
            'decorators' => array(array('ViewScript', array(
                'viewScript' => '_formEditImage.tpl',
                'class'      => 'form element',
                'testing' => 'testing'
            )))
        ));

        Engine_Form::addDefaultDecorators($this->current);
        $mainPhotoEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.photo.mandatory', '1');
        if ($mainPhotoEnable == 1) {
            $required = true;
            $allowEmpty = false;
        } else {
            $required = false;
            $allowEmpty = true;
        }

        $this->addElement('File', 'Filedata', array(
            'label' => 'Choose New Photo',
            'required'=>$required,
            'allowEmpty'=>$allowEmpty,
            'validators' => array(
                array('Extension', false, 'jpg,jpeg,png,gif'),
            ),
        ));

        $this->addElement('Button', 'done', array(
            'label' => 'Save Photo',
            'type' => 'submit',
            'decorators' => array(
                'ViewHelper'
            ),
        ));

        $remove = '';

        if(!$mainPhotoEnable) {
            $this->addElement('Cancel', 'remove', array(
                'label' => 'Remove Photo',
                'link' => true,
                'prependText' => ' or ',
                'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'remove-photo')),
                'onclick' => null,
                'class' => 'smoothbox',
                'decorators' => array(
                    'ViewHelper'
                ),
            ));
            $remove = 'remove';
        }
        $this->addDisplayGroup(array('done', $remove), 'buttons');
    }
}
