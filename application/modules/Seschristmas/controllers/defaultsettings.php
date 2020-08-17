<?php

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
// wishes page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seschristmas_welcome_wishes')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {

  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'seschristmas_welcome_wishes',
      'displayname' => 'Christmas - Wishes Page',
      'title' => 'Wishes Page',
      'description' => 'This page is show all wishes.',
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
      'name' => 'seschristmas.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 1,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesbasic.html-block',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
      'params' => '{"body":"<p><p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"application\/modules\/Seschristmas\/externals\/images\/christmas-banner.png\" alt=\"\"><\/p><\/p>","content_height":"","content_width":"","title":"","nomobile":"0","name":"sesbasic.html-block"}',
  ));



  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 2,
  ));
}


// friend wishes page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'seschristmas_welcome_myfriendwishes')
        ->limit(1)
        ->query()
        ->fetchColumn();

if (!$page_id) {

  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'seschristmas_welcome_myfriendwishes',
      'displayname' => "Christmas - Friends' Wishes Page",
      'title' => 'Friend Wishes Page',
      'description' => 'This page is show all friend wishes.',
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
      'name' => 'seschristmas.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 1,
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesbasic.html-block',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 1,
      'params' => '{"body":"<p><p><img style=\"display: block; margin-left: auto; margin-right: auto;\" src=\"application\/modules\/Seschristmas\/externals\/images\/christmas-banner.png\" alt=\"\"><\/p><\/p>","content_height":"","content_width":"","title":"","nomobile":"0","name":"sesbasic.html-block"}',
  ));

  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.content',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 2,
  ));
}


//Member profile page
$select = new Zend_Db_Select($db);
$select
        ->from('engine4_core_pages')
        ->where('name = ?', 'user_profile_index')
        ->limit(1);
$page_id = $select->query()->fetchObject()->page_id;

//Make an condition
if (!empty($page_id)) {

  // container_id (will always be there)
  $select = new Zend_Db_Select($db);
  $select
          ->from('engine4_core_content')
          ->where('page_id = ?', $page_id)
          ->where('type = ?', 'container')
          ->where('name = ?', 'main')
          ->limit(1);
  $container_id = $select->query()->fetchObject()->content_id;
  if (!empty($container_id)) {
    // left_id (will always be there)
    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_content')
            ->where('parent_content_id = ?', $container_id)
            ->where('type = ?', 'container')
            ->where('name = ?', 'left')
            ->limit(1);
    $left_id = $select->query()->fetchObject()->content_id;
    if (!empty($left_id)) {

      // Check if it's already been placed
      $select = new Zend_Db_Select($db);
      $select
              ->from('engine4_core_content')
              ->where('parent_content_id = ?', $left_id)
              ->where('type = ?', 'widget')
              ->where('name = ?', 'seschristmas.countdown-clock');
      $info = $select->query()->fetch();
      if (empty($info)) {
        // tab on profile
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seschristmas.countdown-clock',
            'parent_content_id' => $left_id,
            'order' => 4,
        ));
      }

      // Check if it's already been placed
      $select = new Zend_Db_Select($db);
      $select
              ->from('engine4_core_content')
              ->where('parent_content_id = ?', $left_id)
              ->where('type = ?', 'widget')
              ->where('name = ?', 'seschristmas.write-wish');
      $info = $select->query()->fetch();
      if (empty($info)) {
        // tab on profile
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seschristmas.write-wish',
            'parent_content_id' => $left_id,
            'order' => 4,
        ));
      }
    }
  }
}


//Member home page
$select = new Zend_Db_Select($db);
$select
        ->from('engine4_core_pages')
        ->where('name = ?', 'user_index_home')
        ->limit(1);
$page_id = $select->query()->fetchObject()->page_id;

if (!empty($page_id)) {
  // container_id (will always be there)
  $select = new Zend_Db_Select($db);
  $select
          ->from('engine4_core_content')
          ->where('page_id = ?', $page_id)
          ->where('type = ?', 'container')
          ->where('name = ?', 'main')
          ->limit(1);
  $container_id = $select->query()->fetchObject()->content_id;

  if (!empty($container_id)) {
    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_content')
            ->where('parent_content_id = ?', $container_id)
            ->where('type = ?', 'container')
            ->where('name = ?', 'middle')
            ->limit(1);
    $middle_id = $select->query()->fetchObject()->content_id;
    if (!empty($middle_id)) {
      // Check if it's already been placed
      $select = new Zend_Db_Select($db);
      $select
              ->from('engine4_core_content')
              ->where('parent_content_id = ?', $middle_id)
              ->where('type = ?', 'widget')
              ->where('name = ?', 'seschristmas.banner-template1');
      $info = $select->query()->fetch();

      $select = new Zend_Db_Select($db);
      $select
              ->from('engine4_core_content', 'order')
              ->where('parent_content_id = ?', $middle_id)
              ->where('type = ?', 'widget')
              ->where('name = ?', 'activity.feed');
      $order = $select->query()->fetchObject()->order;
      if (empty($info)) {
        $db->insert('engine4_core_content', array(
            'page_id' => $page_id,
            'type' => 'widget',
            'name' => 'seschristmas.banner-template1',
            'parent_content_id' => $middle_id,
            'order' => 0,
            'params' => '{"designType":"tree","viewType":"vertical","showcountdown":"0","showtext1":"1","text1":"Merry Christmas and Happy New Year","showtext2":"1","text2":"Christmas Coming Soon","title":"","nomobile":"0","name":"seschristmas.banner-template1"}',
        ));
      }
    }
  }
}