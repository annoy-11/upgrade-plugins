<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Create.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Course_Create extends Engine_Form
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
      $hideClass = 'course_hideelement_smoothbox';
    else
      $hideClass = '';
    $viewer = Engine_Api::_()->user()->getViewer();
    $translate = Zend_Registry::get('Zend_Translate');
    $this->setTitle('Create New Course')
      ->setDescription('Configure your new Course below, then click "Create Course" to create the Course.')
      ->setAttrib('name', 'courses_create_form');
    if($this->getSmoothboxType())
        $this->setAttrib('class','global_form course_smoothbox_create');
    $user = Engine_Api::_()->user()->getViewer();
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;
    if (Engine_Api::_()->core()->hasSubject())
        $course = Engine_Api::_()->core()->getSubject();
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
    $this->addElement('Text', 'title', array(
      'label' => $view->translate('Title'),
      'allowEmpty' => false,
			'description' => $view->translate('Please enter Course title in the box'),
			'placeholder'=> $view->translate('Enter Course Title'),
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '224'))
      ),
    ));
    $custom_url_value = isset($course->custom_url) ? $course->custom_url : (isset($_POST["custom_url"]) ? $_POST["custom_url"] : "");
    // Custom Url
    $this->addElement('Dummy', 'custom_url_course', array(
      'label' => 'Custom URL',
      'placeholder'=> 'Enter URL',
      'content' => '<input type="text" name="custom_url" id="custom_url" value="' . $custom_url_value . '"><i class="fa fa-check" id="course_custom_url_correct" style="display:none;"></i><i class="fa fa-close" id="course_custom_url_wrong" style="display:none;"></i> <button id="check_custom_url_availability" type="button" name="check_availability" ><span class="course_check_availability_btn"><img src="application/modules/Core/externals/images/loading.gif" id="course_custom_url_loading" alt="Loading" style="display:none;" /> Check Availability</button></span><p id="suggestion_tooltip" class="check_tooltip" style="display:none;">'.$translate->translate("You can use letters, numbers and periods.").'</p>',
    ));
    // init to
    if($settings->getSetting('courses.coursetags',1)){
        $this->addElement('Text', 'tags', array(
            'label' => $translate->translate('Tags (Keywords)'),
            'autocomplete' => 'off',
            'description' => $translate->translate('Separate tags with commas.'),
            'filters' => array(
                new Engine_Filter_Censor(),
            )
        ));
        $this->tags->getDecorator("Description")->setOption("placement", "append");
    }
    $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'course', 'auth_html');
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
    if($settings->getSetting('courses.enable.description',1)){
            if((isset($modulesEnable) && array_key_exists('enable_tinymce',$modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable) && $settings->getSetting('courses.wysiwyg.editor',1)) {
                    $textarea = 'TinyMce';
            } else{
                $textarea = 'Textarea';
            }

            $descriptionMan= $settings->getSetting('courses.description.mandatory', '1');
            if ($descriptionMan == 1) {
                $required = true;
                $allowEmpty = false;
            } else {
                $required = false;
                $allowEmpty = true;
            }
        $this->addElement($textarea, 'description', array(
            'label' => 'Course Description',
            'required' => $required,
            'allowEmpty' => $allowEmpty,
            'class'=>'tinymce',
            'editorOptions' => $editorOptions,
        ));
    }
  // prepare categories
  if($settings->getSetting('courses.enable.category', 1)) {
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
    $categories = Engine_Api::_()->getDbtable('categories', 'courses')->getCategoriesAssoc(array('type'=>'course'));
      if( count($categories) > 0 ) {
          $categorieEnable = $settings->getSetting('courses.category.mandatory', '1');
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
    $defaultProfileId = "0_0_" . $this->getDefaultProfileId();
    $customFields = new Sesbasic_Form_Custom_Fields(array(
        'packageId' => '',
        'resourceType' => '',
        'item' => isset($course) ? $course : 'courses',
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
        'fields' => $customFields
    ));
  }
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
  $defaultCurrency = Engine_Api::_()->courses()->getCurrentCurrency();
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
          array('GreaterThan', false, array(-1)),
          array('Between', false, array('min' => '-1', 'max' =>$settings->getSetting('courses.max.fee', 5000), 'inclusive' => false))
      ),
      'filters' => array(
          'StripTags',
          new Engine_Filter_Censor(),
      )
  ));
if($settings->getSetting('courses.enable.discount', 1))
{
    $this->addElement('Radio', 'discount', array(
            'label' => $translate->translate('Discount'),
            'multiOptions'=>array('1'=>'Yes','0'=>'No'),
            'value'=> 0
    ));
    $this->addElement('Select', 'discount_type', array(
            'label' => $translate->translate('Discount Type'),
            'multiOptions'=>array('1'=>'Fixed','0'=>'Percentage'),
            'value'=> 0
    ));
    $this->addElement('Text', 'fixed_discount_value', array(
            'label' => $translate->translate('Discount Value'),
            'placeholder'=>"0.00",
            'class'=>'sesdecimal',
            'validators' => array(
                    array('NotEmpty', true),
                    array('Float', true),
                    array('GreaterThan', false, array(-1))
            ),
    ));
    $this->addElement('Text', 'percentage_discount_value', array(
            'label' => $translate->translate('Discount Value (%)'),
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
    if(empty($course)){
        if(empty($_POST)){
            $startDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes'));
            $start_date = date('m/d/Y',strtotime($startDate));
            $start_time = date('g:ia',strtotime($startDate));
            if($viewer->timezone){
                $start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes')));
                $start_date = date('m/d/Y',($start));
                $start_time = date('g:ia',$start);
            }
        }else{
            $start_date = date('m/d/Y',strtotime($_POST['discount_start_date']));
            $start_time = date('g:ia',strtotime($_POST['discount_start_date_time']));
        }
    }else{
        //call from edit page
        if(!count($_POST)){
            if($course->discount_start_date){
                $startDate = $course->discount_start_date;
                $start_date = date('m/d/Y',strtotime($startDate));
                $start_time = date('g:ia',strtotime($startDate));
            }
        }else{
                $start_date = date('m/d/Y',strtotime($_POST['discount_start_date']));
                $start_time = date('g:ia',strtotime($_POST['discount_start_date_time']));
        }
    }
    $this->addElement('dummy', 'course_custom_discount_datetimes', array(
        'decorators' => array(
            array('ViewScript',
                array(
                    'viewScript' => 'application/modules/Courses/views/scripts/_customDiscountStartdates.tpl',
                    'class' => 'form element',
                    'start_date'=>$start_date,
                    'start_time'=>$start_time,
                    'required'=>false,
                    'start_time_check'=>1,
                    'subject'=>isset($course) ? $course : '',
                )
            )
        )
    ));
    $this->addElement('Radio', 'discount_end_type', array(
            'label' => $translate->translate('Discount End Date'),
            'multiOptions' => array( "1" => $translate->translate("End discount on a specific date. (Please select date from below.)"),"0" => $translate->translate("No End date.")),
            'description' => $translate->translate("Choose from below when do you want to end this discount."),
            'value' => 0,
            'onclick' => "",
    ));
    if(empty($course)){
        if(empty($_POST)){
            $endDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 1Days'));
            $end_date = date('m/d/Y',strtotime($endDate));
            $end_time = date('g:ia',strtotime($endDate));
            if($viewer->timezone){
                $start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 1Days')));
                $end_date = date('m/d/Y',($start));
                $end_time = date('g:ia',$start);
               
            }
        }else{
            $end_date = date('m/d/Y',strtotime($_POST['end_date']));
            $end_time = date('g:ia',strtotime($_POST['end_time']));
        }
    }else{
        //call from edit page
        if(!count($_POST)){
            if($course->discount_end_date){
                $startDate = $course->discount_end_date;
                $end_date = date('m/d/Y',strtotime($startDate));
                $end_time = date('g:ia',strtotime($startDate));
            }
        }else{
                $end_date = date('m/d/Y',strtotime($_POST['discount_end_date']));
                $end_time = date('g:ia',strtotime($_POST['discount_end_date_time']));
        }
    }
    $this->addElement('dummy', 'course_custom_discount_enddatetimes', array('decorators' => array(
            array('ViewScript',
                array(
                    'viewScript' => 'application/modules/Courses/views/scripts/_customDiscountEnddates.tpl',
                    'class' => 'form element',
                    'end_date'=>$end_date,
                    'end_time'=>$end_time,
                    'start_time_check'=>1,
                    'subject'=>isset($course) ? $course : '',
                )
            )
        )
    ));
    $this->addElement('Select', 'allowed_discount_type', array(
            'label' => $translate->translate('Whom To Allow Discount?'),
            'description' => 'Who may avail this discount?',
            'multiOptions' => array('0' => $translate->translate('Everyone'), '2' => $translate->translate('All Registered Members'), '1' => 'Friends','3'=>$translate->translate('Friends of Friends')),
            'value' => 0
    ));
   date_default_timezone_set($oldTz);
}
if($settings->getSetting('courses.purchasenote',1) || $settings->getSetting('courses.reviews',1)) {
    $this->addElement('Text', 'formHeading12',
    array('decorators' => array(
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
    if($settings->getSetting('courses.purchasenote',1)) {
        $this->addElement('Textarea','purchase_note',array(
        'label'=> $translate->translate('Purchase Note'),
        'description' => $translate->translate('Enter the purchase note for this Course & it will display on view page.'),
        ));
    }
    if($settings->getSetting('courses.reviews',1)) {
        $this->addElement('Checkbox', 'enable_review', array(
            'label' => $translate->translate('Enable Reviews'),
            'description' => $translate->translate('Yes, enable reviews for this Course.'),
            'value' => 1,
        ));
    }
}
if($settings->getSetting('courses.start.date', 1) || $settings->getSetting('courses.end.date', 1))  {
  $this->addElement('Text', 'formHeading13', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate('Course Availability'),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 1,
                      'id' => $divContentId++,
                     ))),
    ));
  if($settings->getSetting('courses.start.date', 1))  {
    $this->addElement('Radio', 'show_start_time', array(
        'label' => $translate->translate('Start Date'),
        'description' => '',
        'multiOptions' => array(
            "0" => $translate->translate('Choose Start Date'),
            "1" => $translate->translate('Publish Now'),
        ),
        'value' => 1,
        'onclick' => "showStartDate(this.value);",
    ));
    $oldTz = date_default_timezone_get(); 
    date_default_timezone_set(Engine_Api::_()->user()->getViewer()->timezone);
    if(empty($course)){
            if(empty($_POST)){
                $startDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes'));
                $start_date = date('m/d/Y',strtotime($startDate));
                $start_time = date('g:ia',strtotime($startDate));
                if($viewer->timezone){
                    $start =  strtotime(date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 2 minutes')));
                    $start_date = date('m/d/Y',($start));
                    $start_time = date('g:ia',$start); 
                }
            }else{
                $start_date = date('m/d/Y',strtotime($_POST['start_date']));
                $start_time = date('g:ia',strtotime($_POST['start_time']));
            }
        }else{
            //call from edit page
            if(!count($_POST)){
                if($course->starttime){
                  $startDate = $course->starttime;
                  $start_date = date('m/d/Y',strtotime($startDate));
                  $start_time = date('g:ia',strtotime($startDate));
                }
            }else{
                $start_date = date('m/d/Y',strtotime($_POST['start_date']));
                $start_time = date('g:ia',strtotime($_POST['start_date_time']));
            }
        }
        $this->addElement('dummy', 'course_custom_datetimes', array(
            'decorators' => array(array('ViewScript', array(
                'viewScript' => 'application/modules/Courses/views/scripts/_customdates.tpl',
                'class' => 'form element',
                'start_date'=>$start_date,
                'start_time'=>$start_time,
                'start_time_check'=>1,
                'subject'=>isset($course) ? $course : '',
            )))
        ));
    }
    if($settings->getSetting('courses.end.date', 1))  {
        if(empty($course)){
            $this->addElement('Radio', 'show_end_time', array(
                'label' => $translate->translate('End Date'),
                'description' => '',
                'multiOptions' => array(
                "1" => $translate->translate('End course show to a specific date.'),
                "0" => $translate->translate('No End Date'),
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
                    $end_date = date('m/d/Y',($start));
                    $end_time = date('g:ia',$start);
                }
            }else{
                $end_date = date('m/d/Y',strtotime($_POST['end_date']));
                $end_time = date('g:ia',strtotime($_POST['end_time']));
            }
        }else{
            $this->addElement('Radio', 'show_end_time', array(
                'label' => $translate->translate('End Date'),
                'description' => '',
                'multiOptions' => array(
                "1" => $translate->translate('End course show to a specific date.'),
                "0" => $translate->translate('No End Date'),
            ),
            'value' => $course->show_end_time,
            'onclick' => "showEndDate(this.value);",
            ));
            //call from edit page
            if(!count($_POST)){
                if($course->endtime){
                $startDate = $course->endtime;
                $end_date = date('m/d/Y',strtotime($startDate));
                $end_time = date('g:ia',strtotime($startDate));
              
                }
            }else{
                $end_date = date('m/d/Y',strtotime($_POST['end_date']));
                $end_time = date('g:ia',strtotime($_POST['end_date_time']));
            }
        }
        $this->addElement('dummy', 'course_custom_enddatetimes', array(
            'decorators' => array(array('ViewScript', array(
                    'viewScript' => 'application/modules/Courses/views/scripts/_customEnddates.tpl',
                    'class' => 'form element',
                    'end_date'=>$end_date,
                    'end_time'=>$end_time,
                    'start_time_check'=>1,
                    'subject'=>isset($course) ? $course : '',
            ))),
            'value'=> date('m/d/Y'),
        ));
    }
    date_default_timezone_set($oldTz);
  }
  $this->addElement('Text', 'formHeading4', array(
      'decorators' => array(array('ViewScript', array(
          'viewScript' => '_headingElementsForm.tpl',
          'heading' => $view->translate('Linked Courses'),
          'class' => 'form element',
          'closediv' => 1,
          'openDiv' => 1,
          'id' => $divContentId++,
      ))),
  ));
  $this->addElement('Text', 'upsell', array(
      'label' => $translate->translate('View page courses'),
      'autocomplete' => 'off',
      'placeholder'=> $translate->translate('Enter Course name.'),
      'description' => $translate->translate('Select the Courses that you want to display on Course View Page.'),
      'filters' => array(
          new Engine_Filter_Censor(),
      )
  ));
  $this->upsell->getDecorator("Description")->setOption("placement", "append");
  $this->addElement('Hidden','upsell_id',array('order'=>$hiddenElement++));
   $this->addElement('Text', 'crosssell', array(
      'label' => $translate->translate('Checkout page courses'),
      'placeholder'=> $translate->translate('Enter Course name.'),
      'autocomplete' => 'off',
      'description' => $translate->translate('Select the Courses that you want to display on Checkout Page.'),
      'filters' => array(
          new Engine_Filter_Censor(),
      )
  ));
  $this->crosssell->getDecorator("Description")->setOption("placement", "append");
  $this->addElement('Hidden','crosssell_id',array('order'=>$hiddenElement++));
  if(!isset($course) && $settings->getSetting('courses.main.photo', '1') && Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'upload_mainphoto')) {
    $this->addElement('Text', 'formHeading5', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate('Course Profile Photo.'),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 1,
                      'id' => $divContentId++,
                    ))),
    ));
        $mainPhotomandatory = $settings->getSetting('courses.mainPhoto.mandatory', '1');
        if ($mainPhotomandatory == 1) {
            $required = true;
            $allowEmpty = false;
        } else {
            $required = false;
            $allowEmpty = true;
        }
        $requiredClass = $required ? ' requiredClass' : '';
        $translate = Zend_Registry::get('Zend_Translate');
        //Main Photo
        $this->addElement('File', 'photo', array(
            'label' => $translate->translate('Main Photo'),
            'onclick' => 'javascript:sesJqueryObject("#photo").val("")',
            'onchange' => 'handleFileBackgroundUpload(this,courses_main_photo_preview)',
            'description'=>'Add Photo for your Course',
        ));
        $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $this->addElement('Dummy', 'photo-uploader', array(
            'label' => $translate->translate('Main Photo'),
            'content' => '<div id="dragandrophandlerbackground" class="courses_upload_dragdrop_content sesbasic_bxs' . $requiredClass . '"><div class="courses_upload_dragdrop_content_inner"><i class="fa fa-camera"></i><span class="courses_upload_dragdrop_content_txt">' . $translate->translate('Add photo for your course') . '</span></div></div>'
        ));
        $this->addElement('Image', 'courses_main_photo_preview', array(
            'width' => 300,
            'height' => 200,
            'value' => '1',
            'disable' => true,
        ));
        $this->addElement('Dummy', 'removeimage', array(
            'content' => '<a class="icon_cancel form-link" id="removeimage1" style="display:none; "href="javascript:void(0);" onclick="removeImage();"><i class="fa fa-trash-o"></i>' . $translate->translate('Remove') . '</a>',
        ));
        $this->addElement('Hidden', 'removeimage2', array(
            'value' => 1,
            'order' => 10000000012,
        ));
  }
   $this->addElement('Text', 'formHeading6', array(
      'decorators' => array(array('ViewScript', array(
                      'viewScript' => '_headingElementsForm.tpl',
                      'heading' => $view->translate('Manage Privacy'),
                      'class' => 'form element',
                      'closediv' => 1,
                      'openDiv' => 1,
                      'id' => $divContentId++,
                     ))),
    ));
    if (Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'allow_network')) {
      $networkOptions = array();
      $networkValues = array();
      foreach (Engine_Api::_()->getDbTable('networks', 'network')->fetchAll() as $network) {
        $networkOptions[$network->network_id] = $network->getTitle();
        $networkValues[] = $network->network_id;
      }

      // Select Networks
      $this->addElement('multiselect', 'networks', array(
          'label' => $view->translate('Networks'),
          'multiOptions' => $networkOptions,
          'description' => $view->translate('Choose the Networks to which this Course will be displayed. (Note: Hold down the CTRL key to select or de-select specific networks.)'),
          'value' => $networkValues,
      ));
    }
    if (Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'allow_levels')) { 
        $levelOptions = array();
        $levelValues = array();
        foreach (Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll() as $level) {
             if($level->getTitle() == 'Public')
                continue;
            $levelOptions[$level->level_id] = $level->getTitle();
            $levelValues[] = $level->level_id;
        }
        // Select Member Levels
        $this->addElement('multiselect', 'levels', array(
            'label' => $view->translate('Member Levels'),
            'multiOptions' => $levelOptions,
            'description' => $view->translate('Choose the Member Levels to which this Course will be displayed. (Note: Hold down the CTRL key to select or de-select specific member levels.)'),
            'value' => $levelValues,
        ));
    }
    $availableLabels = array(
      'everyone'            => $view->translate('Everyone'),
      'registered'          => $view->translate('All Registered Members'),
      'owner_network'       => $view->translate('Friends and Networks'),
      'owner_member_member' => $view->translate('Friends of Friends'),
      'owner_member'        => $view->translate('Friends Only'),
      'owner'               => $view->translate('Just Me')
    );
    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('courses', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    $this->addElement('Select', 'auth_ltr_create', array(
            'label' => $view->translate('Lecture View Privacy'),
            'description' => $view->translate('Who may view lectures on course?'),
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
            'class'=>$hideClass,
        ));
    $this->auth_ltr_create->getDecorator('Description')->setOption('placement', 'append');
    $this->addElement('Select', 'auth_tst_create', array(
            'label' => $view->translate('Test Privacy'),
            'description' => $view->translate('Who can take Test?'),
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
            'class'=>$hideClass,
    ));
    $this->auth_tst_create->getDecorator('Description')->setOption('placement', 'append');
    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions),'order'=>$hiddenElement++));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => $view->translate('Privacy'),
            'description' => $view->translate('Who may see this Course?'),
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
            'class'=>$hideClass,
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('courses', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));
    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions),'order'=>$hiddenElement++));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => $view->translate('Comment Privacy'),
            'description' => $view->translate('Who may post comments on this Course?'),
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
            'class'=>$hideClass,
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    $this->addElement('Text', 'formHeading16', array(
      'decorators' => array(array('ViewScript',
            array(
                    'viewScript' => '_headingElementsForm.tpl',
                    'heading' => $view->translate('Other'),
                    'class' => 'form element',
                    'closediv' => 1,
                    'openDiv' => 1,
                    'id' => $divContentId++,
                )
            )
        ),
    ));
    if($settings->getSetting('courses.search', 1)) {
        $this->addElement('Checkbox', 'search', array(
        'label' => $view->translate('People can search for this Course.'),
        'value' => 1,
        ));
    }
    if($settings->getSetting('courses.enable', 1)) {
        $this->addElement('Checkbox', 'enable_course', array(
        'label' => $view->translate('Enable this Course'),
        'value' => 1,
        ));
    }
    $this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array("1"=> $view->translate('Published'), "0"=> $view->translate('Saved As Draft')),
      'description' => $view->translate('If this Course is published, it cannot be switched back to draft mode.'),
      'class'=>$hideClass,
    ));
    $this->draft->getDecorator('Description')->setOption('placement', 'append');
    $this->addElement('Text', 'formHeading17', array(
        'decorators' => array(array('ViewScript',
                array(
                    'viewScript' => '_headingElementsForm.tpl',
                    'heading' => $view->translate(''),
                    'class' => 'form element',
                    'closediv' => 1,
                    'openDiv' => 0,
                    'id' => $divContentId++,
                )
            )
        ),
    ));
    $this->addElement('Hidden','hiddenDic',array('value'=>$divContentId - 1,'order'=>$hiddenElement++));
    $this->addElement('Button', 'submit_check',array(
      'type' => 'submit',
    ));
    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => $view->translate('Create Course'),
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    if($this->getSmoothboxType()) {
        $this->addElement('Dummy', 'brtag', array(
            'content' => '<span style="margin-top:5px;"></span>',
        ));
        $this->addElement('Cancel', 'cancel', array(
            'label' => $view->translate('cancel'),
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
