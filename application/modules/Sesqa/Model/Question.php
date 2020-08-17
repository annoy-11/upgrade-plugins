<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Question.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Model_Question extends Core_Model_Item_Abstract {
  protected $_parent_type = 'user';
  protected $_parent_is_owner = true;
    public function getShortType($inflect = false){
        return "question";
    }
    public function getMediaType(){
        return "question";
    }
  //Get category title
  public function getTitle() {
    return $this->title;
  }

  function getLatestAnswer(){
    $answerTable = Engine_Api::_()->getDbTable('answers','sesqa');
    $select = $answerTable->select()->where('question_id =?',$this->question_id)->order('creation_date DESC')->limit(1);
    $answer = $answerTable->fetchRow($select);
    return $answer;
  }
  //Category href
  public function getHref($params = array()) {
		if(!$this)
			return 'javascript:;';

    $params = array_merge(array(
        'route' => 'sesqa_view',
        'reset' => true,
        'question_id' => $this->getIdentity(),
        'slug' =>$this->getSlug(),
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }


	public function getPhotoUrl($type = NULL) {

		if(!$this)
			return Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_default_image', 'application/modules/Sesqa/externals/images/default.png');
    $thumbnail = $this->photo_id;
    if ($thumbnail) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, $type);
			if($file)
      	return $file->map();
    }
		return Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_default_image', 'application/modules/Sesqa/externals/images/default.png');
  }


   public function getRichContent()
  {
    $view = Zend_Registry::get('Zend_View');
    $view = clone $view;
    $view->clearVars();
    $view->addScriptPath('application/modules/Sesqa/views/scripts/');

    $content = '';
    $content .= '
      <div class="feed_sesqa_rich_content">';
    // Render the thingy
    $view->question = $this;
    $view->owner = $owner = $this->getOwner();
    $view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $view->questionOptions = $this->getOptions();
    $view->hasVoted = $this->viewerVoted();
    $view->multiVote = $this->multi;
    $view->showPieChart = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.showpiechart', false);
    $view->canVote = $this->authorization()->isAllowed($viewer, 'answer');
    $view->canChangeVote = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa.canchangevote', true);
    $view->hideLinks = true;
    $content .= $view->render('_pollActivity.tpl');
    $content .= '
      </div>
    ';
    return $content;
  }
   public function hasVoted(User_Model_User $user)
  {
    $table = Engine_Api::_()->getDbtable('votes', 'sesqa');
    return (bool) $table
      ->select()
      ->from($table, 'COUNT(*)')
      ->where('question_id = ?', $this->getIdentity())
      ->where('user_id = ?', $user->getIdentity())
      ->query()
      ->fetchColumn(0)
      ;
  }
  public function getVote(User_Model_User $user)
  {
    $table = Engine_Api::_()->getDbtable('votes', 'sesqa');
    return $table
      ->select()
      ->from($table, 'poll_option_id')
      ->where('question_id = ?', $this->getIdentity())
      ->where('user_id = ?', $user->getIdentity())
      ->query()
      ->fetchAll()
      ;
  }
  public function viewerVoted()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $votedArray = $this->getVote($viewer);
    $array = array();
    if(count($votedArray)){
      foreach($votedArray as $ids){
          $array[] = $ids['poll_option_id'];
      }
      return $array;
    }
    return "";
    //return $this->getVote($viewer);
  }
  public function getOptions()
  {
    return Engine_Api::_()->getDbtable('options', 'sesqa')->fetchAll(array(
      'question_id = ?' => $this->getIdentity(),
    ));
  }
  public function vote(User_Model_User $user, $option)
  {
    $votesTable = Engine_Api::_()->getDbTable('votes', 'sesqa');
    $optionsTable = Engine_Api::_()->getDbtable('options', 'sesqa');

    // Get poll option
    if( is_numeric($option) ) {
      $option = $optionsTable->find((int) $option)->current();
    }
    if( !($option instanceof Zend_Db_Table_Row_Abstract) ) {
      throw new Engine_Exception('Missing or invalid poll option');
    }

    // Check for existing vote

    $conditional = array(
      'question_id = ?' => $this->getIdentity(),
      'user_id = ?' => $user->getIdentity(),
    );
    if($this->multi)
      $conditional = array('poll_option_id =?'=>$option->poll_option_id);

    $vote = $votesTable->fetchRow($conditional);
    //echo "<prE>";var_dump($conditional);var_dump($vote);die;
    // New vote is the same as old vote, ignore
    if( $vote &&
        $option->poll_option_id == $vote->poll_option_id && !$this->multi) {
      return $this;
    }

    if( !$vote) {
      // Vote did not exist

      // Create vote
      $vote = $votesTable->createRow();
      $vote->setFromArray(array(
        'question_id' => $this->getIdentity(),
        'user_id' => $user->getIdentity(),
        'poll_option_id' => $option->poll_option_id,
        'creation_date' => date("Y-m-d H:i:s"),
        'modified_date' => date("Y-m-d H:i:s"),
      ));
      $vote->save();

      // Increment new option count
      $optionsTable->update(array(
        'votes' => new Zend_Db_Expr('votes + 1'),
      ), array(
        'question_id = ?' => $this->getIdentity(),
        'poll_option_id = ?' => $vote->poll_option_id,
      ));

      // Update internal vote count
      $this->vote_count = new Zend_Db_Expr('vote_count + 1');
      $this->save();
    }else if($this->multi){
      //Decrement old option count
      $optionsTable->update(array(
        'votes' => new Zend_Db_Expr('votes - 1'),
      ), array(
        'question_id = ?' => $this->getIdentity(),
        'poll_option_id = ?' => $vote->poll_option_id,
      ));
      $vote->delete();
      // Update internal vote count
      $this->vote_count = new Zend_Db_Expr('vote_count - 1');
      $this->save();
    } else {
      // Vote did exist

      // Decrement old option count
      $optionsTable->update(array(
        'votes' => new Zend_Db_Expr('votes - 1'),
      ), array(
        'question_id = ?' => $this->getIdentity(),
        'poll_option_id = ?' => $vote->poll_option_id,
      ));

      // Change vote
      $vote->poll_option_id = $option->poll_option_id;
      $vote->modified_date  = date("Y-m-d H:i:s");
      $vote->save();

      // Increment new option count
      $optionsTable->update(array(
        'votes' => new Zend_Db_Expr('votes + 1'),
      ), array(
        'question_id = ?' => $this->getIdentity(),
        'poll_option_id = ?' => $vote->poll_option_id,
      ));
    }

    return $this;
  }
   public function setPhoto($photo)
  {
    if( $photo instanceof Zend_Form_Element_File ) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if( $photo instanceof Storage_Model_File ) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if( $photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id) ) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if( is_string($photo) ) {
      $file = $photo;
      $fileName = $photo;
      $unlink = false;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }

    if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $name = basename($photo['name']);
    } else {
      $name = basename($file);
		}

    if( !$fileName ) {
      $fileName = $file;
    }

    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
      'parent_type' => 'sesquote_quote',
      'parent_id' => $this->getIdentity()
    );

    // Save
    $storage = Engine_Api::_()->storage();

    // Resize image (main)
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(720, 720)
      ->write($path . '/m_' . $name)
      ->destroy();

    // Resize image (profile)
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(200, 400)
      ->write($path . '/p_' . $name)
      ->destroy();


    // Store
    $iMain = $storage->create($path . '/m_' . $name, $params);
    $iProfile = $storage->create($path . '/p_' . $name, $params);

    $iMain->bridge($iProfile, 'thumb.profile');

    // Remove temp files
    @unlink($path . '/p_' . $name);
    @unlink($path . '/m_' . $name);

    // Update row
    $this->modified_date = date('Y-m-d H:i:s');
    $this->photo_id = $iMain->getIdentity();
    $this->save();
    return $this;
  }

  // Interfaces

  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   * */
  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }

  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   * */
  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }

  /**
   * Gets a proxy object for the tags handler
   *
   * @return Engine_ProxyObject
   * */
  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }
}
