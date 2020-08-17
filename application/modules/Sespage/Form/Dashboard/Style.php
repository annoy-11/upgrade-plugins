<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Style.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Dashboard_Style extends Engine_Form {

  public function init() {
    $this
            ->setTitle('Styles')
            ->setMethod('post')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->removeDecorator('FormWrapper');

    // Element: style
    $this->addElement('Textarea', 'style', array(
        'label' => 'Custom Sespage Styles',
        'description' => 'You can change the colors, fonts, and styles of your page by adding CSS code below. The contents of the text area below will be output between <style> tags on your event.'
    ));
//    $this->style->getDecorator('Description')->setOption('placement', 'APPEND');
    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
    ));

    // DisplayGroup: buttons
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
    ));

    $this->addElement('Hidden', 'id');
  }

}
