<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sessocialshare_Form_Admin_Manageplugins_Add extends Engine_Form {

  public function init() {
  
    $this->setTitle('Add New Plugin')
            ->setDescription('Add new plugin on whose activity feeds content from your website will be shared.');
            
    $integrateothermoduleId = Zend_Controller_Front::getInstance()->getRequest()->getParam('integrateothermodule_id', 0);
    
    if (!$integrateothermoduleId) {
      $integrateothermoduleItem = array();
      $integrateothermoduleArray = array();
      $integrateothermoduleArray[] = '';
			//get all enabled modules
      $coreTable = Engine_Api::_()->getDbTable('modules', 'core');
      $select = $coreTable->select()
              ->from($coreTable->info('name'), array('name', 'title'))
              ->where('enabled =?', 1)
              ->where('type =?', 'extra');
      $resultsArray = $select->query()->fetchAll();
      if (!empty($resultsArray)) {
        foreach ($resultsArray as $result) {
          $integrateothermoduleArray[$result['name']] = $result['title'];
        }
      }
      if (!empty($integrateothermoduleArray)) {
        $this->addElement('Select', 'module_name', array(
            'label' => 'Choose Plugin',
            'description' => 'Choose the plugin on which feeds can be shared.',
            'allowEmpty' => false,
            'onchange' => 'changemodule(this.value)',
            'multiOptions' => $integrateothermoduleArray,
        ));
      } else {
        $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_("Here are no module to configure with our plugin lightbox.") . "</span></div>";
        $this->addElement('Dummy', 'module', array(
            'description' => $description,
        ));
        $this->module->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
      }
      $module = Zend_Controller_Front::getInstance()->getRequest()->getParam('module_name', null);
      if (!empty($module)) {
        $this->module_name->setValue($module);
				//get manifest item for given module
        $integrateothermodule = Engine_Api::_()->sessocialshare()->getPluginItem($module);
        if (empty($integrateothermodule))
          $this->addElement('Dummy', 'dummy_title', array(
              'description' => 'No item type define for this plugin.',
          ));
      }
    }
		$param = false;
    if ($integrateothermoduleId)
      $param = true;
    elseif ($integrateothermodule)
      $param = true;
    if ($param) {
      if (!$integrateothermoduleId) {
      
        $this->addElement('Select', 'content_type', array(
            'label' => 'Item Type of Plugin',
            'description' => 'Select the item type for sharing site content on the above chosen plugin which is defined in its manifest.php file.',
            'multiOptions' => $integrateothermodule,
        ));
        $this->addElement('Text', "title", array(
            'label' => 'DropDown Option Text',
            'description' => "Enter the text for the dropdown option for this plugin which will show to users when they share site content.",
            'allowEmpty' => false,
            'required' => true,
        ));
      }
      $this->addElement('Checkbox', 'enabled', array(
          'description' => 'Enable This Plugin?',
          'label' => 'Yes, enable this plugin now.',
          'value' => 1,
      ));
      $this->addElement('Button', 'execute', array(
          'label' => 'Add Plugin',
          'type' => 'submit',
          'ignore' => true,
          'decorators' => array('ViewHelper'),
      ));
      $this->addElement('Cancel', 'cancel', array(
          'label' => 'Cancel',
          'prependText' => ' or ',
          'ignore' => true,
          'link' => true,
          'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
          'decorators' => array('ViewHelper'),
      ));
    }
  }
}