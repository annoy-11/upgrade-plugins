<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgrouppackage_Form_Admin_Package_Edit extends Sesgrouppackage_Form_Admin_Package_Create {

  public function init() {
    parent::init();

    $this
            ->setTitle('Edit Package')
            ->setDescription('Here, you can edit package for groups on your website until someone has not created any group under this package. Only the fields Description, Member Levels, Custom Fields, Highlight & Show in Upgrade, can be edited even after creation of groups.');

    $information = array('featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified', 'hot' => 'Hot', 'custom_fields' => 'Custom Fields');
    $showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgrouppackage.package.info', array_keys($information));

    $packageId = Zend_Controller_Front::getInstance()->getRequest()->getParam('package_id', 0);
    $groupCount = Engine_Api::_()->getDbTable('groups', 'sesgroup')->packageGroupCount($packageId);

    if ($groupCount > 0) {
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
      $this->getElement('group_choose_style')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('group_approve')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      if (in_array('featured', $showinfo)) {
        $this->getElement('group_featured')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('sponsored', $showinfo)) {
        $this->getElement('group_sponsored')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('verified', $showinfo)) {
        $this->getElement('group_verified')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('hot', $showinfo)) {
        $this->getElement('group_hot')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      $this->getElement('group_chooselayout')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('group_seo')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('group_overview')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('group_bgphoto')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('group_contactinfo')
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
