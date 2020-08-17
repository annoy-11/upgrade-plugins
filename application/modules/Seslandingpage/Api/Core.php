<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslandingpage_Api_Core extends Core_Api_Abstract {

  public function getFileUrl($image) {
    
    $table = Engine_Api::_()->getDbTable('files', 'core');
    $result = $table->select()
                ->from($table->info('name'), 'storage_file_id')
                ->where('storage_path =?', $image)
                ->query()
                ->fetchColumn();
    if(!empty($result)) {
      $storage = Engine_Api::_()->getItem('storage_file', $result);
      return $storage->map();
    } else {
      return $image;
    }
  }
  
  public function getMembers($params = array()) {

    $userTable = Engine_Api::_()->getDbtable('users', 'user');
    $select = $userTable->select()
                      ->where('search = ?', 1)
                      ->where('enabled = ?', 1)
                      ->where('photo_id != ?', 0);

    if($params['popularitycriteria'] == 'random') {
      $select->order('Rand()');
    } else {
      $select->order($params['popularitycriteria'] . " DESC");
    }

    if($params['limit']) {
      $select->limit($params['limit']);
    }

    return $userTable->fetchAll($select);
  }

  public function getContents($params = array()) {

    $table = Engine_Api::_()->getItemTable($params['resourcetype']);
    $tableName = $table->info('name');

    $select = $table->select()
                    ->from($tableName)
                    ->limit($params['limit']);
    
    if(!in_array($params['resourcetype'], array('sesadvpoll_poll'))) {
      $select->where('photo_id <> ?', 0);
    }

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $popularitycriteria_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE '".$params['popularitycriteria']."'")->fetch();
    if (!empty($popularitycriteria_exist)) {
      $select->order($params['popularitycriteria'] ." DESC");
    } else {
      $select->order('creation_date DESC');
    }

    $column_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE 'is_delete'")->fetch();
    if (!empty($column_exist)) {
      $select->where('is_delete =?',0);
    }

    return $table->fetchAll($select);

  }

  public function getModulesEnable() {

    $modules = Engine_Api::_()->getDbTable('modules','core')->getEnabledModuleNames();

    $moduleArray = array();

    if(in_array('album',$modules))
      $moduleArray['album'] = 'Albums';

    if(in_array('blog',$modules))
      $moduleArray['blog'] = 'Blogs';

    if(in_array('classified',$modules))
      $moduleArray['classified'] = 'Classifieds';

    if(in_array('event',$modules))
      $moduleArray['event'] = 'Events';

    if(in_array('group',$modules))
      $moduleArray['group'] = 'Groups';

    if(in_array('music',$modules))
      $moduleArray['music_playlist'] = 'Music';

    if(in_array('video',$modules))
      $moduleArray['video'] = 'Videos';

    if(in_array('sesalbum',$modules))
      $moduleArray['sesalbum_album'] = 'SES - Advanced Photos & Albums Plugin';

    if(in_array('sesblog',$modules))
      $moduleArray['sesblog_blog'] = 'SES - Advanced Blog Plugin';
      
    if(in_array('seslisting',$modules))
      $moduleArray['seslisting'] = 'SES - Advanced Listing Plugin';
      
    if(in_array('sesjob',$modules))
      $moduleArray['sesjob_job'] = 'SES - Advanced Job Plugin';
      
    if(in_array('sesadvpoll',$modules))
      $moduleArray['sesadvpoll_poll'] = 'SES - Advanced Polls Plugin';

    if(in_array('sesarticle',$modules))
      $moduleArray['sesarticle'] = 'SES - Advanced Article Plugin';

    if(in_array('sesevent',$modules))
      $moduleArray['sesevent_event'] = 'SES - Advanced Events Plugin';

    if(in_array('sesmusic',$modules))
      $moduleArray['sesmusic_album'] = 'SES - Advanced Music Albums, Songs & Playlists Plugin';

    if(in_array('sesvideo',$modules))
      $moduleArray['sesvideo_video'] = 'SES - Advanced Videos & Channels Plugin';

    if(in_array('sespage',$modules))
      $moduleArray['sespage_page'] = 'SES - Page Directories Plugin';

    if(in_array('sesfaq',$modules))
      $moduleArray['sesfaq_faq'] = 'SES - Multi - Use FAQs Plugin';

    if(in_array('sesrecipe',$modules))
      $moduleArray['sesrecipe_recipe'] = 'SES - Recipes with Reviews and Location Plugin';
    if(in_array('sesbusiness',$modules))
      $moduleArray['businesses'] = 'SES - Businesses Directories Plugin';
    if(in_array('sesgroup',$modules))
      $moduleArray['sesgroup_group'] = 'SES - Group Communities Plugin';

    if(in_array('sesquote',$modules))
      $moduleArray['sesquote_quote'] = 'SES - Quotes Plugin';
    if(in_array('sestip',$modules))
      $moduleArray['sestip_tip'] = 'SES - Tips Plugin';
    if(in_array('sesthought',$modules))
      $moduleArray['sesthought_thought'] = 'SES - Thoughts Plugin';
    if(in_array('sesprayer',$modules))
      $moduleArray['sesprayer_prayer'] = 'SES - Prayers Plugin';

    if(in_array('sescontest',$modules))
      $moduleArray['contest'] = 'SES - Advanced Contests Plugin';
    if(in_array('estore',$modules))
      $moduleArray['stores'] = 'SES - Stores Marketplace Plugin';

    if(in_array('sesnews',$modules))
      $moduleArray['sesnews_news'] = 'News / RSS Importer & Aggregator Plugin';
			
    if(in_array('sescrowdfunding',$modules))
      $moduleArray['crowdfunding'] = 'Crowdfunding / Charity / Fundraising / Donations Plugin'; 

    return $moduleArray;
  }
}
