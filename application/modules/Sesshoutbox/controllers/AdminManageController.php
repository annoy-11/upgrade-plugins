<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshoutbox_AdminManageController extends Core_Controller_Action_Admin {

    public function indexAction() {

        if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $value) {
                if ($key == 'delete_' . $value) {
                    $shoutbox = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $value);
                    $shoutbox->delete();
                }
            }
        }
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesshoutbox_admin_main', array(), 'sesshoutbox_admin_main_manage');

        $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('shoutboxs', 'sesshoutbox')->getDbshoutboxPaginator('show_all');

        $page = $this->_getParam('page', 1);

        $paginator->setItemCountPerPage(1000);

        $paginator->setCurrentPageNumber($page);
    }

    public function createAction() {

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
                ->getNavigation('sesshoutbox_admin_main', array(), 'sesshoutbox_admin_main_manage');

        $this->view->shoutbox_id = $shoutbox_id = $this->_getParam('shoutbox_id', false);

        $this->view->form = $form = new Sesshoutbox_Form_Admin_Create();
        if ($shoutbox_id) {
            $form->submit->setLabel('Save Changes');
            $form->setTitle("Edit Shoutbox");
            $form->setDescription("Below, edit the details for the Shoutbox.");
            $this->view->shoutbox = $shoutbox = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $shoutbox_id);
            $values = $shoutbox->toArray();
            $values['member_level_view_privacy'] = (explode(",", $shoutbox->member_level_view_privacy));
            $values['network_view_privacy'] = (explode(",", $shoutbox->network_view_privacy));
            $form->populate($values);
        }
        if ($this->getRequest()->isPost()) {
            if (!$form->isValid($this->getRequest()->getPost()))
                return;
            $db = Engine_Api::_()->getDbtable('shoutboxs', 'sesshoutbox')->getAdapter();
            $db->beginTransaction();
            try {
                $table = Engine_Api::_()->getDbtable('shoutboxs', 'sesshoutbox');
                $values = $form->getValues();


                $member_level_view_privacy = implode(",", $values['member_level_view_privacy']);
                $network_view_privacy = implode(",", $values['network_view_privacy']);
                $values['member_level_view_privacy'] = $member_level_view_privacy;
                $values['network_view_privacy'] = $network_view_privacy;
                if (!isset($shoutbox)){
                    $shoutbox = $table->createRow();
                    $shoutbox->status = '1';
                }
                $shoutbox->setFromArray($values);
                $shoutbox->save();

                $db->commit();
                if(!$shoutbox_id){
                  $shoutbox->order = $shoutbox->shoutbox_id;
                  $shoutbox->save();
                  $shoutboxId = $shoutbox->shoutbox_id;
                }else{
                  $shoutboxId = $shoutbox_id;
                }
                return $this->_helper->redirector->gotoRoute(array('module' => 'sesshoutbox', 'controller' => 'manage'), 'admin_default', true);
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
        }
    }

    public function deleteAction() {

        $this->_helper->layout->setLayout('admin-simple');
        $id = $this->_getParam('id');
        if ($this->getRequest()->isPost()) {
            $shoutbox = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $id);
            $shoutbox->delete();

            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array('Shoutbox Delete Successfully.')
            ));
        }
        // Output
        $this->renderScript('admin-manage/delete.tpl');
    }

    public function enabledAction() {
        $id = $this->_getParam('id');
        if (!empty($id)) {
            $item = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $id);
            $item->status = !$item->status;
            $item->save();
        }
        $this->_redirect('admin/sesshoutbox/manage');
    }

    public function orderAction() {
        if (!$this->getRequest()->isPost())
            return;
        $shoutboxsTable = Engine_Api::_()->getDbtable('shoutboxs', 'sesshoutbox');
        $shoutboxs = $shoutboxsTable->fetchAll($shoutboxsTable->select());
        foreach ($shoutboxs as $shoutbox) {
            $order = $this->getRequest()->getParam('shoutbox_' . $shoutbox->shoutbox_id);
            if (!$order)
                $order = 999;
            $shoutbox->order = $order;
            $shoutbox->save();
        }
        return;
    }
}
