<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: PostController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_PostController extends Core_Controller_Action_Standard
{
  public function init()
  {
    if( 0 !== ($post_id = (int) $this->_getParam('post_id')) &&
        null !== ($post = Engine_Api::_()->getItem('sesforum_post', $post_id)) &&
        $post instanceof Sesforum_Model_Post ) {
      Engine_Api::_()->core()->setSubject($post);
    }
  }

  public function deleteAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }
    if( !$this->_helper->requireSubject('sesforum_post')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->post = $post = Engine_Api::_()->core()->getSubject('sesforum_post');
    $this->view->topic = $topic = $post->getParent();
    $this->view->sesforum = $sesforum = $topic->getParent();
    if( !$this->_helper->requireAuth()->setAuthParams($post, null, 'delete')->checkRequire() &&
        !$this->_helper->requireAuth()->setAuthParams($sesforum, null, 'topic.delete')->checkRequire() ) {
      return $this->_helper->requireAuth()->forward();
    }

    $this->view->form = $form = new Sesforum_Form_Post_Delete();

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $table = Engine_Api::_()->getItemTable('sesforum_post');
    $db = $table->getAdapter();
    $db->beginTransaction();

    $topic_id = $post->topic_id;

    try
    {
      $post->delete();

      $db->commit();
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    $topic = Engine_Api::_()->getItem('sesforum_topic', $topic_id);
    $href = ( null === $topic ? $sesforum->getHref() : $topic->getHref() );
    return $this->_forward('success', 'utility', 'core', array(
      'closeSmoothbox' => true,
      'parentRedirect' => $href,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Post deleted.')),
      'format' => 'smoothbox'
    ));
  }

  public function editAction()
  {
     if( !$this->_helper->requireUser()->isValid() ) {
      return;
    }
    if( !$this->_helper->requireSubject('sesforum_post')->isValid() ) {
      return;
    }
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->post = $post = Engine_Api::_()->core()->getSubject('sesforum_post');
    $this->view->topic = $topic = $post->getParent();
    $this->view->sesforum = $sesforum = $topic->getParent();
    $this->view->topicTitle = $topic->getTitle();

    if( !$this->_helper->requireAuth()->setAuthParams($post, null, 'edit')->checkRequire() &&
        !$this->_helper->requireAuth()->setAuthParams($sesforum, null, 'topic.edit')->checkRequire() ) {
      return $this->_helper->requireAuth()->forward();
    }

    $this->view->form = $form = new Sesforum_Form_Post_Edit(array('post'=>$post));

    $allowHtml = (bool) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum_html', 0);
    $allowBbcode = (bool) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum_bbcode', 0);

    if( $allowHtml ) {
      $body = $post->body;
      $body = preg_replace_callback('/href=["\']?([^"\'>]+)["\']?/', function($matches) {
          return 'href="' . str_replace(['&gt;', '&lt;'], '', $matches[1]) . '"';
      }, $body);
    } else {
      $body = htmlspecialchars_decode($post->body, ENT_COMPAT);
    }
    $form->body->setValue($body);

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $table = Engine_Api::_()->getItemTable('sesforum_post');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try
    {
      $values = $form->getValues();

      $post->body = $values['body'];
      $post->body = Engine_Text_BBCode::prepare($post->body);

      $post->edit_id = $viewer->getIdentity();

      //DELETE photo here.
      if( !empty($values['photo_delete']) && $values['photo_delete'] ) {
        $post->deletePhoto();
      }

      if( !empty($values['photo']) ) {
        $post->setPhoto($form->photo);
      }

      $post->save();

      $db->commit();

      return $this->_helper->redirector->gotoRoute(array('post_id'=>$post->getIdentity(), 'topic_id' => $post->getParent()->getIdentity()), 'sesforum_topic', true);
    }

    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
  }
}
