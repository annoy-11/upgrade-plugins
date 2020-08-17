<?php

class Sesdocument_Api_Core extends Core_Api_Abstract {


public function getColumnName($value) {
		switch ($value) {
			case 'recently created':
			$optionKey = 'creation_date ASC';
			break;
					case 'most viewed':
			$optionKey = 'view_count DESC';
			break;
					case 'most liked':
			$optionKey = 'like_count DESC';
			break;
					case 'most commented':
			$optionKey = 'comment_count DESC';
			break;
					case 'most rated':
			$optionKey = 'rating DESC';
			break;
		  case 'most favourite':
			$optionKey = 'favourite_count DESC';
      break;
      case 'starttime':
			  $optionKey = 'starttime DESC';
			break;
			default:
			$optionKey = $value;
		};
    return $optionKey;
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
  public function allowReviewRating(){
		if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesdocumentreview') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdocumentreview.allow.review', 1)){
		 	return true;
		}
		return false;
	}

  public function checkPrivacySetting($id) {

    $item = Engine_Api::_()->getItem('sesdocument', $id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    if ($viewerId)
      $level_id = $viewer->level_id;
    else
      $level_id = 5;

    $levels = $item->levels;
    $member_level = explode(",",$item->levels); //json_decode($levels);

    if (!empty($member_level) && !empty($item->levels)) {
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
        $networks = explode(",",$item->networks); //json_decode($item->networks);

        if (!empty($networks)) {
          if (!array_intersect($network_id_array, $networks))
            return false;
        } else
          return true;
      }
    }
    return true;
  }

   public function getLikeStatusDocument($document_id = '', $moduleName = '') {
    if ($moduleName == '')
      $moduleName = 'sesdocument';
    if ($document_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()
              ->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))
              ->where('resource_type =?', $moduleName)
              ->where('poster_id =?', $userId)
              ->where('poster_type =?', 'user')
              ->where(' resource_id =?', $document_id)
              ->query()
              ->fetchColumn();
      if ($total_likes > 0)
        return true;
      else
        return false;
    }
    return false;
  }

   function tagCloudItemCore($fetchtype = '') {

    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'sesdocument')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');

    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));

    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }
    public function ratingCount($video_id){
    $table  = Engine_Api::_()->getDbTable('ratings', 'sesdocument');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.sesdocument_id = ?', $video_id);
    $row = $table->fetchAll($select);
    $total = count($row);
    return $total;
  }
  public function checkRated($video_id, $user_id)
  {
    $table  = Engine_Api::_()->getDbTable('ratings', 'sesdocument');

    $rName = $table->info('name');
    $select = $table->select()
                 ->setIntegrityCheck(false)
                    ->where('sesdocument_id = ?', $video_id)
                    ->where('user_id = ?', $user_id)
                    ->limit(1);
    $row = $table->fetchAll($select);

    if (count($row)>0) return true;
    return false;
  }
    public function getRating($video_id)
  {
    $table  = Engine_Api::_()->getDbTable('ratings', 'sesdocument');
    $rating_sum = $table->select()
      ->from($table->info('name'), new Zend_Db_Expr('SUM(rating)'))
      ->group('sesdocument_id')
      ->where('sesdocument_id = ?', $video_id)
      ->query()
      ->fetchColumn(0)
      ;

    $total = $this->ratingCount($video_id);
    if ($total) $rating = $rating_sum/$this->ratingCount($video_id);
    else $rating = 0;

    return $rating;
  }
    public function setRating($video_id, $user_id, $rating){

    $table  = Engine_Api::_()->getDbTable('ratings', 'sesdocument');
    $rName = $table->info('name');
    $select = $table->select()
                    ->from($rName)
                    ->where($rName.'.sesdocument_id = ?', $video_id)
                    ->where($rName.'.user_id = ?', $user_id);
    $row = $table->fetchRow($select);
    if (empty($row)) {
      // create rating
      Engine_Api::_()->getDbTable('ratings', 'sesdocument')->insert(array(
        'sesdocument_id' => $video_id,
        'user_id' => $user_id,
        'rating' => $rating
      ));
    }
}
    public function deleteDocument($document) {

        Engine_Api::_()->getDbTable('ratings', 'sesdocument')->delete(array(
            'sesdocument_id = ?' => $document->sesdocument_id,
        ));
        Engine_Api::_()->getDbTable('favourites', 'sesdocument')->delete(array(
            'resource_id = ?' => $document->sesdocument_id,
        ));
        if ($document->photo_id){
            Engine_Api::_()->getItem('storage_file', $document->photo_id)->remove();
            Engine_Api::_()->getItem('storage_file', $document->file_id)->remove();
        }
        $document->delete();
    }
}
