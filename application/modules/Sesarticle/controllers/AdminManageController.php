<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesarticle_AdminManageController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesarticle_admin_main', array(), 'sesarticle_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sesarticle_Form_Admin_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesarticle = Engine_Api::_()->getItem('sesarticle', $value);
					Engine_Api::_()->sesarticle()->deleteArticle($sesarticle);
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
    'order' => isset($_GET['order']) ? $_GET['order'] :'',
    'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $articleTable = Engine_Api::_()->getDbTable('sesarticles', 'sesarticle');
    $articleTableName = $articleTable->info('name');
    $select = $articleTable->select()
    ->setIntegrityCheck(false)
    ->from($articleTableName)
    ->joinLeft($tableUserName, "$articleTableName.owner_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'article_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($articleTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');
    
     if (!empty($_GET['category_id']))
      $select->where($articleTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($articleTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($articleTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
    $select->where($articleTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
    $select->where($articleTableName . '.sponsored = ?', $_GET['sponsored']);
		
		if (isset($_GET['package_id']) && $_GET['package_id'] != '')
    $select->where($articleTableName . '.package_id = ?', $_GET['package_id']);
    
    if (isset($_GET['status']) && $_GET['status'] != '')
    $select->where($articleTableName . '.draft = ?', $_GET['status']);
		
		if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    	$select->where($articleTableName . '.is_approved = ?', $_GET['is_approved']);
		
    if (isset($_GET['verified']) && $_GET['verified'] != '')
    $select->where($articleTableName . '.verified = ?', $_GET['verified']);
    
    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
    $select->where($articleTableName . '.offtheday = ?', $_GET['offtheday']);
    
    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
      $select->where($articleTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
      $select->where($articleTableName . '.rating = ?', $_GET['rating']);
      endif;
    }

    if (!empty($_GET['creation_date']))
    $select->where($articleTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');
    
		if (isset($_GET['subcat_id'])) {
			$formFilter->subcat_id->setValue($_GET['subcat_id']);
			$this->view->category_id = $_GET['category_id'];
		}

    if (isset($_GET['subsubcat_id'])) {
			$formFilter->subsubcat_id->setValue($_GET['subsubcat_id']);
			$this->view->subcat_id = $_GET['subcat_id'];
    }

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  
  public function claimAction() {
  
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesarticle_admin_main', array(), 'sesarticle_admin_main_claim');

    $this->view->formFilter = $formFilter = new Sesarticle_Form_Admin_Claim_Filter();
      
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesarticleClaim = Engine_Api::_()->getItem('sesarticle_claim', $value);
          $sesarticleClaim->delete();
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
    'order' => isset($_GET['order']) ? $_GET['order'] :'',
    'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $articleClaimTable = Engine_Api::_()->getDbTable('claims', 'sesarticle');
    $articleClaimTableName = $articleClaimTable->info('name');
    $select = $articleClaimTable->select()
    ->setIntegrityCheck(false)
    ->from($articleClaimTableName)
    ->joinLeft($tableUserName, "$articleClaimTableName.user_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'claim_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($articleClaimTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    $select->where($articleClaimTableName . '.status = ?', $_GET['is_approved']);

    if (!empty($_GET['creation_date']))
    $select->where($articleClaimTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->article_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try
      {
        $sesarticle = Engine_Api::_()->getItem('sesarticle', $id);
        // delete the sesarticle entry into the database
        Engine_Api::_()->sesarticle()->deleteArticle($sesarticle);
        $db->commit();
      }

      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('')
      ));
    }

    // Output
    $this->renderScript('admin-manage/delete.tpl');
  }
  
  //Approved Action
  public function approvedAction() {
    $article_id = $this->_getParam('id');
    if (!empty($article_id)) {
      $sesarticle = Engine_Api::_()->getItem('sesarticle', $article_id);
      $sesarticle->is_approved = !$sesarticle->is_approved;
      $sesarticle->save();
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($sesarticle);
      if(count($action->toArray()) <= 0 && (!$sesarticle->publish_date || strtotime($sesarticle->publish_date) <= time())) {
        $viewer = Engine_Api::_()->getItem('user', $sesarticle->owner_id);
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesarticle, 'sesarticle_new');
        // make sure action exists before attaching the sesblog to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesarticle);
        }
      }
    }
    $this->_redirect('admin/sesarticle/manage');
  }
  
  //Featured Action
  public function featuredAction() {
  
    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('sesarticle', $event_id);
      $event->featured = !$event->featured;
      $event->save();
    }
    $this->_redirect('admin/sesarticle/manage');
  }
  

  //Sponsored Action
  public function sponsoredAction() {
  
    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('sesarticle', $event_id);
      $event->sponsored = !$event->sponsored;
      $event->save();
    }
    $this->_redirect('admin/sesarticle/manage');
  }

  //Verify Action
  public function verifyAction() {
  
    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('sesarticle', $event_id);
      $event->verified = !$event->verified;
      $event->save();
    }
    $this->_redirect('admin/sesarticle/manage');
  }
  
  public function ofthedayAction() {
  
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Sesarticle_Form_Admin_Oftheday();
    $item = Engine_Api::_()->getItem('sesarticle', $id);
    $form->setTitle("Article of the Day");
    $form->setDescription('Here, choose the start date and end date for this article to be displayed as "Article of the Day".');
    if (!$param)
      $form->remove->setLabel("Remove as Article of the Day");
    
    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost())) 
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d',  strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update('engine4_sesarticle_articles', array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array("article_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_sesarticle_articles', array('offtheday' => 0), array("article_id = ?" => $id));
      } else {
        $db->update('engine4_sesarticle_articles', array('offtheday' => 1), array("article_id = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }
  
  public function showDetailAction() {
    $claimId = $this->_getParam('id');
    $this->view->claimItem = Engine_Api::_()->getItem('sesarticle_claim', $claimId);
  }
  
  public function approveClaimAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $claimId = $this->_getParam('id');
    $claimItem = Engine_Api::_()->getItem('sesarticle_claim', $claimId);
    $articleItem = Engine_Api::_()->getItem('sesarticle', $claimItem->article_id);
    $currentOwnerId = $articleItem->owner_id;
    $this->view->form = $form = new Sesarticle_Form_Admin_Claim_Approveform();
    $db = Engine_Db_Table::getDefaultAdapter();
    
		if (!$this->getRequest()->isPost()) {
		return;
		}
		if (!$form->isValid($this->getRequest()->getPost())) {
		return;
		}
    
    $viewer = Engine_Api::_()->user()->getViewer();
		if(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'accept')) {
			
			//upgrade album
			$db->update('engine4_sesarticle_albums', array('owner_id' => $claimItem->user_id), array("article_id = ?" => $claimItem->article_id));
			//upgrade photos
			$db->update('engine4_sesarticle_photos', array('user_id' => $claimItem->user_id), array("article_id = ?" => $claimItem->article_id));
			//upgrade favourites
			$db->update('engine4_sesarticle_favourites', array('user_id' => $claimItem->user_id), array("resource_id = ?" => $claimItem->article_id,'user_id = ?'=>$articleItem->owner_id));
			//upgrade reviews
			$db->update('engine4_sesarticle_reviews', array('owner_id' => $claimItem->user_id), array("article_id = ?" => $claimItem->article_id,'owner_id = ?'=>$articleItem->owner_id));
			//upgrade roles
			$db->update('engine4_sesarticle_roles', array('user_id' => $claimItem->user_id), array("article_id = ?" => $claimItem->article_id,'user_id = ?'=>$articleItem->owner_id));
			//upgrade extention if exists
			//upgrade video
			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesvideo')){ 
				$db->update('engine4_video_videos', array('owner_id' => $claimItem->user_id), array("parent_id = ?" => $claimItem->article_id,'parent_type = ?'=>'sesarticle','owner_id = ?'=>$articleItem->owner_id));
			}
			//upgrade music plugin
			if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmusic')){
				//upgrade video
				$db->update('engine4_sesmusic_albums', array('owner_id' => $claimItem->user_id), array("resource_id = ?" => $claimItem->article_id,'resource_type = ?'=>'sesarticle','owner_id = ? '=>$articleItem->owner_id));
			}
			//done upgrade extention work
			
			$db->update('engine4_sesarticle_claims', array('status' => 1), array("claim_id = ?" => $claimItem->claim_id));
			$db->update('engine4_sesarticle_articles', array('owner_id' => $claimItem->user_id), array("article_id = ?" => $claimItem->article_id));
			$fromName = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.name', 'Site Admin');
			$fromAddress = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.mail.from', 'admin@' . $_SERVER['HTTP_HOST']);
			$mailDataClaimOwner = array('sender_title' => $fromName);
			$bodyForClaimOwner = '';
			$bodyForClaimOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			$bodyForClaimOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataClaimOwner['message'] = $bodyForClaimOwner;
		  Engine_Api::_()->getApi('mail', 'core')->sendSystem($claimItem->user_email, 'sesarticle_claim_owner_approve', $mailDataClaimOwner);
			$mailDataArticleOwner = array('sender_title' => $fromName);
			$bodyForArticleOwner = '';
			$bodyForArticleOwner .= $this->view->translate("Email: %s", $fromAddress) . '<br />';
			if(isset($claimItem->contact_number) && !empty($claimItem->contact_number))
			$bodyForArticleOwner .= $this->view->translate("Claim Owner Contact Number: %s", $claimItem->contact_number) . '<br />';
			$bodyForArticleOwner .= $this->view->translate("Site Owner Comment For Claim: %s", $_POST['admin_comment']) . '<br /><br />';
			$mailDataArticleOwner['message'] = $bodyForArticleOwner;
			$articleOwnerId = Engine_Api::_()->getItem('sesarticle', $claimItem->article_id)->owner_id;
			$articleOwnerEmail = Engine_Api::_()->getItem('user', $articleOwnerId)->email;
			$claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
			$articleOwner = Engine_Api::_()->getItem('user', $currentOwnerId);
			Engine_Api::_()->getApi('mail', 'core')->sendSystem($articleOwnerEmail, 'sesarticle_owner_approve', $mailDataArticleOwner);
			Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $articleItem, 'sesarticle_claim_approve');
      Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($articleOwner, $viewer, $articleItem, 'sesarticle_owner_informed');
		}
		elseif(!empty($_POST['approve_decline']) && ($_POST['approve_decline'] == 'decline')) {
		  $claimOwner = Engine_Api::_()->getItem('user', $claimItem->user_id);
		  $db->delete('engine4_sesarticle_claims', array("claim_id = ?" => $claimItem->claim_id));
		  Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($claimOwner, $viewer, $articleItem, 'sesarticle_claim_declined');
		}
		else {
		  $form->addError($this->view->translate("Choose atleast one option for this claim request."));
      return;
		}
		
		$this->_forward('success', 'utility', 'core', array(
				'smoothboxClose' => 10,
				'parentRefresh' => 10,
				'messages' => array('Claim has been updated Successfully')
		));
  }

  //view item function
  public function viewAction() {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('sesarticle', $id);
    $this->view->item = $item;
  }
  
}
