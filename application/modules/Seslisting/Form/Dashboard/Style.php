<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Style.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Form_Dashboard_Style extends Engine_Form {

  public function init() {
    $this
    ->setTitle('Listing Styles')
    ->setAttrib('id', 'seslisting_ajax_form_submit')
    ->setMethod("POST")
    ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->removeDecorator('FormWrapper');

    // Element: style
    $this->addElement('Textarea', 'style', array(
      'label' => 'Custom Seslisting Styles',
      'description' => 'You can change the colors, fonts, and styles of your listing by adding CSS code below. The contents of the text area below will be output between <style> tags on your event.'
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
    ));

    // DisplayGroup: buttons
    //$this->addDisplayGroup(array('submit'), 'buttons', array());
    $this->addElement('Hidden', 'id');
  }
}
