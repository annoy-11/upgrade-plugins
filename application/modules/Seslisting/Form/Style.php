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

class Seslisting_Form_Style extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Seslisting Styles')
      ->setMethod('post')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ->setAttrib('class', 'global_form_popup')
      ;

    $this->removeDecorator('FormWrapper');

    // Element: style
    $this->addElement('Textarea', 'style', array(
      'label' => 'Custom Seslisting Styles',
      'description' => 'You can change the colors, fonts, and styles of your listing by adding CSS code below. The contents of the text area below will be output between <style> tags on your event.'
    ));
//    $this->style->getDecorator('Description')->setOption('placement', 'APPEND');

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
    ));

    // Element: cancel
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'href' => 'javascript:void(0);',
      'prependText' => ' or ',
      'onclick' => 'parent.Smoothbox.close();',
    ));

    // DisplayGroup: buttons
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(

    ));

    $this->addElement('Hidden', 'id');
  }
}
