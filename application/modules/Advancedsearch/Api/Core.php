<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Advancedsearch_Api_Core extends Core_Api_Abstract {
    public function getSelect($text, $params = array())
    {
        // Build base query
        $table = Engine_Api::_()->getDbtable('search', 'core');
        $tableName = $table->info('name');
        $db = $table->getAdapter();
        $select = $table->select();

        $moduleTable = Engine_Api::_()->getDbtable('modules', 'advancedsearch')->info('name');
        $select->setIntegrityCheck(false)
            ->from($table->info('name'), array('type', 'id', 'description', 'keywords','title'));

        $select->joinLeft($moduleTable,$moduleTable.'.resource_type = '.$table->info('name').'.type','order');
        $availableTypes = Engine_Api::_()->getItemTypes();
        $type = !empty($params["type"]) ? $params['type'] : "";
        $changeType = $this->changeType($type);
        $select->order('order ASC');
        $select->where("($tableName.`title` LIKE  '%$text%' OR $tableName.`description` LIKE  '%$text%' OR $tableName.`keywords` LIKE  '%$text%' OR $tableName.`hidden` LIKE  '%$text%')");
        $select->where($tableName.'.type IN (?)',$availableTypes);
        $select->group('id');
        $select->group('resource_type');

        if( !empty($type) && $type != "all") {
            $select->where('type = ?', $this->changeType($params["type"]));
        }
        if(empty($params["fetchAll"]))
            return Zend_Paginator::factory($select);
        else
            return $table->fetchAll($select);
    }
    function changeType($type){
        return $type;
    }
    function checkModuleEnable($modulename = ""){
        if(!$modulename)
            return false;
        $table = Engine_Api::_()->getDbTable('modules','core');
        $select = $table->select()
            ->where('name = ?', $modulename)
            ->where('enabled = ?', 1);
        return $table->fetchRow($select);
    }
    function createPage($params = array()){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        #integrated modules core
        //Album
        $params = array();
        if($this->checkModuleEnable('album')) {
            $params["title"] = "SES - Professional Search : Core - Albums";
            $params["name"] = "advancedsearch_index_album";
            $params['middle_content'][0]["name"] = "advancedsearch.core-content";
            $params["middle_content"][0]['params'] = '{"show_criteria":["view","likes","comment","postedBy","photo"],"pagging":"loadmore","title":"","nomobile":"0","itemCountPerPage":"10","name":"advancedsearch.core-content"}';
            $params['right_content'][0]["name"] = "advancedsearch.browse-search";
            $params['right_content'][1]["name"] = "album.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('album','Albums','album','Albums',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Blog
        if($this->checkModuleEnable('blog')) {
            $params["title"] = "SES - Professional Search : Core - Blogs";
            $params["name"] = "advancedsearch_index_blog";
            $params['middle_content'][0]["name"] = "advancedsearch.core-content";
            $params["middle_content"][0]['params'] = '{"show_criteria":["view","likes","comment","postedBy","photo"],"pagging":"loadmore","title":"","nomobile":"0","itemCountPerPage":"10","name":"advancedsearch.core-content"}';
            $params['right_content'][0]["name"] = "advancedsearch.browse-search";
            $params['right_content'][1]["name"] = "blog.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('blog','Blogs','blog','Blogs',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Classified
        if($this->checkModuleEnable('classified')) {
            $params["title"] = "SES - Professional Search : Core - Classifieds";
            $params["name"] = "advancedsearch_index_classified";
            $params['middle_content'][0]["name"] = "advancedsearch.core-content";
            $params["middle_content"][0]['params'] = '{"show_criteria":["view","likes","comment","postedBy","photo"],"pagging":"loadmore","title":"","nomobile":"0","itemCountPerPage":"10","name":"advancedsearch.core-content"}';
            $params['right_content'][0]["name"] = "advancedsearch.browse-search";
            $params['right_content'][1]["name"] = "classified.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('classified','Classifieds','classified','Classifieds',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Event
        if($this->checkModuleEnable('event')) {
            $params["title"] = "SES - Professional Search : Core - Events";
            $params['middle_content'][0]["name"] = "advancedsearch.core-content";
            $params["middle_content"][0]['params'] = '{"show_criteria":["view","likes","comment","postedBy","photo"],"pagging":"loadmore","title":"","nomobile":"0","itemCountPerPage":"10","name":"advancedsearch.core-content"}';
            $params["name"] = "advancedsearch_index_event";
            $params['right_content'][0]["name"] = "advancedsearch.browse-search";
            $params['right_content'][1]["name"] = "event.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('event','Events','event','Events',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //GROUP
        if($this->checkModuleEnable('group')) {
            $params["title"] = "SES - Professional Search : Core - Groups";
            $params['middle_content'][0]["name"] = "advancedsearch.core-content";
            $params["middle_content"][0]['params'] = '{"show_criteria":["view","likes","comment","postedBy","photo"],"pagging":"loadmore","title":"","nomobile":"0","itemCountPerPage":"10","name":"advancedsearch.core-content"}';
            $params["name"] = "advancedsearch_index_group";
            $params['right_content'][0]["name"] = "advancedsearch.browse-search";
            $params['right_content'][1]["name"] = "group.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('group','Groups','group','Groups',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Music
        if($this->checkModuleEnable('music')) {
            $params["title"] = "SES - Professional Search : Core - Musics";
            $params['middle_content'][0]["name"] = "advancedsearch.core-content";
            $params["middle_content"][0]['params'] = '{"show_criteria":["view","likes","comment","postedBy","photo"],"pagging":"loadmore","title":"","nomobile":"0","itemCountPerPage":"10","name":"advancedsearch.core-content"}';
            $params["name"] = "advancedsearch_index_music";
            $params['right_content'][0]["name"] = "advancedsearch.browse-search";
            $params['right_content'][1]["name"] = "music.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('music','Musics','music','Musics',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Poll
        if($this->checkModuleEnable('poll')) {
            $params["title"] = "SES - Professional Search : Core - Polls";
            $params["name"] = "advancedsearch_index_poll";
            $params['middle_content'][0]["name"] = "advancedsearch.core-content";
            $params["middle_content"][0]['params'] = '{"show_criteria":["view","likes","comment","postedBy","photo"],"pagging":"loadmore","title":"","nomobile":"0","itemCountPerPage":"10","name":"advancedsearch.core-content"}';
            $params['right_content'][0]["name"] = "advancedsearch.browse-search";
            $params['right_content'][1]["name"] = "poll.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('poll','Polls','poll','Polls',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //User
        if($this->checkModuleEnable('user')) {
            $params["title"] = "SES - Professional Search : Core - Users";
            $params["name"] = "advancedsearch_index_user";
            $params['middle_content'][0]["name"] = "advancedsearch.browse-member";
            $params['right_content'][0]["name"] = "user.browse-search";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('user','Members','user','Members',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesmember plugin
        if($this->checkModuleEnable('sesmember')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Member";
            $params["name"] = "advancedsearch_index_sesmember";
            $params['middle_content'][0]["name"] = "sesmember.browse-members";
            $params['right_content'][0]["name"] = "sesmember.browse-search";
            $params["right_content"][0]["params"] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","3","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"1","network":"yes","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","member_type":"yes","has_photo":"yes","is_online":"yes","is_vip":"yes","title":"","nomobile":"0","name":"sesmember.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('user','Members','sesmember','Members',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }

        //Video
        if($this->checkModuleEnable('video')) {
            $params["title"] = "SES - Professional Search : Core - Videos";
            $params["name"] = "advancedsearch_index_video";
            $params['middle_content'][0]["name"] = "advancedsearch.core-content";
            $params["middle_content"][0]['params'] = '{"show_criteria":["view","likes","comment","postedBy","photo"],"pagging":"loadmore","title":"","nomobile":"0","itemCountPerPage":"10","name":"advancedsearch.core-content"}';
            $params['right_content'][0]["name"] = "advancedsearch.browse-search";
            $params['right_content'][1]["name"] = "video.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('video','Videos','video','Videos',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        #integrated modules ses
        //Sesalbum
        if($this->checkModuleEnable('sesalbum')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Album";
            $params["name"] = "advancedsearch_index_sesalbum_album";
            $params['middle_content'][0]["name"] = "sesalbum.browse-albums";
            $params["middle_content"][0]['params'] = '{"load_content":"auto_load","show_criteria":["like","comment","rating","view","title","by","social_sharing"],"title_truncation":"45","limit_data":"20","height":"200","width":"236","title":"","nomobile":"0","name":"sesalbum.browse-albums"}';
            $params['right_content'][0]["name"] = "sesalbum.browse-search";
            $params['right_content'][1]["name"] = "sesalbum.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesalbum_album','Advanced Photos & Albums Plugin','sesalbum','Albums',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();

            $params["title"] = "SES - Professional Search : SES - Advanced Album Photos";
            $params["name"] = "advancedsearch_index_sesalbum_photo";
            $params['middle_content'][0]["name"] = "sesalbum.tabbed-widget";
            $params["middle_content"][0]['params'] = '{"photo_album":"photo","tab_option":"filter","view_type":"masonry","insideOutside":"inside","fixHover":"hover","show_criteria":["like","comment","rating","view","title","by","socialSharing","favouriteCount","downloadCount","photoCount","likeButton","favouriteButton"],"limit_data":"50","show_limited_data":"no","pagging":"auto_load","title_truncation":"40","height":"350","width":"400","search_type":["mostSPliked"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPfavourite_order":"2","mostSPfavourite_label":"Most Favourite","dummy4":null,"mostSPdownloaded_order":"2","mostSPdownloaded_label":"Most Downloaded","dummy5":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy6":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy7":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy8":null,"featured_order":"6","featured_label":"Featured","dummy9":null,"sponsored_order":"7","sponsored_label":"Sponsored","title":"","nomobile":"0","name":"sesalbum.tabbed-widget"}';
            $params['right_content'][0]["name"] = "sesalbum.browse-search";
            $params["right_content"][0]["params"] = '{"search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","featured","sponsored"],"search_for":"photo","view_type":"vertical","title":"","nomobile":"0","name":"sesalbum.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesalbum_photo','Advanced Photos & Albums Plugin','sesalbum','Photos',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesblog
        if($this->checkModuleEnable('sesblog')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Blogs";
            $params["name"] = "advancedsearch_index_sesblog";
            $params['middle_content'][0]["name"] = "sesblog.browse-blogs";
            $params["middle_content"][0]['params'] = '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"300","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"270","width_grid":"307","height_simplelist":"230","width_simplelist":"260","height_advgrid":"230","width_advgrid":"461","height_supergrid":"250","width_supergrid":"461","width_pinboard":"280","limit_data_pinboard":"12","limit_data_grid":"12","limit_data_list":"12","limit_data_simplelist":"12","limit_data_advlist":"12","limit_data_advgrid":"12","limit_data_supergrid":"12","pagging":"button","title":"","nomobile":"0","name":"sesblog.browse-blogs"}';
            $params['right_content'][0]["name"] = "sesblog.browse-search";
            $params["right_content"][0]["params"] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"sesblog.browse-search"}';
            $params['right_content'][1]["name"] = "sesblog.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesblog','Advanced Blog Plugin','sesblog','Blogs',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesbusiness
        if($this->checkModuleEnable('sesbusiness')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Businesses";
            $params["name"] = "advancedsearch_index_businesses";
            $params['middle_content'][0]["name"] = "sesbusiness.browse-businesses";
            $params["middle_content"][0]['params'] = '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","verifiedLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"250","height":"130","width":"215","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"150","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"9","grid_title_truncation":"45","grid_description_truncation":"100","height_grid":"220","width_grid":"304","dummy18":null,"limit_data_simplegrid":"9","simplegrid_title_truncation":"45","simplegrid_description_truncation":"50","height_simplegrid":"230","width_simplegrid":"304","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"260","width_advgrid":"304","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"25","title":"","nomobile":"0","name":"sesbusiness.browse-businesses"}';
            $params['right_content'][0]["name"] = "sesbusiness.browse-search";
            $params["right_content"][0]['params'] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchBusinessTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closebusiness"],"hide_option":["searchBusinessTitle","view","browseBy","alphabet","Categories","location","miles","closebusiness"],"title":"","nomobile":"0","name":"sesbusiness.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('businesses','Business Directories Plugin','sesbusiness','Businesses',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sescontest
        if($this->checkModuleEnable('sescontest')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Contests";
            $params["name"] = "advancedsearch_index_sescontest";
            $params['middle_content'][0]["name"] = "sescontest.browse-contests";
            $params["middle_content"][0]['params'] = '{"enableTabs":["list","grid","advgrid","pinboard"],"openViewType":"pinboard","show_criteria":["title","startenddate","by","mediaType","category","listdescription","griddescription","pinboarddescription","socialSharing","likeButton","favouriteButton","followButton","joinButton","entryCount","like","comment","favourite","view","follow","status","voteCount"],"show_item_count":"1","height":"250","width":"460","height_grid":"260","width_grid":"393","height_advgrid":"290","width_advgrid":"393","width_pinboard":"350","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","list_description_truncation":"300","grid_description_truncation":"75","pinboard_description_truncation":"150","limit_data_pinboard":"35","limit_data_grid":"30","limit_data_advgrid":"30","limit_data_list":"25","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"button","title":"","nomobile":"0","name":"sescontest.browse-contests"}';
            $params['right_content'][0]["name"] = "sescontest.browse-search";
            $params["right_content"][0]['params'] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","entrymaxtomin","entrymintomax","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"recentlySPcreated","criteria":["0","1","2","3","today","tomorrow","week","nextweek","month"],"show_option":["searchContestTitle","view","browseBy","mediaType","chooseDate","Categories"],"title":"","nomobile":"0","name":"sescontest.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sescontest','Advanced Contests Plugin','sescontest','Contests',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Exhibition
        if($this->checkModuleEnable('exhibition')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Exhibition";
            $params["name"] = "advancedsearch_index_exhibition";
            $params['middle_content'][0]["name"] = "exhibition.browse-exhibitions";
            $params["middle_content"][0]['params'] = '{"enableTabs":["list","grid","advgrid","pinboard"],"openViewType":"pinboard","show_criteria":["title","startenddate","by","mediaType","category","listdescription","griddescription","pinboarddescription","socialSharing","likeButton","favouriteButton","followButton","joinButton","entryCount","like","comment","favourite","view","follow","status","voteCount"],"show_item_count":"1","height":"250","width":"460","height_grid":"260","width_grid":"393","height_advgrid":"290","width_advgrid":"393","width_pinboard":"350","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","list_description_truncation":"300","grid_description_truncation":"75","pinboard_description_truncation":"150","limit_data_pinboard":"35","limit_data_grid":"30","limit_data_advgrid":"30","limit_data_list":"25","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"button","title":"","nomobile":"0","name":"exhibition.browse-exhibitions"}';
            $params['right_content'][0]["name"] = "exhibition.browse-search";
            $params["right_content"][0]['params'] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","entrymaxtomin","entrymintomax","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"recentlySPcreated","criteria":["0","1","2","3","today","tomorrow","week","nextweek","month"],"show_option":["searchContestTitle","view","browseBy","mediaType","chooseDate","Categories"],"title":"","nomobile":"0","name":"exhibition.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('exhibition','Advanced Exhibitions Plugin','exhibition','Exhibitions',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesevent
        if($this->checkModuleEnable('sesevent')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Events";
            $params["name"] = "advancedsearch_index_sesevent_event";
            $params['middle_content'][0]["name"] = "sesevent.browse-events";
            $params["middle_content"][0]['params'] = '{"enableTabs":["list","grid","advgrid","pinboard","masonry","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","listButton","favouriteButton","likeButton","socialSharing","joinedcount","location","buy","title","startenddate","category","host","listdescription","pinboarddescription","commentpinboard"],"limit_data":"12","pagging":"button","order":"mostSPliked","show_item_count":"1","list_title_truncation":"60","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","masonry_title_truncation":"45","list_description_truncation":"170","grid_description_truncation":"45","pinboard_description_truncation":"45","masonry_description_truncation":"45","height":"215","width":"300","photo_height":"290","photo_width":"296","info_height":"160","advgrid_height":"370","advgrid_width":"297","pinboard_width":"250","masonry_height":"350","title":"","nomobile":"0","name":"sesevent.browse-events"}';
            $params['right_content'][0]["name"] = "sesevent.browse-search";
            $params["right_content"][0]["params"] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","mostSPjoined","featured","sponsored","verified"],"view":["0","1","ongoing","past","week","weekend","future","month"],"default_search_type":"view_count DESC","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","start_date":"yes","end_date":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","venue":"yes","title":"Search Events","nomobile":"0","name":"sesevent.browse-search"}';
            $params['right_content'][1]["name"] = "sesevent.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesevent_event','Advanced Events Plugin','sesevent','Events',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesgroup
        if($this->checkModuleEnable('sesgroup')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Groups";
            $params["name"] = "advancedsearch_index_sesgroup_group";
            $params['middle_content'][0]["name"] = "sesgroup.browse-groups";
            $params["middle_content"][0]['params'] = '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","verifiedLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"250","height":"130","width":"215","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"150","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"9","grid_title_truncation":"45","grid_description_truncation":"100","height_grid":"220","width_grid":"304","dummy18":null,"limit_data_simplegrid":"9","simplegrid_title_truncation":"45","simplegrid_description_truncation":"50","height_simplegrid":"230","width_simplegrid":"304","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"260","width_advgrid":"304","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"25","title":"","nomobile":"0","name":"sesgroup.browse-groups"}';
            $params['right_content'][0]["name"] = "sesgroup.browse-search";
            $params["right_content"][0]["params"] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchGroupTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closegroup"],"hide_option":["searchGroupTitle","view","browseBy","alphabet","Categories","location","miles","closegroup"],"title":"","nomobile":"0","name":"sesgroup.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesgroup_group','Group Communities Plugin','sesgroup','Groups',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Seslisting
        if($this->checkModuleEnable('seslisting')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Listings";
            $params["name"] = "advancedsearch_index_seslisting";
            $params['middle_content'][0]["name"] = "seslisting.browse-listings";
            $params["middle_content"][0]['params'] = '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"300","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"270","width_grid":"307","height_simplelist":"230","width_simplelist":"260","height_advgrid":"230","width_advgrid":"461","height_supergrid":"250","width_supergrid":"461","width_pinboard":"280","limit_data_pinboard":"12","limit_data_grid":"12","limit_data_list":"12","limit_data_simplelist":"12","limit_data_advlist":"12","limit_data_advgrid":"12","limit_data_supergrid":"12","pagging":"button","title":"","nomobile":"0","name":"seslisting.browse-listings"}';
            $params['right_content'][0]["name"] = "seslisting.browse-search";
            $params["right_content"][0]["params"] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"seslisting.browse-search"}';
            $params["right_content"][1]["name"] = "seslisting.browse-menu-quick";
            $isCreated =  $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('seslisting','Advanced Listing Plugin','seslisting','Listings',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }

        //Sesmusic
        if($this->checkModuleEnable('sesmusic')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Musics";
            $params["name"] = "advancedsearch_index_sesmusic_albums";
            $params['middle_content'][0]["name"] = "sesmusic.browse-albums";
            $params["middle_content"][0]['params'] = '{"viewType":"gridview","Type":"1","popularity":"creation_date","information":["featured","sponsored","hot","likeCount","commentCount","viewCount","title","postedby","favourite","addplaylist","share"],"height":"220","width":"225","itemCount":"12","title":"","nomobile":"0","name":"sesmusic.browse-albums"}';
            $params['right_content'][0]["name"] = "sesmusic.browse-search";
            $params["right_content"][0]["params"] = '{"searchOptionsType":["searchBox","category","view","show","artists"],"title":"","nomobile":"0","name":"sesmusic.browse-search"}';
            $params["right_content"][1]["name"] = "sesmusic.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesmusic_albums','Professional Music Plugin','sesmusic','Music Albums',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
            //songs
            $params["title"] = "SES - Professional Search : SES - Advanced Music Songs";
            $params["name"] = "advancedsearch_index_sesmusic_albumsongs";
            $params['middle_content'][0]["name"] = "sesmusic.browse-songs";
            $params["middle_content"][0]['params'] = '{"viewType":"listview","Type":"1","popularity":"view_count","information":["featured","sponsored","hot","playCount","downloadCount","likeCount","commentCount","viewCount","favouriteCount","ratingStars","artists","addplaylist","downloadIcon","share","report","title","postedby","favourite","category"],"itemCount":"10","title":"","nomobile":"0","name":"sesmusic.browse-songs"}';
            $params['right_content'][0]["name"] = "sesmusic.songs-browse-search";
            $params["right_content"][0]["params"] = '{"searchOptionsType":["searchBox","category","show","artists"],"title":"","nomobile":"0","name":"sesmusic.songs-browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesmusic_albumsongs','Professional Music Plugin','sesmusic','Music Songs',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();

        }
        //Sespage
        if($this->checkModuleEnable('sespage')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Pages";
            $params["name"] = "advancedsearch_index_sespage_page";
            $params['middle_content'][0]["name"] = "sespage.browse-pages";
            $params["middle_content"][0]['params'] = '{"enableTabs":["list","advlist","simplegrid","grid","advgrid","pinboard","map"],"openViewType":"advlist","category_id":"","show_criteria":["title","listdescription","advlistdescription","griddescription","advgriddescription","simplegriddescription","pinboarddescription","ownerPhoto","by","creationDate","category","price","location","socialSharing","contactDetail","likeButton","favouriteButton","followButton","joinButton","contactButton","like","comment","favourite","view","follow","statusLabel","verifiedLabel"],"pagging":"button","socialshare_enable_plusicon":"1","socialshare_icon_limit":"4","dummy15":null,"limit_data_list":"6","list_title_truncation":"45","list_description_truncation":"250","height":"130","width":"215","dummy16":null,"limit_data_advlist":"5","advlist_title_truncation":"45","advlist_description_truncation":"150","height_advlist":"250","width_advlist":"310","dummy17":null,"limit_data_grid":"9","grid_title_truncation":"45","grid_description_truncation":"100","height_grid":"220","width_grid":"304","dummy18":null,"limit_data_simplegrid":"9","simplegrid_title_truncation":"45","simplegrid_description_truncation":"50","height_simplegrid":"230","width_simplegrid":"304","dummy19":null,"limit_data_advgrid":"9","advgrid_title_truncation":"45","advgrid_description_truncation":"60","height_advgrid":"260","width_advgrid":"304","dummy20":null,"limit_data_pinboard":"10","pinboard_title_truncation":"45","pinboard_description_truncation":"60","width_pinboard":"300","dummy21":null,"limit_data_map":"25","title":"","nomobile":"0","name":"sespage.browse-pages"}';
            $params['right_content'][0]["name"] = "sespage.browse-search";
            $params["right_content"][0]["params"] ='{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPfollower","featured","sponsored","verified","hot"],"default_search_type":"mostSPliked","criteria":["0","4","5","1","2","3"],"default_view_search_type":"0","show_option":["searchPageTitle","view","browseBy","alphabet","Categories","customFields","location","miles","country","state","city","zip","venue","closepage"],"hide_option":["searchPageTitle","view","browseBy","alphabet","Categories","location","miles","closepage"],"title":"","nomobile":"0","name":"sespage.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sespage_page','Page Directories Plugin','sespage','Pages',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesqa
        if($this->checkModuleEnable('sesqa')) {
            $params["title"] = "SES - Professional Search : SES - Advanced QnA";
            $params["name"] = "advancedsearch_index_sesqa_question";
            $params['middle_content'][0]["name"] = "sesqa.tabbed-widget";
            $params["middle_content"][0]["params"] = '{"viewType":"list1","showTabType":"default","category_id":"","show_criteria":["title","favBtn","likeBtn","followBtn","userImage","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"height":"0","width":"0","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncate":"300","limit":"10","show_limited_data":"no","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPvoted","mostSPfavourite","homostSPanswered","unanswered"],"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","mostSPliked_order":"3","mostSPliked_label":"Most Liked","mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","mostSPvoted_order":"5","mostSPvoted_label":"Most Voted","mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","homostSPanswered_order":"7","homostSPanswered_label":"Most Answered","unanswered_order":"7","unanswered_label":"Unanswered","title":"","nomobile":"0","name":"sesqa.tabbed-widget"}';
            $params['right_content'][0]["name"] = "sesqa.browse-search";
            $params["right_content"][0]['params'] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPvoted","mostSPfavourite","homostSPanswered","unanswered","featured","sponsored","verified","hot","new"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_startendtime":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"","nomobile":"0","name":"sesqa.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesqa_question','Questions & Answers Plugin','sesqa','Questions',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesquote
        if($this->checkModuleEnable('sesquote')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Quotes";
            $params["name"] = "advancedsearch_index_sesquote_quote";
            $params['middle_content'][0]["name"] = "sesquote.browse-quotes";
            $params["middle_content"][0]["params"] = '{"stats":["likecount","commentcount","viewcount","postedby","posteddate","source","category","socialSharing","likebutton","permalink"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"250","pagging":"button","limit":"10","title":"","nomobile":"0","name":"sesquote.browse-quotes"}';
            $params['right_content'][0]["name"] = "sesquote.browse-search";
            $params["right_content"][0]['params'] = '{"viewType":"vertical","title":"","nomobile":"0","name":"sesquote.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesquote_quote','Quotes Plugin','sesquote','Quotes',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesteam
        if($this->checkModuleEnable('sesteam')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Site Teams";
            $params["name"] = "advancedsearch_index_sesteam_teams";
            $params['middle_content'][0]["name"] = "sesteam.browse-team";
            $params["middle_content"][0]["params"] = '{"sesteam_type":"teammember","sesteam_template":"2","designation_id":"0","popularity":"","sesteam_contentshow":["featured","sponsored","displayname","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"viewMoreText":"View Details","sesteam_social_border":"1","title":"Meet Team","nomobile":"0","name":"sesteam.team-page"}';
            $params['right_content'][0]["name"] = "sesteam.search";
            $params["right_content"][0]['params'] = '{"sesteamType":"teammember","viewType":"vertical","title":"","nomobile":"0","name":"sesteam.search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesteam_teams','Team Showcase & Multi-Use Team Plugin','sesteam','Site Team',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesreceipe
        if($this->checkModuleEnable('sesrecipe')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Recepies";
            $params["name"] = "advancedsearch_index_sesrecipe";
            $params['middle_content'][0]["name"] = "sesrecipe.browse-recipes";
            $params["middle_content"][0]["params"] = '{"enableTabs":["advlist","grid","pinboard","map"],"openViewType":"grid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_listview2plusicon":"1","socialshare_icon_listview2limit":"2","socialshare_enable_listview3plusicon":"1","socialshare_icon_listview3limit":"2","socialshare_enable_listview4plusicon":"1","socialshare_icon_listview4limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_gridview2plusicon":"1","socialshare_icon_gridview2limit":"2","socialshare_enable_gridview3plusicon":"1","socialshare_icon_gridview3limit":"2","socialshare_enable_gridview4plusicon":"1","socialshare_icon_gridview4limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","category":"0","sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"200","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"200","width_grid":"300","height_simplelist":"230","width_simplelist":"229","height_advgrid":"350","width_advgrid":"300","height_supergrid":"175","width_supergrid":"300","width_pinboard":"250","limit_data_pinboard":"6","limit_data_grid":"6","limit_data_list":"6","limit_data_simplelist":"6","limit_data_advlist":"2","limit_data_advgrid":"6","limit_data_supergrid":"6","pagging":"pagging","title":"","nomobile":"0","name":"sesrecipe.browse-recipes"}';
            $params['right_content'][0]["name"] = "sesrecipe.browse-search";
            $params["right_content"][0]['params'] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPfavourite","mostSPrated","sponsored"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"sesrecipe.browse-search"}';
            $params["right_content"][1]["name"] = "sesrecipe.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesrecipe','Recipes With Reviews & Location Plugin','sesrecipe','Recepies',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesthought
        if($this->checkModuleEnable('sesthought')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Thoughts";
            $params["name"] = "advancedsearch_index_sesthought_thought";
            $params['middle_content'][0]["name"] = "sesthought.browse-thoughts";
            $params["middle_content"][0]["params"] = '{"stats":["likecount","commentcount","viewcount","postedby","posteddate","source","category","socialSharing","likebutton","permalink"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"250","pagging":"button","limit":"10","title":"","nomobile":"0","name":"sesthought.browse-thoughts"}';
            $params['right_content'][0]["name"] = "sesthought.browse-search";
            $params["right_content"][0]['params'] = '{"viewType":"vertical","title":"","nomobile":"0","name":"sesthought.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesthought_thought','Thoughts Plugin','sesthought','Thoughts',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesvideo
        if($this->checkModuleEnable('sesvideo')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Videos";
            $params["name"] = "advancedsearch_index_sesvideo_video";
            $params['middle_content'][0]["name"] = "sesvideo.browse-video";
            $params["middle_content"][0]["params"] = '{"enableTabs":["list","grid","pinboard"],"openViewType":"grid","show_criteria":["watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","duration","descriptionlist","descriptionpinboard","enableCommentPinboard"],"sort":"mostSPliked","title_truncation_list":"70","title_truncation_grid":"30","description_truncation_list":"230","description_truncation_grid":"45","description_truncation_pinboard":"60","height_list":"180","width_list":"260","height_grid":"270","width_grid":"305","width_pinboard":"305","limit_data_pinboard":"10","limit_data_grid":"15","limit_data_list":"20","pagging":"pagging","title":"","nomobile":"0","name":"sesvideo.browse-video"}';
            $params['right_content'][0]["name"] = "sesvideo.browse-search";
            $params["right_content"][0]['params'] = '{"enableTabs":["list","grid","pinboard"],"openViewType":"grid","show_criteria":["watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","duration","descriptionlist","descriptionpinboard","enableCommentPinboard"],"sort":"mostSPliked","title_truncation_list":"70","title_truncation_grid":"30","description_truncation_list":"230","description_truncation_grid":"45","description_truncation_pinboard":"60","height_list":"180","width_list":"260","height_grid":"270","width_grid":"305","width_pinboard":"305","limit_data_pinboard":"10","limit_data_grid":"15","limit_data_list":"20","pagging":"pagging","title":"","nomobile":"0","name":"sesvideo.browse-video"}';
            $params["right_content"][1]['name'] = 'sesvideo.browse-menu-quick';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesvideo_video','Advanced Videos & Channels Plugin','sesvideo','Videos',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
            //channels
            $params["title"] = "SES - Professional Search : SES - Advanced Videos Channel";
            $params["name"] = "advancedsearch_index_sesvideo_chanel";
            $params['middle_content'][0]["name"] = "sesvideo.browse-chanel";
            $params["middle_content"][0]["params"] = '{"show_criteria":["description","follow","followButton","favouriteButton","likeButton","verified","rating","socialeShare","like","comment","photo","view","title","favourite","by","chanelPhoto","chanelVideo","chanelThumbnail","videoCount","watchLater"],"pagging":"button","count_chanel":"1","criteria":"most_chanel","category_limit":"7","chanel_limit":"10","video_limit":"10","seemore_text":"+ See all [category_name]","allignment_seeall":"left","title_truncation":"45","description_truncation":"210","height":"80","width":"120","title":"","nomobile":"0","name":"sesvideo.browse-chanel"}';
            $params['right_content'][0]["name"] = "sesvideo.browse-search";
            $params["right_content"][0]['params'] = '{"search_for":"chanel","view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","featured","sponsored","verified","hot"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"","nomobile":"0","name":"sesvideo.browse-search"}';
            $params["right_content"][1]['name'] = 'sesvideo.browse-chanel-quick';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesvideo_chanel','Advanced Videos & Channels Plugin','sesvideo','Channels',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();

        }
        //Seswishe
        if($this->checkModuleEnable('seswishe')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Wishes";
            $params["name"] = "advancedsearch_index_seswishe_wishe";
            $params['middle_content'][0]["name"] = "seswishe.browse-wishes";
            $params["middle_content"][0]["params"] = '{"stats":["likecount","commentcount","viewcount","postedby","posteddate","source","category","socialSharing","likebutton","permalink"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"250","pagging":"button","limit":"10","title":"","nomobile":"0","name":"seswishe.browse-wishes"}';
            $params['right_content'][0]["name"] = "seswishe.browse-search";
            $params["right_content"][0]['params'] = '{"viewType":"vertical","title":"","nomobile":"0","name":"seswishe.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('seswishe_wishe','Wishes Plugin','seswishe','Wishes',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesprayer
        if($this->checkModuleEnable('sesprayer')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Prayers";
            $params["name"] = "advancedsearch_index_sesprayer_prayer";
            $params['middle_content'][0]["name"] = "sesprayer.browse-prayers";
            $params["middle_content"][0]["params"] = '{"stats":["likecount","commentcount","viewcount","postedby","posteddate","source","category","socialSharing","likebutton","permalink"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","width":"250","pagging":"button","limit":"10","title":"","nomobile":"0","name":"sesprayer.browse-prayers"}';
            $params['right_content'][0]["name"] = "sesprayer.browse-search";
            $params["right_content"][0]['params'] = '{"viewType":"vertical","title":"","nomobile":"0","name":"sesprayer.browse-search"}';
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('sesprayer_prayer','Prayers Plugin','sesprayer','Prayers',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
        //Sesartist
        if($this->checkModuleEnable('sesartist')) {
            $params["title"] = "SES - Professional Search : SES - Advanced Artists";
            $params["name"] = "advancedsearch_index_artists";
            $params['middle_content'][0]["name"] = "sesartist.browse-artists";
            $params["middle_content"][0]["params"] = '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"300","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"270","width_grid":"307","height_simplelist":"230","width_simplelist":"260","height_advgrid":"230","width_advgrid":"461","height_supergrid":"250","width_supergrid":"461","width_pinboard":"280","limit_data_pinboard":"12","limit_data_grid":"12","limit_data_list":"12","limit_data_simplelist":"12","limit_data_advlist":"12","limit_data_advgrid":"12","limit_data_supergrid":"12","pagging":"button","title":"","nomobile":"0","name":"sesartist.browse-artists"}';
            $params['right_content'][0]["name"] = "sesartist.browse-search";
            $params["right_content"][0]['params'] = '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"sesartist.browse-search"}';
            $params["right_content"][1]['name'] = "sesartist.browse-menu-quick";
            $isCreated = $this->createWidgetizePage($params);
            if($isCreated) {
                $db->query("INSERT INTO `engine4_advancedsearch_modules`( `resource_type`, `resource_title`, `module_name`, `title`, `creation_date`, `modified_date`)
                      VALUES ('artists','Artist Directories Plugin','sesartist','Artist Directories',NOW(),NOW())");
                $this->updateIcons($db->lastInsertId());
            }
            $params = array();
        }
    }
    //Insert Wigitize pages
    function createWidgetizePage($params = array()){
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        // profile page
        $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', $params['name'])
            ->limit(1)
            ->query()
            ->fetchColumn();
        // insert if it doesn't exist yet
        if( !$pageId ) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => !empty($params['name']) ? $params['name'] : "NULL",
                'displayname' => !empty($params['title']) ? $params['title'] : "NULL" ,
                'title' => !empty($params['title']) ? str_replace(array('Professional Search : SES -','Professional Search : Core -'),array('',''),$params['title']) : "NULL",
                'description' => !empty($params['description']) ? $params['description'] : "NULL",
                'custom' => 0,
            ));
            $pageId = $db->lastInsertId();
            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $pageId,
                'order' => 1,
            ));
            $topId = $db->lastInsertId();
            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $pageId,
                'order' => 2,
            ));
            $mainId = $db->lastInsertId();
            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $topId,
            ));
            $topMiddleId = $db->lastInsertId();
            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 2,
            ));
            $mainMiddleId = $db->lastInsertId();
            // Insert main-right
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 1,
            ));
            $mainRightId = $db->lastInsertId();
            // Insert middle content
            $order = 1;
            if(!empty($params['middle_content'])) {
                foreach($params['middle_content'] as $content) {
                    $db->insert('engine4_core_content', array(
                        'type' => 'widget',
                        'name' => $content["name"],
                        'params'=>!empty($content['params']) ? $content['params'] : "[]",
                        'page_id' => $pageId,
                        'parent_content_id' => $mainMiddleId,
                        'order' => $order++,
                    ));
                }
            }
            $order = 1;
            // Insert search
            if(!empty($params['right_content'])) {
                foreach ($params['right_content'] as $content) {
                    $db->insert('engine4_core_content', array(
                        'type' => 'widget',
                        'name' => $content["name"],
                        'params' => !empty($content["params"]) ? $content["params"] : "[]",
                        'page_id' => $pageId,
                        'parent_content_id' => $mainRightId,
                        'order' => $order++,
                    ));
                }
            }
            return true;
        }
        return false;
    }
    public function updateIcons($id){
        $item = Engine_Api::_()->getItem('advancedsearch_modules',$id);
        if(!$item)
            return false;
        $moduleName = $item->resource_type;
        $path = APPLICATION_PATH.'/application/modules/Advancedsearch/externals/images/icons/'.$moduleName.'.png';
        //check file exists in icon folder
        if(file_exists($path)){
            //upload file
            $storage = Engine_Api::_()->getItemTable('storage_file');
            $storageObject = $storage->createFile($path, array(
                'parent_id' => $item->getIdentity(),
                'parent_type' => $item->getType(),
                'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
            ));
            // Remove temporary file
            $item->file_id = $storageObject->file_id;
            $item->icon_updated = 1;
            $item->save();
        }
    }
    /* get other module compatibility code as per module name given */
    public function getPluginItem($moduleName) {
        //initialize module item array
        $moduleType = array();
        $filePath =  APPLICATION_PATH . "/application/modules/" . ucfirst($moduleName) . "/settings/manifest.php";
        //check file exists or not
        if (is_file($filePath)) {
            //now include the file
            $manafestFile = include $filePath;
            $resultsArray =  Engine_Api::_()->getDbtable('integrateothermodules', 'sesbasic')->getResults(array('module_name'=>$moduleName));
            if (is_array($manafestFile) && isset($manafestFile['items'])) {
                foreach ($manafestFile['items'] as $item)
                    if (!in_array($item, $resultsArray))
                        $moduleType[$item] = $item.' ';
            }
        }
        return $moduleType;
    }
}