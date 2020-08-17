<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmenu_Api_Core extends Core_Api_Abstract
{
    public function contentNoFoundImg($menuItem  = array())
    {
         if(!empty($menuItem->emptyfeild_img)){
            return $menuItem->emptyfeild_img;
         }else{
            return 'application/modules/Sesmenu/externals/images/folder.png';
         }
    }
    public function contentNoFoundtxt($menuItem  = array())
    {
         if(!empty($menuItem->emptyfeild_txt)){
            return $menuItem->emptyfeild_txt;
         }else {
            return 'Sorry, No Data Found';
         }
    }
	public function getCategories($module)
	{
		$params  = $this->getModuleData($module);
		if($params['category']=='no')
			return false;
		$catTable = Engine_Api::_()->getDbTable('categories', $module);
		$catTableName = $catTable->info('name');
		$select = $catTable->select()
			->from($catTable, array('*'));
        if($params['company']=='SES')
        {
            $select->where($catTableName.'.subcat_id =?', 0)->where($catTableName.'.subsubcat_id =?', 0);
        }
         $db = Engine_Db_Table::getDefaultAdapter();
        $orderColumn = $db->query('SHOW COLUMNS FROM '.$catTableName.' LIKE \'order\'')->fetch();
        if (!empty($orderColumn)) {
            $select->order('order DESC');
        }
        $results = $catTable->fetchAll($select);
		return $results;
	}
	public function getCustomData($menu_id)
	{
		$results = Engine_Api::_()->getDbTable('itemlinks', 'sesmenu')->getInfo(array('sublink' => 0, 'item_id' => $menu_id, 'admin' => 1 ,'enabled'=> 1));
		return $results;
	}
	public function getContentCount($module,$category_id)
	{
		$params  = $this->getModuleData($module);
		if($params['category']=='no')
			return false;
		$table = Engine_Api::_()->getDbTable($params['dbtable'], $module);
		$tableName = $table->info('name');

		$select = $table->select()
			->from($tableName, array('*'))
			->where("category_id = ?",$category_id);
		$results = $table->fetchAll($select);
		return count($results);
	}

	public function getMenuItemInfo($module)
	{
		$params  = $this->getModuleData($module);
		$infoTable = Engine_Api::_()->getDbTable($params['dbtable'], $module);
		$select = $infoTable->select()
			->from($infoTable, array('*'));
		$results = $infoTable->fetchAll($select);

		return $results;
	}
	public function getModuleData($module) {
		switch($module) {
		  case 'core':
                $params['itemTableName'] = '';
                $params['dbtable'] = '';
                $params['content_title'] = 'Core';
                $params['company'] = 'SES';
                $params['category'] = 'no';
                $params['subCat'] = 'no';
			break;
		  case 'user':
			case 'sesmember':
                $params['itemTableName'] = '';
                $params['dbtable'] = '';
                $params['content_title'] = 'User';
                $params['company'] = 'SES';
                $params['category'] = 'no';
                $params['subCat'] = 'no';
			break;
            case 'sescommunityads':
                $params['itemTableName'] = '';
                $params['dbtable'] = '';
                $params['content_title'] = 'Communityads';
                $params['company'] = 'SES';
                $params['category'] = 'no';
                $params['subCat'] = 'no';
			break;
            case 'sescredit':
                $params['itemTableName'] = '';
                $params['dbtable'] = 'credits';
                $params['content_title'] = 'Credit';
                $params['company'] = 'SES';
                $params['category'] = 'no';
                $params['subCat'] = 'no';
			break;
			case 'sescrowdfunding':
                $params['itemTableName'] = 'sescrowdfunding_category';
                $params['dbtable'] = 'crowdfundings';
                $params['content_title'] = 'Crowdfundings';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			case 'booking':
                $params['itemTableName'] = 'booking_category';
                $params['dbtable'] = 'bookings';
                $params['content_title'] = 'Bookings';
                $params['company'] = 'SES';
                $params['category'] = 'no';
                $params['subCat'] = 'no';
			break;
			case 'sesadvpoll':
                $params['itemTableName'] = '';
                $params['dbtable'] = 'polls';
                $params['content_title'] = 'Poll';
                $params['company'] = 'SES';
                $params['category'] = 'no';
                $params['subCat'] = 'no';
			break;
			case 'sesdiscussion':
                $params['itemTableName'] = 'sesdiscussion_category';
                $params['dbtable'] = 'discussions';
                $params['content_title'] = 'Discussion';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'seslisting':
                $params['itemTableName'] = 'seslisting_category';
                $params['dbtable'] = 'seslistings';
                $params['content_title'] = 'Listing';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesblog':
                $params['itemTableName'] = 'sesblog_category';
                $params['dbtable'] = 'blogs';
                $params['content_title'] = 'Blog';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'blog':
                $params['itemTableName'] = 'blog_category';
                $params['dbtable'] = 'blogs';
                $params['content_title'] = 'Blog';
                $params['company'] = '';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			case 'album':
                $params['itemTableName'] = 'album_category';
                $params['dbtable'] = 'albums';
                $params['content_title'] = 'Album';
                $params['company'] = '';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			case 'sesalbum':
                $params['itemTableName'] = 'sesalbum_category';
                $params['dbtable'] = 'albums';
                $params['content_title'] = 'Album';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;

			case 'sesevent':
                $params['itemTableName'] = 'sesevent_category';
                $params['dbtable'] = 'events';
                $params['content_title'] = 'Event';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesvideo':
                $params['itemTableName'] = 'sesvideo_category';
                $params['dbtable'] = 'videos';
                $params['content_title'] = 'Video';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesmusic':
                $params['itemTableName'] = 'sesmusic_categories';
                $params['dbtable'] = 'albums';
                $params['content_title'] = 'music';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sespage':
                $params['itemTableName'] = 'sespage_category';
                $params['dbtable'] = 'pages';
                $params['content_title'] = 'page';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesbusiness':
                $params['itemTableName'] = 'sesbusiness_category';
                $params['dbtable'] = 'businesses';
                $params['content_title'] = 'business';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesgroup':
                $params['itemTableName'] = 'sesgroup_category';
                $params['dbtable'] = 'groups';
                $params['content_title'] = 'group';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sescontest':
                $params['itemTableName'] = 'sescontest_category';
                $params['dbtable'] = 'contests';
                $params['content_title'] = 'contest';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesarticle':
                $params['itemTableName'] = 'sesarticle_category';
                $params['dbtable'] = 'sesarticles';
                $params['content_title'] = 'article';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesquote':
                $params['itemTableName'] = 'sesquote_category';
                $params['dbtable'] = 'quotes';
                $params['content_title'] = 'quote';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesprayer':
                $params['itemTableName'] = 'sesprayer_category';
                $params['dbtable'] = 'prayers';
                $params['content_title'] = 'prayer';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			case 'sesthought':
                $params['itemTableName'] = 'sesthought_category';
                $params['dbtable'] = 'thoughts';
                $params['content_title'] = 'thought';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'seswishe':
                $params['itemTableName'] = 'seswishe_category';
                $params['dbtable'] = 'wishes';
                $params['content_title'] = 'wishe';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesrecipe':
                $params['itemTableName'] = 'sesrecipe_category';
                $params['dbtable'] = 'recipes';
                $params['content_title'] = 'recipe';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sesfaq':
                $params['itemTableName'] = 'sesfaq_category';
                $params['dbtable'] = 'faqs';
                $params['content_title'] = 'faq';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'yes';
			break;
			case 'sestutorial':
                $params['itemTableName'] = 'sestutorial_category';
                $params['dbtable'] = 'tutorials';
                $params['content_title'] = 'tutorial';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			case 'sesqa':
                $params['itemTableName'] = 'sesqa_category';
                $params['dbtable'] = 'questions';
                $params['content_title'] = 'qa';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			 case 'sesproduct':
                $params['itemTableName'] = 'sesproduct_category';
                $params['dbtable'] = 'sesproducts';
                $params['content_title'] = 'Product';
                $params['itemType'] = 'sesproduct';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
            case 'estore':
                $params['itemTableName'] = 'estore_category';
                $params['dbtable'] = 'stores';
                $params['content_title'] = 'Store';
                $params['itemType'] = 'stores';
                $params['company'] = 'SES';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			case 'classified':
                $params['itemTableName'] = 'classified';
                $params['dbtable'] = 'classifieds';
                $params['content_title'] = 'classified';
                $params['company'] = '';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			case 'video':
                $params['itemTableName'] = 'video_category';
                $params['dbtable'] = 'videos';
                $params['content_title'] = 'Video';
                $params['company'] = '';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			case 'forum':
                $params['itemTableName'] = 'forum';
                $params['dbtable'] = 'forums';
                $params['content_title'] = 'forum';
                $params['company'] = '';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			case 'poll':
                $params['itemTableName'] = 'poll';
                $params['dbtable'] = 'polls';
                $params['content_title'] = 'poll';
                $params['company'] = '';
                $params['category'] = 'no';
                $params['subCat'] = 'no';
			break;
			case 'music':
                $params['itemTableName'] = 'music';
                $params['dbtable'] = 'playlists';
                $params['content_title'] = 'music';
                $params['company'] = '';
                $params['category'] = 'no';
                $params['subCat'] = 'no';
			break;
			case 'group':
                $params['itemTableName'] = 'group_category';
                $params['dbtable'] = 'groups';
                $params['content_title'] = 'group';
                $params['company'] = '';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
            case 'event':
                $params['itemTableName'] = 'event_category';
                $params['dbtable'] = 'events';
                $params['content_title'] = 'Event';
                $params['company'] = '';
                $params['category'] = 'yes';
                $params['subCat'] = 'no';
			break;
			default:
                $params['itemTableName'] = '';
                $params['dbtable'] = '';
                $params['content_title'] = '';
                $params['company'] = '';
                $params['category'] = 'no';
                $params['subCat'] = 'no';

		}
		return $params;

	}
    public function getSelect($params = array())
    {
        $currentTime=date('Y-m-d H:i:s');
        $table = Engine_Api::_()->getDbtable($params['dbtable'], $params['module']);
        $rName = $table->info('name');

        $select = $table->select();
        $draftInModules = array("blog");
        $searchInModules = array("blog","album","event","search");
        if( !empty($params['category_id']) )
        {
            $select->where($rName.'.category_id = ?', $params['category_id']);
        }
        if (isset($params['order']) && !empty($params['order'])) {
            if ($params['order'] == 'week') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
                $select->where("DATE(".$rName.".creation_date) between ('$endTime') and ('$currentTime')");
            } elseif ($params['order'] == 'month') {
                $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
                $select->where("DATE(".$rName.".creation_date) between ('$endTime') and ('$currentTime')");
            }else {
            $select->order( !empty($params['order']) ? $params['order'].' DESC' : $rName.'.creation_date DESC' );
            }
        }

        if( isset($params['draft']) && in_array($params['module'],$draftInModules))
        {
        $select->where($rName.'.draft = ?', $params['draft']);
        }


        if( !empty($params['visible']) && in_array($params['module'],$searchInModules))
        {
            $select->where($rName.".search = ?", $params['visible']);
        }

        if(empty($params['limit']))
            $select->limit(3);
        else
            $select->limit($params['limit']);

      return $table->fetchAll($select);

    }
    public function getData($params = array()){
        $moduleInfo = $this->getModuleData($params['module']);
        switch($params['module']) {
            case 'estore':
               return Engine_Api::_()->getDbtable($moduleInfo['dbtable'],$params['module'])->getStoreSelect(array('order' => $params['order'], 'limit' => $params['limit'],'fetchAll'=>true));
               break;
            case 'sesproduct':
               return Engine_Api::_()->getDbtable($moduleInfo['dbtable'],$params['module'])->getSesproductsSelect(array('order' => $params['order'], 'limit' => $params['limit'],'fetchAll'=>true));
            break;
            default :
                return false;
        }

    }

}

