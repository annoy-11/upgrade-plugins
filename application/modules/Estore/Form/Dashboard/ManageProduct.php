<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Dashboard_ManageProduct extends Engine_Form {
  public function init() {

    $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');

    $this->addElement('Text', 'title', array(
        'label' => 'Product Title',
        'placeholder' => 'Enter Product Title',
    ));
    $subform = new Engine_Form(array(
        'description' => 'Creation Date Ex (yyyy-mm-dd)',
        'elementsBelongTo'=> 'date',
        'decorators' => array(
            'FormElements',
            array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
        )
    ));
    $subform->addElement('Text', 'date_to', array('placeholder'=>'to'));
    $subform->addElement('Text', 'date_from', array('placeholder'=>'from'));
    $this->addSubForm($subform, 'date');
    $categories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getCategory(array('column_name' => '*'));
		$data[''] = 'Choose a Category';
      foreach ($categories as $category) {
        $data[$category['category_id']] = $category['category_name'];
				$categoryId = $category['category_id'];
      }
    if (count($categories) > 1) {
      $this->addElement('Select', 'category_id', array(
          'label' => "Category",
          'required' => false,
          'multiOptions' => $data,
          'onchange' => "showSubCategory(this.value)",
      ));
    }

		$isEnablePackage = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproductpackage.enable.package', 1);
		if($isEnablePackage){
				$packages = Engine_Api::_()->getDbTable('packages','sesproductpackage')->getPackage(array('default' => true));
				$packagesArray = array(''=>'');
				foreach($packages as $package){
					$packagesArray[$package['package_id']]	= $package['title'];
				}
			  if(count($packagesArray) > 2) {
					$this->addElement('Select', 'package_id', array(
							'label' => "Packages",
							'required' => true,
							'multiOptions' => $packagesArray,
					));
				}
		}

    $this->addElement('Button', 'manage_product_search_form', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
    ));
     $this->addElement('Dummy','#loadingimge', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" id="sesproduct-search-order-img" alt="Loading" style="display:none;"/>',
   ));
  /*  $this->addElement('Hidden', 'order', array(
        'order' => 10004,
    ));
    $this->addElement('Hidden', 'order_direction', array(
        'order' => 10002,
    ));

    $this->addElement('Hidden', 'event_id', array(
        'order' => 10003,
    ));*/

    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }

}
