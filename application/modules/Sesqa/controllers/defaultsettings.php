<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescommunityads
 * @package    Sescommunityads
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_sponsored')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_sponsored',
    'displayname' => 'SES - Q&A - Sponsored Browse Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists questions.',
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

    // Insert menu
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesqa.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"sesqa.browse-menu"}',
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesqa.tabbed-widget',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","showTabType":"advance","category_id":"","show_criteria":["title","favBtn","likeBtn","followBtn","userImage","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","sponsoredLabel"],"height":"0","width":"0","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncate":"200","limit":"10","show_limited_data":"no","search_type":["sponsored"],"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","mostSPliked_order":"3","mostSPliked_label":"Most Liked","mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","mostSPvoted_order":"5","mostSPvoted_label":"Most Voted","mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","homostSPanswered_order":"7","homostSPanswered_label":"Most Answered","unanswered_order":"7","unanswered_label":"Unanswered","featured_order":"8","featured_label":"Featured","sponsored_order":"8","sponsored_label":"Sponsored","hot_order":"9","hot_label":"Hot","verified_order":"10","verified_label":"Verified","title":"","nomobile":"0","name":"sesqa.tabbed-widget"}',
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.featured-sponsored-hot',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"order":"","criteria":"2","info":"recently_created","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","sponsoredLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"200","width":"200","limit_data":"","title":"Sponsored Questions","nomobile":"0","name":"sesqa.featured-sponsored-hot"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.question-similar',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.recently-viewed-questions',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"criteria":"by_me","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"2","title":"Recently Viewed Questions","nomobile":"0","name":"sesqa.recently-viewed-questions"}',
    ));
}

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_featured')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_featured',
    'displayname' => 'SES - Q&A - Featured Browse Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists questions.',
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

    // Insert menu
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesqa.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesqa.tabbed-widget',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","showTabType":"advance","category_id":"","show_criteria":["title","favBtn","likeBtn","followBtn","userImage","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","featuredLabel"],"height":"0","width":"0","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncate":"200","limit":"10","show_limited_data":"no","search_type":["featured"],"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","mostSPliked_order":"3","mostSPliked_label":"Most Liked","mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","mostSPvoted_order":"5","mostSPvoted_label":"Most Voted","mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","homostSPanswered_order":"7","homostSPanswered_label":"Most Answered","unanswered_order":"7","unanswered_label":"Unanswered","featured_order":"8","featured_label":"Featured","sponsored_order":"8","sponsored_label":"Sponsored","hot_order":"9","hot_label":"Hot","verified_order":"10","verified_label":"Verified","title":"","nomobile":"0","name":"sesqa.tabbed-widget"}',
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.featured-sponsored-hot',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"order":"","criteria":"1","info":"recently_created","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"","title":"Featured Questions","nomobile":"0","name":"sesqa.featured-sponsored-hot"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.recently-viewed-questions',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"criteria":"by_me","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"2","title":"Recently Viewed Questions","nomobile":"0","name":"sesqa.recently-viewed-questions"}',
    ));
}

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_hot')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_hot',
    'displayname' => 'SES - Q&A - Hot Browse Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists questions.',
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

    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.tabbed-widget',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"viewType":"grid1","showTabType":"advance","category_id":"","show_criteria":["title","favBtn","likeBtn","followBtn","userImage","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","hotLabel"],"height":"0","width":"0","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncate":"200","limit":"10","show_limited_data":"no","search_type":["hot"],"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","mostSPliked_order":"3","mostSPliked_label":"Most Liked","mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","mostSPvoted_order":"5","mostSPvoted_label":"Most Voted","mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","homostSPanswered_order":"7","homostSPanswered_label":"Most Answered","unanswered_order":"7","unanswered_label":"Unanswered","featured_order":"8","featured_label":"Featured","sponsored_order":"8","sponsored_label":"Sponsored","hot_order":"9","hot_label":"Hot","verified_order":"10","verified_label":"Verified","title":"","nomobile":"0","name":"sesqa.tabbed-widget"}',
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.question-similar',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"title":"","name":"sesqa.question-similar"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.recently-viewed-questions',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"criteria":"by_me","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"2","title":"Recently Viewed Questions","nomobile":"0","name":"sesqa.recently-viewed-questions"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.featured-sponsored-hot',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"order":"","criteria":"7","info":"recently_created","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"","title":"Hot Questions","nomobile":"0","name":"sesqa.featured-sponsored-hot"}',
    ));
}

//Question Category Browse Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesqa_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesqa_category_browse',
        'displayname' => 'SES - Q&A - Browse Categories Page',
        'title' => 'Browse Categories Page',
        'description' => 'This page is the browse questions categories page.',
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
        'name' => 'sesqa.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));
    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.banner-search',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
        'params' => '',
    ));
    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.categories',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"showinformation":["title","socialshare"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","mainblockheight":"100","mainblockwidth":"200","categoryiconheight":"75","categoryiconwidth":"75","title":"Categories","nomobile":"0","name":"sesqa.categories"}',
    ));
    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.category-associate-qa',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"viewtype":"list1","showinformation":["title","favBtn","likeBtn","followBtn","userImage","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"socialshare_icon_limit":"2","socialshare_enable_plusicon":"1","title_truncate":"60","limit_data":"3","qacriteria":"most_liked","showviewalllink":"1","limitdataqa":"3","height":"0","width":"0","title":"","nomobile":"0","name":"sesqa.category-associate-qa"}',
    ));
}

//Faq Category View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesqa_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
        'name' => 'sesqa_category_index',
        'displayname' => 'SES - Q&A - Category View Page',
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
        'name' => 'sesqa.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.category-banner',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
    ));
    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.secont-third-categories',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"showinformation":["title","socialshare"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","mainblockheight":"200","mainblockwidth":"250","categoryiconheight":"75","categoryiconwidth":"75","title":"","nomobile":"0","name":"sesqa.secont-third-categories"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.category-view-page',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
    ));
}

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_tags')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_tags',
    'displayname' => 'SES - Q&A - Browse Tags Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists tags.',
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

    // Insert menu
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesqa.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 1,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesqa.tag-qa',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => 1,
    ));


}

//browse page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_browse')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_browse',
    'displayname' => 'SES - Q&A - Browse Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists questions.',
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

    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.banner-search',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"backgroundimage":"public\/admin\/bg-qa.jpg","logo":"0","showfullwidth":"full","autosuggest":"1","height":"400","bannertext":"Have Something in Mind ?? Search Here.","description":"","textplaceholder":"Type your keyword for search","template":"1","qacriteria":"creation_date","limit":"4","title":"","nomobile":"0","name":"sesqa.banner-search"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.alphabet-search',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.browse-search',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPvoted","mostSPfavourite","homostSPanswered","unanswered","featured","sponsored","verified","hot","new"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_startendtime":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"","nomobile":"0","name":"sesqa.browse-search"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.tabbed-widget',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"viewType":"list1","showTabType":"default","category_id":"","show_criteria":["title","favBtn","likeBtn","followBtn","userImage","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"height":"0","width":"0","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncate":"300","limit":"10","show_limited_data":"no","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPvoted","mostSPfavourite","homostSPanswered","unanswered"],"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","mostSPliked_order":"3","mostSPliked_label":"Most Liked","mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","mostSPvoted_order":"5","mostSPvoted_label":"Most Voted","mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","homostSPanswered_order":"7","homostSPanswered_label":"Most Answered","unanswered_order":"7","unanswered_label":"Unanswered","title":"","nomobile":"0","name":"sesqa.tabbed-widget"}',
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.question-off-the-day',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"show_criteria":["itemPhoto","title","vote","like"],"category_id":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"30","height":"180","width":"180","title":"Question of the day","nomobile":"0","name":"sesqa.question-off-the-day"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.find-questions',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"enableTabs":["today","week","month","dateCriteria","category"],"limit_data":"5","viewMore":"yes","thisweek":"F35369","thisweekTextColor":"FFFFFF","today":"4267B2","todayTextColor":"FFFFFF","thismonth":"39C355","thismonthTextColor":"FFFFFF","choosedate":"BEC2C9","choosedateTextColor":"FFFFFF","title":"","nomobile":"0","name":"sesqa.find-questions"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.featured-sponsored-hot',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"order":"","criteria":"5","info":"recently_created","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","category","vote","view","like"],"category_id":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"3","title":"Most Recent Questions","nomobile":"0","name":"sesqa.featured-sponsored-hot"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.recently-viewed-questions',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"criteria":"by_me","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","like"],"category_id":"","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"30","height":"180","width":"180","limit_data":"3","title":"Recently Viewed Questions","nomobile":"0","name":"sesqa.recently-viewed-questions"}',
    ));
}

//create page
$pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_create')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_create',
    'displayname' => 'SES - Q&A - Create Page',
    'title' => 'Create Q&A',
    'description' => 'This page is question create page.',
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
    'name' => 'sesqa.browse-menu',
    'page_id' => $pageId,
    'parent_content_id' => $topMiddleId,
    'order' => 1,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $pageId,
    'parent_content_id' => $mainMiddleId,
    'order' => 1,
    ));
}

//view page
    $pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_view')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_view',
    'displayname' => 'SES - Q&A - View Page',
    'title' => 'View Q&A',
    'description' => 'This page lists question view page.',
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

    // Insert main-right
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'left',
        'page_id' => $pageId,
        'parent_content_id' => $mainId,
        'order' => 1,
    ));
    $mainLeftId = $db->lastInsertId();

    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.question-status',
        'page_id' => $pageId,
        'parent_content_id' => $mainLeftId,
        'order' => $widgetOrder++,
        'params' => '{"fontSize":"15","colorOpen":"FFDFA1","textColorOpen":"000000","colorClose":"FFDFA1","textColorClose":"000000","title":"","nomobile":"0","name":"sesqa.question-status"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.about-user',
        'page_id' => $pageId,
        'parent_content_id' => $mainLeftId,
        'order' => $widgetOrder++,
        'params' => '{"show_criteria":["ownerPhoto","ownerTitle","askedQuestionCount","answerQuestionCount","totalUpquestionCount","totalDownquestionCount","totalFavoutiteQuestionCount","totalQuestionFollowCount"],"title":"About User","nomobile":"0","name":"sesqa.about-user"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.stats',
        'page_id' => $pageId,
        'parent_content_id' => $mainLeftId,
        'order' => $widgetOrder++,
        'params' => '{"show_criteria":["totalQuestions","totalAnswers","totalBestAnswers"],"title":"Statistics","nomobile":"0","name":"sesqa.stats"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.recently-viewed-questions',
        'page_id' => $pageId,
        'parent_content_id' => $mainLeftId,
        'order' => $widgetOrder++,
        'params' => '{"criteria":"by_me","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"2","title":"Recently Viewed Questions","nomobile":"0","name":"sesqa.recently-viewed-questions"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.question-tags',
        'page_id' => $pageId,
        'parent_content_id' => $mainLeftId,
        'order' => $widgetOrder++,
        'params' => '{"title":"Tags","name":"sesqa.question-tags"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.view-page',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"show_criteria":["title","openClose","voteBtn","favBtn","likeBtn","followBtn","location","share","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","dummy4":null,"answer_show_criteria":["vote","comment","owner","date","markBest"],"tinymce":"1","limit_data":"20","title":"","nomobile":"0","name":"sesqa.view-page"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.people-acted',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"search_type":["Like","Fav","Follow"],"dummy4":null,"Like_order":"1","Like_label":"People Who Liked This Question","Like_limitdata":"10","dummy5":null,"Follow_order":"2","Follow_label":"People who are Follow This Question","Follow_limitdata":"10","dummy6":null,"Fav_order":"3","Fav_label":"People Who Favourite This","Fav_limitdata":"10","title":"","nomobile":"0","name":"sesqa.people-acted"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.featured-sponsored-hot',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"order":"","criteria":"5","info":"recently_created","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"2","title":"Popular Questions","nomobile":"0","name":"sesqa.featured-sponsored-hot"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.other-questions',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"2","title":"Other Question from Owner","nomobile":"0","name":"sesqa.other-questions"}',
    ));
}

//manage page
    $pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_manage')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_manage',
    'displayname' => 'SES - Q&A - Manage Page',
    'title' => 'Browse Q&A',
    'description' => 'This page lists manage page.',
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

    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.alphabet-search',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.manage-tabbed-widget',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"viewType":"grid1","showTabType":"advance","show_criteria":["itemPhoto","title","favBtn","likeBtn","followBtn","userImage","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"height":"0","width":"0","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncate":"40","limit":"10","search_type":["my_questions","questionSPanswered","questionSPvoted","questionSPupvoted","questionSPdownvoted","questionSPliked","questionSPfavourite","questionSPfollow"],"dummy1":null,"my_questions_order":"1","my_questions_label":"My Questions","dummy2":null,"questionSPanswered_order":"2","questionSPanswered_label":"Answered Questions","dummy3":null,"questionSPvoted_order":"3","questionSPvoted_label":"Poll Voted Questions","dummy4":null,"questionSPupvoted_order":"4","questionSPupvoted_label":"Up Voted Questions","dummy5":null,"questionSPdownvoted_order":"5","questionSPdownvoted_label":"Down Voted Questions","dummy6":null,"questionSPliked_order":"6","questionSPliked_label":"Liked Questions","dummy7":null,"questionSPfavourite_order":"7","questionSPfavourite_label":"Favourite Questions","dummy8":null,"questionSPfollow_order":"8","questionSPfollow_label":"Question Followed","title":"","nomobile":"0","name":"sesqa.manage-tabbed-widget"}',
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.question-similar',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.featured-sponsored-hot',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"order":"","criteria":"5","info":"recently_created","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"2","title":"  ","nomobile":"0","name":"sesqa.featured-sponsored-hot"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.browse-search',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPvoted","mostSPfavourite","homostSPanswered","unanswered","featured","sponsored","verified","hot","new"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_startendtime":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"Search Questions","nomobile":"0","name":"sesqa.browse-search"}',
    ));
}

//Unanwered question page
    $pageId = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesqa_index_unanswered')
    ->limit(1)
    ->query()
    ->fetchColumn();


// insert if it doesn't exist yet
if( !$pageId ) {
    $widgetOrder = 1;
    // Insert page
    $db->insert('engine4_core_pages', array(
    'name' => 'sesqa_index_unanswered',
    'displayname' => 'SES - Q&A - Unanswered Question Page',
    'title' => 'Unanswered Q&A',
    'description' => 'This page lists unanswered questions.',
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

    // Insert menu
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => $widgetOrder++,
    ));

    // Insert content
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.alphabet-search',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.tabbed-widget',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"viewType":"grid1","showTabType":"advance","show_criteria":["title","favBtn","likeBtn","followBtn","userImage","share","location","date","tags","owner","category","vote","answerCount","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"height":"0","width":"0","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"auto_load","title_truncate":"200","limit":"10","show_limited_data":"no","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPvoted","mostSPfavourite","homostSPanswered","unanswered"],"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","mostSPliked_order":"3","mostSPliked_label":"Most Liked","mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","mostSPvoted_order":"5","mostSPvoted_label":"Most Voted","mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","homostSPanswered_order":"7","homostSPanswered_label":"Most Answered","unanswered_order":"7","unanswered_label":"Unanswered","title":"","nomobile":"0","name":"sesqa.tabbed-widget"}',
    ));

    // Insert search
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.question-similar',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"title":"","name":"sesqa.question-similar"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.featured-sponsored-hot',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"order":"","criteria":"5","info":"recently_created","show_criteria":["itemPhoto","title","favBtn","followBtn","likeBtn","share","location","date","tags","owner","category","vote","view","comment","favourite","follow","like","featuredLabel","sponsoredLabel","verifiedLabel","hotLabel","newLabel"],"category_id":null,"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","width":"180","limit_data":"2","title":"Popular Questions","nomobile":"0","name":"sesqa.featured-sponsored-hot"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesqa.browse-search',
        'page_id' => $pageId,
        'parent_content_id' => $mainRightId,
        'order' => $widgetOrder++,
        'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPvoted","mostSPfavourite","homostSPanswered","unanswered","featured","sponsored","verified","hot","new"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_startendtime":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","title":"Search Questions","nomobile":"0","name":"sesqa.browse-search"}',
    ));
}


// Get page id
$select = new Zend_Db_Select($db);
$page_id = $select
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'user_profile_index')
        ->limit(1)
        ->query()
        ->fetchColumn(0);

// sesqa.profile-widget
// Check if it's already been placed
$select = new Zend_Db_Select($db);
$hasProfileEvents = $select
        ->from('engine4_core_content', new Zend_Db_Expr('TRUE'))
        ->where('page_id = ?', $page_id)
        ->where('type = ?', 'widget')
        ->where('name = ?', 'sesqa.profile-widget')
        ->query()
        ->fetchColumn();

// Add it
if (!$hasProfileEvents) {

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
            'name' => 'sesqa.profile-widget',
            'parent_content_id' => $tab_id,
            'order' => 5,
            'params' => '{"title":"Questions","titleCount":true}',
        ));
    }
}

//Default Privacy Set Work
$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Sesqa_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('sesqa_question', $level->level_id, array_keys($form->getValues()));
  $form->populate($valuesForm);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    if ($level->type != 'public') {
      // Set permissions
      $values['auth_comment'] = (array) $values['auth_comment'];
      $values['auth_view'] = (array) $values['auth_view'];
    }
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('sesqa_question', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

$categories = Engine_Api::_()->getDbTable('categories','sesqa')->fetchAll(Engine_Api::_()->getDbTable('categories','sesqa')->select());
foreach($categories as $category){
  $banner = APPLICATION_PATH . '/application/modules/Sesqa/externals/images/Category/Banners';
  $icon = APPLICATION_PATH . '/application/modules/Sesqa/externals/images/Category/Icons';
  $title = str_replace(' ','_',strtolower($category->title));
  if (file_exists($banner.'/'.$title.'.jpg')){
    $category->thumbnail = $this->setCategoryPhoto($banner.'/'.$title.'.jpg',$category->getIdentity(),false);
  }
  if (file_exists($icon.'/'.$title.'_24x24.png')){
    $category->colored_icon = $this->setCategoryPhoto($icon.'/'.$title.'_24x24.png',$category->getIdentity(),false);
  }
  if (file_exists($icon.'/'.$title.'_256x256.png')){
    $category->cat_icon = $this->setCategoryPhoto($icon.'/'.$title.'_256x256.png',$category->getIdentity(),false);
  }
  $category->save();
}
