<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Backgroundphoto.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Form_Dashboard_Backgroundphoto extends Engine_Form {

  public function init() {
    $translate = Zend_Registry::get('Zend_Translate');
    $sesbusiness = Engine_Api::_()->core()->getSubject();
    $this->addElement('File', 'background', array(
        'onchange' => 'handleFileBackgroundUpload(this,business_main_photo_preview)',
    ));
    $this->background->addValidator('Extension', false, 'jpg,jpeg,png,gif');
    $this->addElement('Dummy', 'drag-drop-background', array(
        'content' => '<div id="dragandrophandlerbackground" class="sesbusiness_upload_dragdrop_content sesbasic_bxs"><div class="sesbusiness_upload_dragdrop_content_inner"><i class="fa fa-camera"></i><span class="sesbusiness_upload_dragdrop_content_txt">' . $translate->translate('Add background photo for your business') . '</span></div></div>'
    ));
    if ($sesbusiness->background_photo_id !== null && $sesbusiness->background_photo_id) {
      $backgroundImage = Engine_Api::_()->storage()->get($sesbusiness->background_photo_id, '')->getPhotoUrl();
      $this->addElement('Image', 'business_main_photo_preview', array(
          'width' => 300,
          'height' => 200,
          'value' => '1',
          'src' => $backgroundImage,
          'disable' => true,
      ));
    } else {
      $this->addElement('Image', 'business_main_photo_preview', array(
          'width' => 300,
          'height' => 200,
          'value' => '1',
          'disable' => true,
      ));
    }
    $this->addElement('Dummy', 'removeimage', array(
        'content' => '<a class="icon_cancel form-link" id="removeimage1" style="display:none; "href="javascript:void(0);" onclick="removeImage();"><i class="fa fa-trash-o"></i>' . $translate->translate('Remove') . '</a>',
    ));
    $this->addElement('Hidden', 'removeimage2', array(
        'value' => 1,
        'order' => 10000000012,
    ));
    $this->addElement('Button', 'execute', array(
        'label' => 'Save',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $url = $view->url(array('action' => 'remove-backgroundphoto', 'business_id' => $sesbusiness->custom_url), "sesbusiness_dashboard", true);
    if ($sesbusiness->background_photo_id != 0) {
      $this->addElement('Button', 'cancel', array(
          'label' => 'Remove Photo',
          'prependText' => ' or ',
          'class' => 'secondary_button',
          'link' => true,
          'href' => $url,
          'onclick' => "removePhotoBusiness('$url');",
          'decorators' => array(
              'ViewHelper',
          ),
      ));
      $this->addDisplayGroup(array(
          'execute',
          'cancel',
              ), 'buttons', array(
          'decorators' => array(
              'FormElements',
              'DivDivDivWrapper'
          ),
      ));
    }
  }

}
