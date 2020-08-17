<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminReviewCategoriesController.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_AdminReviewCategoriesController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_rwsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main_rwsettings', array(), 'seslisting_admin_main_revwcat');
    $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main_revwcat', array(), 'seslisting_admin_main_review_subcategories');
    //profile types
    $profiletype = array();
    $topStructure = Engine_Api::_()->fields()->getFieldStructureTop('seslistingreview');
    if (count($topStructure) == 1 && $topStructure[0]->getChild()->type == 'profile_type') {
      $profileTypeField = $topStructure[0]->getChild();
      $options = $profileTypeField->getOptions();
      $options = $profileTypeField->getElementParams('seslisting_event');
      unset($options['options']['order']);
      unset($options['options']['multiOptions']['0']);
      $profiletype = $options['options']['multiOptions'];
    }
    $this->view->profiletypes = $profiletype;
    //Get all categories
    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'seslisting')->getCategory(array('column_name' => '*', 'profile_type' => true));
  }

  //Edit Category
  public function editCategoryAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_rwsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main_rwsettings', array(), 'seslisting_admin_main_revwcat');
    $this->view->subsubNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main_revwcat', array(), 'seslisting_admin_main_review_subcategories');

    $this->view->form = $form = new Seslisting_Form_Admin_Review_Category_Edit();

    $category = Engine_Api::_()->getItem('seslisting_category', $this->_getParam('id'));
    $form->populate($category->toArray());
    if ($category->subcat_id == 0 && $category->subsubcat_id == 0) {
      $form->setTitle('Edit This Category');
    } elseif ($category->subcat_id != 0) {
      $form->setTitle('Edit This 2nd-level Category');
    } elseif ($catparam == 'subsub') {
      $form->setTitle('Edit This 3rd-level Category');
    }

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $category->profile_type_review = isset($_POST['profile_type_review']) ? $_POST['profile_type_review'] : '';
      $category->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('module' => 'seslisting', 'action' => 'index', 'controller' => 'review-categories'), 'admin_default', true);
  }
	public function reviewParameterAction(){
		$category_id = $this->_getParam('id',null);
		if(!$category_id)
			return $this->_forward('notfound', 'error', 'core');
		// In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $viewer = Engine_Api::_()->user()->getViewer();
   $this->view->form =  $form = new Seslisting_Form_Admin_Parameter_Add();
	 $reviewParameters = Engine_Api::_()->getDbtable('parameters', 'seslisting')->getParameterResult(array('category_id'=>$category_id));
	 if(!count($reviewParameters))
	  $form->setTitle('Add Review Parameters');
	 else{
	 	 $form->setTitle('Edit Review Parameters');
		 $form->submit->setLabel('Edit');
	 }
    $form->setDescription("");
		 if( !$this->getRequest()->isPost() ) {
		 	return;
		 }
      $table = Engine_Api::_()->getDbtable('parameters', 'seslisting');
			$tablename = $table->info('name');
      try {
				$values = $form->getValues();
				unset($values['addmore']);
				$dbObject = Engine_Db_Table::getDefaultAdapter();
				$deleteIds = explode(',',$_POST['deletedIds']);
				foreach($deleteIds as $val){
					if(!$val)
						continue;
					$query = 'DELETE FROM '.$tablename.' WHERE parameter_id = '.$val;
					$dbObject->query($query);
				}
				foreach($_POST as $key=>$value){
						if(count(explode('_',$key)) != 3 || !$value)
							continue;
						$id = str_replace('seslisting_review_','',$key);
						$query = 'UPDATE '.$tablename.' SET title = "'.$value .'" WHERE parameter_id = '.$id;
						$dbObject->query($query);
				}
				foreach($_POST['parameters'] as $val){
					$query = 'INSERT IGNORE INTO '.$tablename.' (`parameter_id`, `category_id`, `title`, `rating`) VALUES ("","'.$category_id.'","'.$val.'","0")';
					$dbObject->query($query);
				}
		}
		catch( Exception $e ) {
			throw $e;
		}
    $this->view->message = Zend_Registry::get('Zend_Translate')->_("Review Parameters have been saved.");
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array($this->view->message)
    ));
	}
}
