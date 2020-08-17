<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Fields.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Form_Custom_Product_Fields extends Engine_Form {
  /* Custom */

  protected $_item;
    protected $_type;
  protected $_processedValues = array();
  protected $_topLevelId;
  protected $_topLevelValue;
  protected $_packageId;
  protected $_resourceType;
  protected $_isCreation = false;

  // Add custom element paths?
  public function __construct($options = null) {
    Engine_FOrm::enableForm($this);
    self::enableForm($this);

    parent::__construct($options);
  }

  public static function enableForm(Zend_Form $form) {
    $form->addPrefixPath('Fields_Form_Element', APPLICATION_PATH . '/application/modules/Fields/Form/Element', 'element');
  }

  /* General */

  public function getItem() {
    return $this->_item;
  }

  //WE ARE JUST CHANGING IN THIS FUNCTION
  public function setItem($item) {
    $this->_item = $item;
    return $this;
  }
    public function getType() {
        return $this->_type;
    }

    //WE ARE JUST CHANGING IN THIS FUNCTION
    public function setType($item) {
        $this->_type = $item;
        return $this;
    }
  public function setTopLevelId($id) {
    $this->_topLevelId = $id;
    return $this;
  }

  public function getPackagelId() {
    return $this->_packageId;
  }

  public function setPackageId($id) {
    $this->_packageId = $id;
    return $this;
  }

  public function getResourceType() {
    return $this->_resourceType;
  }

  public function setResourceType($id) {
    $this->_resourceType = $id;
    return $this;
  }

  public function getTopLevelId() {
    return $this->_topLevelId;
  }

  public function setTopLevelValue($val) {
    $this->_topLevelValue = $val;
    return $this;
  }

  public function getTopLevelValue() {
    return $this->_topLevelValue;
  }

  public function setIsCreation($flag = true) {
    $this->_isCreation = (bool) $flag;
    return $this;
  }

  public function setProcessedValues($values) {
    $this->_processedValues = $values;
    $this->_setFieldValues($values);
    return $this;
  }

  public function getProcessedValues() {
    return $this->_processedValues;
  }

  public function getFieldMeta() {
    return Engine_Api::_()->fields()->getFieldsMeta($this->getType());
  }

  public function getFieldStructure() {
    // Let's allow fallback for no profile type (for now at least)
    if (!$this->_topLevelId || !$this->_topLevelValue) {
      $this->_topLevelId = null;
      $this->_topLevelValue = null;
    }

    return Engine_Api::_()->fields()->getFieldsStructureFull($this->getType(), $this->_topLevelId, $this->_topLevelValue);
  }

  // Main

  public function generate() {

    $orderIndex = 0;
    $isEnableCheck = 0;
    if ($this->_packageId != null) {
      $package = Engine_Api::_()->getItem($this->_resourceType, $this->_packageId);
      $fieldsEnable = json_decode($package->custom_fields_params, true);

      $params = json_decode($package->params, true);
      $enableCheck = $params['custom_fields'];
      $isEnableCheck = 1;
    }

      //get all select type fields
      $variations = Engine_Api::_()->sesproduct()->getVariationOptions($this->getItem());
      if(count($variations)){
          $counter = 1;
          $total = count($variations);
          foreach ($variations as $key=>$value){
              $this->addElement('Select', "select_".$key, array(
                  'label' => $value['field_label'],
                  'multiOptions' => !empty($value['multioptions'] && $counter == 1) ? $value['multioptions'] : array('0'=>Zend_Registry::get('Zend_Translate')->translate('-- Please Select --')),
                  'required' => true,
                  'allowEmpty'=> false,
                  'onchange'=>($total != $counter ? "getVariationAttribute(this);" : "getPriceConfiguration(this);"),
                  'order' => $orderIndex++,
              ));
              $counter++;
          }
    }
    $struct = $this->getFieldStructure();
    foreach ($struct as $fskey => $map) {
      $field = $map->getChild();
      if($field->type == 'select'){
          continue;
      }
      // Skip fields hidden on signup
      if (isset($field->show) && !$field->show && $this->_isCreation) {
        continue;
      }
      if ($isEnableCheck && !in_array($fskey, $fieldsEnable) && $fskey != '0_0_1' && $enableCheck == 2)
        continue;

      // Add field and load options if necessary
      $params = $field->getElementParams($this->getType());
      $key = $map->getKey();

      // If value set in processed values, set in element
      if (!empty($this->_processedValues[$field->field_id])) {
        $params['options']['value'] = $this->_processedValues[$field->field_id];
      }

    if (isset($params['options']['multiOptions']) && !empty($params['options']['multiOptions'])) {
        $options = $params['options']['multiOptions'];
        foreach ($options as $option_id => $option) {
            if (!empty($option_id)) {
                $data = Engine_Api::_()->getDbTable('cartproductsoptions', 'sesproduct')->getOption($option_id);
                if ($data) {
                    $price = Engine_Api::_()->sesproduct()->getCurrencyPrice($data->price);
                    if ($data->price != '0.00') {
                        if (!empty($data->type)) {
                            $params['options']['multiOptions'][$data['option_id']] = $option . '   ' . '(+' . $price . ')';
                        } else {
                            $params['options']['multiOptions'][$data['option_id']] = $option . '   ' . '(-' . $price . ')';
                        }
                    } else {
                        $params['options']['multiOptions'][$data['option_id']] = $option;
                    }

                }

            }
        }
    }

        if ($field->type == 'checkbox') {
            if ($field['config']['price'] != '0.00') {
                $price = Engine_Api::_()->sesproduct()->getCurrencyPrice($field['config']['price']);
                if (!empty($field['config']['price_type'])) {
                    $params['options']['label'] = $params['options']['label'] . '   ' . '(+' . $price . ')';
                } else {
                    $params['options']['label'] = $params['options']['label'].'   ' . '(-' . $price . ')';
                }
            }
        }

        if ($field->type == 'text' || $field->type == 'textarea') {
            if ($field['config']['price'] != '0.00') {
                $price = Engine_Api::_()->sesproduct()->getCurrencyPrice($field['config']['price']);
                $wordLimit = "";
                if(!empty($field['config']['limit'])){
                    $wordLimit = " | Word Limit: ".$field['config']['limit'];
                }
                if (!empty($field['config']['price_type'])) {
                    $params['options']['label'] = $params['options']['label'] . '   ' . '(+' . $price . ' '.$wordLimit.')';
                } else {
                    $params['options']['label'] = $params['options']['label'].'   ' . '(-' . $price . ' '.$wordLimit.')';
                }
            }
        }

        if (!@is_array($params['options']['attribs'])) {
            $params['options']['attribs'] = array();
        }

        // Heading
        if ($params['type'] == 'Heading') {
            $params['options']['value'] = Zend_Registry::get('Zend_Translate')->_($params['options']['label']);
            unset($params['options']['label']);
        }

        // Order
        // @todo this might cause problems, however it will prevent multiple orders causing elements to not show up
        $params['options']['order'] = $orderIndex++;

        $inflectedType = Engine_Api::_()->fields()->inflectFieldType($params['type']);
        unset($params['options']['alias']);
        unset($params['options']['publish']);
		$limitval = $params['options']['limit'];
		$params['options']['maxlength'] = $limitval;
		unset($params['options']['limit']);
        $this->addElement($inflectedType, $key, $params['options']);

        $element = $this->getElement($key);

        if (method_exists($element, 'setFieldMeta')) {
            $element->setFieldMeta($field);
        }
      // Set attributes for hiding/showing fields using javscript
      $classes = 'field_container field_' . $map->child_id . ' option_' . $map->option_id . ' parent_' . $map->field_id;
      $element->setAttrib('class', $classes);
      //$element->setAttrib('readonly', '');
      //$element->setAttrib('onfocus', "this.removeAttribute('readonly')");

      //if ($field->canHaveDependents()) {
        if ($field->type == 'text' || $field->type == 'textarea') {
            $wordLimit = 0;
            if(!empty($field['config']['limit'])){
                $wordLimit = $field['config']['limit'];
            }
            $element->setAttrib('onkeydown', 'return setPriceConfiguration(this);');
            $element->setAttrib('onblur', 'getPriceConfiguration(this);');
        }else {
            $element->setAttrib('onchange', 'getPriceConfiguration(this)');
        }
      //}

      // Set custom error message
      if ($field->error) {
        $element->addErrorMessage($field->error);
      }

      if ($field->isHeading()) {
        $element->removeDecorator('Label')
                ->removeDecorator('HtmlTag')
                ->getDecorator('HtmlTag2')->setOption('class', 'form-wrapper-heading');
      }
    }

    $this->addElement('Button', 'addtocart', array(
        'label' => 'Add To Cart',
        'type' => 'submit',
        'order' => 10000,
    ));
  }

  public function saveValues() {
    // An id must be set to save data (duh)
    if (is_null($this->getType())) {
      throw new Exception("Cannot save data when no identity has been specified");
    }

    // Iterate over values
    $values = Engine_Api::_()->fields()->getFieldsValues($this->getItem());
    //remove class fields
    foreach ($values as $iteVal)
      $iteVal->delete();

    $fVals = $_POST;

    if ($this->_elementsBelongTo) {
      if (isset($fVals[$this->_elementsBelongTo])) {
        $fVals = $fVals[$this->_elementsBelongTo];
      }
    }
    unset($fVals['$fVals']);
     $cartmetaTable = Engine_Api::_()->fields()->getTable($this->getType(), 'meta');
     $cartOptionTable = Engine_Api::_()->fields()->getTable($this->getType(), 'options');
    foreach ($fVals as $key => $value) {
      $parts = explode('_', $key);
      if ((count($parts) != 3) && ($parts[0] != 'select'))
            continue;

      //select type
      if (count($parts) == 2)
         $field_id = $parts[1];
      else
         list($parent_id, $option_id, $field_id) = $parts;

        if (count($parts) == 3) {
            //get field type
            $type = $cartmetaTable->select()->from($cartmetaTable->info('name'), 'type')
                ->where('field_id =?', $field_id)
                ->query()->fetchColumn();
        }

      // Array mode
      if (is_array($value)) {

        // Lookup
        $valueRows = $values->getRowsMatching(array(
            'field_id' => $field_id,
            'item_id' => $this->getItem()->getIdentity()
        ));
        // Delete all
        foreach ($valueRows as $valueRow) {
          $valueRow->delete();
        }
        // Insert all
        $indexIndex = 0;
        if (is_array($value) || !empty($value)) {

          foreach ((array) $value as $singleValue) {
            $valueRow = $values->createRow();
            $valueRow->field_id = $field_id;
            $valueRow->item_id = $this->getItem()->getIdentity();
            $valueRow->index = $indexIndex++;
            $valueRow->value = $singleValue;
            $valueRow->save();
          }
        }
      }

      // Scalar mode
      else {
        // Lookup
        $valueRow = $values->getRowMatching(array(
            'field_id' => $field_id,
            'item_id' => $this->getItem()->getIdentity(),
            'index' => 0
        ));

        // Remove value row if empty
        if (empty($value)) {
          if ($valueRow) {
            $valueRow->delete();
          }
          continue;
        }

        // Create if missing
        $isNew = false;
        if (!$valueRow) {
          $isNew = true;
          $valueRow = $values->createRow();
          $valueRow->field_id = $field_id;
          $valueRow->item_id = $this->getItem()->getIdentity();
        }

          if (!empty($type) && $type == 'checkbox') {
              $checkboxOptionId = $cartOptionTable->select()->from($cartOptionTable->info('name'), 'option_id')->where('field_id =?', $field_id)->query()->fetchColumn();
              if (!empty($checkboxOptionId))
                  $valueRow->value = $checkboxOptionId;
              else
                  $valueRow->value = htmlspecialchars($value);
          }
          else {
              $valueRow->value = htmlspecialchars($value);
          }
          if (count($parts) == 2) {
              $valueRow->is_select_type = 1;
          }

          try{
              $valueRow->save();
          }catch(Exception $e){
              //silence
          }

      }
    }




    // Update search table
    Engine_Api::_()->getApi('core', 'fields')->updateSearch($this->getItem(), $values);

    // Fire on save hook
    Engine_Hooks_Dispatcher::getInstance()->callEvent('onFieldsValuesSave', array(
        'item' => $this->getItem(),
        'values' => $values
    ));

    // Regenerate form
    $this->generate();
  }

  protected function _setFieldValues($values) {
    // Iterate over elements and apply the values
    foreach ($this->getElements() as $key => $element) {
      if (count(explode('_', $key)) == 3) {
        list($parent_id, $option_id, $field_id) = explode('_', $key);
        if (isset($values[$field_id])) {
          $element->setValue($values[$field_id]);
        }
      }
    }
  }

  /* These are hacks to existing form methods */

  public function init() {
    $this->generate();
  }

  public function isValid($data) {
    if (!is_array($data)) {
      require_once 'Zend/Form/Exception.php';
      throw new Zend_Form_Exception(__CLASS__ . '::' . __METHOD__ . ' expects an array');
    }
    $translator = $this->getTranslator();
    $valid = true;

    if ($this->isArray()) {
      $data = $this->_dissolveArrayValue($data, $this->getElementsBelongTo());
    }
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    //sesapi calling
    if (!empty($_POST['module']))
      $module = $_POST["module"];
    // Changing this part
    $structure = $this->getFieldStructure();
    $selected = array();
    $arrayId = array();
    if (!empty($this->_topLevelId))
      $selected[$this->_topLevelId] = $this->_topLevelValue;
    if (isset($_POST['category_id']) && $_POST['category_id'] != 0) {
      $category_map_id_data = Engine_Api::_()->getDbtable('categories', $module)->getMapId($_POST['category_id']);
      if ($category_map_id_data != 0) {
        $category_map_id = $category_map_id_data;
        array_push($arrayId, $category_map_id);
      }
    }
    if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0) {
      $subcategory_map_id_data = Engine_Api::_()->getDbtable('categories', $module)->getSubCatMapId($_POST['subcat_id']);
      if ($subcategory_map_id_data != 0) {
        $subcategory_map_id = $subcategory_map_id_data;
        array_push($arrayId, $subcategory_map_id);
      }
    }
    if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0) {
      $subsubcategory_map_id_data = Engine_Api::_()->getDbtable('categories', $module)->getSubSubCatMapId($_POST['subsubcat_id']);
      if ($subsubcategory_map_id_data != 0) {
        $subsubcategory_map_id = $subsubcategory_map_id_data;
        array_push($arrayId, $subsubcategory_map_id);
      }
    }

    foreach ($this->getElements() as $key => $element) {

      $element->setTranslator($translator);

      $parts = explode('_', $key);
      if (count($parts) !== 3) {
        continue;
      }


      list($parent_id, $option_id, $field_id) = $parts;
      //if( !is_numeric($field_id) ) continue;
      $fieldObject = $structure[$key];

      // All top level fields are always shown
      if (!empty($parent_id)) {

        $parent_field_id = $parent_id;
        $option_id = $option_id;
        // Field has already been stored, or parent does not have option
        // specified, <del>or field is a heading</del>
        if (isset($selected[$field_id]) || empty($selected[$parent_field_id]) /* || !isset($data[$key]) */) {
          $element->setIgnore(true);
          continue;
        }

        // Parent option doesn't match
        if (is_scalar($selected[$parent_field_id]) && $selected[$parent_field_id] != $option_id && !in_array($option_id, $arrayId)) {
          $element->setIgnore(true);
          continue;
        } else if (is_array($selected[$parent_field_id]) && !in_array($option_id, $selected[$parent_field_id])) {
          $element->setIgnore(true);
          continue;
        }
      }
      // This field is being used
      if (isset($data[$key])) {
        $selected[$field_id] = $data[$key];
      }

      if ($element instanceof Engine_Form_Element_Heading) {
        $element->setIgnore(true);
      } else if (!isset($data[$key])) {
        $valid = $element->isValid(null, $data) && $valid;
      } else {
        $valid = $element->isValid($data[$key], $data) && $valid;
      }
    }

    $this->_processedValues = $selected;
    // Done changing

    foreach ($this->getSubForms() as $key => $form) {
      $form->setTranslator($translator);
      if (isset($data[$key])) {
        $valid = $form->isValid($data[$key]) && $valid;
      } else {
        $valid = $form->isValid($data) && $valid;
      }
    }

    $this->_errorsExist = !$valid;

    return $valid;
  }

}
