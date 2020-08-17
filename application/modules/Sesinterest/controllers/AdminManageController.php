<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_AdminManageController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesinterest_admin_main', array(), 'sesinterest_admin_main_manageinterests');

        $this->view->formFilter = $formFilter = new Sesinterest_Form_Admin_Filter();
        $page = $this->_getParam('page', 1);

        // Process form
        $values = array();
        if ($formFilter->isValid($this->_getAllParams()))
            $values = $formFilter->getValues();

        foreach ($values as $key => $value) {
            if (null === $value) {
                unset($values[$key]);
            }
        }

        $interests = Engine_Api::_()->getDbtable('interests', 'sesinterest')->getResults(array('column_name' => '*', 'approved' => $values['approved'], 'interest_name' => $values['interest_name']));

        $this->view->paginator = $paginator = Zend_Paginator::factory($interests);
        $this->view->paginator = $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
    }

    public function addAction() {

        $this->_helper->layout->setLayout('admin-simple');
        $this->view->interest_id = $this->_getParam('interest_id');

        //Generate and assign form
        $this->view->form = $form = new Sesinterest_Form_Admin_Interest_Add();
        $form->setTitle('Add New Interest');
        $form->interest_name->setLabel('Interest Name');
        $form->interest_name->setDescription('Enter interests seprate by comma.');

        //Check post
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

            $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
            $values = $form->getValues();
            $values['created_by'] = '1';
            $values['approved'] = '1';
            $values['user_id'] = $viewer_id;

            $table = Engine_Api::_()->getDbTable('interests', 'sesinterest');
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {

                $interest_names = preg_split('/[,]+/', $values['interest_name']);
                foreach($interest_names as $interest_name) {
                    if(empty($interest_name)) continue;
                    $isExist = $table->isExist(array('interest_name' => $interest_name, 'user_id' => $viewer_id));
                    if(empty($isExist)) {
                        $values['interest_name'] = $interest_name;
                        $row = $table->createRow();
                        $row->setFromArray($values);
                        $row->save();
                    }
                }
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            return $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array('You have successfully added interest.')
            ));
        }
    }

    public function editAction() {

        $this->_helper->layout->setLayout('admin-simple');
        $this->view->form = $form = new Sesinterest_Form_Admin_Interest_Edit();
        $form->setTitle('Edit This Interest');
        $form->interest_name->setLabel('Interest Name');

        $interests = Engine_Api::_()->getItem('sesinterest_interest', $this->_getParam('id'));
        $form->populate($interests->toArray());

        //Check post
        if (!$this->getRequest()->isPost())
            return;

        //Check
        if (!$form->isValid($this->getRequest()->getPost())) {
            if (empty($_POST['interest_name'])) {
                $form->addError($this->view->translate("Interest Name * Please complete this field - it is required."));
            }
            return;
        }

        $values = $form->getValues();
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {

            $interests->interest_name = $values['interest_name'];
            $interests->save();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        return $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('You have successfully edit interest.')
        ));
    }

    public function deleteAction() {

        $this->_helper->layout->setLayout('admin-simple');
        $this->view->id = $id = $this->_getParam('id');

        $interestsTable = Engine_Api::_()->getDbtable('interests', 'sesinterest');
        $interests = $interestsTable->find($id)->current();

        //Check post
        if ($this->getRequest()->isPost()) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $interests->delete();
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            return $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array('You have successfully delete interest.')
            ));
        }
        //Output
        $this->renderScript('admin-manage/delete.tpl');
    }

    public function approvedAction() {

        $interest_id = $this->_getParam('id');
        if (!empty($interest_id)) {
            $item = Engine_Api::_()->getItem('sesinterest_interest', $interest_id);
            $item->approved = !$item->approved;
            $item->save();
        }
        $this->_redirect("admin/sesinterest/manage/index/");
    }
}
