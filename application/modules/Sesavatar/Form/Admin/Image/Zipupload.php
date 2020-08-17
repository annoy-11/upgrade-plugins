<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Zipuload.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesavatar_Form_Admin_Image_Zipupload extends Engine_Form {

  public function init() {
  
    $this->setTitle('Upload Zipped Folder for Avatar')
            ->setDescription('');

    $this->addElement('File', 'file', array(
        'allowEmpty' => false,
        'required' => true,
        'label' => 'Zipped Folder',
        'description' => 'Choose the zipped folder of the Avatar images which you want to upload on your website. [Note: folder with extension: ".zip" only.]',
    ));
    $this->file->addValidator('Extension', false, 'zip');
    
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
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
  }
}
