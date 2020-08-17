<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AttributesController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_AttributesController extends Sesproduct_Controller_Abstract {
    protected $_requireProfileType = true;
    protected $_fieldType = 'sesproduct_cartproducts';
  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesproduct', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('product_id', null);
    $product_id = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getProductId($id);
    if ($product_id) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      if ($product && !Engine_Api::_()->core()->hasSubject())
        Engine_Api::_()->core()->setSubject($product);
    } else
      return $this->_forward('requireauth', 'error', 'core');
    $isProductAdmin = Engine_Api::_()->sesproduct()->isProductAdmin($product, 'edit');
    $sesproduct_edit = Zend_Registry::isRegistered('sesproduct_edit') ? Zend_Registry::get('sesproduct_edit') : null;
    if (empty($sesproduct_edit))
      return $this->_forward('notfound', 'error', 'core');
    if (!$isProductAdmin)
     return $this->_forward('requireauth', 'error', 'core');
		parent::init();
  }
  public function attributesAction(){
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $sesproduct_edit = Zend_Registry::isRegistered('sesproduct_edit') ? Zend_Registry::get('sesproduct_edit') : null;
    if (empty($sesproduct_edit))
        return $this->_forward('notfound', 'error', 'core');
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
        return $this->_forward('notfound', 'error', 'core');
    parent::indexAction();
  }
  public function variationsAction(){

    if(isset($_POST['variation_submit'])){
        foreach($_POST as $key=>$value){
            if(strpos($key,'combination_') !== false){
                $combination_id = str_replace('combination_','',$key);
                $combination = Engine_Api::_()->getItem('sesproduct_combination',$combination_id);
                if($combination) {
                    $combination->quantity = $value;
                    $combination->save();
                }
            }
        }
    }

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $sesproduct_edit = Zend_Registry::isRegistered('sesproduct_edit') ? Zend_Registry::get('sesproduct_edit') : null;
    if (empty($sesproduct_edit))
      return $this->_forward('notfound', 'error', 'core');
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
        return $this->_forward('notfound', 'error', 'core');

    //fetch all variation fields
     $this->view->attributes = $attributes = Engine_Api::_()->sesproduct()->getAttributedSelelct($product);

      $this->view->variations = Engine_Api::_()->getDbTable('combinations','sesproduct')->getCombinations(array('product_id'=>$product->getIdentity()));

      $resAttributes = array();
      if(count($attributes)){
          foreach ($attributes as $attribute){
              $resAttributes[] = $attribute['field_id'];
          }
      }

      if(count($resAttributes)){
          $db = Engine_Db_Table::getDefaultAdapter();
          $options = $db->query("SELECT label,option_id FROM engine4_sesproduct_cartproducts_fields_options WHERE field_id IN (".implode(',',$resAttributes).")")->fetchAll();
          $optionsArray = array();
          if(count($options)){
              foreach ($options as $option)
                $optionsArray[$option['option_id']] = $option['label'];
              $this->view->options = $optionsArray;
          }
      }

  }
  function enableCombinationAction(){
     $id = $this->_getParam('id');
     $combonation = Engine_Api::_()->getItem('sesproduct_combination',$id);
     if($combonation){
         $combonation->status = !$combonation->status;
         $combonation->save();
     }
      $combonation = Engine_Api::_()->getItem('sesproduct_combination',$id);
     if($combonation->status == 1){
         echo 1;die;
     }else{
         echo 0;die;
     }

  }
  function deleteCombinationAction(){
      $id = $this->_getParam('combination_id');
      $combonation = Engine_Api::_()->getItem('sesproduct_combination',$id);
      $this->_helper->layout->setLayout('default-simple');

      $this->view->form = $form = new Sesbasic_Form_Delete();
      $form->setTitle('Delete Variation?');
      $form->setDescription('Are you sure that you want to delete this variation? It will not be recoverable after being deleted. ');
      $form->submit->setLabel('Delete');


      if (!$combonation) {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_("Variation doesn't exists or not authorized to delete");
          return;
      }

      if (!$this->getRequest()->isPost()) {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
          return;
      }

      $db = $combonation->getTable()->getAdapter();
      $db->beginTransaction();
      try {
          //Delete all combinations products which is related to this variation
          Engine_Api::_()->getDbtable('combinationmaps', 'sesproduct')->delete(array('combination_id =?' => $this->_getParam('combination_id')));
          $combonation->delete();
          $db->commit();
      } catch (Exception $e) {
          $db->rollBack();
          throw $e;
      }
      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected variation has been deleted.');
      return $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Variation deleted successfully.')
      ));
  }
    public function variationCreateAction(){
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $sesproduct_edit = Zend_Registry::isRegistered('sesproduct_edit') ? Zend_Registry::get('sesproduct_edit') : null;
        if (empty($sesproduct_edit))
            return $this->_forward('notfound', 'error', 'core');
        $this->view->product = $product = Engine_Api::_()->core()->getSubject();
        $viewer = Engine_Api::_()->user()->getViewer();
        $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
        if(!$isProductAdmin)
            return $this->_forward('notfound', 'error', 'core');

        $this->view->form = $form = new Sesproduct_Form_Dashboard_Variation();
        $field_ids = array();
        $attributes = Engine_Api::_()->sesproduct()->getAttributedSelelct($product);
        $optionPrices = array();
        foreach($attributes as $attribute){
            $options = Engine_Api::_()->getDbTable('cartproductsoptions','sesproduct')->getOptionFields($attribute['field_id']);
            $optionsArray = array(''=>'');
            foreach ($options as $option){
                $optionsArray[$option['option_id']] = $option['label'];
            }
            $form->addElement('Select','attribute_id_'.$attribute['field_id'],array(
                'label'=>$attribute['label'],
                'required'=>true,
                'allowEmpty'=>false,
                'onchange'=>"showFields(this)",
                'multiOptions' =>$optionsArray
            ));

            foreach ($options as $option){
                $field_ids[$option['option_id']] = $option['field_id'];
                if(empty($option['price'])){
                    //create increment and price field
                    $form->addElement('Radio','option_id_'.$option['option_id'],array(
                        'label'=>'Choose Increment / decrement price for this attribute',
                        'multiOptions'=>array('1'=>'Increment','0'=>'Decrement'),
                        'class'=>'hide_elem',
                        'value'=>1,
                        'filters' => array(
                            'StripTags',
                            new Engine_Filter_Censor(),
                        )
                    ));
                    $translate = Zend_Registry::get('Zend_Translate');
                    $locale = Zend_Registry::get('Locale');
                    $currencyName = Zend_Locale_Data::getContent($locale, 'nametocurrency', Engine_Api::_()->estore()->defaultCurrency());
                    $form->addElement('Text','option_price_'.$option['option_id'],array(
                        'label' => $translate->translate('Price ('.$currencyName.')'),
                        'validators' => array(
                            array('GreaterThan', false, array(-1))
                        ),
                        'filters' => array(
                            'StripTags',
                            new Engine_Filter_Censor(),
                        ),
                        'class'=>'hide_elem',
                        'value'=>0,
                    ));
                }else{
                    $optionPrices[$option['option_id']]['price'] = $option['price'];
                    $optionPrices[$option['option_id']]['type'] = $option['type'];

                    $form->addElement('Dummy','dummy_'.$option['option_id'],array(
                       'content'=>'<span class="hide_elem hide_form_element">'.($option['type'] == 1 ? '+' : '-' ).Engine_Api::_()->estore()->getCurrencyPrice($option['price'],Engine_Api::_()->estore()->defaultCurrency(),'').'</span>',
                        'class'=>'',
                    ));
                }
            }
        }
        // Check method/data
        if (!$this->getRequest()->isPost()) {
            return;
        }
        if (!$form->isValid($this->getRequest()->getPost())) {
            return;
        }

        $status = $_POST['status'];
        $quatity = $_POST['quatity'];


        $error = false;
        $totalQuatitiy = Engine_Api::_()->getDbTable('combinations','sesproduct')->getTotalQuantity($product);
        if (!empty($product->manage_stock) && ($totalQuatitiy + $_POST['quantity'] >= $product->stock_quatity)) {
            $form->addError(sprintf(Zend_Registry::get('Zend_Translate')->_('You have only %s quantities available for this product and you have already created the product variations with this much quantity. So you can not create more product variations for this product.'), $product->stock_quatity));
            return;
        }
        $attribute_ids = array();
        foreach($_POST as $key=>$value){
            $explode = explode('_',$key);
            $arrayPop = array_pop($explode);
            $type = implode('_',$explode);

            if($type == "option_price"){
                if(!$value)
                    $value = 0;
                if(!Engine_Api::_()->estore()->isValidFloatAndIntegerValue($value)){
                    $form->addError('Enter valid Price.');
                    $error = true;
                }
            }else if ($type == "quantity"){
                if(!Engine_Api::_()->estore()->checkIntegerValue($value)){
                    $form->addError('Enter valid Quantity.');
                    $error = true;
                }
                //check total quantity
                if($product->manage_stock == 1) {
                    if ($totalQuatitiy + $quatity > $product->stock_quatity){
                        $form->addError("Enter quantity is more than the product stock quantity.");
                        $error = true;
                    }
                }
            }else if($type == "attribute_id"){
                $attribute_ids[] = $value;
            }
        }

        //check variation exists or not
        $having = "";
        foreach ($attribute_ids as $id){
            $having .= "FIND_IN_SET(".$id.",options) > 0 AND ";
        }
        $having = trim($having,' AND');
        $db = Engine_Db_Table::getDefaultAdapter();
        $query = $db->query("SELECT GROUP_CONCAT(option_id) as options FROM `engine4_sesproduct_cartproducts_combinations`
              LEFT JOIN engine4_sesproduct_cartproducts_combinationmaps ON engine4_sesproduct_cartproducts_combinations.combination_id
              = engine4_sesproduct_cartproducts_combinationmaps.combination_id WHERE product_id = ".$product->getIdentity()."
              GROUP BY engine4_sesproduct_cartproducts_combinationmaps.combination_id HAVING ".$having)->fetchAll();
        if(count($query) > 0){
            $form->addError("Variation with this combination already exists, please choose different variation combination");
            $error = 1;
        }
        $price = 0;
        $type = "";
        //save values all set now
        foreach($attribute_ids as $id){
            if(empty($_POST['option_price_'.$id])){
                $price += ($optionPrices[$id]['type'] == 1 ? '+' : '-') .$optionPrices[$id]['price'];
            }else{
                $price += ($_POST['option_id_'.$id] == 1 ? '+' : '-').$_POST['option_price_'.$id];
            }
        }
        if($product->price + $price < 0){
            $form->addError("Variation Price can not be less than the Product Price.");
            $error = 1;
        }
        if($error){
            $form->populate($_POST);
            return;
        }

        //insert values
        $combinationTable = Engine_Api::_()->getDbTable('combinations','sesproduct');
        $combination = $combinationTable->createRow();
        $combination->product_id = $product->getIdentity();
        if($price < 0)
            $combination->type = 0;
        else
            $combination->type = 1;
        $combination->status = $status;
        $combination->price = abs($price);
        $combination->quantity = $quatity;
        $combination->save();
        $combinationMapTable = Engine_Api::_()->getDbTable('combinationmaps','sesproduct');
        $order = 0;

        foreach($attribute_ids as $id){

            if(!empty($_POST['option_price_'.$id])) {
                $db->update('engine4_sesproduct_cartproducts_fields_options', array('price' => $_POST['option_price_'.$id], 'type' =>$_POST['option_id_'.$id]), array("option_id = ?" => $id));
            }
            //insert in combinationmaps table
            $maps = $combinationMapTable->createRow();
            $maps->combination_id = $combination->getIdentity();
            $maps->option_id = $id;
            $maps->order = $order;
            $maps->field_id = $field_ids[$id];
            $order = $order + 1;
            $maps->save();
        }

        return $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('Variation created successfully.')
        ));
    }
    public function fieldCreateAction() {
        if ($this->_requireProfileType || $this->_getParam('option_id')) {
            $option = Engine_Api::_()->fields()->getOption($this->_getParam('option_id'), $this->_fieldType);
        } else
            $option = null;
        // Check type param and get form class
        $cfType = $this->_getParam('type');
        if (!empty($cfType)) {
            $adminFormClass = Engine_Api::_()->fields()->getFieldInfo($cfType, 'adminFormClass');
        }
        if (empty($adminFormClass) || !@class_exists($adminFormClass)) {
            $adminFormClass = 'Fields_Form_Admin_Field';
        }
        $this->view->form = $form = new $adminFormClass();
        $form->setAttrib('class','global_form');
        $form->setTitle('Add Attribute');
        $form->removeElement('show');
        $form->removeElement('style');
        $form->removeElement('error');
        $form->removeElement('required');
        $form->removeElement('search');
        if($cfType == "select"){
            $form->addElement('Hidden','required',array('value'=>1,'order'=>928));
        }
        if($form->execute){
            $form->execute->setLabel('Save Attribute');
        }

        //allowed type
        $allowedType = array('text'=>'Single-line Text Input','textarea'=>'Multi-line Text Input','select'=>'Select Box','radio'=>'Radio Buttons','checkbox'=>'Single Checkbox','multiselect'=>'Multi Select Box','multi_checkbox'=>'Multi Checkbox ');
        $form->type->setMultiOptions($allowedType);
        $form->addElement('hidden', 'show', array('value' => 0));
        $form->removeElement('display');
        $this->view->formAlt = $formAlt = new Fields_Form_Admin_Map();
        $formAlt->setAction($this->view->url(array('action' => 'map-create')));
        $fieldMaps = Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType);
        $fieldList = array();
        $fieldData = array();
        foreach (Engine_Api::_()->fields()->getFieldsMeta($this->_fieldType) as $field) {
            if ($field->type == 'profile_type')
                continue;
            // Ignore fields in the same category as we have selected
            foreach ($fieldMaps as $map) {
                if ((!$option || !$map->option_id || $option->option_id == $map->option_id ) && $field->field_id == $map->child_id) {
                    continue 2;
                }
            }
            // Add
            $fieldList[] = $field;
            $fieldData[$field->field_id] = $field->label;
        }
        $this->view->fieldList = $fieldList;
        $this->view->fieldData = $fieldData;

        if($cfType == "textarea" || $cfType == "text" || $cfType == "checkbox" || !$cfType){
            $locale = Zend_Registry::get('Locale');
            $currencyName = Zend_Locale_Data::getContent($locale, 'nametocurrency', Engine_Api::_()->estore()->defaultCurrency());



            $form->addElement('Text','price',array(
                'label' => $this->view->translate('Price (In %s)',$currencyName),
                'value'=>0,
            ));
            $form->addElement('Radio','price_type',array(
                'label' => 'Choose Increment / decrement price for this attribute',
                'multiOptions'=>array(
                    '0'=>'Decrement',
                    '1'=>'Increment',
                ),
                'value'=>1,
            ));
            if($cfType != "checkbox") {
                $form->addElement('Text', 'limit', array(
                    'label' => 'Word Limit',
                    'value' => 100,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                ));
            }
        }

        if (count($fieldData) < 1) {
            $this->view->formAlt = null;
        } else {
            $formAlt->getElement('field_id')->setMultiOptions($fieldData);
        }
        // Check method/data
        if (!$this->getRequest()->isPost()) {
            $form->populate($this->_getAllParams());
            return;
        }
        if (!$form->isValid($this->getRequest()->getPost())) {
            return;
        }
        $field = Engine_Api::_()->fields()->createField($this->_fieldType, array_merge(array(
            'option_id' => ( is_object($option) ? $option->option_id : '0' ),
        ), $form->getValues()));
        $this->view->status = true;
        $this->view->field = $field->toArray();
        $this->view->option = is_object($option) ? $option->toArray() : array('option_id' => '0');
        $this->view->form = null;
        // Re-render all maps that have this field as a parent or child
        $maps = array_merge(
            Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $field->field_id), Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $field->field_id)
        );
        $html = array();
        foreach ($maps as $map) {
            $html[$map->getKey()] = $this->view->adminFieldMeta($map);
        }
        $this->view->htmlArr = $html;
    }
    public function fieldEditAction() {

        $field = Engine_Api::_()->fields()->getField($this->_getParam('field_id'), $this->_fieldType);

        // Check type param and get form class
        $cfType = $this->_getParam('type', $field->type);
        $adminFormClass = null;
        if (!empty($cfType)) {
            $adminFormClass = Engine_Api::_()->fields()->getFieldInfo($cfType, 'adminFormClass');
        }

        if (empty($adminFormClass) || !@class_exists($adminFormClass)) {
            $adminFormClass = 'Fields_Form_Admin_Field';
        }

        // Create form
        $this->view->form = $form = new $adminFormClass();
        $form->setAttrib('class','global_form');
        $form->setTitle('Edit Attribute');
        $form->removeElement('show');
        $form->removeElement('search');
        $form->removeElement('style');
        $form->removeElement('error');
        $form->removeElement('required');
        $form->removeElement('search');
        if($cfType == "select"){
            $form->addElement('Hidden','required',array('value'=>1,'order'=>928));
        }
        if($form->execute){
            $form->execute->setLabel('Save Attribute');
        }
        if($cfType == "textarea" || $cfType == "text" || $cfType == "checkbox" || !$cfType){
            $locale = Zend_Registry::get('Locale');
            $currencyName = Zend_Locale_Data::getContent($locale, 'nametocurrency', Engine_Api::_()->estore()->defaultCurrency());

            $form->addElement('Text','price',array(
                'label' => $this->view->translate('Price (In %s)',$currencyName),
                'value'=>0,
            ));
            $form->addElement('Radio','price_type',array(
                'label' => 'Choose Increment / decrement price for this attribute',
                'multiOptions'=>array(
                    '0'=>'Decrement',
                    '1'=>'Increment',
                ),
                'value'=>1,
            ));
            if($cfType != "checkbox" ) {
                $form->addElement('Text', 'limit', array(
                    'label' => 'Word Limit',
                    'value' => 100,
                    'validators' => array(
                        array('Int', true),
                        array('GreaterThan', true, array(0)),
                    )
                ));
            }
        }
        //allowed type
        $allowedType = array('text'=>'Single-line Text Input','textarea'=>'Multi-line Text Input','select'=>'Select Box','radio'=>'Radio Buttons','checkbox'=>'Single Checkbox','multiselect'=>'Multi Select Box','multi_checkbox'=>'Multi Checkbox ');
        $form->type->setMultiOptions($allowedType);
        $form->addElement('hidden', 'show', array('value' => 0));
        $form->removeElement('display');

        // Check method/data
        if (!$this->getRequest()->isPost()) {
            $form->populate($field->toArray());
            $form->populate($this->_getAllParams());
            if (is_array($field->config)) {
                $form->populate($field->config);
            }
            $this->view->search = $field->search;
            if($form->required)
                $form->required->setValue(1);
            return;
        }

        if (!$form->isValid($this->getRequest()->getPost())) {
            return;
        }

        Engine_Api::_()->fields()->editField($this->_fieldType, $field, $form->getValues());
        $this->view->status = true;
        $this->view->field = $field->toArray();
        $this->view->form = null;
        // Re-render all maps that have this field as a parent or child
        $maps = array_merge(Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('field_id', $field->field_id), Engine_Api::_()->fields()->getFieldsMaps($this->_fieldType)->getRowsMatching('child_id', $field->field_id)
        );
        $html = array();
        foreach ($maps as $map) {
            $html[$map->getKey()] = $this->view->adminFieldMeta($map);
        }
        $this->view->htmlArr = $html;
    }

}
