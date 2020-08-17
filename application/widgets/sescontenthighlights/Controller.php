<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Widget_SescontenthighlightsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

// 	$this->view->contentbackgroundcolor = $this->_getParam('contentbackgroundcolor', '2fc581');
//     $this->view->heading = $this->_getParam('title', '');
//     $this->view->widgetdescription = $this->_getParam('widgetdescription', '');
//     $this->view->design = $design = $this->_getParam('highlight_design', '1');
//     $this->view->module = $module = $this->_getParam('highlight_module', '');
//     $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');
// 		if(!$this->view->module)
// 		 $this->setNoRender();
// 		if($design == 2)
// 			$limit = 6;
// 		elseif($design == 1)
// 			$limit = 5;
// 		else $limit = 15;
//
//     $table = Engine_Api::_()->getItemTable($module);
//     $tableName = $table->info('name');
//     $select = $table->select()->from($tableName)->limit($limit);
//     $db = Zend_Db_Table_Abstract::getDefaultAdapter();
//
// 	$popularitycriteria_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE '".$popularitycriteria."'")->fetch();
// 		if (!empty($popularitycriteria_exist)) {
// 			$select->order("$popularitycriteria DESC");
// 		} else {
// 			$select->order('creation_date DESC');
// 		}
// 			$column_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE 'is_delete'")->fetch();
// 		if (!empty($column_exist)) {
// 			$select->where('is_delete =?',0);
// 		}
//
//       $this->view->result = $result = $table->fetchAll($select);
//       if(!count($result))
//         $this->setNoRender();
  }
}
