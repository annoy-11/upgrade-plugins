<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Import.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Form_Import extends Engine_Form {

  public function init() {

    $this->setTitle('Import Listings')->setDescription('')->setAttrib('name', 'listing_import')->setAttrib('enctype', 'multipart/form-data');

    $this->addElement('Select', 'import_type', array(
      'label' => 'Type of Import',
      'multiOptions' => array("0"=>"","1"=>"Listingger", "2"=>"WordPress","3"=>"Tumblr"),
      'description' => 'Choose a site to import.',
      'onchange' => "showImportOption(this.value);"
    ));

    $this->addElement('File', 'file_data', array(
      'label' => 'Listing XML File',
      'description' => 'Choose a corresponding site file XML to import.'
    ));
    $this->file_data->addValidator('Extension', false, 'xml');


    $this->addElement('Text', 'user_name', array(
      'label' => 'Tumblr User Name',
      'description' => 'Please put here your tumblr account user name to import listings.',
      'filters' => array(
        new Engine_Filter_Censor(),
      )
    ));
    $this->user_name->getDecorator("Description")->setOption("placement", "append");


    $this->addElement('Button', 'submit', array(
      'label' => 'Start Importing',
      'type' => 'submit',
    ));

  }
}
