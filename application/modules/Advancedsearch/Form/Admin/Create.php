<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Advancedsearch_Form_Admin_Create extends Engine_Form
{
  public function init()
  {
    
    $this
      ->setTitle('Add New Content Type')
      ->setDescription('')
      ->setAttribs(array(
        'id' => '',
        'class' => '',
      ))
      ->setMethod('POST');

      $integrateothermoduleId = Zend_Controller_Front::getInstance()->getRequest()->getParam('integrateothermodule_id', 0);
      $modulename = Zend_Controller_Front::getInstance()->getRequest()->getParam('module_name', 0);
      if (!$integrateothermoduleId) {
          $integrateothermoduleItem = array();
          $integrateothermoduleArray = array();
          $integrateothermoduleArray[] = '';
          //get all enabled modules
          $notincludepluginarray = array('chat',  'sesadvancedactivity', 'sesadvancedcomment', 'sesfeedbg', 'sesfeelingactivity', 'sesfeedgif', 'sesbasic', 'sesadvsitenotification', 'sesariana', 'sesbrowserpush', 'seschristmas', 'sescleanwide', 'sescontentcoverphoto', 'sescontestjoinfees', 'sescontestjurymember', 'sescontestpackage', 'sesdemouser', 'seselegant', 'sesemailverification', 'sesemoji', 'seserror', 'seseventticket', 'sesexpose', 'sesfaq', 'sesfbstyle', 'sesfooter', 'seshtmlbackground', 'seslangtranslator', 'sesletteravatar', 'sesmediaimporter', 'sesmember', 'sesmembershorturl', 'sesmetatag', 'sesmultipleform', 'sespagebuilder', 'sespoke', 'sesprofilelock', 'sespymk', 'sessiteiframe', 'sessociallogin', 'sessocialshare', 'sessoundcloudsearch', 'sesspectromedia', 'sesteam', 'sestour', 'sestweet', 'sesusercoverphoto', 'sesvideoimporter','sesapi','sesandroidapp','sesiosapp');
          $coreTable = Engine_Api::_()->getDbTable('modules', 'core');
          $select = $coreTable->select()
              ->from($coreTable->info('name'), array('name', 'title'))
              ->where('enabled =?', 1)
              ->where('name NOT IN (?)', $notincludepluginarray)
              ->where('type =?', 'extra');
          $resultsArray = $select->query()->fetchAll();
          if (!empty($resultsArray)) {
              foreach ($resultsArray as $result) {
                  $integrateothermoduleArray[$result['name']] = $result['title'];
                  if($result["name"] == $modulename){
                      $moduletitle = $result["title"];
                  }
              }
          }
          if (!empty($integrateothermoduleArray)) {
              $this->addElement('Select', 'module_name', array(
                  'label' => 'Choose Plugin',
                  'description' => 'Below, you can choose the plugin to be integrated.',
                  'allowEmpty' => false,
                  'onchange' => 'changemodule(this.value)',
                  'multiOptions' => $integrateothermoduleArray,
              ));
              $this->addElement('Hidden','module_title',array('order'=>89898,'value'=>$moduletitle));
          } else {
              $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_("Here are no module to configure with our plugin.") . "</span></div>";
              $this->addElement('Dummy', 'module', array(
                  'description' => $description,
              ));
              $this->module->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
          }
          $module = Zend_Controller_Front::getInstance()->getRequest()->getParam('module_name', null);
          if (!empty($module)) {
              $this->module_name->setValue($module);
              //get manifest item for given module
              $integrateothermodule = Engine_Api::_()->advancedsearch()->getPluginItem($module);
              if (empty($integrateothermodule))
                  $this->addElement('Dummy', 'dummy_title', array(
                      'description' => 'No item type define for this plugin.',
                  ));
          }
      }

      $param = false;
      if ($integrateothermoduleId)
          $param = true;
      elseif (!empty($integrateothermodule))
          $param = true;
      if ($param) {
          if (!$integrateothermoduleId) {
              $this->addElement('Text', 'title', array(
                  'label' => 'Title',
                  'description' => 'Below, you can write the item title.',
                  'allowEmpty' => false,
                  'required' => true,
              ));
              $this->addElement('Select', 'content_type', array(
                  'label' => 'Item Type of Plugin',
                  'description' => 'Select the item type for search of the above chosen plugin which is defined in its manifest.php file. [This item type is the parent to which search are associated]',
                  'multiOptions' => $integrateothermodule,
              ));
              $this->addElement('File', 'photo', array(
                  'label' => 'Upload Icon',
              ));
              $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
          }
          $this->addElement('Checkbox', 'show_on_search', array(
              'description' => 'Show in Search Box?',
              'label' => 'Yes, show in Search Box.',
              'value' => 1,
          ));
          $this->addElement('Checkbox', 'create_tab', array(
              'description' => 'Show Tab on Search Page?',
              'label' => 'Yes, show Tab on Search Page.',
              'value' => 1,
          ));
          $this->addElement('Button', 'execute', array(
              'label' => 'Create',
              'type' => 'submit',
              'ignore' => true,
              'decorators' => array('ViewHelper'),
          ));
          $this->addElement('Cancel', 'cancel', array(
              'label' => 'Cancel',
              'prependText' => ' or ',
              'ignore' => true,
              'link' => true,
              'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage','module'=>'advancedsearch','controller'=>'settings'),'admin_default',true),
              'decorators' => array('ViewHelper'),
          ));
      }



  }
}