<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshoutbox_IndexController extends Core_Controller_Action_Standard {

    public function shoutboxRuleAction() {

        $shoutbox_id = $this->_getParam('shoutbox_id', null);
        $shoutbox = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $shoutbox_id);
        $this->view->shoutbox_rule = $shoutbox->sesshoutbox_rules ; //Engine_Api::_()->getApi('settings', 'core')->getSetting("sesshoutbox.rules", '');
    }

    public function editMessageAction() {

        $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

        $this->view->content_id = $content_id = $this->_getParam('content_id', null);
        $contents = Engine_Api::_()->getItem('sesshoutbox_content', $content_id);

        if(!$is_ajax) {

            // Prepare form
            $this->view->form = $form = new Sesshoutbox_Form_Edit();
            // Populate form
            $form->populate($contents->toArray());
        }

        if($is_ajax) {
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            // Process
            $table = Engine_Api::_()->getDbTable('contents', 'sesshoutbox');
            $db = $table->getAdapter();
            $db->beginTransaction();
            try {

                $values = $_POST;
                $contents->body = $_POST['body'];
                $contents->save();
                $db->commit();

                echo Zend_Json::encode(array('status' => 1, 'message' => $contents->body));exit();
            }
            catch( Exception $e ) {
                $db->rollBack();
                throw $e;
                echo 0;die;
            }
        }
    }

    public function lastmessageAction() {

        $shoutbox_id = $this->_getParam('shoutbox_id', null);
        if(empty($shoutbox_id))
            return;

        $content_id = $this->_getParam('content_id', null);
        if(empty($content_id))
            return;

        $this->view->shoutbox = $shoutbox = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $shoutbox_id);
        $this->view->viewer_id = $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

        $contentTable = Engine_Api::_()->getDbTable('contents', 'sesshoutbox');
        $contentTableName = $contentTable->info('name');

        $select = $contentTable->select()
                            ->from($contentTableName, '*')
                            ->where('shoutbox_id = ?', $shoutbox_id)
                            ->where('content_id > ?', $content_id)
                            ->order('content_id DESC')
                            ->limit(1);
        $this->view->results = $results = $contentTable->fetchAll($select);
    }

    public function loadmorecontentsAction() {

        $shoutbox_id = $this->_getParam('shoutbox_id', null);
        if(empty($shoutbox_id))
            return;
        $this->view->shoutbox = $shoutbox = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $shoutbox_id);
        $this->view->viewer_id = $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

        $content_id = $this->_getParam('contentid', null);
        if(empty($content_id))
            return;

        $contentTable = Engine_Api::_()->getDbTable('contents', 'sesshoutbox');
        $contentTableName = $contentTable->info('name');

        $select = $contentTable->select()
                            ->from($contentTableName, '*')
                            ->where('shoutbox_id = ?', $shoutbox_id)
                            ->where('content_id < ?', $content_id)
                            ->order('content_id DESC')
                            ->limit(10);

        $this->view->results = $results = $contentTable->fetchAll($select);


    }

  public function reportAction()
  {
    $content = Engine_Api::_()->getItem($this->_getParam('resource_type'), $this->_getParam('resource_id'));
    $this->view->subject = $subject = $content; //Engine_Api::_()->core()->getSubject();


    $this->view->form = $form = new Core_Form_Report();
    $form->populate($this->_getAllParams());

    if( !$this->getRequest()->isPost() )
    {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
    }

    // Process
    $table = Engine_Api::_()->getItemTable('core_report');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      $viewer = Engine_Api::_()->user()->getViewer();

      $report = $table->createRow();
      $report->setFromArray(array_merge($form->getValues(), array(
        'subject_type' => 'sesshoutbox_content',
        'subject_id' => $subject->content_id,
        'user_id' => $viewer->getIdentity(),
      )));
      $report->save();

      // Increment report count
      Engine_Api::_()->getDbtable('statistics', 'core')->increment('core.reports');

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    // Close smoothbox
    $currentContext = $this->_helper->contextSwitch->getCurrentContext();
    if( null === $currentContext )
    {
      return $this->_helper->redirector->gotoRoute(array(), 'default', true);
    }
    else if( 'smoothbox' === $currentContext )
    {
      return $this->_forward('success', 'utility', 'core', array(
        'messages' => $this->view->translate('Your report has been submitted.'),
        'smoothboxClose' => true,
        //'parentRefresh' => false,
      ));
    }
  }

   public function deletemessageAction() {

        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        if (empty($viewer_id))
            return;
        $shoutbox_id = $this->_getParam('shoutbox_id', null);
        $content_id = $this->_getParam('content_id', null);
        $content = Engine_Api::_()->getItem('sesshoutbox_content', $content_id);
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $content->delete();
            $db->commit();
            $this->view->content_id = 1;
        } catch(Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

    public function createAction() {

        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        if (empty($viewer_id))
            return;

        $shoutbox_id = $this->_getParam('shoutbox_id', null);

        $poster_id = $this->_getParam('poster_id', null);

        $content = $this->_getParam('content', null);

        $contentsTable = Engine_Api::_()->getDbTable('contents', 'sesshoutbox');

        $values = array('body' => nl2br($content), 'poster_id' => $poster_id, 'shoutbox_id' => $shoutbox_id, 'poster_type' => 'user');

        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();

        try {

            $item = $contentsTable->createRow();
            $item->setFromArray($values);
            $item->save();

            $db->commit();

            $this->view->content_id = $item->content_id;
        } catch(Exception $e) {
            $db->rollBack();
            throw $e;
        }

    }
}
