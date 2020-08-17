<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursespackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Edit.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Coursespackage_Form_Admin_Package_Edit extends Coursespackage_Form_Admin_Package_Create {

  public function init() {
    parent::init();

    $this
            ->setTitle('Edit Package')
            ->setDescription('Here, you can edit package for pages on your website until someone has not created any page under this package. Only the fields Description, Member Levels, Custom Fields, Highlight & Show in Upgrade, can be edited even after creation of pages.');

    $information = array('featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified', 'hot' => 'Hot', 'custom_fields' => 'Custom Fields');
    $showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.package.info', array_keys($information));

    $packageId = Zend_Controller_Front::getInstance()->getRequest()->getParam('package_id', 0);
    $pageCount = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->packageClassroomCount($packageId);
    if ($pageCount > 0) {
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
      $this->getElement('classroom_choose_style')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('classroom_approve')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      if (in_array('featured', $showinfo)) {
        $this->getElement('classroom_featured')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('sponsored', $showinfo)) {
        $this->getElement('classroom_sponsored')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('verified', $showinfo)) {
        $this->getElement('classroom_verified')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('hot', $showinfo)) {
        $this->getElement('classroom_hot')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      $this->getElement('classroom_chooselayout')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('classroom_seo')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('classroom_overview')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('classroom_bgphoto')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('classroom_contactinfo')
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
