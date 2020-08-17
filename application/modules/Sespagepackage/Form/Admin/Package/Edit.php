<?php

class Sespagepackage_Form_Admin_Package_Edit extends Sespagepackage_Form_Admin_Package_Create {

  public function init() {
    parent::init();

    $this
            ->setTitle('Edit Package')
            ->setDescription('Here, you can edit package for pages on your website until someone has not created any page under this package. Only the fields Description, Member Levels, Custom Fields, Highlight & Show in Upgrade, can be edited even after creation of pages.');

    $information = array('featured' => 'Featured', 'sponsored' => 'Sponsored', 'verified' => 'Verified', 'hot' => 'Hot', 'custom_fields' => 'Custom Fields');
    $showinfo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.package.info', array_keys($information));

    $packageId = Zend_Controller_Front::getInstance()->getRequest()->getParam('package_id', 0);
    $pageCount = Engine_Api::_()->getDbTable('pages', 'sespage')->packagePageCount($packageId);

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
      $this->getElement('page_choose_style')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('page_approve')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      if (in_array('featured', $showinfo)) {
        $this->getElement('page_featured')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('sponsored', $showinfo)) {
        $this->getElement('page_sponsored')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('verified', $showinfo)) {
        $this->getElement('page_verified')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      if (in_array('hot', $showinfo)) {
        $this->getElement('page_hot')
                ->setIgnore(true)
                ->setAttrib('disable', true)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true)
        ;
      }
      $this->getElement('page_chooselayout')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('page_seo')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('page_overview')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('page_bgphoto')
              ->setIgnore(true)
              ->setAttrib('disable', true)
              ->clearValidators()
              ->setRequired(false)
              ->setAllowEmpty(true)
      ;
      $this->getElement('page_contactinfo')
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
