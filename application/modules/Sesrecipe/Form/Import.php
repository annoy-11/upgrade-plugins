<?php

class Sesrecipe_Form_Import extends Engine_Form {
 
  public function init() {
  
    $this->setTitle('Import Recipes')->setDescription('')->setAttrib('name', 'recipe_import')->setAttrib('enctype', 'multipart/form-data');
    
    $this->addElement('Select', 'import_type', array(
      'label' => 'Type of Import',
      'multiOptions' => array("0"=>"","1"=>"Recipeger", "2"=>"WordPress","3"=>"Tumblr"),
      'description' => 'Choose a site to import.',
      'onchange' => "showImportOption(this.value);"
    ));

    $this->addElement('File', 'file_data', array(
      'label' => 'Recipe XML File',
      'description' => 'Choose a corresponding site file XML to import.' 
    ));
    $this->file_data->addValidator('Extension', false, 'xml');
    
    
    $this->addElement('Text', 'user_name', array(
      'label' => 'Tumblr User Name',
      'description' => 'Please put here your tumblr account user name to import recipes.',
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