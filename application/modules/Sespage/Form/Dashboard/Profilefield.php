<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Profilefield.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_Form_Dashboard_Profilefield extends Engine_Form {

  protected $_defaultProfileId;

  public function getDefaultProfileId() {
    return $this->_defaultProfileId;
  }

  public function setDefaultProfileId($default_profile_id) {
    $this->_defaultProfileId = $default_profile_id;
    return $this;
  }

  public function init() {

    $setting = Engine_Api::_()->getApi('settings', 'core');
    if (Engine_Api::_()->core()->hasSubject('sespage_page'))
      $page = Engine_Api::_()->core()->getSubject();
    //get current logged in user
    $this->setTitle('Category Based Profile Information')
            ->setDescription('Here, you can add additional information about your Page specific to its category to provide information about your Page to site members.')
            ->setAttrib('id', 'sespage_create_form')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");
    //Category
    $categories = Engine_Api::_()->getDbTable('categories', 'sespage')->getCategoriesAssoc();
    if (count($categories) > 0) {
      $categorieEnable = $setting->getSetting('sespage.category.required', '1');
      if ($categorieEnable == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
      $categories = array('' => 'Choose Category') + $categories;
      $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'allowEmpty' => $allowEmpty,
          'required' => $required,
          'onchange' => "showSubCategory(this.value);showFields(this.value,1,this.class,this.class,'resets');",
      ));
      //Add Element: 2nd-level Category
      $this->addElement('Select', 'subcat_id', array(
          'label' => "2nd-level Category",
          'allowEmpty' => true,
          'required' => false,
          'multiOptions' => array('0' => ''),
          'registerInArrayValidator' => false,
          'onchange' => "showSubSubCategory(this.value);showFields(this.value,1,this.class,this.class,'resets');"
      ));
      //Add Element: Sub Sub Category
      $this->addElement('Select', 'subsubcat_id', array(
          'label' => "3rd-level Category",
          'allowEmpty' => true,
          'registerInArrayValidator' => false,
          'required' => false,
          'multiOptions' => array('0' => ''),
          'onchange' => 'showFields(this.value,1);showFields(this.value,1,this.class,this.class,"resets");'
      ));
      $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
      $customFields = new Sesbasic_Form_Custom_Fields(array(
          'packageId' => '',
          'resourceType' => '',
          'item' => isset($page) ? $page : 'sespage_page',
          'decorators' => array(
              'FormElements'
      )));
      $customFields->removeElement('submit');
      if ($customFields->getElement($defaultProfileId)) {
        $customFields->getElement($defaultProfileId)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true);
      }
      $this->addSubForms(array(
          'fields' => $customFields
      ));
    }
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }

}
