<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
//$this->uploadDefaultCategory();
$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("eblog_admin_main_importblog", "eblog", "Import SE Blog", "", \'{"route":"admin_default","module":"eblog","controller":"import-blog"}\', "eblog_admin_main", "", 996);');

//Blogs Welcome Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'eblog_index_welcome')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_welcome',
    'displayname' => 'SES - Advanced Blog - Blogs Welcome Page',
    'title' => 'Blog Welcome Page',
    'description' => 'This page is the blog welcome page.',
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

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesbasic.simple-html-block',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"bodysimple":"<div class=\"eblog_welcome_text_block_wrapper sesbasic_bxs sesbasic_clearfix\">\r\n\t<div class=\"eblog_welcome_text_block\">\r\n  \t<h2 class=\"eblog_welcome_text_block_maintxt\">SHARE YOUR  IDEAS & STORIES  WITH THE WORLD<\/h2>\r\n    <div class=\"eblog_welcome_text_block_buttons sesbasic_clearfix\">\r\n    \t<a href=\"javascript:void(0);\" onclick=\"changeEblogManifestUrl(\'home\');\"class=\"eblog_landing_link sesbasic_link_btn sesbasic_animation\">Explore Popular Blogs<\/a>\r\n      <a href=\"javascript:void(0);\" onclick=\"changeEblogManifestUrl(\'create\');\" class=\"eblog_landing_link sesbasic_link_btn sesbasic_animation\">Create Your Unique Blog<\/a>\r\n      <a href=\"javascript:void(0);\" onclick=\"changeEblogManifestUrl(\'categories\');\" class=\"eblog_landing_link sesbasic_link_btn\">Explore By Category<\/a>\r\n    <\/div>\r\n<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 6px;width: 1200px; margin-left: 50px;\">\r\n<\/div>\r\n<div style=\"font-size: 24px;margin-bottom: 30px;  margin-top: 25px;text-align: center;\">Read our Sponsored Blogs!<\/div>\r\n  <\/div>\r\n<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.featured-sponsored-verified-category-carousel',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"carousel_type":"1","slidesToShow":"4","category":"0","criteria":"2","order":"","info":"most_liked","isfullwidth":"1","autoplay":"1","speed":"2000","show_criteria":["title","favouriteButton","likeButton","category","socialSharing"],"title_truncation":"35","height":"350","width":"400","limit_data":"10","title":"","nomobile":"0","name":"eblog.featured-sponsored-verified-category-carousel"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesbasic.simple-html-block',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;margin-top:50px;text-align: center;\">Featured Posts -  Heads up bloggers!<\/div>","en_US_bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;margin-top:50px;text-align: center;\">Featured Posts -  Heads up bloggers!<\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.featured-sponsored-verified-random-blog',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"category":"0","criteria":"1","order":"","show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","verifiedLabel","favouriteButton","likeButton","category","socialSharing","creationDate"],"title":"","nomobile":"0","name":"eblog.featured-sponsored-verified-random-blog"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesbasic.simple-html-block',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"eblog_landing_link eblog_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeEblogManifestUrl(\'browse\');\">Read all Posts\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Verified Blogs on our Community\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.tabbed-widget-blog',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["grid"],"openViewType":"grid","show_criteria":["favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptiongrid"],"pagging":"button","title_truncation_grid":"45","title_truncation_list":"45","title_truncation_pinboard":"45","limit_data_pinboard":"10","limit_data_list":"10","limit_data_grid":"10","description_truncation_list":"35","description_truncation_grid":"45","description_truncation_pinboard":"45","height_grid":"280","width_grid":"393","height_list":"230","width_list":"260","width_pinboard":"300","search_type":["verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"eblog.tabbed-widget-blog"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesbasic.simple-html-block',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"eblog_landing_link eblog_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeEblogManifestUrl(\'locations\');\">Explore All Blogs\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">What do you want to read out?\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.blog-category',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"height":"180","width":"196","limit":"12","video_required":"1","criteria":"admin_order","show_criteria":["title","countBlogs"],"title":"","nomobile":"0","name":"eblog.blog-category"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesbasic.simple-html-block',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"bodysimple":"<div style=\"text-align: center;margin-top:30px; box-shadow:inset 0 1px 0 rgba(255,255,255,.1),0 1px 0 rgba(8,32,84,.1);padding-bottom: 30px;\">\r\n\t<a class=\"eblog_landing_link eblog_welcome_btn sesbasic_animation\" href=\"javascript:void(0);\" onclick=\"changeEblogManifestUrl(\'categories\');\">Browse All Categories\r\n<\/a><\/div>\r\n<div style=\"font-size: 34px;margin-bottom: 30px;  margin-top: 30px;text-align: center;\">Meet our Top Bloggers!\r\n<\/span><\/div>","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.top-bloggers',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","show_criteria":["count","ownername"],"height":"180","width":"234","showLimitData":"0","limit_data":"5","title":"","nomobile":"0","name":"eblog.top-bloggers"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesspectromedia.banner',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"is_full":"1","is_pattern":"1","banner_image":"public\/admin\/banner_final.jpg","banner_title":"Start by creating your Unique Blog","title_button_color":"FFFFFF","description":"Publish your personal or professional blogs at your desired date and time!","description_button_color":"FFFFFF","button1":"1","button1_text":"Get Started","button1_text_color":"0295FF","button1_color":"FFFFFF","button1_mouseover_color":"EEEEEE","button1_link":"blogs\/create","button2":"0","button2_text":"Button - 2","button2_text_color":"FFFFFF","button2_color":"0295FF","button2_mouseover_color":"067FDE","button2_link":"","button3":"0","button3_text":"Button - 3","button3_text_color":"FFFFFF","button3_color":"F25B3B","button3_mouseover_color":"EA350F","button3_link":"","height":"400","title":"","nomobile":"0","name":"sesspectromedia.banner"}',
  ));
}


//Blog Home Page
$select = $db->select()
            ->from('engine4_core_pages')
            ->where('name = ?', 'eblog_index_home')
            ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_home',
    'displayname' => 'SES - Advanced Blog - Blogs Home Page',
    'title' => 'Blog Home',
    'description' => 'This is the blog home page.',
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
    'name' => 'eblog.browse-menu',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.featured-sponsored-verified-category-slideshow',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"category":"0","criteria":"2","order":"","info":"most_liked","isfullwidth":"0","autoplay":"1","speed":"2000","type":"slide","navigation":"nextprev","show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing","creationDate"],"title_truncation":"45","height":"400","limit_data":"12","title":"Sponsored Blog Posts","nomobile":"0","name":"eblog.featured-sponsored-verified-category-slideshow"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.tabbed-widget-blog',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","view","title","category","by","readmore","creationDate","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"show_limited_data":"no","pagging":"pagging","title_truncation_grid":"40","title_truncation_list":"50","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","title_truncation_pinboard":"30","limit_data_pinboard":"12","limit_data_list":"6","limit_data_grid":"15","limit_data_simplelist":"10","limit_data_advlist":"10","limit_data_advgrid":"10","limit_data_supergrid":"9","description_truncation_list":"190","description_truncation_grid":"160","description_truncation_simplelist":"300","description_truncation_advlist":"300","description_truncation_advgrid":"160","description_truncation_supergrid":"160","description_truncation_pinboard":"160","height_grid":"200","width_grid":"307","height_list":"230","width_list":"350","height_simplelist":"230","width_simplelist":"260","height_advgrid":"400","width_advgrid":"460","height_supergrid":"220","width_supergrid":"307","width_pinboard":"300","search_type":["mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","week","month","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"eblog.tabbed-widget-blog"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.of-the-day',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","fixHover":"fix","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","socialSharing"],"title_truncation":"20","description_truncation":"60","height":"180","width":"180","title":"Blog of the Day","nomobile":"0","name":"eblog.of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"recently_created","show_criteria":["title","category"],"show_star":"0","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"70","width":"70","limit_data":"4","title":"Recent Blogs","nomobile":"0","name":"eblog.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_viewed","show_criteria":["view","title"],"show_star":"1","showLimitData":"1","title_truncation":"15","description_truncation":"60","height":"60","width":"70","limit_data":"3","title":"Most Read Blogs","nomobile":"0","name":"eblog.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.tag-cloud-category',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","showType":"simple","text_height":"15","height":"300","itemCountPerPage":"12","title":"Categories","nomobile":"0","name":"eblog.tag-cloud-category"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.top-bloggers',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","show_criteria":["count"],"height":"100","width":"210","showLimitData":"1","limit_data":"3","title":"Top Bloggers","nomobile":"0","name":"eblog.top-bloggers"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'eblog.tag-cloud-blogs',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"eblog.tag-cloud-blogs"}',
  ));

}

//Blog Browse Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_browse',
    'displayname' => 'SES - Advanced Blog - Browse Blogs Page',
    'title' => 'Blog Browse',
    'description' => 'This page lists blog entries.',
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
    'name' => 'eblog.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.category-carousel',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"300","width":"388","autoplay":"1","speed":"2000","criteria":"alphabetical","show_criteria":["title","description","countBlogs","socialshare"],"isfullwidth":"0","limit_data":"12","title":"Categories","nomobile":"0","name":"eblog.category-carousel"}',
  ));

  // Insert search
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.alphabet-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert gutter menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.browse-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"300","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"270","width_grid":"307","height_simplelist":"230","width_simplelist":"260","height_advgrid":"230","width_advgrid":"461","height_supergrid":"250","width_supergrid":"461","width_pinboard":"280","limit_data_pinboard":"12","limit_data_grid":"12","limit_data_list":"12","limit_data_simplelist":"12","limit_data_advlist":"12","limit_data_advgrid":"12","limit_data_supergrid":"12","pagging":"button","title":"","nomobile":"0","name":"eblog.browse-blogs"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"1","title_truncation":"45","description_truncation":"60","height":"180","width":"180","limit_data":"1","title":"Verified Blog","nomobile":"0","name":"eblog.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.browse-menu-quick',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"eblog.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"most_commented","show_criteria":["like","comment","favourite","view","title"],"show_star":"0","showLimitData":"0","title_truncation":"20","description_truncation":"60","height":"60","width":"60","limit_data":"5","title":"Most Commented Blogs","nomobile":"0","name":"eblog.featured-sponsored"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.tag-cloud-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#4a4444","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"eblog.tag-cloud-blogs"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.popular-featured-verified-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"info":"most_viewed","imageType":"rounded","showLimitData":"1","show_criteria":["title","like","view","comment","description","by"],"title_truncation":"45","review_description_truncation":"45","limit_data":"3","title":"Most Viewed Reviews","nomobile":"0","name":"eblog.popular-featured-verified-reviews"}',
  ));
}

//Browse Categories Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'eblog_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'eblog_category_browse',
      'displayname' => 'SES - Advanced Blog - Browse Categories Page',
      'title' => 'Blog Browse Category',
      'description' => 'This page lists blog categories.',
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
    'order' => 3,
  ));
  $main_right_id = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
  $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Eblog' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "category" . DIRECTORY_SEPARATOR;
  if (is_file($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg')) {
    if (!file_exists(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin')) {
      mkdir(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin', 0777, true);
    }
    copy($PathFile . "banner" . DIRECTORY_SEPARATOR . 'category.jpg', APPLICATION_PATH . DIRECTORY_SEPARATOR . 'public/admin/blog-category-banner.jpg');
    $category_banner = 'public/admin/blog-category-banner.jpg';
  } else {
    $category_banner = '';
  }
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.banner-category',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"description":"Discover top-notch blogs, creators, and collections related to your interests, hand-selected by our 100-percent-human curation team.","eblog_categorycover_photo":"' . $category_banner . '","title":"Categories","nomobile":"0","name":"eblog.banner-category"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.blog-category-icons',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"Popular Categories","height":"150","width":"180","alignContent":"center","criteria":"admin_order","show_criteria":["title","countBlogs"],"limit_data":"12","title":"","nomobile":"0","name":"eblog.blog-category-icons"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.category-associate-blog',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["like","comment","rating","ratingStar","view","title","favourite","by","featuredLabel","sponsoredLabel","creationDate","readmore"],"popularity_blog":"like_count","pagging":"button","count_blog":"1","criteria":"alphabetical","category_limit":"5","blog_limit":"5","blog_description_truncation":"45","seemore_text":"+ See all [category_name]","allignment_seeall":"left","height":"160","width":"250","title":"","nomobile":"0","name":"eblog.category-associate-blog"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid1","fixHover":"hover","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","socialSharing"],"title_truncation":"45","description_truncation":"60","height":"180","width":"180","title":"Blog of the Day","nomobile":"0","name":"eblog.of-the-day"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.sidebar-tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":"list","show_criteria":["location","like","favourite","comment","view","title","category","by","creationDate"],"show_limited_data":"no","pagging":"button","title_truncation_grid":"45","title_truncation_list":"20","limit_data_list":"3","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["week","month"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"Blogs Created","nomobile":"0","name":"eblog.sidebar-tabbed-widget"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.tag-cloud-blogs',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"color":"#00f","type":"tab","text_height":"15","height":"300","itemCountPerPage":"21","title":"Trending Tags","nomobile":"0","name":"eblog.tag-cloud-blogs"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"50","width":"50","limit_data":"3","title":"Recent Posts","nomobile":"0","name":"eblog.featured-sponsored"}'
  ));


  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"most_favourite","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"0","title_truncation":"20","description_truncation":"60","height":"60","width":"60","limit_data":"3","title":"Most Favourite Blogs","nomobile":"0","name":"eblog.featured-sponsored"}'
  ));
}

//Browse Locations Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'eblog_index_locations')
    ->limit(1)
    ->query()
    ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'eblog_index_locations',
      'displayname' => 'SES - Advanced Blog - Browse Locations Page',
      'title' => 'Blog Browse Location',
      'description' => 'This page show blog locations.',
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
      'name' => 'eblog.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"eblog.browse-search"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.blog-location',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"location":"World","lat":"56.6465227","lng":"-6.709638499999983","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","location","likeButton","0","1","ratingStar","rating","socialSharing","like","view","comment","favourite"],"location-data":null,"title":"","nomobile":"0","name":"eblog.blog-location"}',
  ));
}

//Browse Reviews Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_review_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_review_browse',
    'displayname' => 'SES - Advanced Blog - Browse Reviews Page',
    'title' => 'Blog Browse Reviews',
    'description' => 'This page show blog browse reviews page.',
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

  // Insert main-left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $main_left_id = $db->lastInsertId();

  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.review-of-the-day',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"gridOutside","show_criteria":["title","like","view","rating","featuredLabel","verifiedLabel","socialSharing"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","title":"Review of the Day","nomobile":"0","name":"sesmember.review-of-the-day"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.browse-review-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","review_title":"1","view":["likeSPcount","viewSPcount","commentSPcount","mostSPrated","leastSPrated","verified","featured"],"review_stars":"1","network":"1","title":"Review Browse Search","nomobile":"0","name":"eblog.browse-review-search"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.browse-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"show_criteria":"","pagging":"button","limit_data":"9","title":"","nomobile":"0","name":"eblog.browse-reviews"}',
  ));
}

//Manage Blogs Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_manage',
    'displayname' => 'SES - Advanced Blog - Manage Blogs Page',
    'title' => 'My Blog Entries',
    'description' => 'This page lists a user\'s blog entries.',
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
    'name' => 'eblog.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.manage-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}


//New Claims Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_claim')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_claim',
    'displayname' => 'SES - Advanced Blog - New Claims Page',
    'title' => 'Blog Claim',
    'description' => 'This page lists blog entries.',
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
    'name' => 'eblog.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.claim-blog',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Blog Create Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();

if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_create',
    'displayname' => 'SES - Advanced Blog - Blog Create Page',
    'title' => 'Write New Blog',
    'description' => 'This page is the blog create page.',
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
    'name' => 'eblog.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}


//Browse Tags Page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'eblog_index_tags')
            ->limit(1)
            ->query()
            ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_tags',
    'displayname' => 'SES - Advanced Blog - Browse Tags Page',
    'title' => 'Blog Browse Tags Page',
    'description' => 'This page displays the blog tags.',
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
  // Insert main-right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 7,
  ));
  $main_right_id = $db->lastInsertId();
  // Insert menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.tag-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Album View Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'eblog_album_view')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_album_view',
    'displayname' => 'SES - Advanced Blog - Album View Page',
    'title' => 'Blog Album View',
    'description' => 'This page displays an blog album.',
    'provides' => 'subject=album',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
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
    'order' => 6,
  ));
  $main_middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.album-breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.album-view-page',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"masonry","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","likeButton","favouriteButton"],"limit_data":"20","pagging":"auto_load","title_truncation":"45","height":"160","width":"140","title":"","nomobile":"0","name":"eblog.album-view-page"}'
  ));
}

//Photo View Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'eblog_photo_view')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_photo_view',
    'displayname' => 'SES - Advanced Blog - Photo View Page',
    'title' => 'Blog Album Photo View',
    'description' => 'This page displays an blog album\'s photo.',
    'provides' => 'subject=eblog_photo',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2
  ));
  $main_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 6,
  ));
  $middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.photo-view-page',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => 1,
    'params' => '{"title":"","nomobile":"0","name":"eblog.photo-view-page"}'
  ));
}


//Browse Claim Requests Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'eblog_index_claim-requests')
              ->limit(1)
              ->query()
              ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_claim-requests',
    'displayname' => 'SES - Advanced Blog - Browse Claim Requests Page',
    'title' => 'Blog Claim Requests',
    'description' => 'This page lists blog claims request entries.',
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
    'name' => 'eblog.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.claim-requests',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Blog List Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_list')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_list',
    'displayname' => 'SES - Advanced Blog - Blog List Page',
    'title' => 'Blog List',
    'description' => 'This page lists a member\'s blog entries.',
    'provides' => 'subject=user',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
  ));
  $main_id = $db->lastInsertId();

  // Insert left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $left_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $middle_id = $db->lastInsertId();

  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-menu',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.content',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
}

//Blog Profile Page Design 1
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_view_1')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_view_1',
    'displayname' => 'SES - Advanced Blog - Blog Profile Page Design 1',
    'title' => 'Blog View',
    'description' => 'This page displays a blog entry.',
    'provides' => 'subject=eblog',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
  ));
  $main_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 3,
  ));
  $middle_id = $db->lastInsertId();

  // Insert right
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $right_id = $db->lastInsertId();

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.view-blog',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"max":6}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Photos","titleCount":false,"load_content":"auto_load","sort":null,"insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","socialSharing","photoCount","likeButton","favouriteButton"],"title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"eblog.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"eblog.profile-videos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-musicalbums',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"informationAlbum":["featured","sponsored","hot","postedBy","commentCount","viewCount","likeCount","ratingStars","songCount","favourite","share"],"pagging":"auto_load","Height":"180","Width":"180","limit_data":"3","title":"Music Albums","nomobile":"0","name":"eblog.profile-musicalbums"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.blog-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"button","limit_data":"5","title":"Reviews","nomobile":"0","name":"eblog.blog-reviews"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"core.comments"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.related-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"1","height":"180","width":"180","list_title_truncation":"45","limit_data":"3","title":" Sub Blogs","nomobile":"0","name":"eblog.related-blogs"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.css-blog',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"core.comments"}',
  ));

  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.labels',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"eblog.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.similar-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","by","favouriteButton","likeButton","socialSharing"],"showLimitData":"0","height":"200","width":"294","list_title_truncation":"45","limit_data":"3","title":"Related Blogs","nomobile":"0","name":"eblog.similar-blogs"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.sidebar-tabbed-widget',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":"list","show_criteria":["title","category","by"],"show_limited_data":"yes","pagging":"auto_load","title_truncation_grid":"45","title_truncation_list":"45","limit_data_list":"5","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["recentlySPcreated","mostSPviewed"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recent Blogs","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Popular BLogs","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"eblog.sidebar-tabbed-widget"}',
  ));

}



//Blog Profile Page Design 2
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_view_2')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_view_2',
    'displayname' => 'SES - Advanced Blog - Blog Profile Page Design 2',
    'title' => 'Blog View',
    'description' => 'This page displays a blog entry.',
    'provides' => 'subject=eblog',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
  ));
  $main_id = $db->lastInsertId();

  // Insert left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $left_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $middle_id = $db->lastInsertId();

  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-menu',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"eblog.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-tags',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"eblog.profile-tags"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.view-blog',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.blog-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"auto_load","limit_data":"5","title":"Blog Profile - Reviews","nomobile":"0","name":"eblog.blog-reviews"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.similar-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"1","height":"207","width":"307","list_title_truncation":"45","limit_data":"3","title":"Blogs","nomobile":"0","name":"eblog.similar-blogs"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-musicalbums',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"informationAlbum":["featured","sponsored","hot","postedBy","commentCount","viewCount","likeCount","ratingStars","songCount","favourite","share"],"pagging":"auto_load","Height":"180","Width":"180","limit_data":"3","title":"Music Albums","nomobile":"0","name":"eblog.profile-musicalbums"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"eblog.profile-videos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":null,"insideOutside":"outside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","photoCount","likeButton","favouriteButton"],"title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"eblog.profile-photos"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
}


//Blog Profile Page Design 3
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_view_3')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_view_3',
    'displayname' => 'SES - Advanced Blog - Blog Profile Page Design 3',
    'title' => 'Blog View',
    'description' => 'This page displays a blog entry.',
    'provides' => 'subject=eblog',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
  ));
  $main_id = $db->lastInsertId();

  // Insert left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $left_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $middle_id = $db->lastInsertId();

  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-menu',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"eblog.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-tags',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"eblog.profile-tags"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.view-blog',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-musicalbums',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"informationAlbum":["featured","sponsored","hot","postedBy","commentCount","viewCount","likeCount","ratingStars","songCount","favourite","share"],"pagging":"auto_load","Height":"180","Width":"180","limit_data":"3","title":"Music Albums","nomobile":"0","name":"eblog.profile-musicalbums"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","photoCount","likeButton","favouriteButton"],"title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"eblog.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.blog-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"auto_load","limit_data":"5","title":"Reviews","nomobile":"0","name":"eblog.blog-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.related-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"eblog.profile-videos"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.similar-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"0","height":"200","width":"307","list_title_truncation":"45","limit_data":"3","title":"Similar Blogs","nomobile":"0","name":"eblog.similar-blogs"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
}


//Blog Profile Page Design 4
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'eblog_index_view_4')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'eblog_index_view_4',
    'displayname' => 'SES - Advanced Blog - Blog Profile Page Design 4',
    'title' => 'Blog View',
    'description' => 'This page displays a blog entry.',
    'provides' => 'subject=eblog',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
  ));
  $main_id = $db->lastInsertId();

  // Insert left
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'left',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 1,
  ));
  $left_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $middle_id = $db->lastInsertId();

  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"eblog.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.gutter-menu',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-tags',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"eblog.profile-tags"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.view-blog',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.similar-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"0","height":"200","width":"307","list_title_truncation":"45","limit_data":"3","title":"Similar Blogs","nomobile":"0","name":"eblog.similar-blogs"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.container-tabs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"max":6}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","photoCount","likeButton","favouriteButton"],"title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"eblog.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.blog-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"auto_load","limit_data":"5","title":"Blog Profile - Reviews","nomobile":"0","name":"eblog.blog-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.review-profile',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"eblog.profile-videos"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.related-blogs',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"0","height":"200","width":"307","list_title_truncation":"45","limit_data":"3","title":"Similar Blogs","nomobile":"0","name":"eblog.similar-blogs"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.profile-musicalbums',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"informationAlbum":["featured","sponsored","hot","postedBy","commentCount","viewCount","likeCount","ratingStars","songCount","favourite","share"],"pagging":"auto_load","Height":"180","Width":"180","limit_data":"3","title":"Music","nomobile":"0","name":"eblog.profile-musicalbums"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"core.comments"}',
  ));
}

//Review Profile Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'eblog_review_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'eblog_review_view',
      'displayname' => 'SES - Advanced Blog - Review Profile Page',
      'title' => 'Blog Review View',
      'description' => 'This page displays a blog review entry.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
  ));
  $main_id = $db->lastInsertId();

  // Insert left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $left_id = $db->lastInsertId();

  // Insert middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.review-owner-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","showTitle":"1","nomobile":"0","name":"eblog.review-owner-photo"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.review-profile-options',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"vertical","title":"","nomobile":"0","name":"eblog.review-profile-options"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.review-breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'eblog.review-profile',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
}

//Category View Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'eblog_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'eblog_category_index',
      'displayname' => 'SES - Advanced Blog - Blog Category View Page',
      'title' => 'Blog Category View Page',
      'description' => 'This page lists blog category view page.',
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
      'name' => 'eblog.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'eblog.category-view',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","show_subcat":"1","show_subcatcriteria":["icon","title","countBlog"],"heightSubcat":"160","widthSubcat":"290","textBlog":"Blogs we like","show_criteria":["featuredLabel","sponsoredLabel","like","comment","rating","ratingStar","favourite","view","title","by","description","readmore","creationDate"],"pagging":"button","description_truncation":"150","blog_limit":"12","height":"200","width":"294","title":"","nomobile":"0","name":"eblog.category-view"}'
  ));
}

$blog_table_exist = $db->query('SHOW TABLES LIKE \'engine4_eblog_blogs\'')->fetch();
if (!empty($blog_table_exist)) {
  $seblog_id = $db->query('SHOW COLUMNS FROM engine4_eblog_blogs LIKE \'seblog_id\'')->fetch();
  if (empty($seblog_id)) {
    $db->query('ALTER TABLE `engine4_eblog_blogs` ADD `seblog_id` INT(11) NOT NULL DEFAULT "0";');
  }
}

$blogcat_table_exist = $db->query('SHOW TABLES LIKE \'engine4_eblog_categories\'')->fetch();
if (!empty($blogcat_table_exist)) {
  $seblog_cayegoryid = $db->query('SHOW COLUMNS FROM engine4_eblog_categories LIKE \'seblog_categoryid\'')->fetch();
  if (empty($seblog_cayegoryid)) {
    $db->query('ALTER TABLE `engine4_eblog_categories` ADD `seblog_categoryid` INT(11) NULL;');
  }
}

$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'eblog_link_blog';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'eblog_link_event';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'eblog_reject_blog_request';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'eblog_reject_event_request';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesuser_claimadmin_blog';");


//Action Type Change for Apps
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'eblog_blog_like' WHERE `engine4_activity_actiontypes`.`type` = 'eblog_like_blog';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'eblog_album_like' WHERE `engine4_activity_actiontypes`.`type` = 'eblog_like_blogalbum';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'eblog_photo_like' WHERE `engine4_activity_actiontypes`.`type` = 'eblog_like_blogphoto';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'eblog_blog_favourite' WHERE `engine4_activity_actiontypes`.`type` = 'eblog_favourite_blog';");


$table_exist = $db->query("SHOW TABLES LIKE 'engine4_eblog_categories'")->fetch();
if (!empty($table_exist)) {
    $member_levels = $db->query("SHOW COLUMNS FROM engine4_eblog_categories LIKE 'member_levels'")->fetch();
    if (empty($member_levels)) {
        $db->query('ALTER TABLE `engine4_eblog_categories` ADD `member_levels` VARCHAR(255) NULL DEFAULT NULL;');
    }
}
$db->query('UPDATE `engine4_eblog_categories` SET `member_levels` = "1,2,3,4" WHERE `engine4_eblog_categories`.`subcat_id` = 0 and  `engine4_eblog_categories`.`subsubcat_id` = 0;');


$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("eblog_admin_main_integrateothermodule", "eblog", "Integrate Plugins", "", \'{"route":"admin_default","module":"eblog","controller":"integrateothermodule","action":"index"}\', "eblog_admin_main", "", 995);');

$db->query('DROP TABLE IF EXISTS `engine4_eblog_integrateothermodules`;');
$db->query('CREATE TABLE IF NOT EXISTS `engine4_eblog_integrateothermodules` (
  `integrateothermodule_id` int(11) unsigned NOT NULL auto_increment,
  `module_name` varchar(64) NOT NULL,
  `content_type` varchar(64) NOT NULL,
  `content_url` varchar(255) NOT NULL,
  `content_id` varchar(64) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`integrateothermodule_id`),
  UNIQUE KEY `content_type` (`content_type`,`content_id`),
  KEY `module_name` (`module_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;');

$table_exist = $db->query("SHOW TABLES LIKE 'engine4_eblog_blogs'")->fetch();
if (!empty($table_exist)) {
    $resource_type = $db->query("SHOW COLUMNS FROM engine4_eblog_blogs LIKE 'resource_type'")->fetch();
    if (empty($resource_type)) {
        $db->query('ALTER TABLE `engine4_eblog_blogs` ADD `resource_type` VARCHAR(128) NULL;');
    }
    $resource_id = $db->query("SHOW COLUMNS FROM engine4_eblog_blogs LIKE 'resource_id'")->fetch();
    if (empty($resource_id)) {
        $db->query('ALTER TABLE `engine4_eblog_blogs` ADD `resource_id` INT(11) NOT NULL DEFAULT "0";');
    }
    $networks = $db->query("SHOW COLUMNS FROM engine4_eblog_blogs LIKE 'networks'")->fetch();
    if (empty($networks)) {
        $db->query('ALTER TABLE `engine4_eblog_blogs` ADD `networks` VARCHAR(255) NULL');
    }
    $levels = $db->query("SHOW COLUMNS FROM engine4_eblog_blogs LIKE 'levels'")->fetch();
    if (empty($levels)) {
        $db->query('ALTER TABLE `engine4_eblog_blogs` ADD `levels` VARCHAR(255) NULL');
    }
    $cotinuereading = $db->query("SHOW COLUMNS FROM engine4_eblog_blogs LIKE 'cotinuereading'")->fetch();
    if (empty($cotinuereading)) {
        $db->query('ALTER TABLE `engine4_eblog_blogs` ADD `cotinuereading` TINYINT(1) NOT NULL DEFAULT \'0\';');
    }

    $continue_height = $db->query("SHOW COLUMNS FROM engine4_eblog_blogs LIKE 'continue_height'")->fetch();
    if(empty($continue_height)) {
        $db->query('ALTER TABLE `engine4_eblog_blogs` ADD `continue_height` INT(11) NOT NULL DEFAULT "0";');
    }
}

$db->query('DELETE FROM `engine4_core_settings` WHERE `engine4_core_settings`.`name` = "eblog.chooselayout";');

$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("eblog_blogadmin", "eblog", \'You are now a admin in this blog {item:$object}.\', 0, ""),
("eblog_acceptadminre", "eblog", \'{item:$subject} accepted as admin request for blog {item:$object}.\', 0, ""),
("eblog_rejestadminre", "eblog", \'{item:$subject} rejected as admin request for blog {item:$object}.\', 0, ""),
("eblog_removeadminre", "eblog", \'{item:$subject} removed as admin request for blog {item:$object}.\', 0, "");');
$db->query('ALTER TABLE `engine4_eblog_roles` ADD `resource_approved` TINYINT(1) NOT NULL DEFAULT "1";');
$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
("eblog_profile_member", "eblog", "Member", "Eblog_Plugin_Menus", "", "eblog_gutter", "", 3);');


$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Eblog_Form_Admin_Level_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => (in_array($level->type, array('admin', 'moderator'))),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('eblog_blog', $level->level_id, array_keys($form->getValues()));

  $form->populate($valuesForm);
  if ($form->defattribut)
    $form->defattribut->setValue(0);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    if ($level->type != 'public') {
      // Set permissions
      $values['auth_comment'] = (array) $values['auth_comment'];
      $values['auth_view'] = (array) $values['auth_view'];
    }
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('eblog_blog', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}

$permissionsTable = Engine_Api::_()->getDbTable('permissions', 'authorization');
foreach (Engine_Api::_()->getDbTable('levels', 'authorization')->fetchAll() as $level) {
  $form = new Eblog_Form_Admin_Review_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => (in_array($level->type, array('admin', 'moderator'))),
  ));
  $values = $form->getValues();
  $valuesForm = $permissionsTable->getAllowed('eblog_review', $level->level_id, array_keys($form->getValues()));

  $form->populate($valuesForm);
  if ($form->defattribut)
    $form->defattribut->setValue(0);
  $db = $permissionsTable->getAdapter();
  $db->beginTransaction();
  try {
    if ($level->type != 'public') {
      // Set permissions
      $values['auth_comment'] = (array) $values['auth_comment'];
      $values['auth_view'] = (array) $values['auth_view'];
    }
    $nonBooleanSettings = $form->nonBooleanFields();
    $permissionsTable->setAllowed('eblog_review', $level->level_id, $values, '', $nonBooleanSettings);
    // Commit
    $db->commit();
  } catch (Exception $e) {
    $db->rollBack();
    throw $e;
  }
}
