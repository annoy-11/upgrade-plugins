<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_Form_Edit extends Engine_Form
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

    if (Engine_Api::_()->core()->hasSubject('sesjob_job'))
        $job = Engine_Api::_()->core()->getSubject();

	 if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesjobpackage') && (Engine_Api::_()->getItem('sesjobpackage_package',$job->package_id)) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjobpackage.enable.package', 1)){
	  $package_id = $job->package_id;
		if ($package_id) {
			$package = Engine_Api::_()->getItem('sesjobpackage_package', $package_id);
			$modulesEnable = json_decode($package->params,true);
		}
	 }

    $this->setTitle('Edit Job Entry')
      ->setDescription('Edit your entry below, then click "Save Changes" to publish the entry on your job.')->setAttrib('name', 'sesjobs_edit');
    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.company', 1)) {
    $this->addElement('Dummy', 'companydetails', array(
      'label' => 'Company Information',
    ));

    $this->addElement('Text', 'company_name', array(
      'label' => 'Company Name',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'company_websiteurl', array(
      'label' => 'Company Website URL',
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Textarea', 'company_description', array(
      'label' => 'Company Description',
      'allowEmpty' => false,
      'required' => true,
    ));

    $industries = Engine_Api::_()->getDbTable('industries', 'sesjob')->getIndustriesAssoc();
    if(count($industries) > 0) {
        $industries = array('' => '') + $industries;
        $this->addElement('Select', 'industry_id', array(
            'label' => 'Industry',
            'multiOptions' => $industries,
            'allowEmpty' => false,
            'required' => true,
        ));
    }

    }

    $this->addElement('Dummy', 'jobgeneralinformation', array(
      'label' => 'Job Information',
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

    // init to
    $this->addElement('Text', 'tags',array(
      'label'=>'Skills (Keywords)',
      'autocomplete' => 'off',
      'description' => 'Separate skills with commas.',
      'filters' => array(
        new Engine_Filter_Censor(),
      ),
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.start.date', 1)) {
			if(isset($job)){
				$start = strtotime($job->publish_date);
				$start_date = date('m/d/Y',($start));
				$start_time = date('g:ia',($start));
				$viewer = Engine_Api::_()->user()->getViewer();
				$publishDate = $start_date.' '.$start_time;
				if($viewer->timezone){
					$start = strtotime($job->publish_date);
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
			if(isset($job) && $job->publish_date != '' && strtotime($publishDate) > time()){
				$this->addElement('dummy', 'job_custom_datetimes', array(
						'decorators' => array(array('ViewScript', array(
						'viewScript' => 'application/modules/Sesjob/views/scripts/_customdates.tpl',
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

    //if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob_enable_location', 1) && ((isset($modulesEnable) && array_key_exists('enable_location',$modulesEnable) && $modulesEnable['enable_location']) || empty($modulesEnable))) {
      $this->addElement('Text', 'location', array(
	  'label' => 'Location',
	  'id' => 'locationSes',
	  'filters' => array(
	      new Engine_Filter_Censor(),
	      new Engine_Filter_HtmlSpecialChars(),
	  ),
      ));
      $this->addElement('Text', 'lat', array(
	  'label' => 'Lat',
	  'id' => 'latSes',
	  'filters' => array(
	      new Engine_Filter_Censor(),
	      new Engine_Filter_HtmlSpecialChars(),
	  ),
      ));
      $this->addElement('dummy', 'map-canvas', array());
      $this->addElement('dummy', 'ses_location', array('content'));
      $this->addElement('Text', 'lng', array(
	  'label' => 'Lng',
	  'id' => 'lngSes',
	  'filters' => array(
	      new Engine_Filter_Censor(),
	      new Engine_Filter_HtmlSpecialChars(),
	  ),
      ));
   // }

    // prepare categories
    $categories = Engine_Api::_()->getDbtable('categories', 'sesjob')->getCategoriesAssoc(array('member_level'=>1));
    if( count($categories) > 0 ) {
        $categorieEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.category.enable', '1');
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


      $sesjob = Engine_Api::_()->core()->getSubject();
      // General form w/o profile type
      $aliasedFields = $sesjob->fields()->getFieldsObjectsByAlias();
      $topLevelId = $topLevelId = 0;
      $topLevelValue = $topLevelValue = null;

      if (isset($aliasedFields['profile_type'])) {
				$aliasedFieldValue = $aliasedFields['profile_type']->getValue($sesjob);
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
      $customFields = new Sesjob_Form_Custom_Fields(array(
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

    $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'sesjob_job', 'auth_html');
    $upload_url = "";
    if(Engine_Api::_()->authorization()->isAllowed('album', $user, 'create')){
      $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
    }

    $editorOptions = array(
      'upload_url' => $upload_url,
      'html' => true,
      'extended_valid_elements'=>$allowed_html,
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

    $this->addElement('Textarea', 'description', array(
      'label' => 'Short Description',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '224'))
      ),
    ));

    if((isset($modulesEnable) && array_key_exists('enable_tinymce',$modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable)) {
			$textarea = 'TinyMce';
		}else
			$textarea = 'Textarea';

    $descriptionMan= Engine_Api::_()->getApi('settings', 'core')->getSetting('sesjob.description.mandatory', '1');
		if ($descriptionMan == 1) {
			$required = true;
			$allowEmpty = false;
		} else {
			$required = false;
			$allowEmpty = true;
		}
    $this->addElement($textarea, 'body', array(
      'label' => 'Job Description',
      'required' => $required,
      'allowEmpty' => $allowEmpty,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));

    if (Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'allow_levels')) {

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
            'description' => 'Choose the Member Levels to which this Job will be displayed. (Note: Hold down the CTRL key to select or de-select specific member levels.)',
            'value' => $levelValues,
        ));
    }

    if (Engine_Api::_()->authorization()->isAllowed('sesjob_job', $viewer, 'allow_network')) {
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
          'description' => 'Choose the Networks to which this Page will be displayed. (Note: Hold down the CTRL key to select or de-select specific networks.)',
          'value' => $networkValues,
      ));
    }

      $this->addElement('Hidden', 'jobstyle', array(
        'value' => 1,
      ));

    //Job Information
    $this->addElement('Dummy', 'jobdetails', array(
      'label' => 'Job Details',
    ));

    $this->addElement('Text', 'salary', array(
        'label' => 'Salary',
        'description' => 'Enter salary that you want to pay.',
        //'required' => true,
        //'allowEmpty' => false,
    ));

    $this->addElement('Text', 'otherpay', array(
        'label' => 'Other Pays',
        //'required' => true,
        //'allowEmpty' => false,
    ));

    $this->addElement('Text', 'experience', array(
        'label' => 'Required Experience',
        //'required' => true,
        //'allowEmpty' => false,
    ));

//     $this->addElement('Text', 'reference_code', array(
//         'label' => 'Reference Code',
//         'description' => "Enter reference code/id for this job",
//         //'required' => true,
//         //'allowEmpty' => false,
//     ));

    $employments = Engine_Api::_()->getDbTable('employments', 'sesjob')->getEmploymentsAssoc();
    if(count($employments) > 0) {
        $employments = array('' => '') + $employments;
        $this->addElement('Select', 'employment_id', array(
            'label' => 'Employment Type',
            'required' => true,
            'allowEmpty' => false,
            'multiOptions' => $employments,
        ));
    }

    $educations = Engine_Api::_()->getDbTable('educations', 'sesjob')->getEducationsAssoc();
    if(count($educations) > 0) {
        $this->addElement('MultiCheckbox', 'education_id', array(
            'label' => 'Education Level',
            //'required' => true,
            //'allowEmpty' => false,
            'multiOptions' => $educations,
        ));
    }

//     $this->addElement('Radio', 'manage_others', array(
//         'label' => 'Manage Others',
//         //'required' => true,
//         //'allowEmpty' => false,
//         'multiOptions' => array('1' => 'Yes', '0' => 'No'),
//         'value' => 0,
//     ));


    $this->addElement('Checkbox', 'search', array(
      'label' => 'Show this job entry in search results',
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
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesjob_job', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this job entry?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesjob_job', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this job entry?',
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
