<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditPhoto.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Dashboard_EditPhoto extends Engine_Form {

  protected $_isArray = true;

  public function init() {
  
    $this->clearDecorators()->addDecorator('FormElements');

//     $this->addElement('Text', 'title', array(
//       'label' => 'Title',
// 			'placeholder' => 'Title',
//       'filters' => array(
//         new Engine_Filter_Censor(),
//         new Engine_Filter_HtmlSpecialChars(),
//       ),
//       'decorators' => array(
//         'ViewHelper',
//         array('HtmlTag', array('tag' => 'div', 'class'=>'crowdfunding_editphotos_title_input')),
//         array('Label', array('tag' => 'div', 'placement' => 'PREPEND', 'class' => 'crowdfunding_editphotos_title')),
//       ),
//     ));

    $this->addElement('Textarea', 'description', array(
      'label' => 'Caption',
      'placeholder' => 'Caption',
      'rows' => 2,
      'cols' => 120,
      'filters' => array(
        new Engine_Filter_Censor(),
      ),
      'decorators' => array(
        'ViewHelper',
        array('HtmlTag', array('tag' => 'div', 'class'=>'album_editphotos_caption_input')),
        array('Label', array('tag' => 'div', 'placement' => 'PREPEND', 'class'=>'crowdfunding_editphotos_caption_label')),
      ),
    ));

    $this->addElement('Checkbox', 'delete', array(
      'label' => "Delete Photo",
      'decorators' => array(
        'ViewHelper',
        array('Label', array('placement' => 'APPEND')),
        array('HtmlTag', array('tag' => 'div', 'class' => 'photo-delete-wrapper')),
      ),
    ));


    $this->addElement('Hidden', 'photo_id', array(
      'validators' => array(
        'Int',
      )
    ));
  }
}