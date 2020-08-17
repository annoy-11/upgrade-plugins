<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditSettings.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Form_Admin_Manage_EditSettings extends Engine_Form {

  public function init() {

    $content_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('content_id', 0);
    $content = Engine_Api::_()->getItem('sesseo_content', $content_id);

    $moreinfo = $this->getTranslator()->translate($content->title);

    $title = vsprintf('Edit Setting For '.$moreinfo, array($content->title));

    $description = vsprintf('Here, you can edit the setting for the '.$moreinfo.'.', array($content->title));

    $this->setTitle($title);


    $this->setDescription($description);

    $this->addElement('Select', 'frequency', array(
      'label' => 'Frequency',
      'description' => 'Choose the frequency of this content.',
      'allowEmpty' => false,
      'multiOptions' => array(
        'always' => 'Always' ,
        'hourly' => 'Hourly' ,
        'daily' => 'Daily' ,
        'weekly' => 'Weekly' ,
        'monthly' => 'Monthly' ,
        'yearly' => 'Yearly' ,
        'never' => 'Never' ,
      ),
    ));


    $this->addElement('Select', 'priority', array(
      'label' => 'Priority',
      'description' => 'Choose the priority of this content.',
      'allowEmpty' => false,
      'multiOptions' => array(
        '0.1' => '0.1',
        '0.2' => '0.2',
        '0.3' => '0.3',
        '0.4' => '0.4',
        '0.5' => '0.5',
        '0.6' => '0.6',
        '0.7' => '0.7',
        '0.8' => '0.8',
        '0.9' => '0.9',
        '1.0' => '1.0'
      ),
    ));

    $this->addElement('Text', "limit", array(
        'label' => 'Enter Limit',
        'description' => "Enter limit for this content that you want to add in site map. [0 for no limit]",
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Checkbox', 'enabled', array(
        'label' => 'Do you want to enable this content sitemap?',
        'description' => 'Enable',
        'value' => 1,
    ));

    $this->addElement('Button', 'execute', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => "javascript:parent.Smoothbox.close();",
        'href' => "javascript:void(0);",
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }
}
