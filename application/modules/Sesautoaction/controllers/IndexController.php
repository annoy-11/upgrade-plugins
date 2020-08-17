<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesautoaction
 * @package    Sesautoaction
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesautoaction_IndexController extends Core_Controller_Action_Standard {

  public function getcontentAction() {

    $resource_type = $this->_getParam('resource_type', null);
    if(empty($resource_type))
        return;

    $autoactiontable = Engine_Api::_()->getDbTable('actions', 'sesautoaction');
    $autoactiontableName = $autoactiontable->info('name');

    $table = Engine_Api::_()->getItemTable($resource_type);
    $tableName = $table->info('name');

    $exselect = $autoactiontable->select()->from($autoactiontableName)->where('resource_type =?', $resource_type);
    $resultsex = $autoactiontable->fetchAll($exselect);
    $exIds = array();
    foreach($resultsex as $result) {
        $exIds[] = $result->resource_id;
    }

    $primary_id = current($table->info("primary"));

    $select = $table->select()->from($tableName);
    if(count($exIds) > 0)
        $select = $select->where($primary_id. ' NOT IN (?)', $exIds);

    $results = $table->fetchAll($select);
    $data = '';
    foreach($results as $result) {
        $id = $result->getIdentity();
        $data .= '<option value="' . $id . '">' . $result->getTitle() . '</option>';
    }
    echo $data;die;
  }

  public function showactionAction() {

    $resource_type = $this->_getParam('resource_type', null);
    if(empty($resource_type))
        return;

    $table = Engine_Api::_()->getItemTable($resource_type);
    $tableName = $table->info('name');

    $resourceclass = Engine_Api::_()->getItemClass($resource_type);

    $likeaction = $friendaction = $commentaction = $follow = $favourite = 0;

    if (method_exists($resourceclass, 'likes')) {
        $likeaction = 1;
    }
    if (method_exists($resourceclass, 'comments')) {
        $commentaction = 1;
    }

    if ($resource_type->type == 'user' && method_exists($resourceclass, 'membership')) {
        $friendaction = 1;
    }

    $dbChek = Zend_Db_Table_Abstract::getDefaultAdapter();
    $follow_count_exist = $dbChek->query("SHOW COLUMNS FROM ".$tableName." LIKE 'follow_count'")->fetch();
    if(!empty($follow_count_exist)) {
        $follow = 1;
    }

    $favourite_count_exist = $dbChek->query("SHOW COLUMNS FROM ".$tableName." LIKE 'favourite_count'")->fetch();
    if(!empty($favourite_count_exist)) {
        $favourite = 1;
    }

    echo json_encode(array('likeaction' => $likeaction, 'friend' => $friendaction, 'commentaction' => $commentaction, 'follow' => $follow, 'favourite' => $favourite));die;

  }
}
