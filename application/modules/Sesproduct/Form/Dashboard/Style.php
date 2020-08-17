<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Style.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Dashboard_Style extends Engine_Form {

  public function init() {
    $this
    ->setTitle('Product Styles')
    ->setAttrib('id', 'sesproduct_ajax_form_submit')
    ->setMethod("POST")
    ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->removeDecorator('FormWrapper');

    // Element: style
    $this->addElement('Textarea', 'style', array(
      'label' => 'Custom Sesproduct Styles',
      'description' => 'You can change the colors, fonts, and styles of your product by adding CSS code below. The contents of the text area below will be output between <style> tags on your event.'
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
