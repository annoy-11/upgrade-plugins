<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Style.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Dashboard_Style extends Engine_Form {

  public function init() {
    $this
            ->setTitle('Styles')
            ->setMethod('post')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->removeDecorator('FormWrapper');

    // Element: style
    $this->addElement('Textarea', 'style', array(
        'label' => 'Custom Sesbusiness Styles',
        'description' => 'You can change the colors, fonts, and styles of your business by adding CSS code below. The contents of the text area below will be output between <style> tags on your event.'
    ));
//    $this->style->getDecorator('Description')->setOption('placement', 'APPEND');
    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
    ));

    // DisplayBusiness: buttons
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
    ));

    $this->addElement('Hidden', 'id');
  }

}
