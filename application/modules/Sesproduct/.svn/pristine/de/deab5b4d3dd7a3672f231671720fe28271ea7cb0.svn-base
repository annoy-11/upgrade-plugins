<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Append.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Wishlist_Append extends Engine_Form {

  public function init() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $wishlistCount = Engine_Api::_()->getDbtable('wishlists', 'sesproduct')->getWishlistsCount(array('viewer_id' => $viewer->getIdentity(), 'column_name' => array('wishlist_id', 'title')));
    $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesproduct', 'addwishlist_max');
    $this->setTitle('Add Product To Wishlist')
            ->setAttrib('id', 'form-wishlist-append')
            ->setAttrib('name', 'wishlist_add')
            ->setAction($_SERVER['REQUEST_URI']);
    $wishlists = array();
    if ($quota > count($wishlistCount) || $quota == 0)
      $wishlists[0] = Zend_Registry::get('Zend_Translate')->_('Create New Wishlist');
    
    if ($quota > count($wishlistCount) || $quota == 0) {
			$this->addElement('Select', 'wishlist_id', array(
        'label' => 'Choose Wishlist',
        'multiOptions' => $wishlists,
        'onchange' => "updateTextFields()",
    ));
      $this->addElement('Text', 'title', array(
          'label' => 'Wishlist Name',
          'placeholder' => 'Enter Wishlist Name',
          'style' => '',
          'filters' => array(
              new Engine_Filter_Censor(),
          ),
      ));
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
			  //Privacy Wishlist View
    $this->addElement('Checkbox', 'is_private', array(
        'label' => Zend_Registry::get('Zend_Translate')->_("Do you want to make this wishlist private?"),
        'value' => 0,
        'disableTranslator' => true
    ));
    //Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Add Wishlists',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
		$orCondition = ' or ';
    } else {
			$orCondition = '';
      $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_("You have already created the maximum number of wishlists allowed. If you would like to create a new wishlist, please delete an old one first. Currently, you can only add products in your existing wishlists.") . "</span></div>";
      $this->addElement('Dummy', 'dummy', array(
          'description' => $description,
      ));
      $this->dummy->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    }
  
    //Element: cancel
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => $orCondition,
        'onclick' => 'parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    //DisplayGroup: buttons
    $this->addDisplayGroup(array('execute', 'cancel'), 'buttons', array('decorators' => array('FormElements', 'DivDivDivWrapper')));
  }

}
