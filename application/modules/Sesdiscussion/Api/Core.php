<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Api_Core extends Core_Api_Abstract {

    public function getwidgetizePage($params = array()) {

        $corePages = Engine_Api::_()->getDbtable('pages', 'core');
        $corePagesName = $corePages->info('name');
        $select = $corePages->select()
                ->from($corePagesName, array('*'))
                ->where('name = ?', $params['name'])
                ->limit(1);
        return $corePages->fetchRow($select);
    }

  public function getLikeStatus($resource_id = '', $resource_type = '') {

    if ($resource_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $resource_type)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('resource_id =?', $resource_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0)
        return 1;
      else
        return 0;
    }
    return 0;
  }

  /* people like item widget paginator */
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
}
