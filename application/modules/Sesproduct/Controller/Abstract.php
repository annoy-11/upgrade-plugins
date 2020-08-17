<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Abstract.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Controller_Abstract extends Core_Controller_Action_Standard
{
  protected $_fieldType;

  protected $_requireProfileType = false;

  protected $_moduleName;

  public function init()
  {
    // Parse module name from class
    if( !$this->_moduleName ) {
      $this->_moduleName = substr(get_class($this), 0, strpos(get_class($this), '_'));
    }

    // Try to set item type to module name (usually an item type)
    if( !$this->_fieldType ) {
      $this->_fieldType = Engine_Api::deflect($this->_moduleName);
    }

    if( !$this->_fieldType || !$this->_moduleName || !Engine_APi::_()->hasItemType($this->_fieldType) ) {
      throw new Fields_Model_Exception('Invalid fieldType or modulePath');
    }

    $this->view->fieldType = $this->_fieldType;

    // Hack up the view paths
    $this->view->addHelperPath(dirname(dirname(__FILE__)) . '/views/helpers', 'Fields_View_Helper');
    $this->view->addScriptPath(dirname(dirname(__FILE__)) . '/views/scripts');

    $this->view->addHelperPath(dirname(dirname(dirname(__FILE__))) . DS . $this->_moduleName . '/views/helpers', $this->_moduleName . '_View_Helper');
    $this->view->addScriptPath(dirname(dirname(dirname(__FILE__))) . DS . $this->_moduleName . '/views/scripts');
  }

  public function indexAction()
  {
    // Set data

    //get option id
      $product = Engine_Api::_()->core()->getSubject();
    $option_id = Engine_Api::_()->getDbTable('cartoptions','sesproduct')->getAttribute($product)->option_id;

    $metaData = Engine_Api::_()->getApi('core', 'fields')->getFieldsMeta($this->_fieldType);
    $optionsData = Engine_Api::_()->getApi('core', 'fields')->getFieldsOptions($this->_fieldType);

      $mapData = Engine_Api::_()->getApi('core', 'fields')->getFieldsMaps($this->_fieldType);
    //get attribute map data
      $mapTable = Engine_Api::_()->fields()->getTable('sesproduct_cartproducts', 'maps');
      $select = $mapTable->select()->where('option_id = '.$option_id.' || option_id = 0')->order('order ASC');

      $mapData = $mapTable->fetchAll($select);


    // Get top level fields
    $topLevelMaps = $mapData->getRowsMatching(array('field_id' => 0, 'option_id' => 0));
    $topLevelFields = array();
    foreach( $topLevelMaps as $map ) {
      $field = $map->getChild();
      $topLevelFields[$field->field_id] = $field;
    }
    $this->view->topLevelMaps = $topLevelMaps;
    $this->view->topLevelFields = $topLevelFields;

    // Do we require profile type?
    // No
    if( !$this->_requireProfileType ) {
      $this->topLevelOptionId = '0';
      $this->topLevelFieldId = '0';
    }
    // Yes
    else {

      // Get top level field
      // Only allow one top level field
      $topLevelField = array_shift($topLevelFields);
      $this->view->topLevelField = $topLevelField;
      $this->view->topLevelFieldId = $topLevelField->field_id;

      // Get top level options
      $topLevelOptions = array();
      foreach( $optionsData->getRowsMatching('field_id', $topLevelField->field_id) as $option ) {
        $topLevelOptions[$option->option_id] = $option->label;
      }
      $this->view->topLevelOptions = $topLevelOptions;

      // Get selected option
      if( empty($option_id) || empty($topLevelOptions[$option_id]) ) {
        $option_id = current(array_keys($topLevelOptions));
      }
      $this->view->topLevelOptionId = $option_id;

      // Get second level fields
      $secondLevelMaps = array();
      $secondLevelFields = array();
      if( !empty($option_id) ) {
        $secondLevelMaps = $mapData->getRowsMatching('option_id', $option_id);
        if( !empty($secondLevelMaps) ) {
          foreach( $secondLevelMaps as $map ) {
            $secondLevelFields[$map->child_id] = $map->getChild();
          }
        }
      }
      $this->view->secondLevelMaps = $secondLevelMaps;
      $this->view->secondLevelFields = $secondLevelFields;
    }
  }



  // Profile types

  public function typeCreateAction()
  {
    $field = Engine_Api::_()->fields()->getField($this->_getParam('field_id'), $this->_fieldType);

    // Validate input
    if( $field->type !== 'profile_type' ) {
      throw new Exception(sprintf('invalid input, type is "%s", expected "profile_type"', $field->type));
    }

    // Create form
    $this->view->form = $form = new Fields_Form_Admin_Type();

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Create New Profile Type from Duplicate of Existing
    if( $form->getValue('duplicate') != 'null' ) {
      // Create New Option in engine4_user_fields_options
      $option = Engine_Api::_()->fields()->createOption($this->_fieldType, $field, array(
        'field_id' => $field->field_id,
        'label' => $form->getValue('label'),
      ));
      // Get New Option ID
      $db = Engine_Db_Table::getDefaultAdapter();
    // Get list of Field IDs From Duplicated member Type
    $fieldMapArray =  $db->select()
            ->from('engine4_user_fields_maps')
            ->where('option_id = ?', $form->getValue('duplicate'))
            ->query()
            ->fetchAll();

    $fieldMapArrayCount = count($fieldMapArray);
    // Check if the Member type is blank
    if( $fieldMapArrayCount == 0 ) {
      $this->view->option = $option->toArray();
      $this->view->form = null;
      return;
    }

    for( $c = 0; $c < $fieldMapArrayCount; $c++ ) {
      $childIdArray[] = $fieldMapArray[$c]['child_id'];
    }
    unset($c);

    $fieldMetaArray = $db->select()
            ->from('engine4_user_fields_meta')
            ->where('field_id IN (' . implode(', ', $childIdArray) . ')')
            ->query()
            ->fetchAll();

    // Copy each row
    for( $c = 0; $c < $fieldMapArrayCount; $c++ ) {
        $fieldId = $fieldMetaArray[$c]['field_id'];
        $db->insert('engine4_user_fields_meta', array(
          'type' => $fieldMetaArray[$c]['type'],
          'label' => $fieldMetaArray[$c]['label'],
          'description' => $fieldMetaArray[$c]['description'],
          'alias' => $fieldMetaArray[$c]['alias'],
          'required' => $fieldMetaArray[$c]['required'],
          'display' => $fieldMetaArray[$c]['display'],
          'publish' => $fieldMetaArray[$c]['publish'],
          'search' => $fieldMetaArray[$c]['search'],
          'show' => $fieldMetaArray[$c]['show'],
          'order' => $fieldMetaArray[$c]['order'],
          'config' => $fieldMetaArray[$c]['config'],
          'validators' => $fieldMetaArray[$c]['validators'],
          'filters' => $fieldMetaArray[$c]['filters'],
          'style' => $fieldMetaArray[$c]['style'],
          'error' => $fieldMetaArray[$c]['error'],
            )
        );
        // Add original field_id to array => new field_id to new corresponding row
        $childIdReference[$fieldId] = $db->lastInsertId();
        // copy field_options corresponding to child id if any
        $childFieldOptions = $db->select()
            ->from('engine4_user_fields_options')
            ->where('field_id =?', $fieldId)
            ->query()
            ->fetchAll();
        if( $childFieldOptions ) {
          $childTable = Engine_Api::_()->fields()->getTable($this->_fieldType, 'meta');
          $select = $childTable->select()->where('field_id = ?', $childIdReference[$fieldId]);
          $childField = $childTable->fetchRow($select);
          foreach( $childFieldOptions as $childFieldOption ) {
            $newChildOption = Engine_Api::_()->fields()->createOption($this->_fieldType, $childField, array(
              'field_id' => $childIdReference[$fieldMetaArray[$c]['field_id']],
              'label' => $childFieldOption['label'],
              'order' => $childFieldOption['order'],
            ));
          }
        }
      }
      unset($c);

    // Create new map from array using new field_id values and new Option ID
    $mapCount = count($fieldMapArray);
    for( $i = 0; $i < $mapCount; $i++ ) {
      $db->insert('engine4_user_fields_maps',
              array(
                  'field_id' => $fieldMapArray[$i]['field_id'],
                  'option_id' => $option->option_id,
                  'child_id' => $childIdReference[$fieldMapArray[$i]['child_id']],
                  'order' => $fieldMapArray[$i]['order'],
                    )
                );
      }

    }
    else{
      // Create new blank option
      $option = Engine_Api::_()->fields()->createOption($this->_fieldType, $field, array(
        'field_id' => $field->field_id,
        'label' => $form->getValue('label'),
      ));
    }
    $this->view->option = $option->toArray();
    $this->view->form = null;

    // Get data
    $mapData = Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType);
    $metaData = Engine_Api::_()->fields()->getFieldsMeta($this->_fieldType);
    $optionData = Engine_Api::_()->fields()->getFieldsOptions($this->_fieldType);

    // Flush cache
    $mapData->getTable()->flushCache();
    $metaData->getTable()->flushCache();
    $optionData->getTable()->flushCache();
  }

  public function typeEditAction()
  {
    $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);
    $field = Engine_Api::_()->fields()->getField($option->field_id, $this->_fieldType);

    // Validate input
    if( $field->type !== 'profile_type' ) {
      throw new Exception('invalid input');
    }

    // Create form
    $this->view->form = $form = new Fields_Form_Admin_Type();
    $form->save->setLabel('Edit Profile Type');
    $form->removeElement('duplicate');

    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      $form->populate($option->toArray());
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    Engine_Api::_()->fields()->editOption($this->_fieldType, $option, array(
      'label' => $form->getValue('label'),
    ));

    $this->view->option = $option->toArray();
    $this->view->form = null;
  }

  public function typeDeleteAction()
  {
    $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);
    $field = Engine_Api::_()->fields()->getField($option->field_id, $this->_fieldType);

    $this->view->form = $form = new Fields_Form_Admin_TypeDelete();

    // Validate input
    if( $field->type !== 'profile_type' ) {
      throw new Exception('invalid input');
    }

    // Do not allow delete if only one type left
    if( count($field->getOptions()) <= 1 ) {
      throw new Exception('only one left');
    }

    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    // Process
    $maps = Engine_Api::_()->fields()->getTable($this->_fieldType, 'maps')->getMapsById($option->option_id);

    foreach ($maps as $map) {
      Engine_Api::_()->fields()->deleteField($this->_fieldType, $map->child_id);
    }
    $delete = Engine_Api::_()->fields()->deleteOption($this->_fieldType, $option);
    if( $delete ) {
      $this->view->form = null;
    }
    // Delete mapping
    Engine_Api::_()->authorization()->mappingGC();
    // @todo reassign stuff
  }



  // Headings

  public function headingCreateAction()
  {
    $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);

    // Create form
    $this->view->form = $form = new Fields_Form_Admin_Heading();

    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $field = Engine_Api::_()->fields()->createField($this->_fieldType, array_merge(array(
      'option_id' => $option->option_id,
      'type' => 'heading',
      'display' => 1
    ), $form->getValues()));

    $this->view->status = true;
    $this->view->field = $field->toArray();
    $this->view->option = $option->toArray();
    $this->view->form = null;

    // Re-render all maps that have this field as a parent or child
    $maps = array_merge(
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $field->field_id),
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $field->field_id)
    );
    $html = array();
    foreach( $maps as $map ) {
      $html[$map->getKey()] = $this->view->adminFieldMeta($map);
    }
    $this->view->htmlArr = $html;
  }

  public function headingEditAction()
  {
    $field = Engine_Api::_()->fields()->getField($this->_getParam('field_id'), $this->_fieldType);

    // Create form
    $this->view->form = $form = new Fields_Form_Admin_Heading();
    $form->setTitle('Edit Heading');

    // Get sync notice
    $linkCount = count(Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)
        ->getRowsMatching('child_id', $field->field_id));
    if( $linkCount >= 2 ) {
      $form->addNotice($this->view->translate(array(
        'This question is synced. Changes you make here will be applied in %1$s other place.',
        'This question is synced. Changes you make here will be applied in %1$s other places.',
        $linkCount - 1), $this->view->locale()->toNumber($linkCount - 1)));
    }

    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      $form->populate($field->toArray());
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    Engine_Api::_()->fields()->editField($this->_fieldType, $field, $form->getValues());

    $this->view->status = true;
    $this->view->field = $field->toArray();
    $this->view->form = null;

    // Re-render all maps that have this field as a parent or child
    $maps = array_merge(
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $field->field_id),
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $field->field_id)
    );
    $html = array();
    foreach( $maps as $map ) {
      $html[$map->getKey()] = $this->view->adminFieldMeta($map);
    }
    $this->view->htmlArr = $html;
  }

  public function headingDeleteAction()
  {
    $field = Engine_Api::_()->fields()->getField($this->_getParam('field_id'), $this->_fieldType);

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    // Delete field
    Engine_Api::_()->fields()->deleteField($this->_fieldType, $field);
  }



  // Fields

  public function fieldCreateAction()
  {
    if( $this->_requireProfileType || $this->_getParam('option_id') ) {
      $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);
    } else {
      $option = null;
    }

    // Check type param and get form class
    $cfType = $this->_getParam('type');
    $adminFormClass = null;
    if( !empty($cfType) ) {
      $adminFormClass = Engine_Api::_()->fields()->getFieldInfo($cfType, 'adminFormClass');
    }
    if( empty($adminFormClass) || !@class_exists($adminFormClass) ) {
      $adminFormClass = 'Fields_Form_Admin_Field';
    }

    // Create form
    $this->view->form = $form = new $adminFormClass();

    // Create alt form
    $this->view->formAlt = $formAlt = new Fields_Form_Admin_Map();
    $formAlt->setAction($this->view->url(array('action' => 'map-create')));

    // Get field data for auto-suggestion
    $fieldMaps = Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType);
    $fieldList = array();
    $fieldData = array();
    foreach( Engine_Api::_()->fields()->getFieldsMeta($this->_fieldType) as $field ) {
      if( $field->type == 'profile_type' ) continue;

      // Ignore fields in the same category as we have selected
      foreach( $fieldMaps as $map ) {
        if( ( !$option || !$map->option_id || $option->option_id == $map->option_id ) && $field->field_id == $map->child_id ) {
          continue 2;
        }
      }

      // Add
      $fieldList[] = $field;
      $fieldData[$field->field_id] = $field->label;
    }
    $this->view->fieldList = $fieldList;
    $this->view->fieldData = $fieldData;

    if( count($fieldData) < 1 ) {
      $this->view->formAlt = null;
    } else {
      $formAlt->getElement('field_id')->setMultiOptions($fieldData);
    }

    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      $form->populate($this->_getAllParams());
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $field = Engine_Api::_()->fields()->createField($this->_fieldType, array_merge(array(
      'option_id' => ( is_object($option) ? $option->option_id : '0' ),
    ), $form->getValues()));

    // Should get linked in field creation
    //$fieldMap = Engine_Api::_()->fields()->createMap($field, $option);

    $this->view->status = true;
    $this->view->field = $field->toArray();
    $this->view->option = is_object($option) ? $option->toArray() : array('option_id' => '0');
    $this->view->form = null;

    // Re-render all maps that have this field as a parent or child
    $maps = array_merge(
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $field->field_id),
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $field->field_id)
    );
    $html = array();
    foreach( $maps as $map ) {
      $html[$map->getKey()] = $this->view->adminFieldMeta($map);
    }
    $this->view->htmlArr = $html;
  }

  public function fieldEditAction()
  {
    $field = Engine_Api::_()->fields()->getField($this->_getParam('field_id'), $this->_fieldType);

    // Check type param and get form class
    $cfType = $this->_getParam('type', $field->type);
    $adminFormClass = null;
    if( !empty($cfType) ) {
      $adminFormClass = Engine_Api::_()->fields()->getFieldInfo($cfType, 'adminFormClass');
    }
    if( empty($adminFormClass) || !@class_exists($adminFormClass) ) {
      $adminFormClass = 'Fields_Form_Admin_Field';
    }

    // Create form
    $this->view->form = $form = new $adminFormClass();
    $form->setTitle('Edit Profile Question');

    // Get sync notice
    $linkCount = count(Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)
        ->getRowsMatching('child_id', $field->field_id));
    if( $linkCount >= 2 ) {
      $form->addNotice($this->view->translate(array(
        'This question is synced. Changes you make here will be applied in %1$s other place.',
        'This question is synced. Changes you make here will be applied in %1$s other places.',
        $linkCount - 1), $this->view->locale()->toNumber($linkCount - 1)));
    }

    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      $form->populate($field->toArray());
      $form->populate($this->_getAllParams());
      if( is_array($field->config) ){
        $form->populate($field->config);
      }
      $this->view->search = $field->search;
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    Engine_Api::_()->fields()->editField($this->_fieldType, $field, $form->getValues());

    $this->view->status = true;
    $this->view->field = $field->toArray();
    $this->view->form = null;

    // Re-render all maps that have this field as a parent or child
    $maps = array_merge(
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $field->field_id),
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $field->field_id)
    );
    $html = array();
    foreach( $maps as $map ) {
      $html[$map->getKey()] = $this->view->adminFieldMeta($map);
    }
    $this->view->htmlArr = $html;
  }

  public function fieldDeleteAction()
  {
    $field = Engine_Api::_()->fields()->getField($this->_getParam('field_id'), $this->_fieldType);

    $this->view->form = $form = new Engine_Form(array(
      'method' => 'post',
      'action' => $_SERVER['REQUEST_URI'],
      'elements' => array(
        array(
          'type' => 'submit',
          'name' => 'submit',
        )
      )
    ));

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    $this->view->status = true;
    Engine_Api::_()->fields()->deleteField($this->_fieldType, $field);
  }



  // Option

  public function optionCreateAction()
  {
    $field = Engine_Api::_()->fields()->getField($this->_getParam('field_id'), $this->_fieldType);
    $label = $this->_getParam('label');

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    // Create new option
    $option = Engine_Api::_()->fields()->createOption($this->_fieldType, $field, array(
      'label' => $label,
    ));

    $this->view->status = true;
    $this->view->option = $option->toArray();
    $this->view->field = $field->toArray();

    // Re-render all maps that have this options's field as a parent or child
    $maps = array_merge(
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $option->field_id),
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $option->field_id)
    );
    $html = array();
    foreach( $maps as $map ) {
      $html[$map->getKey()] = $this->view->adminFieldMeta($map);
    }
    $this->view->htmlArr = $html;
  }

  public function optionEditAction()
  {
    $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);
    $field = Engine_Api::_()->fields()->getField($option->field_id, $this->_fieldType);

    // Create form
    $this->view->form = $form = new Sesproduct_Form_Dashboard_Option();
    $form->submit->setLabel('Edit Attribute');
    if($field->type == "select" && !$this->_getParam('from')){
        $form->removeElement('price');
        $form->removeElement('type');
    }


    // Check method/data
    if( !$this->getRequest()->isPost() ) {
      $form->populate($option->toArray());
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    Engine_Api::_()->fields()->editOption($this->_fieldType, $option, $form->getValues());

      if($field->type == "select" && $this->_getParam('from')){
        //get all variations
          $db = Engine_Db_Table::getDefaultAdapter();
          $optionsData = $db->query("SELECT * from engine4_sesproduct_cartproducts_fields_options WHERE option_id IN (SELECT option_id FROM engine4_sesproduct_cartproducts_combinationmaps
          WHERE combination_id IN (SELECT combination_id FROM engine4_sesproduct_cartproducts_combinationmaps WHERE option_id = ".$this->_getParam('option_id').")  GROUP BY combination_id)")->fetchAll();

          $optionsArray = array();
          foreach($optionsData as $optionItem){
              $optionsArray[$optionItem['option_id']]['type'] = $optionItem['type'];
              $optionsArray[$optionItem['option_id']]['price'] = $optionItem['price'];
          }

          $combimations = $db->query("SELECT GROUP_CONCAT(option_id) as options,combination_id FROM engine4_sesproduct_cartproducts_combinationmaps
          WHERE combination_id IN (SELECT combination_id FROM engine4_sesproduct_cartproducts_combinationmaps WHERE option_id = ".$this->_getParam('option_id').")  GROUP BY combination_id")->fetchAll();
          if(count($combimations)){
              foreach($combimations as $combination){
                  $combination_id = $combination['combination_id'];
                  $options = explode(',',$combination['options']);
                  $price = 0;
                  foreach ($options as $optionItem) {
                      $price += ($optionsArray[$optionItem]['type'] == 1 ? "+" : "-").$optionsArray[$optionItem]['price'];
                  }
                  $combinationItem = Engine_Api::_()->getItem('sesproduct_combination',$combination_id);
                  if($combinationItem){
                      if($price >= 0){
                          $combinationItem->type = 1;
                      }else{
                          $combinationItem->type = 0;
                      }
                      $combinationItem->price = abs($price);
                      $combinationItem->save();
                  }
              }
          }
      }
    // Process
    $this->view->status = true;
    $this->view->form = null;
    $this->view->option = $option->toArray();
    $this->view->field = $field->toArray();

    // Re-render all maps that have this options's field as a parent or child
    $maps = array_merge(
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $option->field_id),
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $option->field_id)
    );
    $html = array();
    foreach( $maps as $map ) {
      $html[$map->getKey()] = $this->view->adminFieldMeta($map);
    }
    $this->view->htmlArr = $html;
  }
    public function optionDeleteVariationAction()
    {
        //In smoothbox
        $this->_helper->layout->setLayout('default-simple');

        $this->view->form = $form = new Sesbasic_Form_Delete();
        $form->setTitle('Delete Option?');
        $form->setDescription('Are you sure that you want to delete this option? It will not be recoverable after being deleted. ');
        $form->submit->setLabel('Delete');




        if (!$this->getRequest()->isPost()) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

            $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);

            if( !$this->getRequest()->isPost() ) {
                return;
            }

            // Delete all values
            $option_id = $option->option_id;
            Engine_Api::_()->fields()->deleteOption($this->_fieldType, $option);
            //delete all variations combination of this option
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->query("DELETE FROM engine4_sesproduct_cartproducts_combinations WHERE combination_id IN (SELECT combination_id FROM engine4_sesproduct_cartproducts_combinationmaps WHERE option_id = ".$this->_getParam('option_id')." )");

            $options = $db->query("SELECT combination_id FROM engine4_sesproduct_cartproducts_combinationmaps WHERE option_id = ".$this->_getParam('option_id'))->fetchAll();

            $optionArray = array();
            foreach ($options as $data){
                $optionArray[] = $data['combination_id'];
            }
            $db->query("DELETE FROM engine4_sesproduct_cartproducts_combinationmaps WHERE combination_id IN (".implode(',',$optionArray)." )");

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected option has been deleted.');
        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => true,
            'parentRefresh' => true,
            'messages' => array($this->view->message)
        ));


    }
  public function optionDeleteAction()
  {
    $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    // Delete all values
    $option_id = $option->option_id;
    Engine_Api::_()->fields()->deleteOption($this->_fieldType, $option);

      //delete combinations
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("DELETE FROM engine4_sesproduct_cartproducts_combinations WHERE combination_id IN (SELECT combination_id FROM engine4_sesproduct_cartproducts_combinationmaps WHERE option_id = ".$this->_getParam('option_id')." )");
      $options = $db->query("SELECT combination_id FROM engine4_sesproduct_cartproducts_combinationmaps WHERE option_id = ".$this->_getParam('option_id'))->fetchAll();
      $optionArray = array();
      foreach ($options as $data){
          $optionArray[] = $data['combination_id'];
      }
      $db->query("DELETE FROM engine4_sesproduct_cartproducts_combinationmaps WHERE combination_id IN (".implode(',',$optionArray)." )");
  }

  public function mapCreateAction()
  {
    $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);
    //$field = Engine_Api::_()->fields()->getField($this->_getParam('parent_id'), $this->_fieldType);

    $child_id = $this->_getParam('child_id', $this->_getParam('field_id'));
    $label = $this->_getParam('label');
    $child = null;

    if( $child_id ) {
      $child = Engine_Api::_()->fields()->getFieldsMeta($this->_fieldType)->getRowMatching('field_id', $child_id);
    } else if( $label ) {
      $child = Engine_Api::_()->fields()->getFieldsMeta($this->_fieldType)->getRowsMatching('label', $label);
      if( count($child) > 1 ) {
        throw new Fields_Model_Exception('Duplicate label');
      }
      $child = current($child);
    } else {
      throw new Fields_Model_Exception('No child field specified');
    }

    if( !($child instanceof Fields_Model_Meta) ) {
      throw new Fields_Model_Exception('No child field found');
    }

    $fieldMap = Engine_Api::_()->fields()->createMap($child, $option);

    $this->view->field = $child->toArray();
    $this->view->fieldMap = $fieldMap->toArray();

    // Re-render all maps that have this field as a parent or child
    $maps = array_merge(
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $option->field_id),
      Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $option->field_id)
    );
    $html = array();
    foreach( $maps as $map ) {
      $html[$map->getKey()] = $this->view->adminFieldMeta($map);
    }
    $this->view->htmlArr = $html;
  }

  public function mapDeleteAction()
  {
    $map = Engine_Api::_()->fields()->getMap($this->_getParam('child_id'), $this->_getParam('option_id'), $this->_fieldType);
    Engine_Api::_()->fields()->deleteMap($map);
  }


  // Other

  public function orderAction()
  {
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    // Get params
    $fieldOrder = (array) $this->_getParam('fieldOrder');
    $optionOrder = (array) $this->_getParam('optionOrder');

    // Sort
    ksort($fieldOrder, SORT_NUMERIC);
    ksort($optionOrder, SORT_NUMERIC);

    // Get data
    $mapData = Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType);
    $metaData = Engine_Api::_()->fields()->getFieldsMeta($this->_fieldType);
    $optionData = Engine_Api::_()->fields()->getFieldsOptions($this->_fieldType);

    // Parse fields (maps)
    $i = 0;
    foreach( $fieldOrder as $index => $ids ) {
      $map = $mapData->getRowMatching(array(
        'field_id' => $ids['parent_id'],
        'option_id' => $ids['option_id'],
        'child_id' => $ids['child_id'],
      ));
      $map->order = ++$i;
      $map->save();
    }

    // Parse options
    $i = 0;
    foreach( $optionOrder as $index => $ids ) {
      $option = $optionData->getRowMatching('option_id', $ids['suboption_id']);
      $option->order = ++$i;
      $option->save();
    }

    // Flush cache
    $mapData->getTable()->flushCache();
    $metaData->getTable()->flushCache();
    $optionData->getTable()->flushCache();

    $this->view->status = true;
  }
}
