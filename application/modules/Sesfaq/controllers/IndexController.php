<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_IndexController extends Core_Controller_Action_Standard {
	
	public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('sesfaq_faq', null, 'view')->isValid())
      return;
	}
	
  function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'sesfaq_faq';
    $dbTable = 'faqs';
    $resorces_id = 'faq_id';
    $notificationType = 'liked';
    $actionType = 'sesfaq_faq_like';
		
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $itemTable = Engine_Api::_()->getDbtable($dbTable, 'sesfaq');
    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');
    $item = Engine_Api::_()->getItem($type, $item_id);
    $select = $tableLike->select()
            ->from($tableMainLike)
            ->where('resource_type = ?', $type)
            ->where('poster_id = ?', $viewer_id)
            ->where('poster_type = ?', 'user')
            ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);

    if (count($result) > 0) {
      //delete		
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      
      $item->like_count--;
      $item->save();
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));
      die;
    } else {

      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {

        $like = $tableLike->createRow();
        $like->poster_id = $viewer_id;
        $like->resource_type = $type;
        $like->resource_id = $item_id;
        $like->poster_type = 'user';
        $like->save();

        $item->like_count++;
        $item->save();

        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      //Send notification and activity feed work.
      $item = Engine_Api::_()->getItem($type, $item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        $result = $activityTable->fetchRow(array('type =?' => $actionType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
	       
        if (!$result) {
	        $action = $activityTable->addActivity($viewer, $subject, $actionType);
	        if ($action)
	          $activityTable->attachActivity($action, $subject);
        }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }
	
	public function helpfulAction() {
    
    $faq_id = $this->_getParam('faq_id', null);
    $helpfulfaq = $this->_getParam('helpfulfaq', null);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $faq = Engine_Api::_()->getItem('sesfaq_faq', $faq_id);
    $reason_id = $this->_getParam('reason_id', 0);
    $checkHelpful = Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->checkHelpful($faq_id, $viewer_id);
    if($checkHelpful) {
      Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->setHelpful($faq_id, $viewer_id, $reason_id, $helpfulfaq);
    } else {
      Engine_Api::_()->getDbTable('helpfaqs', 'sesfaq')->setHelpful($faq_id, $viewer_id, $reason_id, $helpfulfaq);
    }
	}
	
  public function askquestionAction() {

    if (null === $this->_helper->ajaxContext->getCurrentContext()) {
      $this->_helper->layout->setLayout('default-simple');
    } else {
      $this->_helper->layout->disableLayout(true);
    }

    if( !$this->_helper->requireAuth()->setAuthParams('sesfaq_faq', null, 'askquestion')->isValid() )
        return;

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
    $this->view->form = $form = new Sesfaq_Form_Askquestion();
    if(!$this->getRequest()->isPost()) return;
    if(!$form->isValid($this->getRequest()->getPost())) return;
    $db = Engine_Api::_()->getDbtable('askquestions', 'sesfaq')->getAdapter();
    $db->beginTransaction();
    $askquestionsTable = Engine_Api::_()->getDbtable('askquestions', 'sesfaq');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    try {
    
      $values = $form->getValues();
      if(!empty($viewer_id)) {
        $values['user_id'] = $viewer_id;
        $values['name'] = $viewer->getTitle();
        $values['email'] = $viewer->email;
      }
      $askquestion = $askquestionsTable->createRow();
      $askquestion->setFromArray($values);
      $askquestion->save();

      //Email and notification send to admin
      $email = $settings->core_mail_from;
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($email, 'SESFAQ_ASKQUESTION_EMAIL', array(
        'site_title' => $settings->getSetting('core.general.site.title', 'My Community'),
        'description' => $askquestion->description,
        'queue' => true,
        'email' => $email,          
      ));

      $db->commit();
			$this->_forward('success', 'utility', 'core', array(
					'smoothboxClose' => 300,
					'messages' => array('Your question posted successfully.')
			));
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
  }
  
  public function homeAction() {
		 if (!$this->_helper->requireAuth()->setAuthParams('sesfaq_faq', null, 'view')->isValid())
			 return;
    //Render
    $sesfaq_browse = Zend_Registry::isRegistered('sesfaq_browse') ? Zend_Registry::get('sesfaq_browse') : null;
    if(!empty($sesfaq_browse)) {
      $this->_helper->content->setEnabled();
    }
  }
	
  public function browseAction() {
		 if (!$this->_helper->requireAuth()->setAuthParams('sesfaq_faq', null, 'view')->isValid())
			 return;
    //Render
    $sesfaq_browse = Zend_Registry::isRegistered('sesfaq_browse') ? Zend_Registry::get('sesfaq_browse') : null;
    if(!empty($sesfaq_browse)) {
      $this->_helper->content->setEnabled();
    }
  }
  
  public function tagsAction() {
		 if (!$this->_helper->requireAuth()->setAuthParams('sesfaq_faq', null, 'view')->isValid())
			 return;
    //Render
    $sesfaq_browse = Zend_Registry::isRegistered('sesfaq_browse') ? Zend_Registry::get('sesfaq_browse') : null;
    if(!empty($sesfaq_browse)) {
      $this->_helper->content->setEnabled();
    }
  }
  
  public function rateAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $user_id = $viewer->getIdentity();
    
    $rating = $this->_getParam('rating');
    $faq_id =  $this->_getParam('faq_id');

    
    $table = Engine_Api::_()->getDbtable('ratings', 'sesfaq');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      Engine_Api::_()->sesfaq()->setRating($faq_id, $user_id, $rating);
         
      $faq = Engine_Api::_()->getItem('sesfaq_faq', $faq_id);
      $faq->rating = Engine_Api::_()->sesfaq()->getRating($faq->getIdentity());
      $faq->save();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    $total = Engine_Api::_()->sesfaq()->ratingCount($faq->getIdentity());

    $data = array();
    $data[] = array(
      'total' => $total,
      'rating' => $rating,
    );
    return $this->_helper->json($data);
    $data = Zend_Json::encode($data);
    $this->getResponse()->setBody($data);
  }
  
  public function viewAction() {
  
    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $faq = Engine_Api::_()->getItem('sesfaq_faq', $this->_getParam('faq_id'));
    if( $faq ) {
      Engine_Api::_()->core()->setSubject($faq);
    }
    
    // Increment view count
		if($faq) {
			if (!$faq->getOwner()->isSelf($viewer)) {
				$faq->view_count++;
				$faq->save();
			}
		}
    
    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }
    
    if( !$this->_helper->requireAuth()->setAuthParams($faq, $viewer, 'view')->isValid() ) {
      return;
    }
    
    $returnValue = Engine_Api::_()->sesfaq()->checkPrivacySetting($faq->faq_id);
    if ($returnValue == false) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    
    //Render
    $this->_helper->content->setEnabled();
  }
  
  public function searchAction() {

    $text = $this->_getParam('text', null);
    $table = Engine_Api::_()->getDbTable('faqs', 'sesfaq');
    $tableName = $table->info('name');
    $id = 'faq_id';
    $route = 'sesfaq_profile';
    $photo = 'thumb.icon';
    $label = 'title';


    $data = array();
    $select = $table->select()->from($tableName);
    $select->where('title  LIKE ? ', '%' . $text . '%')->where('search =?', 1)->order('title ASC');
    $select->where('status = ?', 1);
    $select->limit('40');
    $results = $table->fetchAll($select);

    foreach ($results as $result) {
      $url = $this->view->url(array($id => $result->$id,'slug'=>$result->getSlug()), $route, true);
      //$photo = $this->view->itemPhoto($result, $photo);
      $data[] = array(
          'id' => $result->$id,
          'label' => $result->$label,
         // 'photo' => $photo,
          'url' => $url,
      );
    }
    return $this->_helper->json($data);
  }
  
  public function subcategoryAction() {
  
    $category_id = $this->_getParam('category_id', null);
    if ($category_id) {
			$subcategory = Engine_Api::_()->getDbtable('categories', 'sesfaq')->getModuleSubcategory(array('category_id'=>$category_id,'column_name'=>'*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        $data .= '<option value=""></option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }
      }
    }
    else
      $data = '';
    echo $data;
    die;
  }
  
	// get faq subsubcategory 
  public function subsubcategoryAction() {
    $category_id = $this->_getParam('subcategory_id', null);
    if ($category_id) {
      $subcategory = Engine_Api::_()->getDbtable('categories', 'sesfaq')->getModuleSubsubcategory(array('category_id'=>$category_id,'column_name'=>'*'));
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        $data .= '<option value=""></option>';
        foreach ($subcategory as $category) {
          $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '">' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
        }
      }
    }
    else
      $data = '';
    echo $data;die;
  }
}