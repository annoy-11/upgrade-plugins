<?php
class Ecoupon_Form_Create extends Engine_Form {
  protected $_couponId;
  public function setCouponId($couponId) {
    $this->_couponId = $couponId;
    return $this;
  }
  public function getCouponId() {
      return $this->_couponId;
  }
  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $couponId = $this->getCouponId();
    $subject = null;
    if ($couponId) {
        $subject = Engine_Api::_()->getItem('ecoupon_coupon', $couponId);
    }
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $translate = Zend_Registry::get('Zend_Translate');
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;
    $this->setTitle('Create New Coupon')
            ->setAttrib('id', 'ecoupon_create_form')
            ->setDescription('Configure your new Coupon below, then click "Create Coupon" to create the Coupon.');
    $divContentId = 1;
    $this->addElement('Text', 'formHeading1', array(
      'decorators' => array(array('ViewScript',
            array(
                    'viewScript' => '_headingElementsForm.tpl',
                    'heading' => $view->translate('General Settings'),
                    'class' => 'form element',
                    'closediv' => 0,
                    'openDiv' => 1,
                    'firstDiv' =>1,
                    'id' => $divContentId++,
                )
            )
        ),
    ));
    $this->addElement('Text', 'title', array(
      'label' => $translate->translate('Title'),
      'allowEmpty' => false,
			'description' => $translate->translate('Please enter Coupon title in the box.'),
			'placeholder'=> $translate->translate('Enter Coupon Title'),
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '224'))
      ),
    ));
    if($settings->getSetting('ecoupon.coupon.code', '1')) {
      $coupon_code = (isset($subject) && !empty($subject))  ? $subject->coupon_code : (isset($_POST["coupon_code"]) ? $_POST["coupon_code"] : "");
      $this->addElement('Dummy', 'coupon_code', array(
        'label' => 'Coupon Code',
        'placeholder'=> 'Please enter code.',
        'content' => '<input type="text" name="coupon_code" id="coupon_code" value="'.$coupon_code.'"><i class="fa fa-check" id="coupon_code_correct" style="display:none;"></i><i class="fa fa-close" id="coupon_code_wrong" style="display:none;"></i> <button id="coupon_code_availability" type="button" name="check_availability" ><span class="coupon_check_availability_btn"><img src="application/modules/Core/externals/images/loading.gif" id="coupon_code_loading" alt="Loading" style="display:none;" /> Check Availability</button></span><p id="suggestion_tooltip" class="check_tooltip" style="display:none;">'.$translate->translate("You can use letters, numbers and periods.").'</p>',
      ));
      $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'coupon', 'auth_html');
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
      $descriptionMan= $settings->getSetting('ecoupon.description.mandatory', '1');
      if ($descriptionMan == 1) {
          $required = true;
          $allowEmpty = false;
      } else {
          $required = false;
          $allowEmpty = true;
      }
      if((isset($modulesEnable) && array_key_exists('enable_tinymce',$modulesEnable) && $modulesEnable['enable_tinymce']) || empty($modulesEnable) && $settings->getSetting('ecoupon.wysiwyg.editor',1)) {
                      $textarea = 'TinyMce';
      } else{
          $textarea = 'Textarea';
      }
      $this->addElement($textarea, 'description', array(
              'label' => 'Course Description',
              'required' => $required,
              'allowEmpty' => $allowEmpty,
              'class'=>'tinymce',
              'editorOptions' => $editorOptions,
      ));
      if($settings->getSetting('ecoupon.main.photo', '1')) {
        $mainPhotomandatory = $settings->getSetting('ecoupon.mainPhoto.mandatory', '1');
        if ($mainPhotomandatory == 1) {
            $required = true;
            $allowEmpty = false;
        } else {
            $required = false;
            $allowEmpty = true;
        }
        $requiredClass = $required ? ' requiredClass' : '';
        $translate = Zend_Registry::get('Zend_Translate');
        //Coupon Photo
        $this->addElement('File', 'photo', array(
            'label' => $translate->translate('Coupon Photo'),
            'onclick' => 'javascript:sesJqueryObject("#photo").val("")',
            'onchange' => 'handleFileBackgroundUpload(this,coupon_main_photo_preview)',
            'description'=>'Add Photo for your Course',
        ));
        $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $this->addElement('Dummy', 'photo-uploader', array(
            'label' => $translate->translate('Coupon Photo'),
            'content' => '<div id="dragandrophandlerbackground" class="coupon_upload_dragdrop_content sesbasic_bxs' . $requiredClass . '"><div class="coupon_upload_dragdrop_content_inner"><i class="fa fa-camera"></i><span class="coupon_upload_dragdrop_content_txt">' . $translate->translate('Add photo for your coupon') . '</span></div></div>'
        ));
        $this->addElement('Image', 'coupon_main_photo_preview', array(
            'width' => 300,
            'height' => 200,
            'src'=> (isset($subject) && !empty($subject))  ? $subject->getPhotoUrl() : '',
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
    }
    $this->addElement('Text', 'formHeading2', array(
      'decorators' => array(array('ViewScript',
            array(
                    'viewScript' => '_headingElementsForm.tpl',
                    'heading' => $view->translate('Discount'),
                    'class' => 'form element',
                    'closediv' => 1,
                    'openDiv' => 1,
                    'id' => $divContentId++,
                )
            )
        ),
    ));
    if($settings->getSetting('ecoupon.enable.discount', '1')) {
      $this->addElement('Select', 'discount_type', array(
              'label' => $translate->translate('Discount Type'),
              'multiOptions'=>array('1'=>'Fixed','0'=>'Percentage'),
              'value'=> 0,
              'onchange'=>'changeDiscountType(this.value)',
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
    }
    $defaultCurrency = Engine_Api::_()->ecoupon()->getCurrentCurrency();
    
    $this->addElement('Text', 'formHeading3', array(
      'decorators' => array(array('ViewScript',
            array(
                    'viewScript' => '_headingElementsForm.tpl',
                    'heading' => $view->translate('Coupon Availability'),
                    'class' => 'form element',
                    'closediv' => 1,
                    'openDiv' => 1,
                    'id' => $divContentId++,
                )
            )
        ),
    ));
    if($settings->getSetting('ecoupon.start.date', '1')) {
      $oldTz = date_default_timezone_get(); 
      date_default_timezone_set(Engine_Api::_()->user()->getViewer()->timezone);
      $current_date =  date('Y-m-d H:i:s');
      $end_date =  date('Y-m-d', strtotime("+30 days"));
      if(empty($subject)){
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
              if($subject->discount_start_time){
                  $startDate = $subject->discount_start_time;
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
                      'viewScript' => 'application/modules/Ecoupon/views/scripts/_customDiscountStartdates.tpl',
                      'class' => 'form element',
                      'start_date'=>$start_date,
                      'start_time'=>$start_time,
                      'required'=>false,
                      'start_time_check'=>1,
                      'subject'=>isset($subject) ? $subject : '',
                  )
              )
          )
      ));
    }
    if($settings->getSetting('ecoupon.end.date', '1')) {
      $this->addElement('Radio', 'discount_end_type', array(
          'id' => 'discount_end_type',
          'label' => $translate->translate('Coupon End Date'),
          'description' => $translate->translate('When will this coupon end?'),
          'multiOptions' => array(
              "1" => $translate->translate("End discount on a specific date. (Please select date from below.)"),
              "0" => $translate->translate("No End date."),
          ),
          'value' => 0
      ));
      $this->addElement('dummy', 'coupon_custom_enddatetimes', array(
          'decorators' => array(array('ViewScript', array(
                  'viewScript' => 'application/modules/Ecoupon/views/scripts/_customDiscountEnddates.tpl',
                  'class' => 'form element',
                  'end_date'=> date('m/d/Y'),
                  'end_time'=> date('g:ia'),
                  'start_time_check'=>1,
          ))),
          'value'=> date('m/d/Y'),
      ));
    }
    $this->addElement('Text', 'formHeading4', array(
      'decorators' => array(array('ViewScript',
            array(
                    'viewScript' => '_headingElementsForm.tpl',
                    'heading' => $view->translate('Coupon Usage'),
                    'class' => 'form element',
                    'closediv' => 1,
                    'openDiv' => 1,
                    'id' => $divContentId++,
                )
            )
        ),
    ));
    
    $this->addElement('Text', 'minimum_purchase_amount', array(
        'label' => sprintf($translate->translate('Minimum Order Amount (%s)'), $defaultCurrency),
        'description' => 'Please enter the minimum order amount to to apply coupon.[Note: Enter 0 for no minimum order amount.]',
        'class'=>'sesdecimal',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
        ),
    ));
    $this->minimum_purchase_amount->getDecorator('Description')->setOptions(array('placement' => 'PREPEND'));
    
    $this->addElement('text', 'count_per_coupon', array(
        'label' => 'Coupon redeem limit for per code',
        'description' => 'How many times this coupon can be used by all customers before being invalid?[Note: Enter 0 for unlimited coupon code used.]',
        'value'=>0,
    ));
    $this->addElement('text', 'count_per_buyer', array(
        'label' => 'Coupon redeem limit for per user',
        'description' => 'How many times a coupon can be used by each customer before being invalid for that customer?[Note: Enter 0 for unlimited coupon code used.]',
        'value'=>0,
    ));
    $availableLabels = array(
      'everyone'            => $view->translate('Everyone'),
      'registered'          => $view->translate('All Registered Members'),
      'owner_network'       => $view->translate('Friends and Networks'),
      'owner_member_member' => $view->translate('Friends of Friends'),
      'owner_member'        => $view->translate('Friends Only'),
      'owner'               => $view->translate('Just Me')
    );
    // Element: auth_view
    $this->addElement('Text', 'formHeading5', array(
      'decorators' => array(array('ViewScript',
            array(
                    'viewScript' => '_headingElementsForm.tpl',
                    'heading' => $view->translate('Privacy'),
                    'class' => 'form element',
                    'closediv' => 1,
                    'openDiv' => 1,
                    'id' => $divContentId++,
                )
            )
        ),
    ));
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('courses', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions),'order'=>$hiddenElement++));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => $view->translate('Privacy'),
            'description' => $view->translate('Who may see this Coupon?'),
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
            'description' => $view->translate('Who may post comments on this Coupon?'),
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
            'class'=>$hideClass,
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    $this->addElement('Text', 'formHeading5', array(
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
    if($settings->getSetting('ecoupon.search', 1)) {
        $this->addElement('Checkbox', 'search', array(
        'label' => $view->translate('People can search for this Coupon.'),
        'value' => 1,
        ));
    }
    if($settings->getSetting('ecoupon.enable.coupon', 1)) {
      $this->addElement('Checkbox', 'enable', array(
          'label' => $translate->translate("Enable this coupon"),
          'value' => 1
      ));
    }
    $this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array("1"=> $view->translate('Published'), "0"=> $view->translate('Saved As Draft')),
      'description' => $view->translate('If this Coupon is published, it cannot be switched back to draft mode.'),
      'class'=>$hideClass,
    ));
    $this->addElement('Text', 'formHeading6', array(
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
    $this->addElement('Button', 'submit', array(
        'label' => $view->translate('Create Coupon'),
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
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
    $this->addElement('Cancel', 'cancel', array(
        'label' => $translate->translate('cancel'),
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
      'decorators' => array(
              'FormElements',
              'DivDivDivWrapper',
      ),
    ));
  }
}
?>
