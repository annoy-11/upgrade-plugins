<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Form_Create extends Engine_Form
{
  public $_error = array();
  protected $_defaultProfileId;
  protected $_fromApi;
  protected $_smoothboxType;
  public function getFromApi() {
    return $this->_fromApi;
  }
  public function setFromApi($fromApi) {
    $this->_fromApi = $fromApi;
    return $this;
  }

  public function getDefaultProfileId() {
    return $this->_defaultProfileId;
  }
  public function setDefaultProfileId($default_profile_id) {
    $this->_defaultProfileId = $default_profile_id;
    return $this;
  }

  public function getSmoothboxType() {
    return $this->_smoothboxType;
  }
  public function setSmoothboxType($smoothboxType) {
    $this->_smoothboxType = $smoothboxType;
    return $this;
  }

  public function init() {
    $settings =Engine_Api::_()->getApi('settings', 'core');
    if($this->getSmoothboxType())
      $hideClass = 'sesproduct_hideelement_smoothbox';
    else
      $hideClass = '';
    $viewer = Engine_Api::_()->user()->getViewer();
    $translate = Zend_Registry::get('Zend_Translate');


    $this->setTitle('Create New Product')
      ->setDescription('Configure your new product below, then click "Create Product" to create the product.')
      ->setAttrib('name', 'sesproducts_create');

		if($this->getSmoothboxType())
			$this->setAttrib('class','global_form sesproduct_smoothbox_create');

    $store_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('store_id');
    if(!empty($store_id))
      $store = Engine_Api::_()->getItem('stores',$store_id);

    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

    if (Engine_Api::_()->core()->hasSubject('sesproduct'))
    $product = Engine_Api::_()->core()->getSubject();
    $hiddenElement = 8899;
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $divContentId = 1;
    $this->addElement('Text', 'formHeading1', array(
        'decorators' => array(array('ViewScript', array(
                        'viewScript' => '_headingElementsForm.tpl',
                        'heading' => $view->translate('General Information'),
                        'class' => 'form element',
                        'closediv' => 0,
                        'openDiv' => 1,
                        'firstDiv' =>1,
                        'id' => $divContentId++,
                       ))),
    ));
    $this->addElement('Hidden', 'type', array(
      'label' => 'Product Type',
      'allowEmpty' => false,
      'required' => false,
      'value' => 'simpleProduct',
    ));


    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '224'))
      ),
    ));

    $custom_url_value = isset($product->custom_url) ? $product->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
    // Custom Url
    $this->addElement('Dummy', 'custom_url_product', array(
	'label' => 'Custom URL',
	'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><i class="fa fa-check" id="sesproduct_custom_url_correct" style="display:none;"></i><i class="fa fa-times" id="sesproduct_custom_url_wrong" style="display:none;"></i> <button id="check_custom_url_availability" type="button" name="check_availability" ><span class="sesproduct_check_availability_btn"><img src="application/modules/Core/externals/images/loading.gif" id="sesproduct_custom_url_loading" alt="Loading" style="display:none;" /> Check Availability</button></span><p id="suggestion_tooltip" class="check_tooltip" style="display:none;">'.$translate->translate("You can use letters, numbers and periods.").'</p>',
    ));

    // init to
    if($settings->getSetting('sesproduct.pagetags',1)){
        $this->addElement('Text', 'tags', array(
            'label' => 'Tags (Keywords)',
            'autocomplete' => 'off',
            'description' => 'Separate tags with commas.',
            'filters' => array(
                new Engine_Filter_Censor(),
            )
        ));
        $this->tags->getDecorator("Description")->setOption("placement", "append");
    }


     $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'sesproduct', 'auth_html');
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);

    $editorOptions = array(
      'upload_url' => $upload_url,
      'html' => (bool) $allowed_html,
    );

    if (!empty($upload_url))
    {
      $editorOptions['plugins'] = array(
        'table', 'fullscreen', 'media', 'preview', 'paste',
        'code', 'image', 'textcolor', 'jbimages', 'link'
      );
      $editorOptions['toolbar1'] = array(
        'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
        'media', 'image', 'jbimages', 'link', 'fullscreen',
        'preview'
      );
      $editorOptions['toolbar2'] = array(
        'fontselect','fontsizeselect','bold','italic','underline','strikethrough','forecolor','backcolor','|','alignleft','aligncenter','alignright','alignjustify','|','bullist','numlist','|','outdent','indent','blockquote',
      );
    }
    if($settings->getSetting('sesproduct.enable.productdescription',1)){

            if((isset($modulesEnable) && array_key_exists('enable_tinymce',$modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable) && $settings->getSetting('sesproduct.enable.wysiwyg',1)) {
                    $textarea = 'TinyMce';
            } else{
                $textarea = 'Textarea';
            }

            $descriptionMan= $settings->getSetting('sesproduct.description.mandatory', '1');
            if ($descriptionMan == 1) {
                $required = true;
                $allowEmpty = false;
            } else {
                $required = false;
                $allowEmpty = true;
            }

        $this->addElement($textarea, 'body', array(
            'label' => 'Product Description',
            'required' => $required,
            'allowEmpty' => $allowEmpty,
            'class'=>'tinymce',
            'editorOptions' => $editorOptions,
        ));

    }

    $this->addElement('Text', 'formHeading10', array(
    'decorators' => array(
                     array(
                        'ViewScript',
                        array(
                          'viewScript' => '_headingElementsForm.tpl',
                          'heading' => $view->translate('Additional Information'),
                          'class' => 'form element',
                          'closediv' => 1,
                          'openDiv' => 1,
                          'id' => $divContentId++,
                        )
                      )
                     ),
    ));

    if($settings->getSetting('sesproduct.enable.location', 1) && ((isset($modulesEnable) && array_key_exists('enable_location',$modulesEnable) && $modulesEnable['enable_location']) || empty($modulesEnable))) {
    
      $location = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.location.mandatory', '1');
      if ($location == 1) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }
      
      $optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}'));
      
      $this->addElement('Text', 'location', array(
        'label' => 'Location',
        'id' => 'locationSes',
        'required' => $required,
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
      ));

      if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
        if(in_array('country', $optionsenableglotion)) {
          $this->addElement('Text', 'country', array(
            'label' => 'Country',
          ));
        }
        if(in_array('state', $optionsenableglotion)) {
          $this->addElement('Text', 'state', array(
            'label' => 'State',
          ));
        }
        if(in_array('city', $optionsenableglotion)) {
          $this->addElement('Text', 'city', array(
            'label' => 'City',
          ));
        }
        if(in_array('zip', $optionsenableglotion)) {
          $this->addElement('Text', 'zip', array(
            'label' => 'Zip',
          ));
        }
      }

      $this->addElement('Text', 'lat', array(
        'label' => 'Latitude',
        'id' => 'latSes',
      ));
      $this->addElement('Text', 'lng', array(
        'label' => 'Longitude',
        'id' => 'lngSes',
      ));
      $this->addElement('dummy', 'map-canvas', array());
      $this->addElement('dummy', 'ses_location', array('content'));
    }

    //sections
    if($settings->getSetting('estore.allowed.section', '1')){
      $sections = Engine_Api::_()->getDbTable('sections','estore')->getSections(array('estore_id'=>$store_id));
      if(count($sections)){
        $sectionArray = array(''=>'');
        foreach($sections as $section){
          $sectionArray[$section->getIdentity()] = $section['title'];
        }
        $this->addElement('Select','section_id',array(
          'label' => 'Sections',
          'description' => '',
          'multiOptions' => $sectionArray
        ));
      }
    }


    // prepare categories
    $categories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getCategoriesAssoc(array('member_levels' => 2));
    if( count($categories) > 0 ) {
		$categorieEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.category.mandatory', '1');
		if ($categorieEnable == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}
    }
	$categories = array('' => '') + $categories;
	// category field
	$this->addElement('Select', 'category_id', array(
	    'label' => 'Category',
	    'multiOptions' => $categories,
	    'allowEmpty' => $allowEmpty,
	    'required' => $required,
	    'onchange' => "showSubCategory(this.value);",
	));
	//Add Element: 2nd-level Category
	$this->addElement('Select', 'subcat_id', array(
	    'label' => "2nd-level Category",
	    'allowEmpty' => true,
	    'required' => false,
	    'multiOptions' => array('0' => ''),
	    'registerInArrayValidator' => false,
	    'onchange' => "showSubSubCategory(this.value);"
	));
	//Add Element: Sub Sub Category
	$this->addElement('Select', 'subsubcat_id', array(
	    'label' => "3rd-level Category",
	    'allowEmpty' => true,
	    'registerInArrayValidator' => false,
	    'required' => false,
	    'multiOptions' => array('0' => ''),
	    'onchange' => 'showCustom(this.value);'
	));

        if (Engine_Api::_()->core()->hasSubject('sesproduct'))
            $product = Engine_Api::_()->core()->getSubject();

      $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
      $customFields = new Sesbasic_Form_Custom_Fields(array(
          'item' => isset($product) ? $product : 'sesproduct',
         'decorators' => array(
             'FormElements','DivDivDivWrapper'
      )));
      $customFields->removeElement('submit');
      if ($customFields->getElement($defaultProfileId)) {
        $customFields->getElement($defaultProfileId)
                ->clearValidators()
                ->setRequired(false)
                ->setAllowEmpty(true);
      }

      $this->addSubForms(array(
          'fields' => $customFields,
      ));




  $this->addElement('Text', 'formHeading11', array(
    'decorators' => array(
                     array(
                        'ViewScript',
                        array(
                          'viewScript' => '_headingElementsForm.tpl',
                          'heading' => $view->translate('Price & Discounts'),
                          'class' => 'form element',
                          'closediv' => 1,
                          'openDiv' => 1,
                          'id' => $divContentId++,
                        )
                      )
                     ),
    ));


  $defaultCurrency = Engine_Api::_()->estore()->defaultCurrency();
  $this->addElement('Select', 'currency', array(
      'label'=>'Currency',
      'multiOptions' => array($defaultCurrency=>$defaultCurrency),
  ));
  $this->addElement('Text', 'price', array(
      'label' => 'Price',
      'placeholder'=>"0.00",
      'class'=>'sesdecimal',
      'validators' => array(
          array('NotEmpty', true),
          array('GreaterThan', false, array(-1))
      ),
      'filters' => array(
          'StripTags',
          new Engine_Filter_Censor(),
      )
  ));
if($settings->getSetting('sesproduct.enable.discount', 1))
{
		$this->addElement('Radio', 'discount', array(
				'label' => 'Discount',
				'multiOptions'=>array('1'=>'Yes','0'=>'No'),
				'value'=>0
		));

		$this->addElement('Select', 'discount_type', array(
				'label' => 'Discount Type',
				'multiOptions'=>array('1'=>'Fixed','0'=>'Percentage'),
				'value'=>0
		));

		$this->addElement('Text', 'fixed_discount_value', array(
				'label' => 'Discount Value',
				'placeholder'=>"0.00",
				'class'=>'sesdecimal',
				'validators' => array(
						array('NotEmpty', true),
						array('Float', true),
						array('GreaterThan', false, array(-1))
				),
		));
		$this->addElement('Text', 'percentage_discount_value', array(
				'label' => 'Discount Value (%)',
				'class'=>'sesdecimal',
				'placeholder'=>"0",
				'required'=>false,
				'validators' => array(
						array('NotEmpty', true),
						array('Float', true),
						array('Between', false, array('min' => '-1', 'max' => '101', 'inclusive' => false)),
				),
		));
		$oldTz = date_default_timezone_get();
		date_default_timezone_set(Engine_Api::_()->user()->getViewer()->timezone);
		$current_date =  date('Y-m-d H:i:s');
		$end_date =  date('Y-m-d', strtotime("+30 days"));
		date_default_timezone_set($oldTz);

		/*$discount_start_date = new Engine_Form_Element_CalendarDateTime('discount_start_date');
		$discount_start_date->setLabel('Discount Start Date');
		$discount_start_date->setAllowEmpty(false);
		$discount_start_date->setValue($current_date);
		$this->addElement($discount_start_date);*/

		if(empty($product)){
			if(empty($_POST)){
				$startDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes'));
				$start_date = date('m/d/Y',strtotime($startDate));
				$start_time = date('g:ia',strtotime($startDate));
				if($viewer->timezone){
					$start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes')));
					$selectedTime = "00:02:00";
					$startTime = time()+strtotime($selectedTime);
					$oldTz = date_default_timezone_get();
					date_default_timezone_set($viewer->timezone);
					$start_date = date('m/d/Y',($start));
					$start_time = date('g:ia',$startTime);
					date_default_timezone_set($oldTz);
				}
			}else{
				$start_date = date('m/d/Y',strtotime($_POST['discount_start_date']));
				$start_time = date('g:ia',strtotime($_POST['discount_start_date_time']));
			}
		}else{
			//call from edit page
			if(!count($_POST)){
				if($product->discount_start_date){
				 $startDate = $product->discount_start_date;
				 $oldTz = date_default_timezone_get();
				 date_default_timezone_set($viewer->timezone);
				 $start_date = date('m/d/Y',strtotime($startDate));
				 $start_time = date('g:ia',strtotime($startDate));
				 date_default_timezone_set($oldTz);
				}
			}else{
				 $start_date = date('m/d/Y',strtotime($_POST['discount_start_date']));
					$start_time = date('g:ia',strtotime($_POST['discount_start_date_time']));
			}
		}
		$this->addElement('dummy', 'product_custom_discount_datetimes', array(
			'decorators' => array(array('ViewScript', array(
												'viewScript' => 'application/modules/Sesproduct/views/scripts/_customDiscountStartdates.tpl',
												'class' => 'form element',
												'start_date'=>$start_date,
												'start_time'=>$start_time,
												'required'=>false,
												'start_time_check'=>1,
												'subject'=>isset($product) ? $product : '',
										 )))
		));


		$this->addElement('Radio', 'discount_end_type', array(
				'label' => 'Discount End Date',
				'multiOptions' => array( "1" => "End discount on a specific date. (Please select date from below.)","0" => "No End date."),
				'description' => "Choose from below when do you want to end this discount.",
				'value' => 0,
				'onclick' => "",
		));

		/*$discount_end_date = new Engine_Form_Element_CalendarDateTime('discount_end_date');
		$discount_end_date->setAllowEmpty(false);
		$discount_end_date->setValue($end_date);
		$this->addElement($discount_end_date);*/
		if(empty($product)){
			if(empty($_POST)){
				$endDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 1Days'));
				$end_date = date('m/d/Y',strtotime($endDate));
				$end_time = date('g:ia',strtotime($endDate));
				if($viewer->timezone){
					$start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 1Days')));
					$selectedTime = "00:02:00";
					$startTime = time()+strtotime($selectedTime);
					$oldTz = date_default_timezone_get();
					date_default_timezone_set($viewer->timezone);
					$end_date = date('m/d/Y',($start));
					$end_time = date('g:ia',$startTime);
					date_default_timezone_set($oldTz);
				}
			}else{
				$end_date = date('m/d/Y',strtotime($_POST['end_date']));
				$end_time = date('g:ia',strtotime($_POST['end_time']));
			}
		}else{
			//call from edit page
			if(!count($_POST)){
				if($product->discount_end_date){
				 $startDate = $product->discount_end_date;
				 $oldTz = date_default_timezone_get();
				 date_default_timezone_set($viewer->timezone);
				 $end_date = date('m/d/Y',strtotime($startDate));
				 $end_time = date('g:ia',strtotime($startDate));
				 date_default_timezone_set($oldTz);
				}
			}else{
				 $end_date = date('m/d/Y',strtotime($_POST['discount_end_date']));
					$end_time = date('g:ia',strtotime($_POST['discount_end_date_time']));
			}
		}
		$this->addElement('dummy', 'product_custom_discount_enddatetimes', array(
			'decorators' => array(array('ViewScript', array(
									'viewScript' => 'application/modules/Sesproduct/views/scripts/_customDiscountEnddates.tpl',
									'class' => 'form element',
									'end_date'=>$end_date,
									'end_time'=>$end_time,
									'start_time_check'=>1,
									'subject'=>isset($product) ? $product : '',
							)))
		));
		$this->addElement('Select', 'allowed_discount_type', array(
				'label' => 'Whom To Allow Discount?',
				'description' => 'Who may avail this discount?',
				'multiOptions' => array('0' => 'Everyone', '2' => 'All Registered Members', '1' => 'Public'),
				'value' => 0
		));
}
  $this->addElement('Text', 'formHeading2', array(
    'decorators' => array(
                     array(
                        'ViewScript',
                        array(
                          'viewScript' => '_headingElementsForm.tpl',
                          'heading' => $view->translate('Inventory'),
                          'class' => 'form element',
                          'closediv' => 1,
                          'openDiv' => 1,
                          'id' => $divContentId++,
                        )
                      )
                     ),
    ));

         if(!empty($product)){
             $allowEmpty = true;
             $required = false;
         }else{
             $allowEmpty = false;
             $required = true;
         }
          $skyArray = array(
              'label' => 'SKU',
              'autocomplete' => 'off',
              'allowEmpty' => $allowEmpty,
              'required' => $required,
              'description' => '',
              'filters' => array(
                  new Engine_Filter_Censor(),
              )
          );
          if (!empty($product)) {
              $skyArray['disabled'] = 'disabled';
          }
          $this->addElement('Text', 'sku', $skyArray);
          $this->sku->getDecorator("Description")->setOption("placement", "append");

    if($settings->getSetting('sesproduct.enable.brand',1)) {
        $this->addElement('Text', 'brand', array(
            'label' => 'Brand Name',
            'autocomplete' => 'off',
            'allowEmpty'=>true,
            'required' => false,
            'description' => '',
            'filters' => array(
                new Engine_Filter_Censor(),
            )
        ));
        $this->brand->getDecorator("Description")->setOption("placement", "append");
    }

	if($settings->getSetting('sesproduct.enable.stockmanagement',1)) {

        $this->addElement('Select', 'manage_stock',array(
        'label' => 'Manage Stock',
        'description' => 'Do you want to enable stock management for this product?',
        'multiOptions' => array('1'=>'Yes',0=>'No'),
        'value'=>0,
        'filters' => array(
            new Engine_Filter_Censor(),
            )
        ));
        $this->manage_stock->getDecorator("Description")->setOption("placement", "append");


        if(!empty($_POST['manage_stock'])){
            $allowEmptyStockQuatity = false;
            $requiredStockQuatity = true;
        }else{
            $allowEmptyStockQuatity = true;
            $requiredStockQuatity = false;
        }

        $this->addElement('Text', 'stock_quatity', array(
            'label' => 'Stock Quantity',
            'autocomplete' => 'off',
            'allowEmpty'=>$allowEmptyStockQuatity,
            'required' => $requiredStockQuatity,
            'class'=>'sesinteger',
            'description' => '',
            'validators' => array(
                array('NotEmpty', true),
                array('GreaterThan', false, array(-1))
            ),
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
            ),

        ));
        $this->stock_quatity->getDecorator("Description")->setOption("placement", "append");
    }

	if($settings->getSetting('sesproduct.outofstock',1)) {
        $this->addElement('Checkbox', 'show_outof_stock', array(
        'label' => 'Show this product even when out of stock.',
        'value' => 1,
        ));
	}
	if($settings->getSetting('sesproduct.backinstock',1)) {
        $this->addElement('Checkbox', 'enable_backin_stock', array(
        'label' => 'Enable users to contact for Product Back in Stock.',
        'value' => 1,
        ));
	}
	if($settings->getSetting('sesproduct.enable.stockmanagement',1)) {
		if($settings->getSetting('sesproduct.minquantity',1)) {
			$this->addElement('Text', 'min_quantity', array(
					'label' => 'Minimum Order Quantity',
					'autocomplete' => 'off',
					'allowEmpty'=>'false',
					'required' => 'true',
					'class'=>'sesinteger',
					'description' => 'Enter the minimum order quantity for this product that buyer needs to purchase.',
					'value'=>1,
					'validators' => array(
							array('NotEmpty', true),
							array('GreaterThan', false, array(-1))
					),
					'filters' => array(
							'StripTags',
							new Engine_Filter_Censor(),
					),
			));
			$this->min_quantity->getDecorator("Description")->setOption("placement", "append");
		}
		if($settings->getSetting('sesproduct.maxquantity',1)) {
			$this->addElement('Text', 'max_quatity', array(
					'label' => 'Maximum Order Quantity',
					'class'=>'sesinteger',
					'autocomplete' => 'off',
					'description' => 'Enter the maximum order quantity for this product that buyer can purchase.',
					'validators' => array(
							array('NotEmpty', true),
							array('GreaterThan', false, array(-1))
					),
					'filters' => array(
							'StripTags',
							new Engine_Filter_Censor(),
					),
			));
			$this->max_quatity->getDecorator("Description")->setOption("placement", "append");
		}
	}
    if($settings->getSetting('sesproduct.purchasenote',1) || $settings->getSetting('sesproduct.reviews',1)) {
        $this->addElement('Text', 'formHeading12', array(
        'decorators' => array(
                        array(
                            'ViewScript',
                            array(
                            'viewScript' => '_headingElementsForm.tpl',
                            'heading' => $view->translate('Advanced'),
                            'class' => 'form element',
                            'closediv' => 1,
                            'openDiv' => 1,
                            'id' => $divContentId++,
                            )
                        )
                        ),
        ));

        if($settings->getSetting('sesproduct.purchasenote',1)) {
            $this->addElement('Textarea','purchase_note',array(
            'label'=>'Purchase Note',
            'description' => 'Enter the purchase note for this product.',
            ));
        }

        if($settings->getSetting('sesproduct.reviews',1)) {
            $this->addElement('Checkbox', 'enable_review', array(
                'description' => 'Enable Reviews',
            'label' => 'Yes, enable reviews for this product.',
                'value' => 1,
            ));
        }
    }
   $this->addElement('Text', 'formHeading3', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate('Shipping Information'),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 1,
                      'id' => $divContentId++,
                     ))),
    ));

    $dimension =$settings->getSetting('sesproduct.dimension.matrix',1);
    if($dimension == 1) {
        $defaultDimension = 'Cm';
    }
    else if ($dimension == 2){
        $defaultDimension = 'Inch';
    }
   else if ($dimension == 3){
        $defaultDimension = 'Feet';
    }
    else if ($dimension == 4){
        $defaultDimension = 'meter (m)';
    }

    $weight =$settings->getSetting('sesproduct.weight.matrix',2);
    if($weight == 1) {
        $defaultWeight = 'Pound';
    }
    else if ($weight == 2){
        $defaultWeight = 'Kilogram';
    }
   else if ($weight == 3){
        $defaultWeight = 'Gram';
    }
    else if ($weight == 4){
        $defaultWeight = 'Ounce';
    }

  $this->addElement('Text', 'weight', array(
      'label' => 'Product Weight ('.$defaultWeight.')',
      'autocomplete' => 'off',
      'class'=>'sesdecimal',
      'description' => 'Enter the weight of this product.',
      'validators' => array(
          array('NotEmpty', true),
          array('GreaterThan', false, array(-1))
      ),
      'filters' => array(
          'StripTags',
          new Engine_Filter_Censor(),
      ),
  ));
  $this->weight->getDecorator("Description")->setOption("placement", "append");

  $length = !empty($_POST['length']) ? $_POST['length'] : ($product ? $product->length : "");
  $width = !empty($_POST['width']) ? $_POST['width'] : ($product ? $product->width : "");
  $height = !empty($_POST['height']) ? $_POST['height'] : ($product ? $product->height : "");

  $this->addElement('Dummy', 'dimention', array(
        'label' => ' Product Dimensions ('.$defaultDimension.')',
        'autocomplete' => 'off',
        'content'=>'<input type="text" value="'.$length.'" name="Length" placeholder="Length" class="sesdecimal" style="float:left; width:100px;margin-top:0px;margin-left:5px;"> <input type="text" class="sesdecimal" value="'.$width.'" name="Width" placeholder="Width" style="float:left; width:100px;margin-top:0px;margin-left:5px;"> <input type="text" class="sesdecimal" name="Height" placeholder="Height" value="'.$height.'" style="float:left; width:100px;margin-top:0px;margin-left:5px;">',
        'description' => '',
        'filters' => array(
            new Engine_Filter_Censor(),
        )
  ));

if($settings->getSetting('sesproduct.start.date', 1) || $settings->getSetting('sesproduct.end.date', 1))  {

  $this->addElement('Text', 'formHeading13', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate('Product Availability'),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 1,
                      'id' => $divContentId++,
                     ))),
    ));


  if($settings->getSetting('sesproduct.start.date', 1))  {
        $this->addElement('Radio', 'show_start_time', array(
            'label' => 'Start Date',
            'description' => '',
            'multiOptions' => array(
            "0" => 'Choose Start Date',
            "1" => 'Publish Now',
        ),
        'value' => 1,
        'onclick' => "showStartDate(this.value);",
        ));
        if(empty($product)){
            if(empty($_POST)){
                $startDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes'));
                $start_date = date('m/d/Y',strtotime($startDate));
                $start_time = date('g:ia',strtotime($startDate));
                if($viewer->timezone){
                    $start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes')));
                    $selectedTime = "00:02:00";
                    $startTime = time()+strtotime($selectedTime);
                    $oldTz = date_default_timezone_get();
                    date_default_timezone_set($viewer->timezone);
                    $start_date = date('m/d/Y',($start));
                    $start_time = date('g:ia',$startTime);
                    date_default_timezone_set($oldTz);
                }
            }else{
                $start_date = date('m/d/Y',strtotime($_POST['start_date']));
                $start_time = date('g:ia',strtotime($_POST['start_time']));
            }
        }else{
            //call from edit page
            if(!count($_POST)){
                if($product->starttime){
                $startDate = $product->starttime;
                $oldTz = date_default_timezone_get();
                date_default_timezone_set($viewer->timezone);
                $start_date = date('m/d/Y',strtotime($startDate));
                $start_time = date('g:ia',strtotime($startDate));
                date_default_timezone_set($oldTz);
                }
            }else{
                $start_date = date('m/d/Y',strtotime($_POST['start_date']));
                $start_time = date('g:ia',strtotime($_POST['start_date_time']));
            }
        }
        $this->addElement('dummy', 'product_custom_datetimes', array(
            'decorators' => array(array('ViewScript', array(
                                    'viewScript' => 'application/modules/Sesproduct/views/scripts/_customdates.tpl',
                                    'class' => 'form element',
                                    'start_date'=>$start_date,
                                    'start_time'=>$start_time,
                                    'start_time_check'=>1,
                                    'subject'=>isset($product) ? $product : '',
                            )))
        ));
    }

  if($settings->getSetting('sesproduct.end.date', 1))  {

        if(empty($product)){
            $this->addElement('Radio', 'show_end_time', array(
                'label' => 'End Date',
                'description' => '',
                'multiOptions' => array(
                "1" => 'End product show to a specific date.',
                "0" => 'No End Date',
            ),
            'value' => $settings->getSetting('show.end.time', 1),
            'onclick' => "showEndDate(this.value);",
            ));
            if(empty($_POST)){
                $startDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' +30 days'));
                $end_date = date('m/d/Y',strtotime($startDate));
                $end_time = date('g:ia',strtotime($startDate));

                if($viewer->timezone){
                    $start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' +30 days')));
                    $selectedTime = "00:02:00";
                    $startTime = time()+strtotime($selectedTime);
                    $oldTz = date_default_timezone_get();
                    date_default_timezone_set($viewer->timezone);
                    $end_date = date('m/d/Y',($start));
                    $end_time = date('g:ia',$startTime);
                    date_default_timezone_set($oldTz);
                }
            }else{
                $end_date = date('m/d/Y',strtotime($_POST['end_date']));
                $end_time = date('g:ia',strtotime($_POST['end_time']));
            }
        }else{
            $this->addElement('Radio', 'show_end_time', array(
                'label' => 'End Date',
                'description' => '',
                'multiOptions' => array(
                "1" => 'End product show to a specific date.',
                "0" => 'No End Date',
            ),
            'value' => $product->show_end_time,
            'onclick' => "showEndDate(this.value);",
            ));
            //call from edit page
            if(!count($_POST)){
                if($product->endtime){
                $startDate = $product->endtime;
                $oldTz = date_default_timezone_get();
                date_default_timezone_set($viewer->timezone);
                $end_date = date('m/d/Y',strtotime($startDate));
                $end_time = date('g:ia',strtotime($startDate));
                date_default_timezone_set($oldTz);
                }
            }else{
                $end_date = date('m/d/Y',strtotime($_POST['end_date']));
                $end_time = date('g:ia',strtotime($_POST['end_date_time']));
            }
        }
        $this->addElement('dummy', 'product_custom_enddatetimes', array(
            'decorators' => array(array('ViewScript', array(
                                    'viewScript' => 'application/modules/Sesproduct/views/scripts/_customEnddates.tpl',
                                    'class' => 'form element',
                                    'end_date'=>$end_date,
                                    'end_time'=>$end_time,
                                    'start_time_check'=>1,
                                    'subject'=>isset($product) ? $product : '',
                            ))),
                            'value'=> date('m/d/Y'),
        ));

    }

}

  $this->addElement('Text', 'formHeading4', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate('Linked Products'),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 1,
                      'id' => $divContentId++,
                     ))),
    ));



  $this->addElement('Text', 'upsell', array(
      'label' => 'Upsell Products',
      'autocomplete' => 'off',
      'placeholder'=>'Enter product name.',
      'description' => 'Select the products that you want to Upsell with this product. Selected products will show on products view page.',
      'filters' => array(
          new Engine_Filter_Censor(),
      )
  ));
 $this->upsell->getDecorator("Description")->setOption("placement", "append");

  $this->addElement('Hidden','upsell_id',array('order'=>$hiddenElement++));

   $this->addElement('Text', 'crosssell', array(
      'label' => 'Cross-sell Products',
      'placeholder'=>'Enter product name.',
      'autocomplete' => 'off',
      'description' => 'Select the products that you want to Cross-sell with this product. Selected products will show in shopping cart.',
      'filters' => array(
          new Engine_Filter_Censor(),
      )
  ));
  $this->crosssell->getDecorator("Description")->setOption("placement", "append");
  $this->addElement('Hidden','crosssell_id',array('order'=>$hiddenElement++));

  if(empty($product)){
    $this->addElement('Text', 'formHeading5', array(
        'decorators' => array(array('ViewScript', array(
          'viewScript' => '_headingElementsForm.tpl',
          'heading' => $view->translate('Design'),
          'class' => 'form element',
          'closediv' => 1,
          'openDiv' => 1,
          'id' => $divContentId++,
         ))),
    ));
    $photoLeft = true;
    if(isset($existing_package_id) && $existing_package_id){
        $modulesEnable = json_decode($package->params,true);
        $package_id = $existing_package->package_id;
        if($package_id){
          $photoLeft = $package->allowUploadPhoto($existing_package->getIdentity(),true);
        }

    }
    $mainPhotoEnable = $settings->getSetting('sesproduct.photo.mandatory', '1');
    if ($mainPhotoEnable == 1) {
        $required = true;
        $allowEmpty = false;
    } else {
        $required = false;
        $allowEmpty = true;
    }
    // Init submit
    if($this->getFromApi()){
      $this->addElement('File', 'file', array(
          'label' => 'Main Photo',
          'description' => '',
      ));
    }
    if(((isset($modulesEnable) && array_key_exists('modules',$modulesEnable) && in_array('photo',$modulesEnable['modules'])) || empty($modulesEnable)) && $photoLeft){
      if(isset($modulesEnable) && array_key_exists('photo_count',$modulesEnable) && $modulesEnable['photo_count']){
          if(isset($photoLeft))
              $photo_count = $photoLeft;
          else
              $photo_count = $modulesEnable['photo_count'];
          $this->addElement('hidden', 'photo_count', array('value' => $photo_count,'order'=>$hiddenElement++));
      }
      $this->addElement('hidden', 'type', array('order'=>$hiddenElement++));
      $this->addElement('Dummy', 'fancyuploadfileids', array('content'=>'<input id="fancyuploadfileids" name="file" type="hidden" value="" >'));
      $this->addElement('Dummy', 'tabs_form_productcreate', array(
      'label' => 'Upload photos',
      //'required'=>$required,
      //'allowEmpty'=>$allowEmpty,
      'content' => '<div class="sesproduct_create_form_tabs sesbasic_clearfix sesbm"><ul id="sesproduct_create_form_tabs" class="sesbasic_clearfix"><li class="active sesbm"><i class="fa fa-arrows sesbasic_text_light"></i><a href="javascript:;" class="drag_drop">'.$translate->translate('Drag & Drop').'</a></li><li class=" sesbm"><i class="fa fa-upload sesbasic_text_light"></i><a href="javascript:;" class="multi_upload">'.$translate->translate('Multi Upload').'</a></li><li class=" sesbm"><i class="fa fa-link sesbasic_text_light"></i><a href="javascript:;" class="from_url">'.$translate->translate('From URL').'</a></li></ul></div>',
      ));
      $this->addElement('Dummy', 'drag-drop', array(
      'content' => '<div id="dragandrophandler" class="sesproduct_upload_dragdrop_content sesbasic_bxs">'.$translate->translate('Drag & Drop Photos Here').'</div>',
      ));
      $this->addElement('Dummy', 'from-url', array(
      'content' => '<div id="from-url" class="sesproduct_upload_url_content sesbm"><input type="text" name="from_url" id="from_url_upload" value="" placeholder="'.$translate->translate('Enter Image URL to upload').'"><span id="loading_image"></span><span></span><button id="upload_from_url">'.$translate->translate('Upload').'</button></div>',
      ));

      $this->addElement('Dummy', 'file_multi', array('content'=>'<input type="file" accept="image/x-png,image/jpeg" onchange="readImageUrl(this)" multiple="multiple" id="file_multi" name="file_multi">'));
      $this->addElement('Dummy', 'uploadFileContainer', array('content'=>'<div id="show_photo_container" class="sesproduct_upload_photos_container sesbasic_bxs sesbasic_custom_scroll clear"><div id="show_photo"></div></div>'));
    }else{
      //make main photo upload btn
      $this->addElement('File', 'photo_file', array(
          'label' => 'Main Photo',
          'required'=>$required,
          'allowEmpty'=>$allowEmpty,
      ));
      $this->photo_file->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    }
  }
  $this->addElement('Text', 'formHeading6', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate('Privacy'),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 1,
                      'id' => $divContentId++,
                     ))),
    ));
     if (Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'allow_network')) {
      $networkOptions = array();
      $networkValues = array();
      foreach (Engine_Api::_()->getDbTable('networks', 'network')->fetchAll() as $network) {
        $networkOptions[$network->network_id] = $network->getTitle();
        $networkValues[] = $network->network_id;
      }

      // Select Networks
      $this->addElement('multiselect', 'networks', array(
          'label' => 'Networks',
          'multiOptions' => $networkOptions,
          'description' => 'Choose the Networks to which this Product will be displayed. (Note: Hold down the CTRL key to select or de-select specific networks.)',
          'value' => $networkValues,
      ));
    }
    if (Engine_Api::_()->authorization()->isAllowed('sesproduct', $viewer, 'allow_levels')) {

        $levelOptions = array();
        $levelValues = array();
        foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
//             if($level->getTitle() == 'Public')
//                 continue;
            $levelOptions[$level->level_id] = $level->getTitle();
            $levelValues[] = $level->level_id;
        }
        // Select Member Levels
        $this->addElement('multiselect', 'levels', array(
            'label' => 'Member Levels',
            'multiOptions' => $levelOptions,
            'description' => 'Choose the Member Levels to which this Product will be displayed. (Note: Hold down the CTRL key to select or de-select specific member levels.)',
            'value' => $levelValues,
        ));
    }

    $availableLabels = array(
      'everyone'            => 'Everyone',
      'registered'          => 'All Registered Members',
      'owner_network'       => 'Friends and Networks',
      'owner_member_member' => 'Friends of Friends',
      'owner_member'        => 'Friends Only',
      'owner'               => 'Just Me'
    );

    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesproduct', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions),'order'=>$hiddenElement++));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this product?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
            'class'=>$hideClass,
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesproduct', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions),'order'=>$hiddenElement++));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this product?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
            'class'=>$hideClass,
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }

     $this->addElement('Text', 'formHeading16', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate('Other'),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 1,
                      'id' => $divContentId++,
                     ))),
    ));
    if($settings->getSetting('sesproduct.search', 1)) {
        $this->addElement('Checkbox', 'search', array(
        'label' => 'People can search for this product.',
        'value' => 1,
        ));
    }
    if($settings->getSetting('sesproduct.product', 1)) {

        $this->addElement('Checkbox', 'enable_product', array(
        'label' => 'Enable this product',
        'value' => 1,
        ));
    }

    $this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array(""=>"Published", "1"=>"Saved As Draft"),
      'description' => 'If this entry is published, it cannot be switched back to draft mode.',
      'class'=>$hideClass,
    ));
    $this->draft->getDecorator('Description')->setOption('placement', 'append');
    $this->addElement('Text', 'formHeading17', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate(''),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 0,
                      'id' => $divContentId++,
                     ))),
    ));
    $this->addElement('Hidden','hiddenDic',array('value'=>$divContentId - 1,'order'=>$hiddenElement++));
    $this->addElement('Button', 'submit_check',array(
      'type' => 'submit',
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => 'Create Product',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    if($this->getSmoothboxType()) {
			$this->addElement('Cancel', 'advanced_sesproductoptions', array(
        'label' => 'Show Advanced Settings',
        'link' => true,
				'class'=>'active',
        'href' => 'javascript:;',
        'onclick' => 'return false;',
        'decorators' => array(
            'ViewHelper'
        )
    	));
			$this->addElement('Dummy', 'brtag', array(
					'content' => '<span style="margin-top:5px;"></span>',
			));
			$this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'href' => '',
				'prependText' => ' or ',
        'onclick' => 'sessmoothboxclose();',
        'decorators' => array(
            'ViewHelper'
        )
    	));
			$this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
					'decorators' => array(
							'FormElements',
							'DivDivDivWrapper',
					),
			));
    }
  }
}
