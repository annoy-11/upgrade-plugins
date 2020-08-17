<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Albumsongs.php 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seseventmusic_Model_DbTable_Albumsongs extends Engine_Db_Table {

  protected $_rowClass = 'Seseventmusic_Model_Albumsong';

  public function getOfTheDayResults() {

    $select = $this->select()
            ->from($this->info('name'), array('*'))
            ->where('offtheday =?', 1)
            ->where('starttime <= DATE(NOW())')
            ->where('endtime >= DATE(NOW())')
            ->order('RAND()');
    return $this->fetchRow($select);
  }

  //Get all songs
  public function getAllSongs($album_id) {

    $select = $this->select()
            ->from($this->info('name'))
            ->where('album_id = ?', $album_id);
    return $this->fetchAll($select);
  }

  //Song count in album
  public function songsCount($album_id) {
    return $this->select()
                    ->from($this->info('name'), array('count(*) as song_count'))
                    ->where('album_id = ?', $album_id)
                    ->query()
                    ->fetchColumn();
  }

  //Widget Results according to parameters
  public function widgetResults($params = array()) {

    $albumTableName = Engine_Api::_()->getDbtable('albums', 'seseventmusic')->info('name');

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    $albumSongsTableName = $this->info('name');

    $select = $this->select()
            ->from($albumSongsTableName, $params['column'])
            ->joinLeft($albumTableName, "$albumTableName.album_id = $albumSongsTableName.album_id", null);

    //You may also like work
    if (isset($params['popularity']) && $params['popularity'] == "You May Also Like") {
      $albumSongsIds = Engine_Api::_()->seseventmusic()->likeIds(array('type' => 'seseventmusic_albumsong', 'id' => $viewer_id));
      $select->where($albumSongsTableName . '.albumsong_id NOT IN(?)', $albumSongsIds);
    }

    if (isset($params['widgteName'])) {

      if ($params['widgteName'] == "Lyrics Action")
        $select->where($albumSongsTableName . ".lyrics <> ?", '');

      if ($params['widgteName'] == "Recommanded Album Songs") {
        $select->where($albumTableName . ".owner_id <> ?", $viewer_id);
      }

      if ($params['widgteName'] == "Related Album Songs") {
        $select->where($albumSongsTableName . ".album_id <> ?", $params['album_id']);
      }

      if ($params['widgteName'] == "Other Album Songs") {
        $select->where($albumSongsTableName . ".albumsong_id <> ?", $params['albumsong_id'])
                ->where($albumTableName . ".owner_id = ?", $viewer_id);
      }

      if ($params['widgteName'] == "Other Songs of Music Album") {
        $select->where($albumSongsTableName . ".album_id = ?", $params['album_id']);
      }
    }

    if (isset($params['popularity'])) {
      if ($params['popularity'] == 'featured') {
        $select->where($albumSongsTableName . ".featured = ?", 1);
      } elseif ($params['popularity'] == 'sponsored') {
        $select->where($albumSongsTableName . ".sponsored = ?", 1);
      } elseif ($params['popularity'] == 'bothfesp') {
        $select->where($albumSongsTableName . ".featured = ?", 1)
                ->where($albumSongsTableName . ".sponsored = ?", 1);
      }
    }

    if (isset($params['displayContentType'])) {
      if ((isset($params['displayContentType']) && $params['displayContentType'] == 'featured')) {
        $select->where($albumSongsTableName . ".featured = ?", 1);
      } elseif ((isset($params['displayContentType']) && $params['displayContentType'] == 'sponsored')) {
        $select->where($albumSongsTableName . ".sponsored = ?", 1);
      } elseif ((isset($params['displayContentType']) && $params['displayContentType'] == 'feaspo')) {
        $select->where($albumSongsTableName . ".featured = ?", 1)
                ->where($albumSongsTableName . ".sponsored = ?", 1);
      } elseif (isset($params['displayContentType']) && $params['displayContentType'] == 'hotlat') {
        $select->where($albumSongsTableName . ".hot = ?", 1)
                ->where($albumSongsTableName . ".upcoming  = ?", 1);
      } elseif (isset($params['displayContentType']) && $params['displayContentType'] == 'hot') {
        $select->where($albumSongsTableName . ".hot = ?", 1);
      } elseif (isset($params['displayContentType']) && $params['displayContentType'] == 'upcoming') {
        $select->where($albumSongsTableName . ".upcoming = ?", 1);
      }
    }

    if ((isset($params['alphabet']) && $params['alphabet'] != 'all'))
      $select->where($albumSongsTableName . ".title LIKE ?", $params['alphabet'] . '%');

    //String Search
    if (!empty($params['title']) && !empty($params['title'])) {
      $select->where("$albumSongsTableName.title LIKE ?", "%{$params['title']}%")
              ->orWhere("$albumSongsTableName.description LIKE ?", "%{$params['title']}%");
    }

    if ((isset($params['alphabet']) && $params['alphabet'] != 'all'))
      $select->where($albumSongsTableName . ".title LIKE ?", $params['alphabet'] . '%');

    if (isset($params['popularity'])) {
      switch ($params['popularity']) {
        case "featured" :
          $select->order($albumSongsTableName . '.featured' . ' DESC')
                  ->order($albumSongsTableName . '.album_id DESC');
          break;
        case "sponsored" :
          $select->order($albumSongsTableName . '.sponsored' . ' DESC')
                  ->order($albumSongsTableName . '.album_id DESC');
          break;
        case "bothfesp":
          $select->order($albumSongsTableName . '.sponsored' . ' DESC')
                  ->order($albumSongsTableName . '.featured' . ' DESC')
                  ->order($albumSongsTableName . '.album_id DESC');
          break;
        case "hot":
          $select->order($albumSongsTableName . '.hot' . ' DESC')
                  ->order($albumSongsTableName . '.album_id DESC');
          break;
        case "view_count":
          $select->order($albumSongsTableName . '.view_count DESC');
          break;
        case "like_count":
          $select->order($albumSongsTableName . '.like_count DESC');
          break;
        case "comment_count":
          $select->order($albumSongsTableName . '.comment_count DESC');
          break;
        case "download_count":
          $select->order($albumSongsTableName . '.download_count DESC');
          break;
        case "upcoming":
          $select->order($albumSongsTableName . '.upcoming' . ' DESC')
                  ->order($albumSongsTableName . '.albumsong_id DESC');
          break;
        case "favourite_count":
          $select->order($albumSongsTableName . '.favourite_count DESC');
          break;
        case "play_count":
          $select->order($albumSongsTableName . '.play_count DESC');
          break;
        case "creation_date":
          $select->order($albumSongsTableName . '.creation_date DESC');
          break;
        case "modified_date":
          $select->order($albumSongsTableName . '.modified_date DESC');
          break;
        case "rating":
          $select->order($albumSongsTableName . '.rating DESC');
          break;
        case "You May Also Like":
          $select->order('RAND() DESC');
          break;
      }
    }

    if (isset($params['limit']) && !empty($params['limit']))
      $select->limit($params['limit']);

    return $this->fetchAll($select);
  }

}
