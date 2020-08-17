<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Submit.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesseo_Form_Admin_Manage_Submit extends Engine_Form {

  public function init() {

    $this->setTitle("Submit Sitemap");
    $this->setDescription("Here, you can submit sitemap on google.");

    $this->addElement('MultiCheckbox', 'search_engine', array(
      'label' => 'Search Engine',
      'description' => 'Choose search engine where you want to submit sitemap.',
      'multiOptions' => array(
        'google' => 'Google',
        'bing' => 'Bing',
      ),
      'value' => array('google', 'bing'),
    ));

    $this->addElement('Checkbox', 'regenerate_sitemap', array(
        'description' => 'Regenerate Sitemap',
        'label' => 'Do you want to regenerate sitemap before submitting to search engine?',
        'value' => 0,
    ));

    $this->addElement('Button', 'execute', array(
        'label' => 'Submit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
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
