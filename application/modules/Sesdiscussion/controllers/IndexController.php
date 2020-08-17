<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('discussion', null, 'view')->isValid() ) return;
  }

  function voteupAction() {

    $itemguid = $this->_getParam('itemguid',0);
    $userguid = $this->_getParam('userguid',0);
    $type = $this->_getParam('type','upvote');

    $item = Engine_Api::_()->getItemByGuid($itemguid);

    $isPageSubject = Engine_Api::_()->getItemByGuid($userguid);

    $isVote = Engine_Api::_()->getDbTable('voteupdowns','sesdiscussion')->isVote(array('resource_id'=>$item->getIdentity(),'resource_type'=>$item->getType(),'user_id'=>$isPageSubject->getIdentity(),'user_type'=>$isPageSubject->getType()));

    $checkType = "";
    if($isVote)
      $checkType = $isVote->type;

    if($checkType != "upvote" && $type == "upvote") {
      //up vote
      $table = Engine_Api::_()->getDbTable('voteupdowns','sesdiscussion');
      $vote = $table->createRow();
      $vote->type = "upvote";
      $vote->resource_type = $item->getType();
      $vote->resource_id = $item->getIdentity();
      $vote->user_type = $isPageSubject->getType();
      $vote->user_id = $isPageSubject->getIdentity();
      $vote->save();
      $item->vote_up_count = new Zend_Db_Expr('vote_up_count + 1');
      if($isVote){
         $isVote->delete();
         $item->vote_down_count = new Zend_Db_Expr('vote_down_count - 1');
      }
      $item->getTable()->update(array('total_votecount' => new Zend_Db_Expr('total_votecount + 1')), array('discussion_id = ?' => $item->getIdentity()));
      $item->save();
    } else {
      //down vote
      $table = Engine_Api::_()->getDbTable('voteupdowns','sesdiscussion');
      $vote = $table->createRow();
      $vote->type = "downvote";
      $vote->resource_type = $item->getType();
      $vote->resource_id = $item->getIdentity();
      $vote->user_type = $isPageSubject->getType();
      $vote->user_id = $isPageSubject->getIdentity();
      $vote->save();
      $item->vote_down_count = new Zend_Db_Expr('vote_down_count + 1');
      if($isVote){
        $isVote->delete();
        $item->vote_up_count = new Zend_Db_Expr('vote_up_count - 1');
      }
      $item->getTable()->update(array('total_votecount' => new Zend_Db_Expr('total_votecount - 1')), array('discussion_id = ?' => $item->getIdentity()));
      $item->save();
    }
    echo $this->view->partial('_updownvote.tpl', 'sesdiscussion', array('item' => $item,'isPageSubject'=>$isPageSubject));die;
  }

  public function getIframelyInformationAction() {

    $url = trim(strip_tags($this->_getParam('uri')));
    $ajax = $this->_getParam('ajax', false);
    $information = $this->handleIframelyInformation($url);
    $this->view->ajax = $ajax;
    $this->view->valid = !empty($information['code']);
    $this->view->iframely = $information;
  }

  public function previewAction() {

    // clean URL for html code
    $uri = trim(strip_tags($this->_getParam('uri')));
    $displayUri = $uri;
    $info = parse_url($displayUri);
    if( !empty($info['path']) ) {
      $displayUri = str_replace($info['path'], urldecode($info['path']), $displayUri);
    }
    $this->view->url = Engine_String::convertUtf8($displayUri);
    $this->view->title = '';
    $this->view->description = '';
    $this->view->thumb = null;
    $this->view->imageCount = 0;
    $this->view->images = array();
    try {
      $config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;

      if( !empty($config['host']) && $config['host'] != 'none' ) {
        $this->_getFromIframely($config, $uri);
      } else {
        $this->_getFromClientRequest($uri);
      }
    } catch( Exception $e ) {
      throw $e;
    }

    $this->view->title = Engine_String::convertUtf8($this->view->title);
    if($this->view->title){
      $this->view->valid = 1;
    } else {
      $this->view->valid = 0;
    }
    $this->view->description = Engine_String::convertUtf8($this->view->description);
  }


  protected function _getFromIframely($config, $uri)
  {
    $iframely = Engine_Iframely::factory($config)->get($uri);

    $images = ''; //array();
    if( !empty($iframely['links']['thumbnail']) ) {
      $images = $iframely['links']['thumbnail'][0]['href'];
    }
    if( !empty($iframely['meta']['title']) ) {
      $this->view->title = $iframely['meta']['title'];
    }
    if( !empty($iframely['meta']['description']) ) {
      $this->view->description = $iframely['meta']['description'];
    }
    $this->view->imageCount = count($images);
    $this->view->images = $images;
//     $allowRichHtmlTyes = array(
//       'player',
//       'image',
//       'reader',
//       'survey',
//       'file'
//     );
//     $typeOfContent = array_intersect(array_keys($iframely['links']), $allowRichHtmlTyes);
//     if( $typeOfContent ) {
//       $this->view->richHtml = $iframely['html'];
//     }
  }

  protected function _getFromClientRequest($uri)
  {
    $info = parse_url($uri);
    if( !empty($info['path']) ) {
      $path = urldecode($info['path']);
      foreach( explode('/', $info['path']) as $path ) {
        $paths[] = urlencode($path);
      }
      $uri = str_replace($info['path'], join('/', $paths), $uri);
    }
    $client = new Zend_Http_Client($uri, array(
      'maxredirects' => 2,
      'timeout' => 10,
    ));
    // Try to mimic the requesting user's UA
    $client->setHeaders(array(
      'User-Agent' => $_SERVER['HTTP_USER_AGENT'],
      'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      'X-Powered-By' => 'Zend Framework'
    ));
    $response = $client->request();
    // Get content-type
    list($contentType) = explode(';', $response->getHeader('content-type'));
    $this->view->contentType = $contentType;
    // Handling based on content-type
    switch( strtolower($contentType) ) {
      // Images
      case 'image/gif':
      case 'image/jpeg':
      case 'image/jpg':
      case 'image/tif': // Might not work
      case 'image/xbm':
      case 'image/xpm':
      case 'image/png':
      case 'image/bmp': // Might not work
        $this->_previewImage($uri, $response);
        break;
      // HTML
      case '':
      case 'text/html':
        $this->_previewHtml($uri, $response);
        break;
      // Plain text
      case 'text/plain':
        $this->_previewText($uri, $response);
        break;
      // Unknown
      default:
        break;
    }
  }

  protected function _previewImage($uri, Zend_Http_Response $response)
  {
    $this->view->imageCount = 1;
    $this->view->images = array($uri);
  }

  protected function _previewText($uri, Zend_Http_Response $response)
  {
    $body = $response->getBody();
    if( preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getHeader('content-type'), $matches) ||
      preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getBody(), $matches) ) {
      $charset = trim($matches[1]);
    } else {
      $charset = 'UTF-8';
    }
    // Reduce whitespace
    $body = preg_replace('/[\n\r\t\v ]+/', ' ', $body);
    $this->view->title = substr($body, 0, 63);
    $this->view->description = substr($body, 0, 255);
  }

  protected function _previewHtml($uri, Zend_Http_Response $response)
  {
    $body = $response->getBody();
    $body = trim($body);
    if( preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getHeader('content-type'), $matches) ||
      preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getBody(), $matches) ) {
      $this->view->charset = $charset = trim($matches[1]);
    } else {
      $this->view->charset = $charset = 'UTF-8';
    }
    if( function_exists('mb_convert_encoding') ) {
      $body = mb_convert_encoding($body, 'HTML-ENTITIES', $charset);
    }
    // Get DOM
    if( class_exists('DOMDocument') ) {
      $dom = new Zend_Dom_Query($body);
    } else {
      $dom = null; // Maybe add b/c later
    }
    $title = null;
    if( $dom ) {
      $titleList = $dom->query('title');
      if( count($titleList) > 0 ) {
        $title = trim($titleList->current()->textContent);
      }
    }
    $this->view->title = $title;
    $description = null;
    if( $dom ) {
      $descriptionList = $dom->queryXpath("//meta[@name='description']");
      // Why are they using caps? -_-
      if( count($descriptionList) == 0 ) {
        $descriptionList = $dom->queryXpath("//meta[@name='Description']");
      }
      // Try to get description which is set under og tag
      if( count($descriptionList) == 0 ) {
        $descriptionList = $dom->queryXpath("//meta[@property='og:description']");
      }
      if( count($descriptionList) > 0 ) {
        $description = trim($descriptionList->current()->getAttribute('content'));
      }
    }
    $this->view->description = $description;
    $thumb = null;
    if( $dom ) {
      $thumbList = $dom->queryXpath("//link[@rel='image_src']");
      $attributeType = 'href';
      if(count($thumbList) == 0 ) {
        $thumbList = $dom->queryXpath("//meta[@property='og:image']");
        $attributeType = 'content';
      }
      if( count($thumbList) > 0 ) {
        $thumb = $thumbList->current()->getAttribute($attributeType);
      }
    }
    $this->view->thumb = $thumb;
    $medium = null;
    if( $dom ) {
      $mediumList = $dom->queryXpath("//meta[@name='medium']");
      if( count($mediumList) > 0 ) {
        $medium = $mediumList->current()->getAttribute('content');
      }
    }
    $this->view->medium = $medium;
    // Get baseUrl and baseHref to parse . paths
    $baseUrlInfo = parse_url($uri);
    $baseUrl = null;
    $baseHostUrl = null;
    $baseUrlScheme = $baseUrlInfo['scheme'];
    $baseUrlHost = $baseUrlInfo['host'];
    if( $dom ) {
      $baseUrlList = $dom->query('base');
      if( $baseUrlList && count($baseUrlList) > 0 && $baseUrlList->current()->getAttribute('href') ) {
        $baseUrl = $baseUrlList->current()->getAttribute('href');
        $baseUrlInfo = parse_url($baseUrl);
        if( !isset($baseUrlInfo['scheme']) || empty($baseUrlInfo['scheme']) ) {
          $baseUrlInfo['scheme'] = $baseUrlScheme;
        }
        if( !isset($baseUrlInfo['host']) || empty($baseUrlInfo['host']) ) {
          $baseUrlInfo['host'] = $baseUrlHost;
        }
        $baseHostUrl = $baseUrlInfo['scheme'] . '://' . $baseUrlInfo['host'] . '/';
      }
    }
    if( !$baseUrl ) {
      $baseHostUrl = $baseUrlInfo['scheme'] . '://' . $baseUrlInfo['host'] . '/';
      if( empty($baseUrlInfo['path']) ) {
        $baseUrl = $baseHostUrl;
      } else {
        $baseUrl = explode('/', $baseUrlInfo['path']);
        array_pop($baseUrl);
        $baseUrl = join('/', $baseUrl);
        $baseUrl = trim($baseUrl, '/');
        $baseUrl = $baseUrlInfo['scheme'] . '://' . $baseUrlInfo['host'] . '/' . $baseUrl . '/';
      }
    }
    $images = array();
    if( $thumb ) {
      $images[] = $thumb;
    }
    if( $dom ) {
      $imageQuery = $dom->query('img');
      foreach( $imageQuery as $image ) {
        $src = $image->getAttribute('src');
        // Ignore images that don't have a src
        if( !$src || false === ($srcInfo = @parse_url($src)) ) {
          continue;
        }
        $ext = ltrim(strrchr($src, '.'), '.');
        // Detect absolute url
        if( strpos($src, '/') === 0 ) {
          // If relative to root, add host
          $src = $baseHostUrl . ltrim($src, '/');
        } elseif( strpos($src, './') === 0 ) {
          // If relative to current path, add baseUrl
          $src = $baseUrl . substr($src, 2);
        } elseif( !empty($srcInfo['scheme']) && !empty($srcInfo['host']) ) {
          // Contians host and scheme, do nothing
        } elseif( empty($srcInfo['scheme']) && empty($srcInfo['host']) ) {
          // if not contains scheme or host, add base
          $src = $baseUrl . ltrim($src, '/');
        } elseif( empty($srcInfo['scheme']) && !empty($srcInfo['host']) ) {
          // if contains host, but not scheme, add scheme?
          $src = $baseUrlInfo['scheme'] . ltrim($src, '/');
        } else {
          // Just add base
          $src = $baseUrl . ltrim($src, '/');
        }

        if( !in_array($src, $images) ) {
          $images[] = $src;
        }
      }
    }
    // Unique
    $images = array_values(array_unique($images));
    // Truncate if greater than 20
    if( count($images) > 1 ) {
      array_splice($images, 1, count($images));
    }
    $this->view->imageCount = count($images);
    $this->view->images = $images;
  }

  function followAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    if ($viewer->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $Fav = Engine_Api::_()->getDbTable('followers', 'sesdiscussion')->getItemFollower('discussion', $item_id);
    $followerItem = Engine_Api::_()->getDbTable('discussions', 'sesdiscussion');
    if (count($Fav) > 0) {
      //delete
      $db = $Fav->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $Fav->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count - 1')), array('discussion_id = ?' => $item_id));
      $item = Engine_Api::_()->getItem('discussion', $item_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesdiscussion_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->sesbasic()->deleteFeed(array('type' => 'sesdiscussion_follow', "subject_id" => $viewer->getIdentity(), "object_type" => $item->getType(), "object_id" => $item->getIdentity()));
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->follow_count));
      $this->view->follower_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('followers', 'sesdiscussion')->getAdapter();
      $db->beginTransaction();
      try {
        $follow = Engine_Api::_()->getDbTable('followers', 'sesdiscussion')->createRow();
        $follow->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $follow->resource_type = 'discussion';
        $follow->resource_id = $item_id;
        $follow->save();
        $followerItem->update(array('follow_count' => new Zend_Db_Expr('follow_count + 1')), array('discussion_id = ?' => $item_id));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem('discussion', @$item_id);
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbTable('actions', 'activity');

        $result = $activityTable->fetchRow(array('type =?' => 'sesdiscussion_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, 'sesdiscussion_follow');
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }

        Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'sesdiscussion_follow', "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($item->getOwner(), $viewer, $item, 'sesdiscussion_follow');
      }
      $this->view->follower_id = 1;
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->follow_count, 'follower_id' => 1));
      die;
    }
  }

  //item favourite as per item tye given
  function favouriteAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login')); die;
    }

    $type = 'discussion';
    $dbTable = 'discussions';
    $resorces_id = 'discussion_id';
    $notificationType = 'sesdiscussion_favourite';

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesdiscussion')->getItemfav($type, $item_id);

    $favItem = Engine_Api::_()->getDbtable($dbTable, 'sesdiscussion');
    if (count($Fav) > 0) {
      //delete
      $db = $Fav->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $Fav->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count - 1')), array($resorces_id . ' = ?' => $item_id));
      $item = Engine_Api::_()->getItem($type, $item_id);
      if(@$notificationType) {
	      Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
	      Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
	      Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'sesdiscussion')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesdiscussion')->createRow();
        $fav->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $fav->resource_type = $type;
        $fav->resource_id = $item_id;
        $fav->save();
        $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count + 1'),
                ), array(
            $resorces_id . '= ?' => $item_id,
        ));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem(@$type, @$item_id);
      if(@$notificationType) {
	      $subject = $item;
	      $owner = $subject->getOwner();
	      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && @$notificationType) {
	        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
	        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
	        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
	        $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
	        if (!$result) {
	          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
	          if ($action)
	            $activityTable->attachActivity($action, $subject);
	        }
	      }
      }
      $this->view->favourite_id = 1;
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1));
      die;
    }
  }

  //fetch user like item as per given item id .
  public function likeItemAction() {

    $item_id = $this->_getParam('item_id', '0');
    $item_type = $this->_getParam('item_type', '0');
    if (!$item_id || !$item_type)
      return;
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title',0);
		$this->view->title = $title == '' ? $view->translate("People Who Like This") : $title;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $item = Engine_Api::_()->getItem($item_type, $item_id);
    $param['type'] = $this->view->item_type = $item_type;
    $param['id'] = $this->view->item_id = $item->getIdentity();
    $paginator = Engine_Api::_()->sesdiscussion()->likeItemCore($param);
    $this->view->item_id = $item_id;
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($page);
  }

  public function topDiscussionPostersAction() {

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title',0);
		$this->view->title = $title == '' ? $view->translate("People Who Like This") : $title;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';

    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');

    $discussionTable = Engine_Api::_()->getDbTable('discussions', 'sesdiscussion');
    $discussionTableName = $discussionTable->info('name');

    $select = $userTable->select()
                      ->from($userTable, array('COUNT(*) AS discussion_count', 'user_id', 'displayname'))
                      ->setIntegrityCheck(false)
                      ->join($discussionTableName, $discussionTableName . '.owner_id=' . $userTableName . '.user_id')
                      ->group($userTableName . '.user_id')
                      ->order('discussion_count DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($page);
  }


  function likeAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    if ($viewer_id == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }
    $type = $this->_getParam('type', false);

    $notificationType = 'sesdiscussion_discussion_like';

    $item_id = $this->_getParam('id');


    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }
    $item = Engine_Api::_()->getItem($type, $item_id);
    $itemTable = Engine_Api::_()->getDbtable('discussions', 'sesdiscussion');
    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');
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

      Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
      Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
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
        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array('discussion_id = ?' => $item_id));
        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //Send notification and activity feed work.
      $subject = $item;
      $owner = $subject->getOwner();
      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
        $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
        if (!$result) {
          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
          if ($action)
            $activityTable->attachActivity($action, $subject);
        }
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }

  public function discussionPopupAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $this->view->createform = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.createform', 1);

    $this->view->actionparam = $this->_getParam('actionparam',null);

    $this->view->discussion_id = $discussion_id = $this->_getParam('discussion_id',false);
    //$this->view->photo_id = $this->_getParam('photo_id',false);
    $this->view->discussions = $discussion = Engine_Api::_()->getItem('discussion',$discussion_id);
    // Get tags
    $this->view->discussionTags = $discussion->tags()->getTagMaps();
    // Do other stuff
    $this->view->mine = true;
    $this->view->canEdit = $this->_helper->requireAuth()->setAuthParams($discussion, null, 'edit')->checkRequire();
  }

  public function viewAction() {

    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $discussion = Engine_Api::_()->getItem('discussion', $this->_getParam('discussion_id'));
    if( $discussion ) {
      Engine_Api::_()->core()->setSubject($discussion);
    }

    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }

    $canView = $this->_helper->requireAuth()->setAuthParams('discussion', null, 'view')->checkRequire();
    if(empty($canView)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    if( !$discussion->getOwner()->isSelf(Engine_Api::_()->user()->getViewer()) ) {
      $discussion->getTable()->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'discussion_id = ?' => $discussion->getIdentity(),
      ));
      $this->view->mine = false;
    }

    if ($viewer->getIdentity() != 0 && isset($discussion->discussion_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_sesdiscussion_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $discussion->discussion_id . '", "sesdiscussion_discussion","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }

    // Render
    $this->_helper->content->setEnabled();
  }

  public function topVotedAction()
  {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function indexAction()
  {
    // Render
    $this->_helper->content->setEnabled();
  }

  // USER SPECIFIC METHODS
  public function manageAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;
    // Render
    $this->_helper->content->setEnabled();
  }


  public function createAction()
  {

    $this->view->createform = $createform = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.createform', 1);

    $sessmoothbox = $this->view->typesmoothbox = false;
		if($this->_getParam('typesmoothbox',false)){
      // Render
			$sessmoothbox = true;
			$this->view->typesmoothbox = true;
			$this->_helper->layout->setLayout('default-simple');
			$layoutOri = $this->view->layout()->orientation;
      if ($layoutOri == 'right-to-left') {
          $this->view->direction = 'rtl';
      } else {
          $this->view->direction = 'ltr';
      }

      $language = explode('_', $this->view->locale()->getLocale()->__toString());
      $this->view->language = $language[0];
		}

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('discussion', null, 'create')->isValid()) return;

    // set up data needed to check quota
    $viewer = Engine_Api::_()->user()->getViewer();

    if($createform && !$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesdiscussion_Form_Create();
    }

    if(empty($createform)) {
      $is_ajax = 1;
      // Render
      $this->_helper->content->setEnabled();

      $this->view->form = $form = new Sesdiscussion_Form_Create();

      // If not post or form not valid, return
      if( !$this->getRequest()->isPost() ) {
        return;
      }

      if( !$form->isValid($this->getRequest()->getPost()) ) {
        return;
      }
    }

    if($is_ajax) {
      // Process
      $table = Engine_Api::_()->getItemTable('discussion');
      $db = $table->getAdapter();
      $db->beginTransaction();
      $values = $_POST; //$form->getValues();

      unset($values['photo_preview']);
      try {
        // Create blog
        $viewer = Engine_Api::_()->user()->getViewer();
        $formValues = $_POST; //$form->getValues();

        if( empty($values['auth_view']) ) {
          $formValues['auth_view'] = 'everyone';
        }

        if( empty($values['auth_comment']) ) {
          $formValues['auth_comment'] = 'everyone';
        }

        $values = array_merge($formValues, array(
          'owner_type' => $viewer->getType(),
          'owner_id' => $viewer->getIdentity(),
        ));

        if($values['video']) {
          $information = $this->handleIframelyInformation($values['video']);
          $values['code'] = $information['code'];
        }

        $title = $values['discussiontitle'];
        $discussiontitle = $values['title'];
        $values['discussiontitle'] = $discussiontitle;
        $values['title'] = $title;

        $discussion = $table->createRow();
        $discussion->setFromArray($values);
        $discussion->save();

        //New Level work
        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.automaticallymarkasnew', 0)) {
          $discussion->new = 1;
          $discussion->save();
        }

        // Direct URL upload
        if(empty($_POST['photolink'])) {
          if(!empty($_FILES['photo']['name'])) {
            $discussion->setPhoto($_FILES['photo']);
          }
        } elseif($_POST['photolink']) {
          $discussion->setPhoto($_POST['photolink']);
        }

        // Auth
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

        $viewMax = array_search($values['auth_view'], $roles);
        $commentMax = array_search($values['auth_comment'], $roles);

        foreach( $roles as $i => $role ) {
          $auth->setAllowed($discussion, $role, 'view', ($i <= $viewMax));
          $auth->setAllowed($discussion, $role, 'comment', ($i <= $commentMax));
        }

        // Add tags
        $tags = preg_split('/[,]+/', $values['tags']);
        $discussion->tags()->addTagMaps($viewer, $tags);

        // Add activity only if blog is published
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $discussion, 'sesdiscussion_new');
        // make sure action exists before attaching the blog to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $discussion);
        }

        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
          }
          $discussion->action_id = $action->getIdentity();
          $discussion->save();
        }

        // Commit
        $db->commit();

        if($createform) {
          echo Zend_Json::encode(array('status' => 1,'url' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('user_id' => $discussion->owner_id, 'discussion_id' => $discussion->discussion_id, 'slug' => $discussion->getSlug()), 'sesdiscussion_entry_view', true)));exit();
        } else {
          return $this->_helper->redirector->gotoRoute(array('user_id' => $discussion->owner_id, 'discussion_id' => $discussion->discussion_id, 'slug' => $discussion->getSlug()), 'sesdiscussion_entry_view', true);
        }
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        //echo 0;die;
      }
    }

  }


  public function editAction()
  {
    $this->view->createform = $createform = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.createform', 1);

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);

    if( !$this->_helper->requireUser()->isValid() ) return;

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->discussion_id = $this->_getParam('discussion_id');
    $this->view->discussion = $discussion = Engine_Api::_()->getItem('discussion', $this->_getParam('discussion_id'));

    if (isset($discussion->category_id) && $discussion->category_id != 0)
      $this->view->category_id = $discussion->category_id;
    else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;

    if (isset($discussion->subcat_id) && $discussion->subcat_id != 0)
      $this->view->subcat_id = $discussion->subcat_id;
    else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;

    if (isset($discussion->subsubcat_id) && $discussion->subsubcat_id != 0)
      $this->view->subsubcat_id = $discussion->subsubcat_id;
    else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;

    if( !$this->_helper->requireAuth()->setAuthParams($discussion, $viewer, 'edit')->isValid() ) return;

    if(!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Sesdiscussion_Form_Edit();

      $this->view->category_id = $discussion->category_id;
      $this->view->subcat_id = $discussion->subcat_id;
      $this->view->subsubcat_id = $discussion->subsubcat_id;

      // Populate form
      $form->populate($discussion->toArray());

        $tagStr = '';
        foreach( $discussion->tags()->getTagMaps() as $tagMap ) {
            $tag = $tagMap->getTag();
            if( !isset($tag->text) ) continue;
            if( '' !== $tagStr ) $tagStr .= ', ';
            $tagStr .= $tag->text;
        }

        $form->populate(array(
            'tags' => $tagStr,
            'discussiontitle' => $discussion->title,
            'title' => $discussion->discussiontitle,
        ));
        $this->view->tagNamePrepared = $tagStr;

      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      foreach( $roles as $role ) {
        if ($form->auth_view){
          if( $auth->isAllowed($discussion, $role, 'view') ) {
           $form->auth_view->setValue($role);
          }
        }

        if ($form->auth_comment){
          if( $auth->isAllowed($discussion, $role, 'comment') ) {
            $form->auth_comment->setValue($role);
          }
        }
      }
    }

    if(empty($createform)) {

      // Render
      $this->_helper->content->setEnabled();

      // Check post/form
      if( !$this->getRequest()->isPost() ) {
        return;
      }
      if( !$form->isValid($this->getRequest()->getPost()) ) {
        return;
      }
      $is_ajax = 1;
    }

    if($is_ajax) {
      // Process
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $values = $_POST; //$form->getValues();

        if( empty($values['auth_view']) ) {
          $values['auth_view'] = 'everyone';
        }
        if( empty($values['auth_comment']) ) {
          $values['auth_comment'] = 'everyone';
        }

        $title = $values['discussiontitle'];
        $discussiontitle = $values['title'];
        $values['discussiontitle'] = $discussiontitle;
        $values['title'] = $title;

        $discussion->setFromArray($values);
        $discussion->modified_date = date('Y-m-d H:i:s');
        $discussion->save();

        // Add photo
        if( !empty($_FILES['photo']['name']) ) {
          $discussion->setPhoto($_FILES['photo']);
        }

        // handle tags
        $tags = preg_split('/[,]+/', $values['tags']);
        $discussion->tags()->setTagMaps($viewer, $tags);

        if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags && $discussion->action_id) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$discussion->action_id."'");
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$discussion->action_id.'", "'.$tag.'")');
          }
        }
        // Commit
        $db->commit();

        if($createform) {
            echo Zend_Json::encode(array('status' => 1,'url' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('user_id' => $discussion->owner_id, 'discussion_id' => $discussion->discussion_id, 'slug' => $discussion->getSlug()), 'sesdiscussion_entry_view', true)));exit();
        } else {
          return $this->_helper->redirector->gotoRoute(array('user_id' => $discussion->owner_id, 'discussion_id' => $discussion->discussion_id, 'slug' => $discussion->getSlug()), 'sesdiscussion_entry_view', true);
        }
      } catch( Exception $e ) {
        $db->rollBack();
        throw $e;
        echo 0;die;
      }
    }
  }

  // HELPER FUNCTIONS
  public function handleIframelyInformation($uri) {

    $iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion_iframely_disallow');
    if (parse_url($uri, PHP_URL_SCHEME) === null) {
        $uri = "http://" . $uri;
    }
    $uriHost = Zend_Uri::factory($uri)->getHost();
    if ($iframelyDisallowHost && in_array($uriHost, $iframelyDisallowHost)) {
        return;
    }
    $config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;
    $iframely = Engine_Iframely::factory($config)->get($uri);
    if (!in_array('player', array_keys($iframely['links']))) {
        return;
    }
    $information = array('thumbnail' => '', 'title' => '', 'description' => '', 'duration' => '');
    if (!empty($iframely['links']['thumbnail'])) {
        $information['thumbnail'] = $iframely['links']['thumbnail'][0]['href'];
        if (parse_url($information['thumbnail'], PHP_URL_SCHEME) === null) {
            $information['thumbnail'] = str_replace(array('://', '//'), '', $information['thumbnail']);
            $information['thumbnail'] = "http://" . $information['thumbnail'];
        }
    }
    if (!empty($iframely['meta']['title'])) {
        $information['title'] = $iframely['meta']['title'];
    }
    if (!empty($iframely['meta']['description'])) {
        $information['description'] = $iframely['meta']['description'];
    }
    if (!empty($iframely['meta']['duration'])) {
        $information['duration'] = $iframely['meta']['duration'];
    }
    $information['code'] = $iframely['html'];
    return $information;
  }

  public function deleteAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $discussion = Engine_Api::_()->getItem('discussion', $this->getRequest()->getParam('discussion_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($discussion, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesdiscussion_Form_Delete();

    if( !$discussion ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Discussion entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $discussion->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
        $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
        $dbGetInsert->query("DELETE FROM engine4_sesadvancedactivity_hashtags WHERE action_id = '".$discussion->action_id."'");
      }
      $discussion->delete();

      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your discussion entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesdiscussion_general', true),
      'messages' => Array($this->view->message)
    ));
  }
}
