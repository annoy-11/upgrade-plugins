<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_IndexController extends Core_Controller_Action_Standard {

    public function interestsAction() {

        if (!$this->_helper->requireUser()->isValid())
            return;

        $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

        if (!Engine_Api::_()->core()->hasSubject()) {
            // Can specifiy custom id
            $id = $this->_getParam('user_id', null);
            $subject = null;
            if (null === $id) {
                $subject = Engine_Api::_()->user()->getViewer();
                Engine_Api::_()->core()->setSubject($subject);
            } else {
                $subject = Engine_Api::_()->getItem('user', $id);
                Engine_Api::_()->core()->setSubject($subject);
            }
        }
        if ($id) {
            $params = array('id' => $id);
        } else {
            $params = array();
        }

        $this->view->user = $user = Engine_Api::_()->getItem('user', $subject->getIdentity());

        $table = Engine_Api::_()->getDbTable('userinterests', 'sesinterest');
        $interestTable = Engine_Api::_()->getDbTable('interests', 'sesinterest');

        // Set up navigation
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_edit', array('params' => $params));
        $this->view->form = $form = new Sesinterest_Form_Interests();

//         $intStr = '';
//         $interests = $table->getUserInterests(array('user_id' => $user->getIdentity()));
//         foreach( $interests as $interest ) {
//             //$tag = $tagMap->getTag();
//             if( !isset($interest->interest_name) ) continue;
//             if( '' !== $intStr ) $intStr .= ', ';
//             $intStr .= $interest->interest_name;
//         }
//         $form->populate(array('custom_interests' => $intStr));

        // Check if post
        if( !$this->getRequest()->isPost() ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Not post');
            return;
        }

        if( !$form->isValid($this->getRequest()->getPost()) ) {
            $this->view->status = false;
            $this->view->error =  Zend_Registry::get('Zend_Translate')->_('Invalid data');
            return;
        }

        if ($this->getRequest()->getPost()) {

            $values = $form->getValues();

            Engine_Api::_()->getDbtable('userinterests', 'sesinterest')->delete(array('user_id =?' => $user->getIdentity()));
            if(!empty($values['custom_interests'])) {
                $custom_interests = explode(',', $values['custom_interests']);
                foreach($custom_interests as $custom_interest) {
                    if(empty($custom_interest)) continue;
                    $interest_id = $interestTable->getColumnName(array('column_name' => 'interest_id', 'interest_name' => $custom_interest));
                    if(empty($interest_id)) {
                        $values['interest_name'] = $custom_interest;
                        $values['approved'] = '1';
                        $values['created_by'] = '0';
                        $values['user_id'] = $user->getIdentity();

                        $row = $interestTable->createRow();
                        $row->setFromArray($values);
                        $row->save();

                        //Entry in Userinterest table
                        $valuesUser['interest_name'] = $custom_interest;
                        $valuesUser['interest_id'] = $row->getIdentity();
                        $valuesUser['user_id'] = $user->getIdentity();
                        $rowUser = $table->createRow();
                        $rowUser->setFromArray($valuesUser);
                        $rowUser->save();
                    } else {
                        //Entry in Userinterest table
                        $valuesUser['interest_name'] = $custom_interest;
                        $valuesUser['interest_id'] = $interest_id;
                        $valuesUser['user_id'] = $user->getIdentity();
                        $rowUser = $table->createRow();
                        $rowUser->setFromArray($valuesUser);
                        $rowUser->save();
                    }
                }
            }

            $values['user_id'] = $user->getIdentity();
            //Engine_Api::_()->getDbtable('userinterests', 'sesinterest')->delete(array('user_id =?' => $user->getIdentity()));
            foreach($values['interests'] as $interest) {

                $getColumnName = $interestTable->getColumnName(array('column_name' => 'interest_name', 'interest_id' => $interest));
                $values['interest_name'] = $getColumnName;
                $values['interest_id'] = $interest;

                $row = $table->createRow();
                $row->setFromArray($values);
                $row->save();

            }
            $form->addNotice(Zend_Registry::get('Zend_Translate')->_('Your changes have been saved.'));
            return $this->_helper->redirector->gotoRoute(array());
        }
    }

    public function deleteAction() {

        $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->userinterest_id = $userinterest_id = $this->_getParam('userinterest_id');
        $userinterest = Engine_Api::_()->getItem('sesinterest_userinterest', $userinterest_id);

        if(!$is_ajax) {
            $this->view->form = $form = new Sesinterest_Form_Delete();
        }

        if($is_ajax) {
            $db = $userinterest->getTable()->getAdapter();
            $db->beginTransaction();
            try {
                $userinterest->delete();
                $db->commit();
            } catch( Exception $e ) {
                $db->rollBack();
                throw $e;
                echo 0;die;
            }
        }
    }

    public function suggestAction() {

        $sesdata = array();
        $table = Engine_Api::_()->getDbtable('interests', 'sesinterest');
        $select = $table->select()
                        ->where('interest_name  LIKE ? ', '%' . $this->_getParam('text') . '%')
                        ->order('interest_name ASC')->limit('40');
        $results = $table->fetchAll($select);

        foreach ($results as $result) {
            $sesdata[] = array(
                'id' => $result->interest_id,
                'label' => $result->interest_name,
            );
        }
        return $this->_helper->json($sesdata);
    }

}
