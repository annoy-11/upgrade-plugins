<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ProfileController.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdocument_ProfileController extends Core_Controller_Action_Standard {
  public function init() {
    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject() &&
            ($id = $this->_getParam('id'))) {
		$document_id = Engine_Api::_()->getDbtable('sesdocuments', 'sesdocument')->getDocumentId($id);
    if ($document_id) {
      $document = Engine_Api::_()->getItem('sesdocument', $document_id);
      if ($document)
        Engine_Api::_()->core()->setSubject($document);
      else
        return $this->_forward('requireauth', 'error', 'core');
    }else
      return $this->_forward('requireauth', 'error', 'core');
		}

    $this->_helper->requireSubject();
    $this->_helper->requireAuth()->setNoForward()->setAuthParams(
            $subject, Engine_Api::_()->user()->getViewer(), 'view'
    );
  }
  public function indexAction() { 
    $subject = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
		if((!$subject->is_approved || !$subject->draft ) && $viewer->getIdentity() != $subject->getOwner()->getIdentity()){
			return $this->_forward('notfound', 'error', 'core');
		}

    if (!$this->_helper->requireAuth()->setAuthParams($subject, $viewer, 'view')->isValid()) {
      return;
    }

    // Check block
    if ($viewer->isBlockedBy($subject)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    //Privacy: networks and member level based 
    
    if (Engine_Api::_()->authorization()->isAllowed('sesdocument', $subject->getOwner(), 'allow_levels') || Engine_Api::_()->authorization()->isAllowed('sesdocument', $subject->getOwner(), 'allow_networks')) { 
        $returnValue = Engine_Api::_()->sesdocument()->checkPrivacySetting($subject->getIdentity());
        if ($returnValue == false) {
            return $this->_forward('requireauth', 'error', 'core');
        }
    }

    // Increment view count
    if (!$subject->getOwner()->isSelf($viewer)) {
      $subject->view_count++;
      $subject->save();
    }

		  if ($viewer->getIdentity() != 0) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_sesdocument_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $subject->getIdentity() . '", "'.$subject->getType().'","' . $viewer->getIdentity() . '",NOW())  ON DUPLICATE KEY UPDATE creation_date = NOW()');
    }
    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', $subject->getType())
            ->where('id = ?', $subject->getIdentity())
            ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
		

		$view->headLink()->appendStylesheet($view->layout()->staticBaseUrl
								. 'application/modules/Sesdocument/externals/styles/styles.css');
		$script =
              "
							sesJqueryObject(document).click(function(sesdocument){
								var moreTab = sesJqueryObject(sesdocument.target).parent('.more_tab');
								if(moreTab.length == 0){
												sesJqueryObject('.more_tab').removeClass('tab_open').addClass('tab_closed');
								}
							});
";
		$view->headScript()->appendScript($script);
    // Render
		$hayStack = array('1','2','3','4');
		if(isset($_GET['layout']) && in_array($_GET['layout'],$hayStack)){
			$letters = range('a','z');
			$letter = $letters[$_GET['layout']-1];
			$this->_helper->content->setContentName("sesdocument_custom_layout".$letter."")->setNoRender()->setEnabled();
		}else{
			$this->_helper->content->setNoRender()->setEnabled();
		}
  }
}
