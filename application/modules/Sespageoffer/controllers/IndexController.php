<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_IndexController extends Core_Controller_Action_Standard {

    public function init() {
        $id = $this->_getParam('pageoffer_id', $this->_getParam('pageoffer_id', null));
            if ($id && intval($id)) {
            $offer = Engine_Api::_()->getItem('pageoffer', $id);
            if ($offer) {
                Engine_Api::_()->core()->setSubject($offer);
            }
        }
    }

	public function browseAction() {
        // Render
        $this->_helper->content->setEnabled();
	}

    public function homeAction() {
        //Render
        $this->_helper->content->setEnabled();
    }

    public function getofferAction() {

        $viewer = Engine_Api::_()->user()->getViewer();
        $parent_id = $this->_getParam('parent_id', null);
        $resource = Engine_Api::_()->getItem('sespage_page', $parent_id);
        $offer = Engine_Api::_()->getItem('pageoffer', $this->_getParam('pageoffer_id'));
        if( !$offer ) {
            Engine_Api::_()->core()->setSubject($offer);
        }

        $claimsTable = Engine_Api::_()->getDbTable('claims', 'sespageoffer');
        $claim = $claimsTable->createRow();
        $claim->resource_id = $offer->getIdentity();
        $claim->user_id = $viewer->getIdentity();
        $claim->save();

        $offer->claimed_count++;
        $offer->save();

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($viewer, 'sespageoffer_getoffer', array('sender_title' => $offer->getOwner()->getTitle(), 'object_link' => $offer->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'couponcode' => $offer->couponcode));
    }

    public function viewAction()
    {
        // Check permission
        $viewer = Engine_Api::_()->user()->getViewer();
        $offer = Engine_Api::_()->getItem('pageoffer', $this->_getParam('pageoffer_id'));
        if( !$offer ) {
            Engine_Api::_()->core()->setSubject($offer);
        }

        if( !$this->_helper->requireSubject()->isValid() ) {
            return;
        }

        if( !$this->_helper->requireAuth()->setAuthParams($offer, $viewer, 'view')->isValid() ) {
            return;
        }

        if( !$offer || !$offer->getIdentity() || ($offer->draft && !$offer->isOwner($viewer)) ) {
            return $this->_helper->requireSubject->forward();
        }

        /* Insert data for recently viewed widget */
        if ($viewer->getIdentity() != 0) {
            $dbObject = Engine_Db_Table::getDefaultAdapter();
            $dbObject->query('INSERT INTO engine4_sespage_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $offer->getIdentity() . '", "' . $offer->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
        }

        // Prepare data
        $offerTable = Engine_Api::_()->getDbtable('pageoffers', 'sespageoffer');
        if( !$offer->isOwner($viewer) ) {
            $offerTable->update(array('view_count' => new Zend_Db_Expr('view_count + 1')), array('pageoffer_id = ?' => $offer->getIdentity()));
        }

        // Render
        $this->_helper->content->setEnabled();
    }

    public function deleteAction() {

        $viewer = Engine_Api::_()->user()->getViewer();
        $offer = Engine_Api::_()->getItem('pageoffer', $this->getRequest()->getParam('pageoffer_id'));
        if( !$this->_helper->requireAuth()->setAuthParams($offer, null, 'delete')->isValid()) return;

        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');

        $this->view->form = $form = new Sespageoffer_Form_Delete();

        if( !$offer ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Offer entry doesn't exist or not authorized to delete");
            return;
        }

        if( !$this->getRequest()->isPost() ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

        $db = $offer->getTable()->getAdapter();
        $db->beginTransaction();

        try {
            Engine_Api::_()->getApi('core', 'sespageoffer')->deleteOffer($offer);
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your offer entry has been deleted.');

        $parentItem = Engine_Api::_()->getItem('sespage_page', $this->_getParam('parent_id', null));

        $widgetId = Engine_Api::_()->sespage()->getIdentityWidget('sespageoffer.profile-offers','widget','sespage_profile_index_'.$parentItem->pagestyle);
        if($widgetId)
            $widgetId = '/tab/'.$widgetId;
        else
            $widgetId = '';

        $url = $parentItem->getHref().$widgetId;

        return $this->_forward('success' ,'utility', 'core', array(
            'parentRedirect' => $url,
            'messages' => Array($this->view->message)
        ));
    }


    public function editAction() {

        if( !$this->_helper->requireUser()->isValid() ) return;

        // Render
        $this->_helper->content->setEnabled();

        $viewer = Engine_Api::_()->user()->getViewer();

        // Get navigation
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
        ->getNavigation('sespage_main');

        $offer = Engine_Api::_()->getItem('pageoffer', $this->_getParam('pageoffer_id'));
        if( !Engine_Api::_()->core()->hasSubject('pageoffer') ) {
            Engine_Api::_()->core()->setSubject($offer);
        }

        $parent_id = $this->_getParam('parent_id', null);
        if(empty($parent_id))
            return;

        $this->view->parentItem = $parentItem = Engine_Api::_()->getItem('sespage_page', $parent_id);

        if( !$this->_helper->requireSubject()->isValid() ) return;
        if( !$this->_helper->requireAuth()->setAuthParams($offer, $viewer, 'edit')->isValid() ) return;

        // Prepare form
        $this->view->form = $form = new Sespageoffer_Form_Edit();

        // Populate form
        $form->populate($offer->toArray());

        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

        foreach( $roles as $role ) {
            if ($form->auth_view){
                if( $auth->isAllowed($offer, $role, 'view') ) {
                    $form->auth_view->setValue($role);
                }
            }

            if ($form->auth_comment){
                if( $auth->isAllowed($offer, $role, 'comment') ) {
                    $form->auth_comment->setValue($role);
                }
            }
        }

        // hide status change if it has been already published
        if( $offer->draft == "0" ) {
            $form->removeElement('draft');
        }

        // Check post/form
        if( !$this->getRequest()->isPost() ) {
            return;
        }

        if( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }

        // Process
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();

        try {
            $values = $form->getValues();

            if( empty($values['auth_view']) ) {
                $values['auth_view'] = 'everyone';
            }
            if( empty($values['auth_comment']) ) {
                $values['auth_comment'] = 'everyone';
            }

            $values['view_privacy'] = $values['auth_view'];
            $values['parent_id'] = $parent_id;

            $offer->setFromArray($values);
            $offer->modified_date = date('Y-m-d H:i:s');
            $offer->save();

            // Add photo
            if( !empty($values['photo']) ) {
                $offer->setPhoto($form->photo);
            }

            // Auth
            $viewMax = array_search($values['auth_view'], $roles);
            $commentMax = array_search($values['auth_comment'], $roles);

            foreach( $roles as $i => $role ) {
                $auth->setAllowed($offer, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($offer, $role, 'comment', ($i <= $commentMax));
            }

            // insert new activity if pageoffer is just getting published
            $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($offer);
            if( count($action->toArray()) <= 0 && $values['draft'] == '0' ) {
                $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $offer, 'sespageoffer_new');
                // make sure action exists before attaching the pageoffer to the activity
                if( $action != null ) {
                    Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $offer);
                }
            }

            // Rebuild privacy
            $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
            foreach( $actionTable->getActionsByObject($offer) as $action ) {
                $actionTable->resetActivityBindings($action);
            }
            $db->commit();
        } catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }
        return $this->_helper->redirector->gotoRoute(array('action' => 'view',  'pageoffer_id' => $offer->getIdentity(), 'slug' => $offer->getSlug()), 'sespageoffer_view', true);
    }

    public function createAction() {

        if (!$this->_helper->requireUser->isValid())
        return;

        if( !$this->_helper->requireAuth()->setAuthParams('pageoffer', null, 'create')->isValid()) return;
        $parent_id = $this->_getParam('parent_id', null);
        if(empty($parent_id))
            return;

        $this->view->parentItem = $parentItem = Engine_Api::_()->getItem('sespage_page', $parent_id);

        $getPageRolePermission = Engine_Api::_()->sespage()->getPageRolePermission($parentItem->getIdentity(),'post_content','offer',false);

        $allowed = true;
        $canUpload = $getPageRolePermission ? $getPageRolePermission : $parentItem->authorization()->isAllowed($viewer, 'offer');
        $canUpload = !$allowed ? false : $canUpload;
        if(!$canUpload)
            return $this->_forward('notfound', 'error', 'core');

        // Render
        $this->_helper->content->setEnabled();

        // set up data needed to check quota
        $viewer = Engine_Api::_()->user()->getViewer();
        $values['user_id'] = $viewer->getIdentity();
        $values['parent_id'] = $parent_id;
//         $paginator = Engine_Api::_()->getItemTable('pageoffer')->getOffersPaginator($values);
//
//         $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'pageoffer', 'max');
//         $this->view->current_count = $paginator->getTotalItemCount();

        // Prepare form
        $this->view->form = $form = new Sespageoffer_Form_Create();

        // If not post or form not valid, return
        if( !$this->getRequest()->isPost() ) {
            return;
        }

        if( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }

        // Process
        $table = Engine_Api::_()->getItemTable('pageoffer');
        $db = $table->getAdapter();
        $db->beginTransaction();

        try {
        // Create pageoffer
        $viewer = Engine_Api::_()->user()->getViewer();
        $formValues = $form->getValues();

        if( empty($formValues['auth_view']) ) {
            $formValues['auth_view'] = 'everyone';
        }

        if( empty($formValues['auth_comment']) ) {
            $formValues['auth_comment'] = 'everyone';
        }

        $values = array_merge($formValues, array(
            'owner_type' => $viewer->getType(),
            'owner_id' => $viewer->getIdentity(),
            'parent_id' => $parent_id,
            'view_privacy' => $formValues['auth_view'],
        ));

        $offer = $table->createRow();
        $offer->setFromArray($values);
        $offer->save();

        if( !empty($values['photo']) ) {
            $offer->setPhoto($form->photo);
        }

        // Auth
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

        $viewMax = array_search($formValues['auth_view'], $roles);
        $commentMax = array_search($formValues['auth_comment'], $roles);

        foreach( $roles as $i => $role ) {
            $auth->setAllowed($offer, $role, 'view', ($i <= $viewMax));
            $auth->setAllowed($offer, $role, 'comment', ($i <= $commentMax));
        }

        // Add activity only if pageoffer is published
        if( $values['draft'] == 0 ) {
            $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $parentItem, 'sespageoffer_new');
            // make sure action exists before attaching the pageoffer to the activity
            if( $action ) {
                Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $offer);
            }
        }
        // Commit
        $db->commit();
        } catch( Exception $e ) {
            return $this->exceptionWrapper($e, $form, $db);
        }

        $widgetId = Engine_Api::_()->sespage()->getIdentityWidget('sespageoffer.profile-offers','widget','sespage_profile_index_'.$parentItem->pagestyle);
        if($widgetId)
        $widgetId = '/tab/'.$widgetId;
        else
        $widgetId = '';

        $url = $parentItem->getHref().$widgetId;
        header("location:".$url);
    }
}
