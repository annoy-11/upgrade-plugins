<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Edit.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Estorepackage_Form_Admin_Package_Edit extends Estorepackage_Form_Admin_Package_Create {

  public function init() {
    parent::init();

    $this
            ->setTitle('Edit Package')
            ->setDescription('Here, you can edit package for stores on your website until someone has not created any store under this package. Only the fields Description, Member Levels, Custom Fields, Highlight & Show in Upgrade, can be edited even after creation of stores.');

    $information = array('featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified', 'hot' => 'Hot', 'custom_fields' => 'Custom Fields');
    $showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('estorepackage.package.info', array_keys($information));

    $packageId = Zend_Controller_Front::getInstance()->getRequest()->getParam('package_id', 0);
    $storeCount = Engine_Api::_()->getDbTable('stores', 'estore')->packageStoreCount($packageId);

    if ($storeCount > 0) {
      // Disable some elements
      $this->getElement('item_count')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('price')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('recurrence')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('duration')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('is_renew_link')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('renew_link_days')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('upload_cover')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('upload_mainphoto')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('store_choose_style')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('store_approve')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      if (in_array('featured', $showinfo)) {
        $this->getElement('store_featured')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('sponsored', $showinfo)) {
        $this->getElement('store_sponsored')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('verified', $showinfo)) {
        $this->getElement('store_verified')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('hot', $showinfo)) {
        $this->getElement('store_hot')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      $this->getElement('store_chooselayout')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('store_seo')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('store_overview')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('store_bgphoto')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('store_contactinfo')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
    }
    // Change the submit label
    $this->getElement('execute')->setLabel('Edit Package');
  }

}
