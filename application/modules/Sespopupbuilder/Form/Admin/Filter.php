<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespopupbuilder_Form_Admin_Filter extends Engine_Form {

  public function init() {

    $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');

    $this->addElement('Text', 'title', array(
        'label' => 'Popup Title',
        'placeholder' => 'Enter Popup Title',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Select', 'popup_type', array(
        'label' => 'Popup Type',
        'placeholder' => 'Select Popup Type',
				'multiOptions'=>array(
				''=>'Select Type',
				'image'=>'Image',
				'html'=>'HTML',
				'video'=>'Video',
				'facebook_like'=>'Facebook Likebox',
				'iframe'=>'Iframe',
				'notification_bar'=>'Notification',
				'pdf'=>'PDF',
				'age_verification'=>'Age Verification',
				'cookie_consent'=>'Cookies Consent',
				'christmas'=>'Christmas',
				'count_down'=>'Countdown',
				),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    
    $this->addElement('Select', 'is_deleted', array(
        'label' => "Status",
        'required' => true,
        'multiOptions' => array("" => 'Select', "1" => "Disabled", "0" => "Enabled"),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
    ));
    
  }

}
