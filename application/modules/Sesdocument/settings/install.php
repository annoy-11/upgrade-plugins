<?php


class Sesdocument_Installer extends Engine_Package_Installer_Module {

    public function onInstall() {

        $db = $this->getDb();

        $select = new Zend_Db_Select($db);
        // Get page id
        $page_id = $select
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'user_profile_index')
                ->limit(1)
                ->query()
                ->fetchColumn(0);
        // Check if it's already been placed
        $select = new Zend_Db_Select($db);
        $hasProfileDocuments = $select
                ->from('engine4_core_content', new Zend_Db_Expr('TRUE'))
                ->where('page_id = ?', $page_id)
                ->where('type = ?', 'widget')
                ->where('name = ?', 'sesdocument.profile-documents')
                ->query()
                ->fetchColumn();

        // Add it
        if (!$hasProfileDocuments) {

            // container_id (will always be there)
            $select = new Zend_Db_Select($db);
            $container_id = $select
                    ->from('engine4_core_content', 'content_id')
                    ->where('page_id = ?', $page_id)
                    ->where('type = ?', 'container')
                    ->limit(1)
                    ->query()
                    ->fetchColumn();

            // middle_id (will always be there)
            $select = new Zend_Db_Select($db);
            $middle_id = $select
                    ->from('engine4_core_content', 'content_id')
                    ->where('parent_content_id = ?', $container_id)
                    ->where('type = ?', 'container')
                    ->where('name = ?', 'middle')
                    ->limit(1)
                    ->query()
                    ->fetchColumn();

            // tab_id (tab container) may not always be there
            $select = new Zend_Db_Select($db);
            $select
                    ->from('engine4_core_content', 'content_id')
                    ->where('type = ?', 'widget')
                    ->where('name = ?', 'core.container-tabs')
                    ->where('page_id = ?', $page_id)
                    ->limit(1);
            $tab_id = $select->query()->fetchObject();
            if ($tab_id && @$tab_id->content_id) {
                $tab_id = $tab_id->content_id;
            } else {
                $tab_id = $middle_id;
            }

            // insert
            if ($tab_id) {
                $db->insert('engine4_core_content', array(
                    'page_id' => $page_id,
                    'type' => 'widget',
                    'name' => 'sesdocument.profile-documents',
                    'parent_content_id' => $tab_id,
                    'order' => 8,
                    'params' => '{"title":"Documents","titleCount":true}',
                ));
            }
        }

        $select = $db->select()
                ->from('engine4_core_pages')
                ->where('name = ?', 'sesdocument_index_home')
                ->limit(1);
        $info = $select->query()->fetch();
        if (empty($info)) {
        $db->insert('engine4_core_pages', array(
            'name' => 'sesdocument_index_home',
            'displayname' => 'SES - Document Sharing - Document Home Page',
            'title' => 'Document Home',
            'description' => 'This is the document home page.',
            'custom' => 0,
        ));
        $page_id = $db->lastInsertId('engine4_core_pages');

        //CONTAINERS
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'main',
            'parent_content_id' => null,
            'order' => 2,
            'params' => '',
        ));
        $container_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'middle',
            'parent_content_id' => $container_id,
            'order' => 6,
            'params' => '',
        ));
        $middle_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'top',
            'parent_content_id' => null,
            'order' => 1,
            'params' => '',
        ));
        $topcontainer_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'left',
            'parent_content_id' => $container_id,
            'order' => 4,
            'params' => '',
        ));
        $left_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'middle',
            'parent_content_id' => $topcontainer_id,
            'order' => 6,
            'params' => '',
        ));
        $topmiddle_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'right',
            'parent_content_id' => $container_id,
            'order' => 5,
            'params' => '',
        ));
        $right_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.browse-menu',
            'parent_content_id' => $topmiddle_id,
            'order' => 3,
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.category-carousel',
            'parent_content_id' => $topmiddle_id,
            'order' => 4,
            'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"300","speed":"300","width":"400","autoplay":"1","criteria":"most_document","show_criteria":["title","description","countDocuments","socialshare"],"isfullwidth":"1","limit_data":"0","title":"Popular Categories","nomobile":"0","name":"sesdocument.category-carousel"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-home-error',
            'parent_content_id' => $topmiddle_id,
            'order' => 5,
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.of-the-day',
            'parent_content_id' => $left_id,
            'order' => 8,
            'params' => '{"viewType":"gridOutside","show_criteria":["title","location","socialSharing","likeButton","favouriteButton","listButton"],"grid_title_truncation":"30","list_title_truncation":"45","height":"240","width":"180","title":"Document of the Day","nomobile":"0","name":"sesdocument.of-the-day"}',
        ));



        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.featured-sponsored',
            'parent_content_id' => $left_id,
            'order' => 10,
            'params' => '{"viewType":"list","gridInsideOutside":"in","mouseOver":"over","order":"ongoingSPupcomming","criteria":"5","info":"most_liked","show_criteria":["title","location","startenddate","socialSharing","likeButton","favouriteButton","listButton"],"grid_title_truncation":"45","list_title_truncation":"15","height":"180","width":"180","limit_data":"3","title":"Most Liked Documents","nomobile":"0","name":"sesdocument.featured-sponsored"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.featured-sponsored',
            'parent_content_id' => $left_id,
            'order' => 11,
            'params' => '{"viewType":"list","order":"ongoingSPupcomming","criteria":"5","info":"most_commented","show_criteria":["title","location","startenddate","socialSharing","likeButton","favouriteButton","listButton"],"grid_title_truncation":"45","list_title_truncation":"15","height":"180","width":"180","limit_data":"3","title":"Most Commented Documents","nomobile":"0","name":"sesdocument.featured-sponsored"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.recently-viewed-item',
            'parent_content_id' => $topmiddle_id,
            'order' => 12,
            'params' => '{"view_type":"list","gridInsideOutside":"in","mouseOver":"over","criteria":"on_site","show_criteria":["title","location"],"grid_title_truncation":"45","list_title_truncation":"18","height":"180","width":"180","limit_data":"3","title":"Recently Viewed Documents","nomobile":"0","name":"sesdocument.recently-viewed-item"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.browse-search',
            'parent_content_id' => $middle_id,
            'order' => 14,
            'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","mostSPjoined","featured","sponsored","verified"],"view":["0","1","ongoing","past","week","weekend","future","month"],"default_search_type":"creation_date ASC","alphabet":"no","friend_show":"no","search_title":"yes","browse_by":"no","categories":"yes","location":"yes","kilometer_miles":"no","start_date":"no","end_date":"no","country":"no","state":"no","city":"no","zip":"no","venue":"no","title":"","nomobile":"0","name":"sesdocument.browse-search"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.featured-sponsored-carousel',
            'parent_content_id' => $middle_id,
            'order' => 15,
            'params' => '{"order":"ongoingSPupcomming","criteria":"6","info":"most_viewed","show_criteria":["title","location","startenddate","socialSharing","likeButton","favouriteButton","listButton"],"list_title_truncation":"20","gridInsideOutside":"in","mouseOver":"over","imageheight":"215","viewType":"horizontal","height":"215","width":"215","limit_data":"8","title":"Verified Documents","nomobile":"0","name":"sesdocument.featured-sponsored-carousel"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.tabbed-documents',
            'parent_content_id' => $middle_id,
            'order' => 16,
            'params' => '{"enableTabs":["list","grid","advgrid","pinboard","masonry","map"],"openViewType":"advgrid","tabOption":"default","show_item_count":"0","show_criteria":["favouriteButton","listButton","likeButton","socialSharing","location","buy","title","startenddate","category","host","listdescription","commentpinboard"],"limit_data":" 8","show_limited_data":"no","pagging":"pagging","grid_title_truncation":"33","advgrid_title_truncation":"33","list_title_truncation":"45","pinboard_title_truncation":"33","masonry_title_truncation":"33","list_description_truncation":"45","masonry_description_truncation":"45","grid_description_truncation":"45","pinboard_description_truncation":"45","height":"160","width":"215","photo_height":"190","photo_width":"315","info_height":"135","advgrid_width":"318","advgrid_height":"360","pinboard_width":"325","masonry_height":"280","search_type":["ongoingSPupcomming","week","weekend","month","mostSPjoined"],"ongoingSPupcomming_order":"1","ongoingSPupcomming_label":"Upcoming & Ongoing","upcoming_order":"2","upcoming_label":"Upcoming","ongoing_order":"3","ongoing_label":"Ongoing","past_order":"4","past_label":"Past","week_order":"5","week_label":"This Week","weekend_order":"6","weekend_label":"This Weekend","month_order":"7","month_label":"This Month","mostSPjoined_order":"8","mostSPjoined_label":"Most Joined Documents","recentlySPcreated_order":"9","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"10","mostSPviewed_label":"Most Viewed","mostSPliked_order":"11","mostSPliked_label":"Most Liked","mostSPcommented_order":"12","mostSPcommented_label":"Most Commented","mostSPrated_order":"13","mostSPrated_label":"Most Rated","mostSPfavourite_order":"14","mostSPfavourite_label":"Most Favourite","featured_order":"15","featured_label":"Featured","sponsored_order":"16","sponsored_label":"Sponsored","verified_order":"17","verified_label":"Verified","title":"Popular Documents","nomobile":"0","name":"sesdocument.tabbed-documents"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.featured-sponsored-carousel',
            'parent_content_id' => $right_id,
            'order' => 18,
            'params' => '{"order":"ongoingSPupcomming","criteria":"2","info":"most_liked","show_criteria":["title","like","comment","view","favourite","location","host","startenddate","socialSharing","likeButton","favouriteButton","listButton"],"list_title_truncation":"16","gridInsideOutside":"out","mouseOver":"","imageheight":"180","viewType":"vertical","height":"305","width":"180","limit_data":"8","title":"Sponsored Documents","nomobile":"0","name":"sesdocument.featured-sponsored-carousel"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.tag-cloud',
            'parent_content_id' => $right_id,
            'order' => 19,
            'params' => '{"color":"#000000","text_height":"15","height":"150","itemCountPerPage":"25","title":"Popular Tags","nomobile":"0","name":"sesdocument.tag-cloud"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.featured-sponsored',
            'parent_content_id' => $right_id,
            'order' => 20,
            'params' => '{"viewType":"gridInside","gridInsideOutside":"in","mouseOver":"over","order":"ongoingSPupcomming","criteria":"1","info":"most_liked","show_criteria":["title","category","location","startenddate","socialSharing","likeButton","favouriteButton","listButton","buy"],"grid_title_truncation":"25","list_title_truncation":"45","height":"180","width":"180","limit_data":"3","title":"Featured Documents","nomobile":"0","name":"sesdocument.featured-sponsored"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.featured-sponsored',
            'parent_content_id' => $right_id,
            'order' => 15,
            'params' => '{"viewType":"list","gridInsideOutside":"in","mouseOver":"over","order":"ongoingSPupcomming","criteria":"5","info":"favourite_count","show_criteria":["title","location","startenddate"],"grid_title_truncation":"45","list_title_truncation":"15","height":"180","width":"180","limit_data":"3","title":"Most Favourite Documents","nomobile":"0","name":"sesdocument.featured-sponsored"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.featured-sponsored',
            'parent_content_id' => $right_id,
            'order' => 15,
            'params' => '{"viewType":"list","order":"","criteria":"5","info":"most_rated","show_criteria":["title","location","startenddate"],"grid_title_truncation":"45","list_title_truncation":"18","height":"180","width":"180","limit_data":"3","title":"Top Rated Documents","nomobile":"0","name":"sesdocument.featured-sponsored"}',
        ));

        }

        $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesdocument_index_create')
            ->limit(1)
            ->query()
            ->fetchColumn();


            // insert if it doesn't exist yet
            if( !$pageId ) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'sesdocument_index_create',
                'displayname' => 'SES - Document Sharing - Create Page',
                'title' => 'Create Page',
                'description' => '',
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

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'sesdocument.create-menu',
                'page_id' => $pageId,
                'parent_content_id' => $topMiddleId,
                'order' => 0,
            ));
            }

        $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesdocument_category_browse')
                ->limit(1)
                ->query()
                ->fetchColumn();
        if (!$page_id) {
            $widgetOrder = 1;
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'sesdocument_category_browse',
                'displayname' => 'SES - Document Sharing - Browse Categories Page',
                'title' => 'Browse Categories Page',
                'description' => 'This page is the browse documents categories page.',
                'custom' => 0,
            ));
            $page_id = $db->lastInsertId();
            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();
            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();
            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $top_id,
                'order' => 6
            ));
            $top_middle_id = $db->lastInsertId();
            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 6
            ));
            $main_middle_id = $db->lastInsertId();

            $db->insert('engine4_core_content', array(
                'page_id' => $page_id,
                'type' => 'widget',
                'name' => 'sesdocument.browse-menu',
                'parent_content_id' => $top_middle_id,
                'order' => $widgetOrder++,
                'params' => '',
            ));
            $db->insert('engine4_core_content', array(
                'page_id' => $page_id,
                'type' => 'widget',
                'name' => 'sesdocument.banner-category',
                'parent_content_id' => $top_middle_id,
                'order' => $widgetOrder++,
                'params' => '{"description":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur massa neque, ullamcorper at justo eu, cursus sodales ante.","sesdocument_categorycover_photo":"public\/admin\/document_category_banner.jpg","title":"Document Categories","nomobile":"0","name":"sesDocument.banner-category"}',
            ));

            $array['show_content'] = 1;
            $array['title'] = '';
            $array['nomobile'] = 0;
            $array['name'] = 'sesbasic.simple-html-block';

            foreach ($languageList as $key => $language) {
            if ($language == 'en')
            $coulmnName = 'bodysimple';
            else
            $coulmnName = $language . '_bodysimple';
            $array[$coulmnName] = '<div style="font-size:30px;margin-bottom: 15px;margin:15px">All Categories</div>';
            }

            $db->insert('engine4_core_content', array(
                'page_id' => $page_id,
                'type' => 'widget',
                'name' => 'sesbasic.simple-html-block',
                'parent_content_id' => $main_middle_id,
                'order' => $widgetOrder++,
                'params' => json_encode($array),
            ));

            $db->insert('engine4_core_content', array(
                'page_id' => $page_id,
                'type' => 'widget',
                'name' => 'sesdocument.document-category',
                'parent_content_id' => $main_middle_id,
                'order' => $widgetOrder++,
                'params' => '{"height":"140","width":"285","alignContent":"center","criteria":"most_document","show_criteria":["title","countDocuments"],"title":"","nomobile":"0","name":"sesdocument.document-category"}',
            ));

            $db->insert('engine4_core_content', array(
                'page_id' => $page_id,
                'type' => 'widget',
                'name' => 'sesdocument.category-associate-document',
                'parent_content_id' => $main_middle_id,
                'order' => $widgetOrder++,
                'params' => '{"view_type":"2","show_criteria":["title","by","description","like","view","comment","favourite","featuredLabel","sponsoredLabel","albumPhoto","joinedcount","photoThumbnail","favouriteButton","likeButton","listButton","socialSharing","location","startenddate"],"photo_height":"190","photo_width":"282","info_height":"180","pagging":"button","count_document":"1","criteria":"most_document","category_limit":"5","document_limit":"4","seemore_text":"+ See all [category_name]","allignment_seeall":"left","title_truncation":"20","description_truncation":"40","title":"","nomobile":"0","name":"sesdocument.category-associate-document"}',
            ));
            }

            $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesdocument_category_index')
                ->limit(1)
                ->query()
                ->fetchColumn();
            if (!$page_id) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'sesdocument_category_index',
                'displayname' => 'SES - Document Sharing - Category View Page',
                'title' => 'Category View Page',
                'description' => 'This page is the category view page.',
                'custom' => 0,
            ));
            $page_id = $db->lastInsertId();
            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $page_id,
                'order' => 1,
            ));
            $top_id = $db->lastInsertId();
            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $page_id,
                'order' => 2,
            ));
            $main_id = $db->lastInsertId();
            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $page_id,
                'parent_content_id' => $main_id,
                'order' => 6
            ));
            $main_middle_id = $db->lastInsertId();

            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'sesdocument.browse-menu',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 4,
            ));

            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'sesdocument.category-view',
                'page_id' => $page_id,
                'parent_content_id' => $main_middle_id,
                'order' => 5,
                'params' => '{"show_subcat":"1","show_subcatcriteria":["title","icon","countDocuments"],"heightSubcat":"140","widthSubcat":"226","dummy1":null,"show_criteria":["featuredLabel","sponsoredLabel","like","comment","joinedcount","startenddate","rating","view","title","by","favourite"],"pagging":"pagging","document_limit":"9","height":"160","width":"160","title":"","nomobile":"0","name":"sesdocument.category-view"}',
            ));
        }

        $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesdocument_index_browse')
                ->limit(1)
                ->query()
                ->fetchColumn();

        // insert if it doesn't exist yet
        if (!$page_id) {
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'sesdocument_index_browse',
            'displayname' => 'SES - Document Sharing - Document Browse Page',
            'title' => ' Document Browse',
            'description' => 'This page lists documents.',
            'custom' => 0,
        ));
        $page_id = $db->lastInsertId();

        // Insert top
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'top',
            'page_id' => $page_id,
            'order' => 1,
        ));
        $top_id = $db->lastInsertId();

        // Insert main
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'main',
            'page_id' => $page_id,
            'order' => 2,
        ));
        $main_id = $db->lastInsertId();

        // Insert top-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $top_id,
        ));
        $top_middle_id = $db->lastInsertId();

        // Insert main-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 2,
        ));
        $main_middle_id = $db->lastInsertId();

        // Insert main-right
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'right',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 1,
        ));
        $main_right_id = $db->lastInsertId();

        // Insert menu
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => 3,
        ));

        // Insert search
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.browse-search',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => 4,
            'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","featured","sponsored","verified"],"view":["0","1","ongoing","past","week","weekend","future","month"],"default_search_type":"view_count DESC","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","start_date":"yes","end_date":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","venue":"yes","title":"Search Events","nomobile":"0","name":"sesdocument.browse-search"}',
        ));

        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.browse-documents',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => 7,
            'params' => '{"enableTabs":["list","grid","advgrid","pinboard","masonry","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","listButton","favouriteButton","likeButton","socialSharing","joinedcount","location","buy","title","startenddate","category","host","listdescription","pinboarddescription","commentpinboard"],"limit_data":"12","pagging":"button","order":"mostSPliked","show_item_count":"1","list_title_truncation":"60","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","masonry_title_truncation":"45","list_description_truncation":"170","grid_description_truncation":"45","pinboard_description_truncation":"45","masonry_description_truncation":"45","height":"215","width":"300","photo_height":"290","photo_width":"296","info_height":"160","advgrid_height":"370","advgrid_width":"297","pinboard_width":"250","masonry_height":"350","title":"","nomobile":"0","name":"sesdocument.browse-documents"}',
        ));


        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.browse-menu-quick',
            'page_id' => $page_id,
            'parent_content_id' => $main_right_id,
            'order' => 10,
            'params' => '{"popup":["1"],"title":"","nomobile":"0","name":"sesdocument.browse-menu-quick"}',
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.featured-sponsored-carousel',
            'page_id' => $page_id,
            'parent_content_id' => $main_right_id,
            'order' => 11,
            'params' => '{"order":"ongoingSPupcomming","criteria":"6","info":"most_liked","show_criteria":["title","category","location","startenddate","rating","featuredLabel","sponsoredLabel","socialSharing","likeButton","favouriteButton","listButton"],"list_title_truncation":"45","gridInsideOutside":"out","mouseOver":"over","imageheight":"225","viewType":"vertical","height":"250","width":"180","limit_data":"6","title":"Verified Events","nomobile":"0","name":"sesdocument.featured-sponsored-carousel"}',
        ));

        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.recently-viewed-item',
            'page_id' => $page_id,
            'parent_content_id' => $main_right_id,
            'order' => 12,
            'params' => '{"view_type":"gridInside","gridInsideOutside":"out","mouseOver":"over","criteria":"on_site","show_criteria":["title","location","startenddate"],"grid_title_truncation":"15","list_title_truncation":"45","height":"180","width":"180","limit_data":"3","title":"Recently Viewed Events","nomobile":"0","name":"sesdocument.recently-viewed-item"}',
        ));
        }

        $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesdocument_index_manage')
                ->limit(1)
                ->query()
                ->fetchColumn();

        // insert if it doesn't exist yet
        if (!$page_id) {
        $widgetOrder = 1;
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'sesdocument_index_manage',
            'displayname' => 'SES - Document Sharing - Document Manage Page',
            'title' => 'My Documents',
            'description' => 'This page lists a user\'s documents.',
            'custom' => 0,
        ));
        $page_id = $db->lastInsertId();

        // Insert top
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'top',
            'page_id' => $page_id,
            'order' => 1,
        ));
        $top_id = $db->lastInsertId();

        // Insert main
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'main',
            'page_id' => $page_id,
            'order' => 2,
        ));
        $main_id = $db->lastInsertId();

        // Insert top-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $top_id,
        ));
        $top_middle_id = $db->lastInsertId();

        // Insert main-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 2,
        ));
        $main_middle_id = $db->lastInsertId();

        // Insert menu
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => $widgetOrder++,
        ));

        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.manage-documents',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => $widgetOrder++,
            'params' => '{"enableTabs":["list","grid"],"openViewType":"advgrid","show_criteria":["favouriteButton","listButton","likeButton","joinedcount","socialSharing","like","location","comment","favourite","buy","rating","view","title","startenddate","category","by","host","listdescription","griddescription","pinboarddescription","commentpinboard","documentcount","share","showDocumentsList"],"limit_data":"20","pagging":"button","advgrid_title_truncation":"25","grid_title_truncation":"25","list_title_truncation":"50","pinboard_title_truncation":"25","masonry_title_truncation":"25","list_description_truncation":"100","masonry_description_truncation":"45","grid_description_truncation":"38","pinboard_description_truncation":"40","width_lists":"308","width_hosts":"310","height_hosts":"220","advgrid_width":"308","advgrid_height":"395","height":"200","width":"280","photo_height":"150","photo_width":"308","info_height":"215","pinboard_width":"250","masonry_height":"330","search_type":["all","joinedDocuments","hostedDocuments","save","like","favourite","featured","sponsored","verified","lists","hosts"],"all_order":"1","all_label":"Owned Documents","joinedDocuments_order":"2","joinedDocuments_label":"Joined Documents Only","hostedDocuments_order":"3","hostedDocuments_label":"Hosted Documents Only","save_order":"4","save_label":"Saved Documents","like_order":"5","like_label":"Liked Documents","favourite_order":"6","favourite_label":"Favourite Documents","featured_order":"7","featured_label":"Featured Documents","sponsored_order":"8","sponsored_label":"Sponsored Documents","verified_order":"9","verified_label":"Verified Documents","lists_order":"10","lists_label":"My Lists","hosts_order":"11","hosts_label":"My Hosts","title":"","nomobile":"0","name":"sesdocument.manage-documents"}',
        ));
        }

        $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesdocument_index_tags')
                ->limit(1)
                ->query()
                ->fetchColumn();
        if (!$page_id) {
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'sesdocument_index_tags',
            'displayname' => 'SES - Document Sharing - Browse Tags Page',
            'title' => 'Documents Browse Tags Page',
            'description' => 'This page is the browse documents tag page.',
            'custom' => 0,
        ));
        $page_id = $db->lastInsertId();
        // Insert top
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'top',
            'page_id' => $page_id,
            'order' => 1,
        ));
        $top_id = $db->lastInsertId();
        // Insert main
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'main',
            'page_id' => $page_id,
            'order' => 2,
        ));
        $main_id = $db->lastInsertId();
        // Insert top-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $top_id,
            'order' => 6
        ));
        $top_middle_id = $db->lastInsertId();
        // Insert main-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 6
        ));
        $main_middle_id = $db->lastInsertId();
        // Insert menu
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => 3,
        ));
        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.tag-documents',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => 4,
        ));
        }

        $select = new Zend_Db_Select($db);
        $hasWidget = $select
        ->from('engine4_core_pages', new Zend_Db_Expr('TRUE'))
        ->where('name = ?', 'sesdocument_profile_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
        // Add it
        if (empty($hasWidget)) {

        $db->insert('engine4_core_pages', array(
            'name' => 'sesdocument_profile_index',
            'displayname' => 'SES - Document Sharing - Document Profile',
            'title' => 'Document Profile',
            'description' => 'This is the profile for an document.',
            'custom' => 0,
            'provides' => 'subject=document',
        ));
        $page_id = $db->lastInsertId('engine4_core_pages');

        // Insert top
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'top',
            'page_id' => $page_id,
            'order' => 1,
        ));
        $top_id = $db->lastInsertId();

        // Insert main
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'main',
            'page_id' => $page_id,
            'order' => 2,
        ));
        $container_id = $db->lastInsertId();

        // Insert top-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $top_id,
            'order' => 6,
        ));
        $top_middle_id = $db->lastInsertId();

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'middle',
            'parent_content_id' => $container_id,
            'order' => 6,
        ));
        $middle_id = $db->lastInsertId('engine4_core_content');

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'container',
            'name' => 'right',
            'parent_content_id' => $container_id,
            'order' => 5,
        ));
        $right_id = $db->lastInsertId('engine4_core_content');

        // middle column
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'core.container-tabs',
            'parent_content_id' => $middle_id,
            'order' => 7,
            'params' => '{"max":"7","title":"","nomobile":"0","name":"core.container-tabs"}',
        ));
        $tab_id = $db->lastInsertId('engine4_core_content');



        // tabs
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-breadcrumb',
            'parent_content_id' => $tab_id,
            'order' => 8,
            'params' => '{"title":"Info","name":"sesdocument.document-breadcrumb"}',
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-view-page',
            'parent_content_id' => $tab_id,
            'order' => 8,
            'params' => '{"title":"view","name":"sesdocument.document-view-page"}',
        ));


        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'core.profile-links',
            'parent_content_id' => $tab_id,
            'order' => 18,
            'params' => '{"title":"Links","titleCount":true}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.recently-viewed-item',
            'parent_content_id' => $middle_id,
            'order' => 19,
            'params' => '{"view_type":"gridInside","gridInsideOutside":"in","mouseOver":"","criteria":"by_me","show_criteria":["title","location"],"grid_title_truncation":"18","list_title_truncation":"45","height":"180","width":"220","limit_data":"4","title":"Recently Viewed by You","nomobile":"0","name":"sesdocument.recently-viewed-item"}',
        ));

        // right column
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-view-gutter-menu',
            'parent_content_id' => $right_id,
            'order' => 25,
            'params' => '{"title":"Buy Ticket","type":"button","nomobile":"0","name":"sesdocument.document-view-gutter-menu"}',
        ));
            $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-view-gutter-photo',
            'parent_content_id' => $right_id,
            'order' => 25,
            'params' => '{"title":"Buy Ticket","type":"button","nomobile":"0","name":"sesdocument.document-view-gutter-photo"}',
        ));
            $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-view-label',
            'parent_content_id' => $right_id,
            'order' => 25,
            'params' => '{"title":"Buy Ticket","type":"button","nomobile":"0","name":"sesdocument.document-view-label"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-profile-like',
            'parent_content_id' => $right_id,
            'order' => 21,
            'params' => '{"title":"","name":"sesdocument.document-profile-like"}',
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-profile-favourite',
            'parent_content_id' => $right_id,
            'order' => 22,
            'params' => '{"title":"","name":"sesdocument.document-profile-favourite"}',
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-label',
            'parent_content_id' => $right_id,
            'order' => 23,
            'params' => '{"option":["featured","sponsored","verified","offtheday"],"title":"","nomobile":"0","name":"sesdocument.document-label"}',
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-information',
            'parent_content_id' => $right_id,
            'order' => 24,
        ));
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.other-document',
            'parent_content_id' => $right_id,
            'order' => 25,
            'params' => '{"title":"Buy Ticket","type":"button","nomobile":"0","name":"sesdocument.other-document"}',
        ));

        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'sesdocument.document-owner-photo',
            'parent_content_id' => $right_id,
            'order' => 26,
            'params' => '{"guestCount":"4","height":"45","width":"40","title":"","nomobile":"0","name":"sesdocument.document-owner-photo"}',
        ));
        }

        $page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesdocument_index_edit')
                ->limit(1)
                ->query()
                ->fetchColumn();
        if (!$page_id) {
        // Insert page
        $db->insert('engine4_core_pages', array(
            'name' => 'sesdocument_index_edit',
            'displayname' => 'SES - Document Sharing - Document Edit Page',
            'title' => 'Documents Edit Page',
            'description' => 'This page is the edit documents page.',
            'custom' => 0,
        ));
        $page_id = $db->lastInsertId();
        // Insert top
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'top',
            'page_id' => $page_id,
            'order' => 1,
        ));
        $top_id = $db->lastInsertId();
        // Insert main
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'main',
            'page_id' => $page_id,
            'order' => 2,
        ));
        $main_id = $db->lastInsertId();
        // Insert top-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $top_id,
            'order' => 6
        ));
        $top_middle_id = $db->lastInsertId();
        // Insert main-middle
        $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $page_id,
            'parent_content_id' => $main_id,
            'order' => 6
        ));
        $main_middle_id = $db->lastInsertId();
        // Insert menu
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesdocument.browse-menu',
            'page_id' => $page_id,
            'parent_content_id' => $top_middle_id,
            'order' => 3,
        ));
        // Insert content
        $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'core.content',
            'page_id' => $page_id,
            'parent_content_id' => $main_middle_id,
            'order' => 4,
        ));
        }
        parent::onInstall();
    }
  }
