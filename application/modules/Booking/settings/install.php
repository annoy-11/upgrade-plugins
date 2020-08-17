<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Booking_Installer extends Engine_Package_Installer_Module {

  public function onPreinstall() {
    $db = $this->getDb();
    parent::onPreinstall();
  }

  public function onInstall() {
    $db = $this->getDb();
    $this->browseServicePage();
    $this->browseProfessionalPage();
    $this->bookingAppointmentPage();
    //$this->bookingBecomeProfessionalPage();
    $this->bookingSettingsPage();
    $this->bookingBookServicesPage();
    $this->professionalview();
    $this->serviceview();
    parent::onInstall();
  }
  
  function browseServicePage(){

    $db = $this->getDb();

    // profile page
    $select = new Zend_Db_Select($db);
    $pageId = $select
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'booking_index_index')
      ->limit(1)
      ->query()
      ->fetchColumn();


    // insert if it doesn't exist yet
    if( !$pageId ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'booking_index_index',
        'displayname' => 'SES - Booking & Appointments Plugin - Browse Sevices Page',
        'title' => 'Browse Sevices Page',
        'description' => 'This page lists services created.',
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
        'order' => 3,
      ));
      $mainMiddleId = $db->lastInsertId();

      // Insert menu
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => 4,
      ));
      
    // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.service-search',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 5,
        'params' => '{"view_type":"horizontal","search_type":["professionalName","serviceName","price"],"title":"","nomobile":"0","name":"booking.service-search"}'
      ));
      // Insert content
      
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.browse-services',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 6,
        'params'=>'{"show_criteria":["serviceimage","providericon","providername","servicename","price","minute","like","favourite","report","likecount","favouritecount","viewbutton"],"limit_data":"9","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"button","title_truncation":"20","height":"200","width":"200","servicewidth":"370","title":"","nomobile":"0","name":"booking.browse-services"}'
      ));
    }
    return $this;
  }

  function browseProfessionalPage(){
    $db = $this->getDb();

    // profile page
    $select=new Zend_Db_Select($db);
    $pageId = $select
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'booking_index_professionals')
      ->limit(1)
      ->query()
      ->fetchColumn();


    // insert if it doesn't exist yet
    if( !$pageId ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'booking_index_professionals',
        'displayname' => 'SES - Booking & Appointments Plugin - Browse professionals Page',
        'title' => 'Browse professionals Page',
        'description' => 'This page lists professionals created.',
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
        'order' => 3,
      ));
      $mainMiddleId = $db->lastInsertId();

      // Insert menu
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => 4,
      ));

      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.professional-search',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 5,
        'params' =>'{"view_type":"horizontal","search_type":["professionalName","serviceName","rating","availability","location"],"title":"","nomobile":"0","name":"booking.professional-search"}'
      ));
      
        // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.professionals',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 6,
        'params'=>'{"show_criteria":["name","image","designation","location","description","profilephoto","rating","like","favourite","follow","likecount","favouritecount","followcount","bookbutton","viewprofile","socialSharing"],"limit_data":" 12","socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","pagging":"button","title_truncation":"30","height":"140","width":"140","title":"","nomobile":"0","name":"booking.professionals"}'
      ));
    }
    return $this;
  }

  function bookingAppointmentPage(){
    $db = $this->getDb();
    $select = new Zend_Db_Select($db);
    $pageId = $select
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'booking_index_appointments')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$pageId ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'booking_index_appointments',
        'displayname' => 'SES - Booking & Appointments Plugin - Appointments Page',
        'title' => 'Appointments Page',
        'description' => 'This widget displays all the given,taken,rejected,cancelled & completed appointments.',
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
        'order' => 3,
      ));
      $topMiddleId = $db->lastInsertId();

      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $pageId,
        'parent_content_id' => $mainId,
        'order' => 4,
      ));
       $mainMiddleId = $db->lastInsertId();

      // Insert menu
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => 5,
      ));
      
      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.appointments',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 6,
        'params' => '{"tabOption":"advance","search_type":["given","taken","cancelled","completed","reject"],"limit_data":"10","pagging":"button","title":"","nomobile":"0","name":"booking.appointments"}'
      ));
   } 
  return $this;
  }

  function bookingSettingsPage(){

    $db = $this->getDb();
    $select = new Zend_Db_Select($db);
    $pageId = $select
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'booking_index_settings')
      ->limit(1)
      ->query()
      ->fetchColumn();

    // insert if it doesn't exist yet
    if( !$pageId ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'booking_index_settings',
        'displayname' => 'SES - Booking & Appointments Plugin - Settings Page',
        'title' => 'Settings Page',
        'description' => 'This page change Booking Settings.',
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
        'order' => 0,
      ));
       $mainMiddleId = $db->lastInsertId();

      // Insert menu
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => 1,
      ));

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.expert-dashboard',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 1,
      ));
   } 
  return $this;
  }
  
  function bookingBecomeProfessionalPage(){
      $db = $this->getDb();
    $select = new Zend_Db_Select($db);
    $pageId = $select
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'booking_index_becomeprofessionals')
      ->limit(1)
      ->query()
      ->fetchColumn();


    // insert if it doesn't exist yet
    if( !$pageId ) {
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'booking_index_becomeprofessionals',
        'displayname' => 'SES - Booking & Appointments Plugin - Become a Professionals Page',
        'title' => 'Become a Professionals Page',
        'description' => 'This page make normal user to Professionals',
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
        'name' => 'booking.browse-menu',
        'page_id' => $pageId,
        'parent_content_id' => $topMiddleId,
        'order' => 0,
      ));

      // Insert content
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'booking.become-professionals',
        'page_id' => $pageId,
        'parent_content_id' => $mainMiddleId,
        'order' => 1,
      ));
    }
    return $this;
  }
  
    function bookingBookServicesPage(){
        $db = $this->getDb();

        // profile page
        $select = new Zend_Db_Select($db);
        $pageId = $select
          ->from('engine4_core_pages', 'page_id')
          ->where('name = ?', 'booking_index_bookservices')
          ->limit(1)
          ->query()
          ->fetchColumn();


        // insert if it doesn't exist yet
        if( !$pageId ) {
          // Insert page
          $db->insert('engine4_core_pages', array(
            'name' => 'booking_index_bookservices',
            'displayname' => 'SES - Booking & Appointments Plugin - Book Services Page',
            'title' => 'Book Sevices Page',
            'description' => 'Book any service page',
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
            'order' => 3,
            'parent_content_id' => $topId,
          ));
          $topMiddleId = $db->lastInsertId();

          // Insert main-middle
          $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $pageId,
            'parent_content_id' => $mainId,
            'order' => 4,
          ));
          $mainMiddleId = $db->lastInsertId();

          // Insert menu
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'booking.browse-menu',
            'page_id' => $pageId,
            'parent_content_id' => $topMiddleId,
            'order' => 5,
          ));

          // Insert content
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'booking.book-services',
            'page_id' => $pageId,
            'parent_content_id' => $mainMiddleId,
            'order' => 6,
          ));
        }
        return $this;
    }
    
    function professionalview(){
        $db = $this->getDb();
        $select = new Zend_Db_Select($db);
        $pageId = $select
          ->from('engine4_core_pages', 'page_id')
          ->where('name = ?', 'booking_professional_index')
          ->limit(1)
          ->query()
          ->fetchColumn();

        // insert if it doesn't exist yet
        if( !$pageId ) {
          // Insert page
          $db->insert('engine4_core_pages', array(
            'name' => 'booking_professional_index',
            'displayname' => 'SES - Booking & Appointments Plugin - Professional View Page',
            'title' => 'Professional view page',
            'description' => 'This page show professional profile.',
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
            'order' => 3,
          ));
          
          $topMiddleId = $db->lastInsertId();
          
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'booking.breadcrumb',
            'page_id' => $pageId,
            'parent_content_id' => $topMiddleId,
            'order' => 4,
          ));
          
          // Insert main-middle
          $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $pageId,
            'parent_content_id' => $mainId,
            'order' => 5,
          ));
           $mainMiddleId = $db->lastInsertId();
           
           
          // Insert menu
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'booking.expert-profile',
            'page_id' => $pageId,
            'parent_content_id' => $mainMiddleId,
            'order' => 6,
            'params' => '{"show_criteria":["image","name","designation","location","rating","about","contact","like","favourite","follow","report","likecount","favouritecount","followcount","bookme","socialSharing"],"socialshare_enable_plusicon":"1","socialshare_icon_limit":"2","title":"","nomobile":"0","name":"booking.expert-profile"}',
          ));

          // Insert content
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'booking.profile-services',
            'page_id' => $pageId,
            'parent_content_id' => $mainMiddleId,
            'order' => 7,
            'params'=>'{"show_criteria":["serviceimage","servicename","price","minute","like","favourite","likecount","favouritecount","bookbutton"],"limit_data":"8","pagging":"button","title_truncation":"20","height":"160","width":"140","title":"","nomobile":"0","name":"booking.profile-services"}',
          ));
        } 
    return $this;
    }
    
    function serviceview(){
        $db = $this->getDb();
        $select = new Zend_Db_Select($db);
        $pageId = $select
          ->from('engine4_core_pages', 'page_id')
          ->where('name = ?', 'booking_service_index')
          ->limit(1)
          ->query()
          ->fetchColumn();

        // insert if it doesn't exist yet
        if( !$pageId ) {
          // Insert page
          $db->insert('engine4_core_pages', array(
            'name' => 'booking_service_index',
            'displayname' => 'SES - Booking & Appointments Plugin - Service View Page.',
            'title' => 'Service view page',
            'description' => 'This page show service details',
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
            'order' => 3,
          ));
          $topMiddleId = $db->lastInsertId();

          // Insert menu
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'booking.breadcrumb',
            'page_id' => $pageId,
            'parent_content_id' => $topMiddleId,
            'order' => 4,
          ));
          
          // Insert main-middle
          $db->insert('engine4_core_content', array(
            'type' => 'container',
            'name' => 'middle',
            'page_id' => $pageId,
            'parent_content_id' => $mainId,
            'order' => 5,
          ));
          
           $mainMiddleId = $db->lastInsertId();

          // Insert menu
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'booking.service-view',
            'page_id' => $pageId,
            'parent_content_id' => $mainMiddleId,
            'order' => 6,
          ));
        } 
    return $this;
    }
}
?>