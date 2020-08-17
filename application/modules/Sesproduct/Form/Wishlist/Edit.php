<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Wishlist_Edit extends Engine_Form {

  public function init() {
    parent::init();
    $this->setTitle('Edit Wishlist')
            ->setAttrib('id', 'form-upload-product')
            ->setAttrib('name', 'wishlist_edit')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    $this->addElement('Text', 'title', array(
        'label' => 'Wishlist Name',
        'placeholder' => 'Enter Wishlist Name',
        'maxlength' => '63',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '63')),
        )
    ));
    //Init descriptions
    $this->addElement('Textarea', 'description', array(
        'label' => 'Wishlist Description',
        'placeholder' => 'Enter Wishlist Description',
        'maxlength' => '300',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
            new Engine_Filter_StringLength(array('max' => '300')),
            new Engine_Filter_EnableLinks(),
        ),
    ));
    //Init album art
    $this->addElement('File', 'mainphoto', array(
        'label' => 'Wishlist Photo',
    ));
    $this->mainphoto->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    $wishlist_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('wishlist_id');
    if ($wishlist_id) {
      $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
      $photoId = $wishlist->photo_id;
      if ($photoId) {
        $img_path = Engine_Api::_()->storage()->get($photoId, '')->getPhotoUrl();
        $path = $img_path;
        if (isset($path) && !empty($path)) {
          $this->addElement('Image', 'wishlist_mainphoto_preview', array(
              'label' => 'Wishlist Photo Preview',
              'src' => $path,
							'onclick' =>'javascript:;',
              'width' => 100,
              'height' => 100,
          ));
        }
      }
    }
    if ($wishlist_id) {
      $photoId = $wishlist->photo_id;
      if ($photoId) {
        $this->addElement('Checkbox', 'remove_photo', array(
            'label' => 'Yes, remove wishlist photo.'
        ));
      }
    }
		 //Privacy Playlist View
    $this->addElement('Checkbox', 'is_private', array(
        'label' => Zend_Registry::get('Zend_Translate')->_("Do you want to make this wishlist private?"),
        'value' => 0,
        'disableTranslator' => true
    ));

    	$this->addElement('dummy', 'product_list', array(
			'decorators' => array(array('ViewScript', array(
                                    'viewScript' => 'application/modules/Sesproduct/views/scripts/wishlist/_productList.tpl',
                                    'wishlist'=>isset($wishlist) ? $wishlist : '',
                                )))
		));
    //Pre-fill form values
    $this->addElement('Hidden', 'wishlist_id');
   // $this->removeElement('fancyuploadfileids');

    //Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
       'onclick' => 'parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    // DisplayGroup: buttons
    $this->addDisplayGroup(array(
        'execute',
        'cancel',
            ), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper'
        ),
    ));
  }

}
