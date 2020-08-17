<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-11-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Api_Core extends Core_Api_Abstract {

  public function getAdminnSuperAdmins() {
    $userTable = Engine_Api::_()->getDbTable('users', 'user');
    $select = $userTable->select()->from($userTable->info('name'), 'user_id')->where('level_id IN (?)', array(1,2));
    $results = $select->query()->fetchAll();
    return $results;
  }

  public function getBaseUrl($staticBaseUrl = true,$url = "") {
      if(strpos($url,'http') !== false)
          return $url;
      $http = '';
      if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off'){
          $http = '';
      }
      $baseUrl =  APPLICATION_PATH.$url;
      if(Zend_Registry::get('StaticBaseUrl') != "/")
          $baseUrl = str_replace(Zend_Registry::get('StaticBaseUrl'),'/',$baseUrl);
      return $http.str_replace('//','/',$baseUrl);
  }

  public function ratingCount($edocument_id){
    $table  = Engine_Api::_()->getDbTable('ratings', 'edocument');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.edocument_id = ?', $edocument_id);
    $row = $table->fetchAll($select);
    $total = count($row);
    return $total;
  }
  public function getRating($edocument_id)
  {
    $table  = Engine_Api::_()->getDbTable('ratings', 'edocument');
    $rating_sum = $table->select()
      ->from($table->info('name'), new Zend_Db_Expr('SUM(rating)'))
      ->group('edocument_id')
      ->where('edocument_id = ?', $edocument_id)
      ->query()
      ->fetchColumn(0);
    $total = $this->ratingCount($edocument_id);
    if ($total) $rating = $rating_sum/$this->ratingCount($edocument_id);
    else $rating = 0;

    return $rating;
  }

  public function getRatings($edocument_id)
  {
    $table  = Engine_Api::_()->getDbTable('ratings', 'edocument');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.edocument_id = ?', $edocument_id);
    $row = $table->fetchAll($select);
    return $row;
  }

  public function checkRated($edocument_id, $user_id)
  {
    $table  = Engine_Api::_()->getDbTable('ratings', 'edocument');

    $rName = $table->info('name');
    $select = $table->select()
                 ->setIntegrityCheck(false)
                    ->where('edocument_id = ?', $edocument_id)
                    ->where('user_id = ?', $user_id)
                    ->limit(1);
    $row = $table->fetchAll($select);

    if (count($row)>0) return true;
    return false;
  }

  public function setRating($edocument_id, $user_id, $rating){
    $table  = Engine_Api::_()->getDbTable('ratings', 'edocument');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.edocument_id = ?', $edocument_id)
                    ->where($rName.'.user_id = ?', $user_id);
    $row = $table->fetchRow($select);
    if (empty($row)) {
      // create rating
      Engine_Api::_()->getDbTable('ratings', 'edocument')->insert(array(
        'edocument_id' => $edocument_id,
        'user_id' => $user_id,
        'rating' => $rating
      ));
    }
  }

	public function isDocumentAdmin($document = null, $privacy = null) {

        $viewer = Engine_Api::_()->user()->getViewer();
        if(!isset($document->owner_id))
            return 0;
        if($viewer->getIdentity()) {
            if($viewer->level_id == 1 || $viewer->level_id == 2)
                return 1;
        }
        $level_id = Engine_Api::_()->getItem('user', $document->owner_id)->level_id;
        if($privacy == 'create') {
            return 1;
        }
        else {
            if(!Engine_Api::_()->authorization()->getPermission($level_id, 'edocument', $privacy))
                return 0;
            else {
                return 1;
            }
        }
	}

    public function checkPrivacySetting($document_id) {

        $document = Engine_Api::_()->getItem('edocument', $document_id);
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();

        if ($viewerId)
            $level_id = $viewer->level_id;
        else
            $level_id = 5;

        $levels = $document->levels;
        $member_level = explode(",",$document->levels); //json_decode($levels);

        if (!empty($member_level)  && !empty($item->levels)) {
            if (!in_array($level_id, $member_level))
                return false;
        } else
            return true;


        if ($viewerId) {
            $network_table = Engine_Api::_()->getDbtable('membership', 'network');
            $network_select = $network_table->select('resource_id')->where('user_id = ?', $viewerId);
            $network_id_query = $network_table->fetchAll($network_select);
            $network_id_query_count = count($network_id_query);
            $network_id_array = array();
            for ($i = 0; $i < $network_id_query_count; $i++) {
                $network_id_array[$i] = $network_id_query[$i]['resource_id'];
            }

            if (!empty($network_id_array)) {
                $networks = explode(",",$document->networks);

                if (!empty($networks)) {
                    if (!array_intersect($network_id_array, $networks))
                        return false;
                } else
                    return true;
            }
        }
        return true;
    }

	public function allowReviewRating() {

		if (Engine_Api::_()->getApi('settings', 'core')->getSetting('edocument.allow.review', 1))
            return true;

		return false;
	}

    public function deleteDocument($edocument = null) {

		if(!$edocument)
			return false;

        $documentId = $edocument->edocument_id;
		$owner_id = $edocument->owner_id;

		//Delete Favourites
		$edocumentFavouritesTable = Engine_Api::_()->getDbtable('favourites', 'edocument');
		$edocumentFavouritesTable->delete(array(
			'user_id = ?' => $owner_id,
            'resource_id = ?' =>  $documentId,
		));
		$edocument->delete();
	}

    function tagCloudItemCore($fetchtype = '', $edocument_id = '') {

        $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
        $tableTagName = $tableTagmap->info('name');

        $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
        $tableMainTagName = $tableTag->info('name');

        $select = $tableTagmap->select()
                ->from($tableTagName)
                ->setIntegrityCheck(false)
                ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
                ->where('resource_type =?', 'edocument')
                ->where('tag_type =?', 'core_tag')
                ->group($tableTagName . '.tag_id');
        if($edocument_id) {
            $select->where($tableTagName.'.resource_id =?', $edocument_id);
        }
        $select->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));

        if ($fetchtype == '')
            return Zend_Paginator::factory($select);
        else
            return $tableTagmap->fetchAll($select);
    }

    public function likeItemCore($params = array()) {

        $parentTable = Engine_Api::_()->getItemTable('core_like');
        $parentTableName = $parentTable->info('name');
        $select = $parentTable->select()
                ->from($parentTableName)
                ->where('resource_type = ?', $params['type'])
                ->order('like_id DESC');
        if (isset($params['id']))
            $select = $select->where('resource_id = ?', $params['id']);
        if (isset($params['poster_id']))
            $select = $select->where('poster_id =?', $params['poster_id']);
        return Zend_Paginator::factory($select);
    }

    public function getIdentityWidget($name, $type, $corePages) {

        $widgetTable = Engine_Api::_()->getDbTable('content', 'core');
        $widgetPages = Engine_Api::_()->getDbTable('pages', 'core')->info('name');
        $identity = $widgetTable->select()
                ->setIntegrityCheck(false)
                ->from($widgetTable, 'content_id')
                ->where($widgetTable->info('name') . '.type = ?', $type)
                ->where($widgetTable->info('name') . '.name = ?', $name)
                ->where($widgetPages . '.name = ?', $corePages)
                ->joinLeft($widgetPages, $widgetPages . '.page_id = ' . $widgetTable->info('name') . '.page_id')
                ->query()
                ->fetchColumn();
        return $identity;
    }

    public function getLikeStatus($edocument_id = '', $resource_type = '') {

        if ($edocument_id != '') {
            $userId = Engine_Api::_()->user()->getViewer()->getIdentity();

        if ($userId == 0)
            return false;

        $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');

        $total_likes = $coreLikeTable->select()
                                    ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
                                    ->where('resource_type =?', $resource_type)
                                    ->where('poster_id =?', $userId)
                                    ->where('poster_type =?', 'user')
                                    ->where('resource_id =?', $edocument_id)
                                    ->limit(1)
                                    ->query()
                                    ->fetchColumn();
        if ($total_likes > 0)
            return true;
        else
            return false;
        }
        return false;
    }

    public function getwidgetizePage($params = array()) {

        $corePages = Engine_Api::_()->getDbtable('pages', 'core');
        $corePagesName = $corePages->info('name');
        $select = $corePages->select()
                ->from($corePagesName, array('*'))
                ->where('name = ?', $params['name'])
                ->limit(1);
        return $corePages->fetchRow($select);
    }
}
