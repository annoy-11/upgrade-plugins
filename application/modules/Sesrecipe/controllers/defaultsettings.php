<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

// $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesrecipe_admin_main_importrecipe", "sesrecipe", "Import SE Recipe", "", \'{"route":"admin_default","module":"sesrecipe","controller":"import-recipe"}\', "sesrecipe_admin_main", "", 996);');

//Recipes Welcome Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesrecipe_index_welcome')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_welcome',
    'displayname' => 'SES - Recipes With Reviews & Location - Recipes Welcome Page',
    'title' => 'Recipe Welcome Page',
    'description' => 'This page is the recipe welcome page.',
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
    'name' => 'sesrecipe.search',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"backgroundimage":"public\/admin\/recipes.jpg","showfullwidth":"full","height":"400","bannertext":"Follow tastes to discover more recipes!","description":"","title":"","nomobile":"0","name":"sesrecipe.search"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.browse-menu',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.featured-sponsored-verified-category-slideshow',
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"category":"0","criteria":"0","order":"","info":"recently_created","isfullwidth":"1","autoplay":"1","speed":"4000","type":"fade","navigation":"nextprev","show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing","creationDate"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"400","limit_data":"20","title":"","nomobile":"0","name":"sesrecipe.featured-sponsored-verified-category-slideshow"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesbasic.simple-html-block',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"bodysimple":"<div style=\"font-size: 34px;margin-bottom: 50px;  margin-top: 50px;text-align: center;\">Quick Jump to your Favorite Category\r\n<\/span><\/div>","en_US_bodysimple":"","show_content":"1","title":"","nomobile":"0","name":"sesbasic.simple-html-block"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.recipe-category-icons',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"titleC":"","height":"160px","width":"160px","alignContent":"center","criteria":"alphabetical","show_criteria":["title","countRecipes"],"limit_data":"20","title":"","nomobile":"0","name":"sesrecipe.recipe-category-icons"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.category-associate-recipe',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","rating","ratingStar","view","title","favourite","by"],"popularity_recipe":"creation_date","pagging":"auto_load","count_recipe":"1","criteria":"alphabetical","category_limit":"5","recipe_limit":"8","recipe_description_truncation":"45","seemore_text":"+ See all [category_name]","allignment_seeall":"left","height":"160","width":"250","title":"","nomobile":"0","name":"sesrecipe.category-associate-recipe"}',
  ));
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.populartabbed-recipe',
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"search_type":["mostSPviewed","mostSPliked","mostSPcommented","mostSPrated"],"dummy1":null,"recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_label":"Featured","dummy8":null,"sponsored_label":"Sponsored","dummy9":null,"verified_label":"Verified","title_truncation":"16","height":"180","width":"180","countrecipe":"6","title":"","nomobile":"0","name":"sesrecipe.populartabbed-recipe"}',
  ));
}


//Recipe Home Page
$select = $db->select()
            ->from('engine4_core_pages')
            ->where('name = ?', 'sesrecipe_index_home')
            ->limit(1);
$info = $select->query()->fetch();
if (empty($info)) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_home',
    'displayname' => 'SES - Recipes With Reviews & Location - Recipes Home Page',
    'title' => 'Recipe Home',
    'description' => 'This is the recipe home page.',
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
    'name' => 'sesrecipe.browse-menu',
    'parent_content_id' => $topmiddle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.category-carousel',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"title_truncation_grid":"45","description_truncation_grid":"45","height":"180","width":"300","autoplay":"1","speed":"2000","criteria":"alphabetical","show_criteria":["title","countRecipes"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","isfullwidth":"1","limit_data":"10","title":"","nomobile":"0","name":"sesrecipe.category-carousel"}',
  ));

  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.tabbed-widget-recipe',
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"list","tabOption":"advance","htmlTitle":"1","category_id":"","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","location","likeButton","socialSharing","like","favourite","comment","rating","title","by","creationDate","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","descriptiongrid2","enableCommentPinboard"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_listview2plusicon":"1","socialshare_icon_listview2limit":"2","socialshare_enable_listview3plusicon":"1","socialshare_icon_listview3limit":"2","socialshare_enable_listview4plusicon":"1","socialshare_icon_listview4limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_gridview2plusicon":"1","socialshare_icon_gridview2limit":"2","socialshare_enable_gridview3plusicon":"1","socialshare_icon_gridview3limit":"2","socialshare_enable_gridview4plusicon":"1","socialshare_icon_gridview4limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","show_limited_data":"no","pagging":"button","title_truncation_grid":"40","title_truncation_list":"50","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_advgrid2":"45","title_truncation_supergrid":"45","title_truncation_pinboard":"30","limit_data_pinboard":"4","limit_data_list":"4","limit_data_grid":"9","limit_data_grid2":"9","limit_data_simplelist":"4","limit_data_advlist":"2","limit_data_advgrid":"6","limit_data_supergrid":"9","description_truncation_list":"300","description_truncation_grid":"160","description_truncation_advgrid2":"45","description_truncation_simplelist":"400","description_truncation_advlist":"250","description_truncation_advgrid":"120","description_truncation_supergrid":"160","description_truncation_pinboard":"160","height_grid":"200","width_grid":"300","height_list":"230","width_list":"250","height_simplelist":"230","width_simplelist":"225","height_advgrid":"300","width_advgrid":"302","height_advgrid2":"200","width_advgrid2":"225","height_supergrid":"175","width_supergrid":"302","width_pinboard":"250","search_type":["mostSPviewed","mostSPliked","mostSPcommented","mostSPrated","mostSPfavourite","week","featured","sponsored","verified"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"","nomobile":"0","name":"sesrecipe.tabbed-widget-recipe"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.top-recipegers',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","show_criteria":["count"],"height":"100","width":"210","showLimitData":"1","limit_data":"3","title":"Top Recipeurs","nomobile":"0","name":"sesrecipe.top-recipegers"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.browse-menu-quick',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.of-the-day',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","fixHover":"fix","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","socialSharing"],"title_truncation":"20","description_truncation":"60","height":"180","width":"180","title":"Recipe of the Day","nomobile":"0","name":"sesrecipe.of-the-day"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.featured-sponsored',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"recently_created","show_criteria":["title","category"],"show_star":"0","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"70","width":"70","limit_data":"4","title":"Recent Recipes","nomobile":"0","name":"sesrecipe.featured-sponsored"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.tag-cloud-category',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#00f","showType":"simple","text_height":"15","height":"300","itemCountPerPage":"12","title":"Categories","nomobile":"0","name":"sesrecipe.tag-cloud-category"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.tag-cloud-recipes',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#2e2b2b","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"sesrecipe.tag-cloud-recipes"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type' => 'widget',
    'name' => 'sesrecipe.review-of-the-day',
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","like","view"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"180","title":"","nomobile":"0","name":"sesrecipe.review-of-the-day"}',
  ));
}	

//Recipe Browse Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_browse',
    'displayname' => 'SES - Recipes With Reviews & Location - Browse Recipes Page',
    'title' => 'Recipe Browse',
    'description' => 'This page lists recipe entries.',
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
    'name' => 'sesrecipe.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  
  // Insert gutter menu
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.featured-sponsored-verified-category-slideshow',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"category":"0","criteria":"0","order":"","info":"recently_created","isfullwidth":"0","autoplay":"1","speed":"2000","type":"fade","navigation":"nextprev","show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing","creationDate"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","height":"300","limit_data":"5","title":"","nomobile":"0","name":"sesrecipe.featured-sponsored-verified-category-slideshow"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.alphabet-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPfavourite","mostSPrated","sponsored"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"sesrecipe.browse-search"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.browse-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["advlist","grid","pinboard","map"],"openViewType":"grid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"socialshare_enable_listview1plusicon":"1","socialshare_icon_listview1limit":"2","socialshare_enable_listview2plusicon":"1","socialshare_icon_listview2limit":"2","socialshare_enable_listview3plusicon":"1","socialshare_icon_listview3limit":"2","socialshare_enable_listview4plusicon":"1","socialshare_icon_listview4limit":"2","socialshare_enable_gridview1plusicon":"1","socialshare_icon_gridview1limit":"2","socialshare_enable_gridview2plusicon":"1","socialshare_icon_gridview2limit":"2","socialshare_enable_gridview3plusicon":"1","socialshare_icon_gridview3limit":"2","socialshare_enable_gridview4plusicon":"1","socialshare_icon_gridview4limit":"2","socialshare_enable_pinviewplusicon":"1","socialshare_icon_pinviewlimit":"2","socialshare_enable_mapviewplusicon":"1","socialshare_icon_mapviewlimit":"2","category":"0","sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"200","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"200","width_grid":"300","height_simplelist":"230","width_simplelist":"229","height_advgrid":"350","width_advgrid":"300","height_supergrid":"175","width_supergrid":"300","width_pinboard":"250","limit_data_pinboard":"6","limit_data_grid":"6","limit_data_list":"6","limit_data_simplelist":"6","limit_data_advlist":"2","limit_data_advgrid":"6","limit_data_supergrid":"6","pagging":"pagging","title":"","nomobile":"0","name":"sesrecipe.browse-recipes"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.tag-cloud-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"color":"#4a4444","type":"cloud","text_height":"15","height":"170","itemCountPerPage":"20","title":"Popular Tags","nomobile":"0","name":"sesrecipe.tag-cloud-recipes"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.featured-sponsored',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"grid1","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"1","title_truncation":"45","description_truncation":"60","height":"180","width":"180","limit_data":"1","title":"Verified Recipe","nomobile":"0","name":"sesrecipe.featured-sponsored"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.browse-menu-quick',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.popular-featured-verified-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
    'params' => '{"info":"most_viewed","imageType":"rounded","showLimitData":"1","show_criteria":["title","like","view","comment","description","by"],"title_truncation":"45","review_description_truncation":"45","limit_data":"3","title":"Most Viewed Reviews","nomobile":"0","name":"sesrecipe.popular-featured-verified-reviews"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.calendar',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.people-like-item',
    'page_id' => $page_id,
    'parent_content_id' => $main_right_id,
    'order' => $widgetOrder++,
  ));
}

//Browse Categories Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesrecipe_category_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {

  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesrecipe_category_browse',
      'displayname' => 'SES - Recipes With Reviews & Location - Browse Categories Page',
      'title' => 'Recipe Browse Category',
      'description' => 'This page lists recipe categories.',
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
      'name' => 'sesrecipe.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.banner-category',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,     
      'params' => '{"description":"Discover top-notch recipes, creators, and collections related to your interests, hand-selected by our 100-percent-human curation team.","sesrecipe_categorycover_photo":"","title":"Categories","nomobile":"0","name":"sesrecipe.banner-category"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.recipe-category-icons',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"titleC":"Popular Categories","height":"150","width":"180","alignContent":"center","criteria":"admin_order","show_criteria":["title","countRecipes"],"limit_data":"12","title":"","nomobile":"0","name":"sesrecipe.recipe-category-icons"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.category-associate-recipe',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"show_criteria":["like","comment","rating","ratingStar","view","title","favourite","by","featuredLabel","sponsoredLabel","creationDate","readmore"],"popularity_recipe":"like_count","pagging":"button","count_recipe":"1","criteria":"alphabetical","category_limit":"5","recipe_limit":"5","recipe_description_truncation":"45","seemore_text":"+ See all [category_name]","allignment_seeall":"left","height":"160","width":"250","title":"","nomobile":"0","name":"sesrecipe.category-associate-recipe"}'
  ));
  
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.of-the-day',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid1","fixHover":"hover","show_criteria":["title","like","view","comment","favourite","rating","ratingStar","by","favouriteButton","likeButton","featuredLabel","verifiedLabel","socialSharing"],"title_truncation":"45","description_truncation":"60","height":"180","width":"180","title":"Recipe of the Day","nomobile":"0","name":"sesrecipe.of-the-day"}'
  ));
  
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.tag-cloud-recipes',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"color":"#00f","type":"tab","text_height":"15","height":"300","itemCountPerPage":"21","title":"Trending Tags","nomobile":"0","name":"sesrecipe.tag-cloud-recipes"}'
  ));
  
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.sidebar-tabbed-widget',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"enableTabs":"list","show_criteria":["location","like","favourite","comment","view","title","category","by","creationDate"],"show_limited_data":"no","pagging":"button","title_truncation_grid":"45","title_truncation_list":"20","limit_data_list":"3","limit_data_grid":"10","description_truncation_grid":"45","height_grid":"270","width_grid":"389","height_list":"60","width_list":"60","search_type":["week","month"],"dummy1":null,"recentlySPcreated_order":"1","recentlySPcreated_label":"Recently Created","dummy2":null,"mostSPviewed_order":"2","mostSPviewed_label":"Most Viewed","dummy3":null,"mostSPliked_order":"3","mostSPliked_label":"Most Liked","dummy4":null,"mostSPcommented_order":"4","mostSPcommented_label":"Most Commented","dummy5":null,"mostSPrated_order":"5","mostSPrated_label":"Most Rated","dummy6":null,"mostSPfavourite_order":"6","mostSPfavourite_label":"Most Favourite","dummy7":null,"featured_order":"7","featured_label":"Featured","dummy8":null,"sponsored_order":"8","sponsored_label":"Sponsored","dummy9":null,"verified_order":"9","verified_label":"Verified","dummy10":null,"week_order":"10","week_label":"This Week","dummy11":null,"month_order":"11","month_label":"This Month","title":"Recipes Created","nomobile":"0","name":"sesrecipe.sidebar-tabbed-widget"}'
  ));

  
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"square","criteria":"5","order":"","info":"recently_created","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"1","title_truncation":"20","description_truncation":"60","height":"50","width":"50","limit_data":"3","title":"Recent Posts","nomobile":"0","name":"sesrecipe.featured-sponsored"}'
  ));
  
  
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.featured-sponsored',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"list","imageType":"rounded","criteria":"5","order":"","info":"most_favourite","show_criteria":["like","comment","favourite","view","title","by","creationDate","category","rating","ratingStar","socialSharing","likeButton","favouriteButton"],"show_star":"0","showLimitData":"0","title_truncation":"20","description_truncation":"60","height":"60","width":"60","limit_data":"3","title":"Most Favourite Recipes","nomobile":"0","name":"sesrecipe.featured-sponsored"}'
  ));
}

//Browse Locations Page
$page_id = $db->select()
    ->from('engine4_core_pages', 'page_id')
    ->where('name = ?', 'sesrecipe_index_locations')
    ->limit(1)
    ->query()
    ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sesrecipe_index_locations',
      'displayname' => 'SES - Recipes With Reviews & Location - Browse Locations Page',
      'title' => 'Recipe Browse Location',
      'description' => 'This page show recipe locations.',
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
      'name' => 'sesrecipe.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.browse-search',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"sesrecipe.browse-search"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.recipe-location',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"location":"World","lat":"56.6465227","lng":"-6.709638499999983","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","location","likeButton","0","1","ratingStar","rating","socialSharing","like","view","comment","favourite"],"location-data":null,"title":"","nomobile":"0","name":"sesrecipe.recipe-location"}',
  ));
}  

//Browse Reviews Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_review_browse')
  ->limit(1)
  ->query()
  ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_review_browse',
    'displayname' => 'SES - Recipes With Reviews & Location - Browse Reviews Page',
    'title' => 'Recipe Browse Reviews',
    'description' => 'This page show recipe browse reviews page.',
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
    'name' => 'sesrecipe.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.review-of-the-day',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"gridOutside","show_criteria":["title","like","view","rating","featuredLabel","verifiedLabel","socialSharing"],"grid_title_truncation":"45","list_title_truncation":"45","height":"180","width":"180","photo_height":"160","photo_width":"250","title":"Review of the Day","nomobile":"0","name":"sesmember.review-of-the-day"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.browse-review-search',
    'page_id' => $page_id,
    'parent_content_id' => $main_left_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"vertical","review_title":"1","view":["likeSPcount","viewSPcount","commentSPcount","mostSPrated","leastSPrated","verified","featured"],"review_stars":"1","network":"1","title":"Review Browse Search","nomobile":"0","name":"sesrecipe.browse-review-search"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.browse-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating"],"show_criteria":"","pagging":"button","limit_data":"9","title":"","nomobile":"0","name":"sesrecipe.browse-reviews"}',
  ));
}

//Manage Recipes Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_manage')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_manage',
    'displayname' => 'SES - Recipes With Reviews & Location - Manage Recipes Page',
    'title' => 'My Recipe Entries',
    'description' => 'This page lists a user\'s recipe entries.',
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
    'name' => 'sesrecipe.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.manage-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}


//New Claims Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_claim')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_claim',
    'displayname' => 'SES - Recipes With Reviews & Location - New Claims Page',
    'title' => 'Recipe Claim',
    'description' => 'This page lists recipe entries.',
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
    'name' => 'sesrecipe.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.claim-recipe',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Recipe Create Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_create')
  ->limit(1)
  ->query()
  ->fetchColumn();
  
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_create',
    'displayname' => 'SES - Recipes With Reviews & Location - Recipe Create Page',
    'title' => 'Write New Recipe',
    'description' => 'This page is the recipe create page.',
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
    'name' => 'sesrecipe.browse-menu',
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
            ->where('name = ?', 'sesrecipe_index_tags')
            ->limit(1)
            ->query()
            ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_tags',
    'displayname' => 'SES - Recipes With Reviews & Location - Browse Tags Page',
    'title' => 'Recipe Browse Tags Page',
    'description' => 'This page displays the recipe tags.',
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
    'name' => 'sesrecipe.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.tag-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Album View Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesrecipe_album_view')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_album_view',
    'displayname' => 'SES - Recipes With Reviews & Location - Album View Page',
    'title' => 'Recipe Album View',
    'description' => 'This page displays an recipe album.',
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
    'name' => 'sesrecipe.album-breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.album-view-page',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"masonry","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","by","socialSharing","likeButton","favouriteButton"],"limit_data":"20","pagging":"auto_load","title_truncation":"45","height":"160","width":"140","title":"","nomobile":"0","name":"sesrecipe.album-view-page"}'
  ));
}

//Photo View Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesrecipe_photo_view')
              ->limit(1)
              ->query()
              ->fetchColumn();
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_photo_view',
    'displayname' => 'SES - Recipes With Reviews & Location - Photo View Page',
    'title' => 'Recipe Album Photo View',
    'description' => 'This page displays an recipe album\'s photo.',
    'provides' => 'subject=sesrecipe_photo',
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
    'name' => 'sesrecipe.photo-view-page',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => 1,
    'params' => '{"title":"","nomobile":"0","name":"sesrecipe.photo-view-page"}'
  ));
}	


//Browse Claim Requests Page
$page_id = $db->select()
              ->from('engine4_core_pages', 'page_id')
              ->where('name = ?', 'sesrecipe_index_claim-requests')
              ->limit(1)
              ->query()
              ->fetchColumn();
// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_claim-requests',
    'displayname' => 'SES - Recipes With Reviews & Location - Browse Claim Requests Page',
    'title' => 'Recipe Claim Requests',
    'description' => 'This page lists recipe claims request entries.',
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
    'name' => 'sesrecipe.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));
  
  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.claim-requests',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
  ));
}

//Recipe List Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_list')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_list',
    'displayname' => 'SES - Recipes With Reviews & Location - Recipe List Page',
    'title' => 'Recipe List',
    'description' => 'This page lists a member\'s recipe entries.',
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
    'name' => 'sesrecipe.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.gutter-menu',
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

//Recipe Profile Page Design 1
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_view_1')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_view_1',
    'displayname' => 'SES - Recipes With Reviews & Location - Recipe Profile Page Design 1',
    'title' => 'Recipe View',
    'description' => 'This page displays a recipe entry.',
    'provides' => 'subject=sesrecipe',
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
    'order' => 1,
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
    'name' => 'core.container-tabs',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"max":6}',
  ));
  $tab_id = $db->lastInsertId('engine4_core_content');
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Photos","titleCount":false,"load_content":"button","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","socialSharing","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"236","nomobile":"0","name":"sesrecipe.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"sesrecipe.profile-videos"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","name":"core.comments"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.recipe-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"button","limit_data":"5","title":"Reviews","nomobile":"0","name":"sesrecipe.recipe-reviews"}',
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.related-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","ratingStar","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"1","height":"180","width":"180","list_title_truncation":"45","limit_data":"3","title":" Sub Recipes","nomobile":"0","name":"sesrecipe.related-recipes"}',
  ));
  
  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.labels',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"photoviewtype":"circle","user_description_limit":"20","title":"","nomobile":"0","name":"sesrecipe.gutter-photo"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"sesrecipe.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"title":""}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","by","favouriteButton","likeButton","socialSharing"],"showLimitData":"0","height":"200","width":"294","list_title_truncation":"45","limit_data":"3","title":"Related Recipes","nomobile":"0","name":"sesrecipe.similar-recipes"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.similar-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","title","by","favouriteButton","likeButton","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"0","height":"200","width":"294","list_title_truncation":"45","limit_data":"4","title":"Related Recipes","nomobile":"0","name":"sesrecipe.similar-recipes"}',
  ));
}


//Recipe Profile Page Design 2
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_view_2')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_view_2',
    'displayname' => 'SES - Recipes With Reviews & Location - Recipe Profile Page Design 2',
    'title' => 'Recipe View',
    'description' => 'This page displays a recipe entry.',
    'provides' => 'subject=sesrecipe',
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
    'name' => 'sesrecipe.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.similar-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","by"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"1","height":"207","width":"307","list_title_truncation":"45","limit_data":"3","title":"Recipes","nomobile":"0","name":"sesrecipe.similar-recipes"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-tags',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"sesrecipe.profile-tags"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.recipe-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"auto_load","limit_data":"5","title":"Recipe Profile - Reviews","nomobile":"0","name":"sesrecipe.recipe-reviews"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"outside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","socialSharing","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"3","height":"200","width":"200","nomobile":"0","name":"sesrecipe.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"sesrecipe.profile-videos"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.view-recipe',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","description","photo","socialShare","ownerOptions","postComment","rating","likeButton","shareButton","smallShareButton","favouriteButton","view","like","comment","review","statics"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"Details","nomobile":"0","name":"sesrecipe.view-recipe"}',
  ));
}


//Recipe Profile Page Design 3
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_view_3')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_view_3',
    'displayname' => 'SES - Recipes With Reviews & Location - Recipe Profile Page Design 3',
    'title' => 'Recipe View',
    'description' => 'This page displays a recipe entry.',
    'provides' => 'subject=sesrecipe',
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
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 3,
  ));
  $right_id = $db->lastInsertId();
  
  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"outside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","socialSharing","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"3","height":"200","width":"200","nomobile":"0","name":"sesrecipe.profile-photos"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"sesrecipe.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.gutter-menu',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.related-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"sesrecipe.profile-videos"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.view-recipe',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","description","photo","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"","nomobile":"0","name":"sesrecipe.view-recipe"}',
  ));
  
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.recipe-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["share","report","pros","description","postedBy","rating","likeButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"button","limit_data":"5","title":"Reviews","nomobile":"0","name":"sesrecipe.recipe-reviews"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-tags',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"sesrecipe.profile-tags"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.similar-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","by"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"0","height":"200","width":"210","list_title_truncation":"45","limit_data":"3","title":"Similar Recipes","nomobile":"0","name":"sesrecipe.similar-recipes"}',
  ));
}


//Recipe Profile Page Design 4
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_view_4')
  ->limit(1)
  ->query()
  ->fetchColumn();

// insert if it doesn't exist yet
if( !$page_id ) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_view_4',
    'displayname' => 'SES - Recipes With Reviews & Location - Recipe Profile Page Design 4',
    'title' => 'Recipe View',
    'description' => 'This page displays a recipe entry.',
    'provides' => 'subject=sesrecipe',
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
  
  // Insert middle
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'right',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $right_id = $db->lastInsertId();
  
  // Insert gutter
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.gutter-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"photoviewtype":"square","user_description_limit":"150","title":"","nomobile":"0","name":"sesrecipe.gutter-photo"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.like-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.favourite-button',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.advance-share',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"advShareOptions":["privateMessage","siteShare","quickShare","addThis"],"title":"","nomobile":"0","name":"sesrecipe.advance-share"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.gutter-menu',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-videos',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list"],"openViewType":"list","show_criteria":["featuredLabel","sponsoredLabel","hotLabel","watchLater","favouriteButton","playlistAdd","likeButton","socialSharing","like","comment","favourite","rating","view","title","category","by","duration","description"],"pagging":"auto_load","title_truncation_list":"45","title_truncation_grid":"45","DescriptionTruncationList":"45","height":"160","width":"140","limit_data":"20","title":"Videos","nomobile":"0","name":"sesrecipe.profile-videos"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.view-recipe',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["title","description","photo","socialShare","ownerOptions","postComment","rating","likeButton","shareButton","smallShareButton","favouriteButton","view","like","comment","review","statics"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"","nomobile":"0","name":"sesrecipe.view-recipe"}'
  ));
  
  
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.similar-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","showLimitData":"0","height":"200","width":"307","list_title_truncation":"45","limit_data":"3","title":"Similar Recipes","nomobile":"0","name":"sesrecipe.similar-recipes"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-photos',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Albums","titleCount":false,"load_content":"auto_load","sort":"recentlySPcreated","insideOutside":"inside","fixHover":"fix","show_criteria":["like","comment","view","favouriteCount","title","socialSharing","photoCount","likeButton","favouriteButton"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title_truncation":"45","limit_data":"20","height":"200","width":"200","nomobile":"0","name":"sesrecipe.profile-photos"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.recipe-reviews',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"stats":["likeCount","commentCount","viewCount","title","share","report","pros","cons","description","recommended","postedBy","parameter","creationDate","rating","likeButton","socialSharing"],"pagging":"auto_load","limit_data":"5","title":"Recipe Profile - Reviews","nomobile":"0","name":"sesrecipe.recipe-reviews"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.review-profile',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.related-recipes',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"show_criteria":["like","comment","favourite","view","title","by","rating","featuredLabel","sponsoredLabel","verifiedLabel","favouriteButton","likeButton","category","socialSharing"],"showLimitData":"0","height":"200","width":"307","list_title_truncation":"45","limit_data":"3","title":"Similar Recipes","nomobile":"0","name":"sesrecipe.similar-recipes"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'core.comments',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"Comments","name":"core.comments"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.profile-tags',
    'page_id' => $page_id,
    'parent_content_id' => $right_id,
    'order' => $widgetOrder++,
    'params' => '{"itemCountPerPage":"30","title":"Tags","nomobile":"0","name":"sesrecipe.profile-tags"}',
  ));
}

//Review Profile Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesrecipe_review_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
      'name' => 'sesrecipe_review_view',
      'displayname' => 'SES - Recipes With Reviews & Location - Review Profile Page',
      'title' => 'Recipe Review View',
      'description' => 'This page displays a recipe review entry.',
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
    'name' => 'sesrecipe.review-owner-photo',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"title":"","showTitle":"1","nomobile":"0","name":"sesrecipe.review-owner-photo"}',
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.review-profile-options',
    'page_id' => $page_id,
    'parent_content_id' => $left_id,
    'order' => $widgetOrder++,
    'params' => '{"viewType":"vertical","title":"","nomobile":"0","name":"sesrecipe.review-profile-options"}',
  ));
  
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.review-breadcrumb',
    'page_id' => $page_id,
    'parent_content_id' => $middle_id,
    'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.review-profile',
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
        ->where('name = ?', 'sesrecipe_category_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesrecipe_category_index',
      'displayname' => 'SES - Recipes With Reviews & Location - Recipe Category View Page',
      'title' => 'Recipe Category View Page',
      'description' => 'This page lists recipe category view page.',
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
      'name' => 'sesrecipe.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesrecipe.category-view',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"viewType":"grid","show_subcat":"1","show_subcatcriteria":["icon","title","countRecipe"],"heightSubcat":"160","widthSubcat":"290","textRecipe":"Recipes we like","show_criteria":["featuredLabel","sponsoredLabel","like","comment","rating","ratingStar","favourite","view","title","by","description","readmore","creationDate"],"pagging":"button","description_truncation":"150","recipe_limit":"12","height":"200","width":"294","title":"","nomobile":"0","name":"sesrecipe.category-view"}'
  ));
}

$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesrecipe_link_recipe';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesrecipe_link_event';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesrecipe_reject_recipe_request';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesrecipe_reject_event_request';");
$db->query("DELETE FROM `engine4_activity_notificationtypes` WHERE `engine4_activity_notificationtypes`.`type` = 'sesuser_claimadmin_recipe';");

//Action Type Change for Apps
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'sesrecipe_recipe_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesrecipe_like_recipe';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'sesrecipe_album_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesrecipe_like_recipealbum';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'sesrecipe_photo_like' WHERE `engine4_activity_actiontypes`.`type` = 'sesrecipe_like_recipephoto';");
$db->query("UPDATE `engine4_activity_actiontypes` SET `type` = 'sesrecipe_recipe_favourite' WHERE `engine4_activity_actiontypes`.`type` = 'sesrecipe_favourite_recipe';");

//Recipe Contributors depadent on Advanced Members Plugin
$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("sesrecipe_main_contributors", "sesrecipe", "Browse Contributors", "Sesrecipe_Plugin_Menus::canRecipesContributors", \'{"route":"sesrecipe_general","action":"contributors"}\', "sesrecipe_main", "", 6);');

 //Browse Recipe Contributors Page
$page_id = $db->select()
  ->from('engine4_core_pages', 'page_id')
  ->where('name = ?', 'sesrecipe_index_contributors')
  ->limit(1)
  ->query()
  ->fetchColumn();
if( !$page_id ) {
  $widgetOrder = 1;
  $db->insert('engine4_core_pages', array(
    'name' => 'sesrecipe_index_contributors',
    'displayname' => 'SES - Recipes With Reviews & Location - Browse Recipe Contributors Page',
    'title' => 'Browse Recipe Contributors',
    'description' => 'This page show all recipe contributors of your site.',
    'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'top',
    'page_id' => $page_id,
    'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'main',
    'page_id' => $page_id,
    'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'container',
    'name' => 'middle',
    'page_id' => $page_id,
    'parent_content_id' => $main_id,
    'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesrecipe.browse-menu',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-search',
    'page_id' => $page_id,
    'parent_content_id' => $top_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"view_type":"horizontal","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPrated","featured","sponsored","verified"],"view":["0","1","3","week","month"],"default_search_type":"creation_date ASC","show_advanced_search":"1","network":"yes","alphabet":"yes","friend_show":"yes","search_title":"yes","browse_by":"yes","location":"yes","kilometer_miles":"yes","country":"yes","state":"yes","city":"yes","zip":"yes","member_type":"yes","has_photo":"yes","is_online":"yes","is_vip":"yes","title":"","nomobile":"0","name":"sesmember.browse-search"}'
  ));

  $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesmember.browse-members',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"enableTabs":["list","advlist","grid","advgrid","pinboard","map"],"openViewType":"advlist","show_criteria":["featuredLabel","sponsoredLabel","verifiedLabel","vipLabel","message","friendButton","followButton","likeButton","likemainButton","socialSharing","like","location","rating","view","title","friendCount","mutualFriendCount","profileType","age","profileField","heading","labelBold","pinboardSlideshow"],"limit_data":"12","profileFieldCount":"5","pagging":"button","order":"mostSPviewed","show_item_count":"1","list_title_truncation":"45","grid_title_truncation":"45","advgrid_title_truncation":"45","pinboard_title_truncation":"45","main_height":"350","main_width":"585","height":"200","width":"250","photo_height":"250","photo_width":"284","info_height":"315","advgrid_height":"322","advgrid_width":"382","pinboard_width":"350","title":"","nomobile":"0","name":"sesmember.browse-members"}',
  ));
}

    
$select = new Zend_Db_Select($db);
// profile page
$select
  ->from('engine4_core_pages')
  ->where('name = ?', 'user_profile_index')
  ->limit(1);
$page_id = $select->query()->fetchObject()->page_id;

// Check if it's already been placed
$select = new Zend_Db_Select($db);
$select
  ->from('engine4_core_content')
  ->where('page_id = ?', $page_id)
  ->where('type = ?', 'widget')
  ->where('name = ?', 'sesrecipe.profile-sesrecipes')
  ;
$info = $select->query()->fetch();

if( empty($info) ) {

  // container_id (will always be there)
  $select = new Zend_Db_Select($db);
  $select
    ->from('engine4_core_content')
    ->where('page_id = ?', $page_id)
    ->where('type = ?', 'container')
    ->limit(1);
  $container_id = $select->query()->fetchObject()->content_id;

  // middle_id (will always be there)
  $select = new Zend_Db_Select($db);
  $select
    ->from('engine4_core_content')
    ->where('parent_content_id = ?', $container_id)
    ->where('type = ?', 'container')
    ->where('name = ?', 'middle')
    ->limit(1);
  $middle_id = $select->query()->fetchObject()->content_id;

  // tab_id (tab container) may not always be there
  $select
    ->reset('where')
    ->where('type = ?', 'widget')
    ->where('name = ?', 'core.container-tabs')
    ->where('page_id = ?', $page_id)
    ->limit(1);
  $tab_id = $select->query()->fetchObject();
  if( $tab_id && @$tab_id->content_id ) {
      $tab_id = $tab_id->content_id;
  } else {
    $tab_id = null;
  }

  // tab on profile
  $db->insert('engine4_core_content', array(
    'page_id' => $page_id,
    'type'    => 'widget',
    'name'    => 'sesrecipe.profile-sesrecipes',
    'parent_content_id' => ($tab_id ? $tab_id : $middle_id),
    'order'   => 6,
    'params'  => '{"title":"Sesrecipes","titleCount":true}',
  ));

}