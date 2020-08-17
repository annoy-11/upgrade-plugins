<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Form_Edit extends Engine_Form
{
  protected $_defaultProfileId;
  protected $_fromApi;
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

  public function init() {
  
    $translate = Zend_Registry::get('Zend_Translate'); 
    
 		if (Engine_Api::_()->core()->hasSubject('sesrecipe_recipe'))
    $recipe = Engine_Api::_()->core()->getSubject();
		
	 if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesrecipepackage') && (Engine_Api::_()->getItem('sesrecipepackage_package',$recipe->package_id)) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipepackage.enable.package', 1)){
	  $package_id = $recipe->package_id;
		if ($package_id) {
			$package = Engine_Api::_()->getItem('sesrecipepackage_package', $package_id);
			$modulesEnable = json_decode($package->params,true);
		}
	 }
		
    $this->setTitle('Edit Recipe Entry')
      ->setDescription('Edit your entry below, then click "Save Changes" to publish the entry on your recipe.')->setAttrib('name', 'sesrecipes_edit');
    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

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
    
    // init to
    $this->addElement('Text', 'tags',array(
      'label'=>'Tags (Keywords)',
      'autocomplete' => 'off',
      'description' => 'Separate tags with commas.',
      'filters' => array(
        new Engine_Filter_Censor(),
      ),
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.start.date', 1)) {
			if(isset($recipe)){
				$start = strtotime($recipe->publish_date);
				$start_date = date('m/d/Y',($start));
				$start_time = date('g:ia',($start));
				$viewer = Engine_Api::_()->user()->getViewer();
				$publishDate = $start_date.' '.$start_time;
				if($viewer->timezone){
					$start = strtotime($recipe->publish_date);
					$oldTz = date_default_timezone_get();
					date_default_timezone_set($viewer->timezone);
					$start_date = date('m/d/Y',($start));
          $start_date_y = date('Y',strtotime($start_date));
          $start_date_m = date('m',strtotime($start_date));
          $start_date_d = date('d',strtotime($start_date));
					$start_time = date('g:ia',($start));
					date_default_timezone_set($oldTz);
				}
			}
			if(isset($recipe) && $recipe->publish_date != '' && strtotime($publishDate) > time()){ 
				$this->addElement('dummy', 'recipe_custom_datetimes', array(
						'decorators' => array(array('ViewScript', array(
						'viewScript' => 'application/modules/Sesrecipe/views/scripts/_customdates.tpl',
						'class' => 'form element',
						'start_date'=>$start_date,
						'start_time'=>$start_time,
						'start_time_check'=>1,
						'subject'=> '',
				  )))
				));
			  if($this->getFromApi()){
          // Start time
          $start = new Engine_Form_Element_Date('starttime');
          $start->setLabel("Start Time");
          if(!empty($start_date_y)){
            $start_date_cal = array('year'=>$start_date_y,'month'=>$start_date_m,'day'=>$start_date_d);
            $start->setValue($start_date_cal);
          }
          $start->setAllowEmpty(true);
          $start->setRequired(false);
          $this->addElement($start);
        }
      }
		}
    
    //if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe_enable_location', 1) && ((isset($modulesEnable) && array_key_exists('enable_location',$modulesEnable) && $modulesEnable['enable_location']) || empty($modulesEnable))) {
      $this->addElement('Text', 'location', array(
        'label' => 'Location',
        'id' => 'locationSes',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
      ));
      
      $optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}'));

      if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
        if(in_array('country', $optionsenableglotion)) {
          $this->addElement('Text', 'country', array(
            'placeholder' => 'Country',
          ));
        }
        if(in_array('state', $optionsenableglotion)) {
          $this->addElement('Text', 'state', array(
            'placeholder' => 'State',
          ));
        }
        if(in_array('city', $optionsenableglotion)) {
          $this->addElement('Text', 'city', array(
            'placeholder' => 'City',
          ));
        }
        if(in_array('zip', $optionsenableglotion)) {
          $this->addElement('Text', 'zip', array(
            'placeholder' => 'Zip',
          ));
        }
      }

      $this->addElement('Text', 'lat', array(
        'placeholder' => 'Latitude',
        'id' => 'latSes',
      ));
      $this->addElement('Text', 'lng', array(
        'placeholder' => 'Longitude',
        'id' => 'lngSes',
      ));
			
    	$this->addDisplayGroup(array('country', 'state', 'city', 'zip', 'lat', 'lng'), 'LocationGroup', array(
				'decorators' => array('FormElements', 'DivDivDivWrapper'),
			));
			
      $this->addElement('dummy', 'map-canvas', array());
      $this->addElement('dummy', 'ses_location', array('content'));
   // }
    
    // prepare categories
    $categories = Engine_Api::_()->getDbtable('categories', 'sesrecipe')->getCategoriesAssoc();
    if( count($categories) > 0 ) {
        $categorieEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.category.enable', '1');
        if ($categorieEnable == 1) {
          $required = true;
          $allowEmpty = false;
        } else {
          $required = false;
          $allowEmpty = true;
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
			
			
      $sesrecipe = Engine_Api::_()->core()->getSubject();
      // General form w/o profile type
      $aliasedFields = $sesrecipe->fields()->getFieldsObjectsByAlias();
      $topLevelId = $topLevelId = 0;
      $topLevelValue = $topLevelValue = null;

      if (isset($aliasedFields['profile_type'])) {
				$aliasedFieldValue = $aliasedFields['profile_type']->getValue($sesrecipe);
				$topLevelId = $aliasedFields['profile_type']->field_id;
				$topLevelValue = ( is_object($aliasedFieldValue) ? $aliasedFieldValue->value : null );
				if (!$topLevelId || !$topLevelValue) {	
					$topLevelId = null;
					$topLevelValue = null;
				}
				$topLevelId = $topLevelId;
				$topLevelValue = $topLevelValue;
      }
      // Get category map form data
      $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
      $customFields = new Sesrecipe_Form_Custom_Fields(array(
	  'item' => Engine_Api::_()->core()->getSubject(),
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
    
     if($this->getFromApi()){
       $this->addElement('File', 'file', array(
          'label' => 'Main Photo',
          'description' => '',
        ));
      }
    if(((isset($modulesEnable) && array_key_exists('modules',$modulesEnable) && in_array('photo',$modulesEnable['modules'])) || empty($modulesEnable))){
			//silence
		}else{
			// Photo
			$this->addElement('File', 'photo_file', array(
				'label' => 'Main Photo'
			));
			$this->photo_file->addValidator('Extension', false, 'jpg,png,gif,jpeg');
				
		}
		
    $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'sesrecipe', 'auth_html');
    $upload_url = "";
    
    if(Engine_Api::_()->authorization()->isAllowed('album', $user, 'create')){
      $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
    }

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
		
    if((isset($modulesEnable) && array_key_exists('enable_tinymce',$modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable)) {
				$textarea = 'TinyMce';
		}else
			$textarea = 'Textarea';
		
    $descriptionMan= Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.description.mandatory', '1');
		if ($descriptionMan == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}
		
    $this->addElement($textarea, 'body', array(
      'label' => 'Recipe Description',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));
    
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.enablerecipedesignview', 1)) {
    
      $chooselayout = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.chooselayout', 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');
      $chooselayoutVal = unserialize($chooselayout);
      
      $designoptions = array();
      if(in_array(1, $chooselayoutVal)) {
        $designoptions[1] = '<a href="" onclick="showPreview(1);return false;"><img src="./application/modules/Sesrecipe/externals/images/layout_1.jpg" alt="" /></a> '.$translate->translate("Design 1");
      }
      if(in_array(2, $chooselayoutVal)) {
        $designoptions[2] = '<a href="" onclick="showPreview(2);return false;"><img src="./application/modules/Sesrecipe/externals/images/layout_2.jpg" alt="" /></a> '.$translate->translate("Design 2");
      } 
      if(in_array(3, $chooselayoutVal)) {
        $designoptions[3] = '<a href="" onclick="showPreview(3);return false;"><img src="./application/modules/Sesrecipe/externals/images/layout_3.jpg" alt="" /></a> '.$translate->translate("Design 3");
      } 
      if(in_array(4, $chooselayoutVal)) {
        $designoptions[4] = '<a href="" onclick="showPreview(4);return false;"><img src="./application/modules/Sesrecipe/externals/images/layout_4.jpg" alt="" /></a> '.$translate->translate("Design 4");
      } 

      $this->addElement('Radio', 'recipestyle', array(
        'label' => 'Recipe Layout',
        'description' => 'Set Your Recipe Template',
        'multiOptions' => $designoptions,
        'escape' => false,
      ));
		} else {
      $this->addElement('Hidden', 'recipestyle', array(
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sesrecipe.defaultlayout', 1),
      ));
		}

    $this->addElement('Checkbox', 'search', array(
      'label' => 'Show this recipe entry in search results',
      'value' => 1,
    ));

    $availableLabels = array(
      'everyone'            => 'Everyone',
      'registered'          => 'All Registered Members',
      'owner_network'       => 'Friends and Networks',
      'owner_member_member' => 'Friends of Friends',
      'owner_member'        => 'Friends Only',
      'owner'               => 'Just Me'
    );

    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesrecipe_recipe', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this recipe entry?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesrecipe_recipe', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this recipe entry?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    $this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array(""=>"Published", "1"=>"Saved As Draft"),
      'description' => 'If this entry is published, it cannot be switched back to draft mode.'
    ));
		$this->draft->getDecorator('Description')->setOption('placement', 'append');
    // Element: submit
  // Element: execute
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
    ));
  }
}
