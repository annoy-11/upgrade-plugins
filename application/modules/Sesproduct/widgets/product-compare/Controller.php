<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Widget_ProductCompareController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
      $request = Zend_Controller_Front::getInstance()->getRequest();
      $param = $request->getParams();

    $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('likeCount', 'commentCount', 'viewCount', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel', 'sponsoredLabel', 'favourite', 'creationDate', 'readmore'));

    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
     $profile_types = '';
    $id = !empty($param['id']) ? $param['id'] : 0;
    if(!$id)
        return $this->setNoRender();
      $category = Engine_Api::_()->getItem('sesproduct_category',$id);
    if(!$category)
        return $this->setNoRender();
    $this->view->category_id = $id;

     $subcategories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getModuleSubcategory(array('category_id'=>$category->category_id ,'column_name'=>array('profile_type','category_id')));
    foreach($subcategories as $subcategory) {
        if($subcategory->category_id) {
            $subsubcategories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getModuleSubsubcategory(array('category_id'=>$subcategory->category_id ,'column_name'=>array('profile_type','category_id')));
        foreach($subsubcategories as $subsubcategory) {
            if(!is_null($subsubcategory->profile_type) && $subsubcategory->profile_type != 0)
                $profile_types .= $subsubcategory->profile_type.' , ';
            }
        }
       if(!is_null($subcategory->profile_type) && $subcategory->profile_type != 0)
        $profile_types .= $subcategory->profile_type.' , ';
    }
    $profile_types .= $category->profile_type;

    $this->view->products = $products = Engine_Api::_()->getItemMulti('sesproduct',$_SESSION["sesproduct_add_to_compare"][$id]);

      $db = Zend_Db_Table_Abstract::getDefaultAdapter();
      $view = $this->view;
      $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
      $productCustomFields = array();
      //get products custom fields
      foreach($products as $product){
          $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($product);
          if( count($fieldStructure) <= 1 ) {
              continue;
          }
          $productCustomFields[$product->getIdentity()] = $this->view->sesproductArrayFieldValueLoop($product,$fieldStructure);
      }
      $this->view->productCustomFields = $productCustomFields;


      $this->view->profile_fileds = $db->query("SELECT label,type FROM engine4_sesproduct_fields_maps LEFT JOIN engine4_sesproduct_fields_meta
     ON engine4_sesproduct_fields_maps.child_id = engine4_sesproduct_fields_meta.field_id WHERE option_id IN( ".$profile_types . ") ORDER BY engine4_sesproduct_fields_maps.`order`")->fetchAll();


  }
}
