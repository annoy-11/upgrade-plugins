<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_managesampaigns');

    $this->view->formFilter = $formFilter = new Sescrowdfunding_Form_Admin_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $value);
					Engine_Api::_()->sescrowdfunding()->deleteCrowdfunding($sescrowdfunding);
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    $values = array_merge(array('order' => isset($_GET['order']) ? $_GET['order'] :'', 'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : ''), $values);

    $this->view->assign($values);

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $crowdfundingTable = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding');
    $crowdfundingTableName = $crowdfundingTable->info('name');
    $select = $crowdfundingTable->select()
                              ->setIntegrityCheck(false)
                              ->from($crowdfundingTableName)
                              ->joinLeft($tableUserName, "$crowdfundingTableName.owner_id = $tableUserName.user_id", 'username')
                              ->order((!empty($_GET['order']) ? $_GET['order'] : 'crowdfunding_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
    $select->where($crowdfundingTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

     if (!empty($_GET['category_id']))
      $select->where($crowdfundingTableName . '.category_id =?', $_GET['category_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
    $select->where($crowdfundingTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['approved']) && $_GET['approved'] != '')
    $select->where($crowdfundingTableName . '.approved = ?', $_GET['approved']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
    $select->where($crowdfundingTableName . '.sponsored = ?', $_GET['sponsored']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
    $select->where($crowdfundingTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['draft']) && $_GET['draft'] != '')
    $select->where($crowdfundingTableName . '.draft = ?', $_GET['draft']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
    $select->where($crowdfundingTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
      $select->where($crowdfundingTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
      $select->where($crowdfundingTableName . '.rating = ?', $_GET['rating']);
      endif;
    }

    if (!empty($_GET['creation_date']))
    $select->where($crowdfundingTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

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

    public function photosAction() {

        $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sescrowdfunding_admin_main', array(), 'sescrowdfunding_admin_main_photos');

        $this->view->formFilter = $formFilter = new Sescrowdfunding_Form_Admin_Manage_Filter(array('albumTitle' =>'yes'));

        // Process form
        $values = array();
        if( $formFilter->isValid($this->_getAllParams()) ) {
            $values = $formFilter->getValues();
        }
        foreach( $_GET as $key => $value ) {
            if( '' === $value ) {
                unset($_GET[$key]);
            } else
                $values[$key]=$value;
        }

        if( $this->getRequest()->isPost() ) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $value) {
                if ($key == 'delete_' . $value) {
                    $photo = Engine_Api::_()->getItem('sescrowdfunding_photo', $value);
                    $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $photo->crowdfunding_id);
                    if($crowdfunding->photo_id == $photo->file_id) {
                        $crowdfunding->photo_id = 0;
                        $crowdfunding->save();
                    }
                    $photo->delete();
                }
            }
        }

        $tablePhoto = Engine_Api::_()->getDbtable('photos', 'sescrowdfunding');
        $tablePhotoName = $tablePhoto->info('name');
        $tableAlbum = Engine_Api::_()->getDbtable('albums', 'sescrowdfunding');
        $tableAlbumName = $tableAlbum->info('name');
        $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
        $crowdfundingTableName = Engine_Api::_()->getItemTable('crowdfunding')->info('name');
        $select =  $tablePhoto->select()
                            ->from($tablePhotoName)
                            ->setIntegrityCheck(false)
                            ->joinLeft($tableAlbumName, "$tableAlbumName.album_id = $tablePhotoName.album_id",NULL)
                            ->joinLeft($tableUserName, "$tableUserName.user_id = $tablePhotoName.user_id", 'username')
                            ->joinLeft($crowdfundingTableName, "$crowdfundingTableName.crowdfunding_id = $tablePhotoName.crowdfunding_id", array('title'));

        // Set up select info
        if( !empty($values['title']) )
            $select->where($crowdfundingTableName.'.title LIKE ?',$values['title'] );

        if( !empty($values['creation_date']) )
            $select->where($tablePhotoName.'.date(creation_date) = ?', $values['creation_date'] );

        $select->where($tableAlbumName.'.album_id != ?',0);
        $select->where($tablePhotoName.'.album_id != ?',0);
        $select->order($tablePhotoName.'.photo_id DESC');

        $page = $this->_getParam('page', 1);
        $this->view->paginator = $paginator = Zend_Paginator::factory($select);
        $paginator->setItemCountPerPage(25);
        $paginator->setCurrentPageNumber( $page );
    }

	public function deletePhotoAction(){
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $this->view->album_id = $id = $this->_getParam('id');
        // Check post
        if( $this->getRequest()->isPost())
        {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try
            {
                $photo = Engine_Api::_()->getItem('sescrowdfunding_photo', $id);
                $crowdfunding = Engine_Api::_()->getItem('crowdfunding', $photo->crowdfunding_id);
                if($crowdfunding->photo_id == $photo->file_id) {
                    $crowdfunding->photo_id = 0;
                    $crowdfunding->save();
                }
                // delete the photo in the database
                $photo->delete();
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
                'messages' => array('Photo deleted successfully.')
            ));
        }
        // Output
        $this->renderScript('admin-manage/delete-photo.tpl');
	}

  public function deleteAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->crowdfunding_id=$id;
    if( $this->getRequest()->isPost() ) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $id);
        Engine_Api::_()->sescrowdfunding()->deleteCrowdfunding($sescrowdfunding);
        $db->commit();
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh'=> 10,
          'messages' => array('')
      ));
    }
    $this->renderScript('admin-manage/delete.tpl');
  }

  //Featured Action
  public function featuredAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('crowdfunding', $event_id);
      $event->featured = !$event->featured;
      $event->save();
    }
    $this->_redirect('admin/sescrowdfunding/manage');
  }

  public function sponsoredAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('crowdfunding', $event_id);
      $event->sponsored = !$event->sponsored;
      $event->save();
    }
    $this->_redirect('admin/sescrowdfunding/manage');
  }

  public function verifiedAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('crowdfunding', $event_id);
      $event->verified = !$event->verified;
      $event->save();
    }
    $this->_redirect('admin/sescrowdfunding/manage');
  }

  public function approvedAction() {

    $event_id = $this->_getParam('id');
    if (!empty($event_id)) {
      $event = Engine_Api::_()->getItem('crowdfunding', $event_id);
      $event->approved = !$event->approved;
      $event->save();
    }
    $this->_redirect('admin/sescrowdfunding/manage');
  }

  public function ofthedayAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Sescrowdfunding_Form_Admin_Oftheday();
    $item = Engine_Api::_()->getItem('crowdfunding', $id);
    $form->setTitle("Crowdfunding of the Day");
    $form->setDescription('Here, choose the start date and end date for this crowdfunding to be displayed as "Crowdfunding of the Day".');
    if (!$param)
      $form->remove->setLabel("Remove as Crowdfunding of the Day");

    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['startdate'] = date('Y-m-d',  strtotime($values['startdate']));
      $values['enddate'] = date('Y-m-d', strtotime($values['enddate']));
      $db->update('engine4_sescrowdfunding_crowdfundings', array('startdate' => $values['startdate'], 'enddate' => $values['enddate']), array("crowdfunding_id = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update('engine4_sescrowdfunding_crowdfundings', array('offtheday' => 0), array("crowdfunding_id = ?" => $id));
      } else {
        $db->update('engine4_sescrowdfunding_crowdfundings', array('offtheday' => 1), array("crowdfunding_id = ?" => $id));
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
    $this->view->claimItem = Engine_Api::_()->getItem('sescrowdfunding_claim', $claimId);
  }

  //view item function
  public function viewAction() {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('crowdfunding', $id);
    $this->view->item = $item;
  }

}
