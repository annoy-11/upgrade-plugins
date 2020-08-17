<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Poll.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagepoll_Model_Poll extends Core_Model_Item_Abstract
{
  protected $_parent_type = 'user';

  protected $_parent_is_owner = true;

  // Interfaces
  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
  public function getHref($params = array())
  {
    $params = array_merge(array(
      'route' => 'sespagepoll_view',
      'reset' => true,
      'user_id' => $this->user_id,
      'poll_id' => $this->poll_id,
      'slug' => $this->getSlug(),
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }

  public function getHiddenSearchData()
  {
    $optionsTable = Engine_Api::_()->getDbTable('options', 'sespagepoll');
    $options = $optionsTable
      ->select()
      ->from($optionsTable->info('name'), 'poll_option')
      ->where('poll_id = ?', $this->getIdentity())
      ->query()
      ->fetchAll(Zend_Db::FETCH_COLUMN);

    return join(' ', $options);
  }

  public function getRichContent()
  {
    $view = Zend_Registry::get('Zend_View');
    $view = clone $view;
    $view->clearVars();
    $view->addScriptPath('application/modules/Sespagepoll/views/scripts/');
    
    $content = '';
    $content .= '
      <div class="feed_poll_rich_content">
        <div class="feed_item_link_title">
          ' . $view->htmlLink($this->getHref(), $this->getTitle()) . '
        </div>
        <div class="feed_item_link_desc">
          ' . $view->viewMore($this->getDescription()) . '
        </div>
    ';

    // Render the thingy
    $view->sespagepoll = $this;
    $view->owner = $owner = $this->getOwner();
    $view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $view->pollOptions = $this->getOptions();
    $view->hasVoted = $this->viewerVoted();
    $view->showPieChart = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepoll.showpiechart', false);
    $view->canVote = $this->authorization()->isAllowed(null, 'vote');
    $view->canChangeVote = Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepoll.canchangevote', false);
    $view->hideLinks = true;

    $content .= $view->render('_poll.tpl');

    /* $content .= '
    <div class="poll_stats">
    '; */

    $content .= '
      </div>
    ';
    return $content;
  }
  
  public function getOptions()
  {
    return Engine_Api::_()->getDbtable('options', 'sespagepoll')->fetchAll(array(
      'poll_id = ?' => $this->getIdentity(),
    ));
  }
  
  public function getOptionsAssoc()
  {
    $optionTable = Engine_Api::_()->getDbtable('options', 'sespagepoll');
    $data = $optionTable
        ->select()
        ->from($optionTable, array('poll_option_id', 'poll_option'))
        ->where('poll_id = ?', $this->getIdentity())
        ->query()
        ->fetchAll();
    
    $options = array();
    foreach( $data as $datum ) {
      $options[$datum['poll_option_id']] = $datum['poll_option'];
    }
    return $options;
  }

  public function optionsFetchAll(){
    $optionTable = Engine_Api::_()->getDbtable('options', 'sespagepoll');
    $data = $optionTable
      ->select()
      ->from($optionTable, array('*'))
      ->where('poll_id = ?', $this->getIdentity())
      ->query()
      ->fetchAll();
    return $data;
  }

  public function hasVoted(User_Model_User $user)
  {
    $table = Engine_Api::_()->getDbtable('votes', 'sespagepoll');
    return (bool) $table
      ->select()
      ->from($table, 'COUNT(*)')
      ->where('poll_id = ?', $this->getIdentity())
      ->where('user_id = ?', $user->getIdentity())
      ->query()
      ->fetchColumn(0)
      ;
  }

  public function getVote(User_Model_User $user)
  {
    $table = Engine_Api::_()->getDbtable('votes', 'sespagepoll');
    return $table
      ->select()
      ->from($table, 'poll_option_id')
      ->where('poll_id = ?', $this->getIdentity())
      ->where('user_id = ?', $user->getIdentity())
      ->query()
      ->fetchColumn(0)
      ;
  }

  public function getVoteCount($recheck = false)
  {
    if( $recheck ) {
      $table = Engine_Api::_()->getDbtable('votes', 'sespagepoll');
      $voteCount = $table->select()
        ->from($table, 'COUNT(*)')
        ->where('poll_id = ?', $this->getIdentity())
        ->query()
        ->fetchColumn(0)
        ;
      if( $voteCount != $this->vote_count ) {
        $this->vote_count = $voteCount;
        $this->save();
      }
    }
    return $this->vote_count;
  }

  public function viewerVoted()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    return $this->getVote($viewer);
  }

  public function vote(User_Model_User $user, $option, $page, $owner,$poll)
  {
		$item = $poll;
	  $viewer = Engine_Api::_()->user()->getViewer();
    $votesTable = Engine_Api::_()->getDbTable('votes', 'sespagepoll');
    $optionsTable = Engine_Api::_()->getDbtable('options', 'sespagepoll');

    // Get poll option
    if( is_numeric($option) ) {
      $option = $optionsTable->find((int) $option)->current();
    }
    if( !($option instanceof Zend_Db_Table_Row_Abstract) ) {
      throw new Engine_Exception('Missing or invalid poll option');
    }
	$notificationType = 'sespagepoll_vote_poll';
    // Check for existing vote
    $vote = $votesTable->fetchRow(array(
      'poll_id = ?' => $this->getIdentity(),
      'user_id = ?' => $user->getIdentity(),
    ));

    // New vote is the same as old vote, ignore
    if( $vote &&
        $option->poll_option_id == $vote->poll_option_id ) {
      return $this;
    }

    if( !$vote ) {
      // Vote did not exist

      // Create vote
      $vote = $votesTable->createRow();
      $vote->setFromArray(array(
        'poll_id' => $this->getIdentity(),
        'user_id' => $user->getIdentity(),
        'poll_option_id' => $option->poll_option_id,
        'creation_date' => date("Y-m-d H:i:s"),
        'modified_date' => date("Y-m-d H:i:s"),
      ));
      $vote->save();
	  // Notification work 
	 if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $page->getType(), "object_id = ?" => $page->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $page, $notificationType);
				$action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $page, 'vote_sespagepoll_poll');
					if( $action != null ) {
						Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $item);
					}
      }
	  //End Notification work
      // Increment new option count
      $optionsTable->update(array(
        'votes' => new Zend_Db_Expr('votes + 1'),
      ), array(
        'poll_id = ?' => $this->getIdentity(),
        'poll_option_id = ?' => $vote->poll_option_id,
      ));

      // Update internal vote count
      $this->vote_count = new Zend_Db_Expr('vote_count + 1');
      $this->save();
    } else {
      // Vote did exist

      // Decrement old option count
      $optionsTable->update(array(
        'votes' => new Zend_Db_Expr('votes - 1'),
      ), array(
        'poll_id = ?' => $this->getIdentity(),
        'poll_option_id = ?' => $vote->poll_option_id,
      ));
      
      // Change vote
      $vote->poll_option_id = $option->poll_option_id;
      $vote->modified_date  = date("Y-m-d H:i:s");
      $vote->save();
	  if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $page->getType(), "object_id = ?" => $page->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $page, $notificationType);
				$action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $page, 'vote_sespagepoll_poll');
					if( $action != null ) {
						Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $item);
					}
      }
	  
      // Increment new option count
      $optionsTable->update(array(
        'votes' => new Zend_Db_Expr('votes + 1'),
      ), array(
        'poll_id = ?' => $this->getIdentity(),
        'poll_option_id = ?' => $vote->poll_option_id,
      ));
    }

    
    // Recheck all options?
    /*
    // Note: this doesn't seem to work because we're in a transaction -_-
    $subselect = $table->select()
      ->from($table, 'COUNT(*)')
      ->where('poll_id = ?', $this->getIdentity())
      ->where('poll_option_id = ?', new Zend_Db_Expr($optionsTable->info('name') . '.poll_option_id'))
      ;
    $optionsTable->update(array(
      'votes' => $subselect,
    ), array(
      'poll_id = ?' => $this->getIdentity(),
    ));
     * 
     */

    return $this;
  }

  protected function _insert()
  {
    if( null === $this->search ) {
      $this->search = 1;
    }

    parent::_insert();
  }

  protected function _delete()
  {
    //     delete poll votes
    Engine_Api::_()->getDbtable('votes', 'sespagepoll')->delete(array(
      'poll_id = ?' => $this->getIdentity(),
    ));

    // delete poll options's Images
    $optionTable = Engine_Api::_()->getDbtable('options', 'sespagepoll');
    $select = $optionTable->select()->where('poll_id = ?', $this->getIdentity());
    $data = $optionTable->fetchAll($select);
    foreach($data as $option){
      if($option['file_id']){
        $fileobj = Engine_Api::_()->getItem('storage_file', $option['file_id']);
        if ($fileobj) {
          $fileobj->remove();
        }
      }
    }

    // delete poll options
    Engine_Api::_()->getDbtable('options', 'sespagepoll')->delete(array(
      'poll_id = ?' => $this->getIdentity(),
    ));

    parent::_delete();
  }

  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   **/
  public function comments()
  {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }

  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   **/
  public function likes()
  {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }
}