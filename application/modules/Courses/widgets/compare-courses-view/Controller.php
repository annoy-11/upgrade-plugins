<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Widget_CompareCoursesViewController extends Engine_Content_Widget_Abstract {

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
      $category = Engine_Api::_()->getItem('courses_category',$id);
    if(!$category)
        return $this->setNoRender();
    $this->view->category_id = $id;
     $subcategories = Engine_Api::_()->getDbtable('categories', 'courses')->getModuleSubcategory(array('category_id'=>$category->category_id ,'column_name'=>array('profile_type','category_id')));
    foreach($subcategories as $subcategory) {
        if($subcategory->category_id) {
            $subsubcategories = Engine_Api::_()->getDbtable('categories', 'courses')->getModuleSubsubcategory(array('category_id'=>$subcategory->category_id ,'column_name'=>array('profile_type','category_id')));
        foreach($subsubcategories as $subsubcategory) {
            if(!is_null($subsubcategory->profile_type) && $subsubcategory->profile_type != 0)
                $profile_types .= $subsubcategory->profile_type.' , ';
            }
        }
       if(!is_null($subcategory->profile_type) && $subcategory->profile_type != 0)
        $profile_types .= $subcategory->profile_type.' , ';
    }
    $courses_widgets = Zend_Registry::isRegistered('courses_widgets') ? Zend_Registry::get('courses_widgets') : null;
    if(empty($courses_widgets))
      return $this->setNoRender();
    $profile_types .= $category->profile_type;
    if(!isset($_SESSION["courses_add_to_compare"]))
        return $this->setNoRender();
    $this->view->courses = $courses = Engine_Api::_()->getItemMulti('courses',$_SESSION["courses_add_to_compare"][$id]);
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $view = $this->view;
    $view->addHelperPath(APPLICATION_PATH . '/application/modules/Fields/View/Helper', 'Fields_View_Helper');
    $courseCustomFields = array();
    //get courses custom fields
    foreach($courses as $course){
        $fieldStructure = Engine_Api::_()->fields()->getFieldsStructurePartial($course);
        if( count($fieldStructure) <= 1 ) {
            continue;
        }
        $courseCustomFields[$course->getIdentity()] = $this->view->coursesArrayFieldValueLoop($course,$fieldStructure);
    }
    $this->view->courseCustomFields = $courseCustomFields;
    $this->view->profile_fileds = $db->query("SELECT label,type FROM engine4_courses_fields_maps LEFT JOIN engine4_courses_fields_meta
    ON engine4_courses_fields_maps.child_id = engine4_courses_fields_meta.field_id WHERE option_id IN( ".$profile_types . ") ORDER BY engine4_courses_fields_maps.`order`")->fetchAll();
  }

}
