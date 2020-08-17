<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Api_Core extends Core_Api_Abstract {

  function tagCloudItemCore($fetchtype = '', $note_id = '') {

    $tableTagmap = Engine_Api::_()->getDbTable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbTable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'pagenote')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if ($note_id) {
      $selecttagged_photo->where($tableTagName . '.resource_id =?', $note_id);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }

  public function deleteNote($note) {

    // delete note favourite entries
    Engine_Api::_()->getDbtable('favourites', 'sespage')->delete(array('resource_id = ?' => $note->getIdentity(), 'resource_type = ?' => $note->getType()));

    //Delete views extries
    Engine_Api::_()->getDbtable('recentlyviewitems', 'sespage')->delete(array('resource_id = ?' => $note->getIdentity(), 'resource_type = ?' => $note->getType()));

    // delete activity feed and its comments/likes
    $item = Engine_Api::_()->getItem('pagenote', $note->getIdentity());
    if ($item) {
      $item->delete();
    }
  }
}
