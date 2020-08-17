<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Create.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Form_Admin_Coupon_Create extends Engine_Form {
  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $params = $request->getParams();
    $hiddenElement = 8899;
    $couponId = $params['coupon_id'];
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
      $this->addElement('TinyMce', 'description', array(
              'label' => 'Course Description',
              'required' => false,
              'allowEmpty' => true,
              'class'=>'tinymce',
              'editorOptions' => $editorOptions,
      ));
      $translate = Zend_Registry::get('Zend_Translate');
      //Main Photo
      $this->addElement('File', 'photo', array(
          'label' => $translate->translate('Main Photo'),
          'onclick' => 'javascript:sesJqueryObject("#photo").val("")',
          'onchange' => 'handleFileBackgroundUpload(this,coupon_main_photo_preview)',
          'description'=>'Add Photo for your Course',
      ));
      $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
      $this->addElement('Dummy', 'photo-uploader', array(
          'label' => $translate->translate('Main Photo'),
          'content' => '<div id="dragandrophandlerbackground" class="coupon_upload_dragdrop_content sesbasic_bxs' . $requiredClass . '"><div class="coupon_upload_dragdrop_content_inner"><i class="fa fa-camera"></i><span class="coupon_upload_dragdrop_content_txt">' . $translate->translate('Add photo for your course') . '</span></div></div>'
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
    $start = new Engine_Form_Element_CalendarDateTime('discount_start_time');
    $start->setLabel("Start Date");
    $start->setAllowEmpty(false);
    $start->setRequired(true);
    $this->addElement($start);

    $end = new Engine_Form_Element_CalendarDateTime('discount_end_time');
    $end->setLabel("End Date");
    $end->setRequired(true);
    $end->setAllowEmpty(false);
    $this->addElement($end);
    $this->addElement('Text', 'minimum_purchase_amount', array(
        'label' => sprintf($translate->translate('Minimum Order Amount')),
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
    $multiOptions = array();
    $integratedModules = Engine_Api::_()->getDbtable('types', 'ecoupon')->getIntegratedModules(1);
    $integratedModuleArray = array();
    $multiOptions['all'] = 'Select All Integrated';
    if(!empty($integratedModules)){
      foreach($integratedModules as $integratedModule){
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled($integratedModule->module_name))
          $multiOptions[$integratedModule->item_type] = $integratedModule->title;
      }
    }
    $this->addElement('Select', 'item_type', array(
      'label' => $translate->translate('Add Items to apply this coupon'),
      'description'=>'Select Items to apply this coupon',
      'multiOptions'=>$multiOptions,
      'onchange'=>'changePackageInfo(this.value)',
    ));
    $this->addElement('Text', 'package', array(
        'label' => $translate->translate('Package Name'),
        'autocomplete' => 'off',
        'placeholder'=> $translate->translate('Enter Package name.'),
        'description' => $translate->translate('Select the Courses that you want to display on Package View Page.'),
        'filters' => array(
            new Engine_Filter_Censor(),
        )
    ));
    $this->addElement('Hidden','item_ids',array('order'=>$hiddenElement++));
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
            'description' => $view->translate('Who may post comments on this Coupon?'),
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
            'class'=>$hideClass,
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    $this->addElement('Checkbox', 'search', array(
    'label' => $view->translate('People can search for this Coupon.'),
    'value' => 1,
    ));
    $this->addElement('Checkbox', 'enable', array(
        'label' => $translate->translate("Enable this coupon"),
        'value' => 1
    ));
    $this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array("1"=> $view->translate('Published'), "0"=> $view->translate('Saved As Draft')),
      'description' => $view->translate('If this Coupon is published, it cannot be switched back to draft mode.'),
      'class'=>$hideClass,
    ));
    $this->addElement('hidden', 'is_package', array('value' => '1'));
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
