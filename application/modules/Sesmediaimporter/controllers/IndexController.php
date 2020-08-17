<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmediaimporter_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    //if (!$this->_helper->requireUser->isValid())
      //return;
     //Render
    $this->_helper->content->setEnabled();
  }
  public function albumCreateAction(){
    if( !$this->_helper->requireAuth()->setAuthParams('album', null, 'create')->isValid() ) return;
     $this->view->mediaimporter = $mediaimporter = $this->_getParam('typeMedia', null);
    // Get form
    $this->view->form = $form = new Sesmediaimporter_Form_Album();
    $mediaimporter = $this->_getParam('typeMedia', null);
    if($mediaimporter == "album"){
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $view->headStyle()->appendStyle('#title-wrapper, #description-wrapper, #album-wrapper{display:none !important;}');
    }
    if(!empty($_POST['sesmediaimporter'])){
      $form->sesmediaimporter_data->setValue($_POST['mediadata']);
      return;
    }
    if( !$this->getRequest()->isPost() )
    {
      if( null !== ($album_id = $this->_getParam('album_id')) )
      {
        $form->populate(array(
          'album' => $album_id
        ));
      }
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) )
    {
      return;
     }

    $db = Engine_Api::_()->getItemTable('album')->getAdapter();
    $db->beginTransaction();

    try
    {
      if(!empty($_POST['sesmediaimporter_data'])){
       $mediaimporterdata = json_decode($_POST['sesmediaimporter_data'],true);
       $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
       if($this->_getParam('typeMedia','') == "zip"){
         $mediaimporterdata['zip_upload'] = $_SESSION['upload_zip'];
         $album = $this->sesMediaImporterAlbumCreate($form,$_POST,$viewer);
         if(!$album_id){
          $album->save();
         }
         $mediaimporterdata['album_data']['sesalbum_album_id'] = $album->album_id;
       }else if(isset($mediaimporterdata['album_data']['album_id'])){
         foreach($mediaimporterdata['album_data']['album_id'] as $importerdata){
           $album = $this->sesMediaImporterAlbumCreate($form,$_POST,$viewer);
           $mediaimporterdata['album_data']['sesalbum_album_id'][$importerdata] = $album->album_id;
           if(!$album_id){
            $album->save();
           }
         }
       }else{
          $album = $this->sesMediaImporterAlbumCreate($form,$_POST,$viewer);
          $mediaimporterdata['album_data']['sesalbum_album_id'] = $album->album_id;
          if(!$album_id){
            $album->save();
          }
       }
       $mediaimporterdata = json_encode($mediaimporterdata);
       $this->_helper->layout->setLayout('default-simple');
       $dbGetInsert->query("INSERT INTO `engine4_sesmediaimporter_import`(`params`, `creation_date`, `modified_date`) VALUES ('".$mediaimporterdata."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
       return $this->_forward('success', 'utility', 'core', array(
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Import Data successfully added in queue. You will get notification once your request processed.')),       'parentRefresh'=> 3000,
        'smoothboxClose' => 3000,
      ));
    }
      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }  
  }
  public function sesMediaImporterAlbumCreate($form,$post,$viewer){
    $db = Engine_Api::_()->getItemTable('album')->getAdapter();
    $db->beginTransaction();
    try {
      $album = $form->saveValues(0);
      // Add tags
      $values = $form->getValues();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }  
     return $album;
  }
	public function serviceAction()
  {
    if($this->view->viewer()->getIdentity() == 0){
        return $this->_helper->redirector->gotoRoute(array(), 'sesmediaimporter_general', true);
    }
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if (!$this->_helper->requireUser->isValid())
      return;
    $type = $this->_getParam('type');
    if($type == "px500"){
      if(!$type || !$settings->getSetting('sesmediaimporter.500px'))
        return $this->_helper->redirector->gotoRoute(array(), 'sesmediaimporter_general', true);
    }else{
        if(!$type || !$settings->getSetting('sesmediaimporter.'.$type))
          return $this->_helper->redirector->gotoRoute(array(), 'sesmediaimporter_general', true);
    }
    $status = true;
    if($type == 'facebook'){
      $table = Engine_Api::_()->getDbtable('facebook', 'sesmediaimporter');
      $api = $table->getApi();
      $status = true;
      if( !$api || empty($_SESSION['sesmediaimporter_facebook']) || !$table->enable()) {
        $status =  false;
      }
      // Not logged in
      if( !$table->isConnected() ) {
        $status = false;
      }
      // Not logged into correct facebook account
      if( !$table->checkConnection() ) {
        $status = false; 
      }  
      
    }else if($type == 'px500'){
      $type = "500px";
      $table = Engine_Api::_()->getDbtable('px500', 'sesmediaimporter');
      $api = $table ->getApi();
      $status = true;
      if( !$api || empty($_SESSION['sesmediaimporter_px500']) || !$table->enable()) {
        $status =  false;
      }
      // Not logged in
      if( !$table->isConnected() ) {
        $status = false;
      }   
      if (empty($_SESSION['px500_access_token']) || empty($_SESSION['px500_access_token']['oauth_token']) || empty($_SESSION['px500_access_token']['oauth_token_secret'])) {
       $status = false; 
      }
    }else if($type == 'zip'){
        if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmediaimporter.zip.enable',0))
          $status = false;
    }else if($type == 'instagram'){
      $table = Engine_Api::_()->getDbtable('instagram', 'sesmediaimporter');
      $api = $table ->getApi();
      $status = true;
      if( !$api || empty($_SESSION['sesmediaimporter_instagram']) || !$table->enable()) {
        $status =  false;
      }
      // Not logged in
      if( !$table->isConnected() ) {
        $status = false;
      }      
    }else if($type == 'flickr'){
      $table = Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter');
      $api = $table ->getApi();
      $status = true;
      if( !$api || empty($_SESSION['sesmediaimporter_flickr']) || !$table->enable()) {
        $status =  false;
      }
      // Not logged in
      if( !$table->isConnected() ) {
        $status = false;
      }     
    }else{
      $table =   Engine_Api::_()->getDbtable('google', 'sesmediaimporter');
      $api = $table ->getApi();
      if(!$api || !$table->enable())
        $status = false;
    }
    if(!$status){
         header("Location:".$table->loginButton().'?direct=1');
    }
    
     //Render
    $this->_helper->content->setEnabled();
  }
  function picasa_list_pictures( $data, $thumb_max_size = 200,$entryKey = 'feed' )
  {
    $xml = new DOMDocument();
    $xml->loadXML( $data );
    $namespace_media = $xml->getElementsByTagName( 'feed' )->item( 0 )->getAttribute( 'xmlns:media' );
    $pictures = array();
    $pictures['pagging']['totalresults'] = (int)$xml->getElementsByTagName('totalResults')->item(0)->nodeValue;
    $pictures['pagging']['startindex']  = (int) $xml->getElementsByTagName('startIndex')->item(0)->nodeValue;
    $pictures['pagging']['itemsperpage'] = (int) $xml->getElementsByTagName('itemsPerPage')->item(0)->nodeValue;
    foreach( $xml->getElementsByTagName( 'entry' ) as $entry )
    {
      $elem = $entry->getElementsByTagNameNS( $namespace_media, 'group' )->item( 0 );
      $thumb = array( 'url' => '', 'size' => 0 );
      foreach( $elem->getElementsByTagNameNS( $namespace_media, 'thumbnail' ) as $xml_thumb )
      {
        $thumb_size = (int)$xml_thumb->getAttribute( 'height' );
        $thumb_width = (int)$xml_thumb->getAttribute( 'width' );
        if ( $thumb_width < $thumb_size ) $thumb_size = $thumb_width;
        if( $thumb_size < $thumb_max_size && $thumb_size > $thumb['size'] )
        {
          $thumb['url'] = $xml_thumb->getAttribute( 'url' );
          $thumb['size'] = $thumb_size;
        }
      }
      $content_tag = $elem->getElementsByTagNameNS( $namespace_media, 'content' )->item( 0 );
      
      $picture = array(
        'url'=> str_replace('https://picasaweb.google.com/data/entry/user','https://picasaweb.google.com/data/feed/api/user',$entry->getElementsByTagName('id')->item(0)->nodeValue),
        'id'=> end(explode('/',$entry->getElementsByTagName('id')->item(0)->nodeValue)),
        'title' => $elem->getElementsByTagNameNS( $namespace_media, 'title' )->item( 0 )->nodeValue,
        'thumbnail' => $thumb['url'],
        'url' => $content_tag->getAttribute( 'url' ),
      );		
      if($entryKey == 'entry'){
        $picture['count'] = $entry->getElementsByTagName('numphotos')->item(0)->nodeValue;
      }
      $pictures ['photos'][]= $picture;
    }
    return $pictures;
  }
  public function loadGooglePhotoAction(){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    //Get Albums
    if(!empty($_POST['page'])){
      $extra_params = '&start-index='.$_POST['page'];
    }
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $googleTable = Engine_Api::_()->getDbtable('google', 'sesmediaimporter');
    $access_token = $googleTable->getApi();
    if(!$access_token){
      echo 'login'; die;
    }
    $this->view->album_id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;
    if(!empty($_REQUEST['id']))
      $url = 'https://picasaweb.google.com/data/feed/api/user/default/albumid/'.$_REQUEST['id'].'?imgmax=1600&max-results='.$settings->getSetting('sesmediaimporter.photoshowcount',8).$extra_params;
    else
      $url = 'https://picasaweb.google.com/data/feed/api/user/default?kind=photo&imgmax=1600&max-results='.$settings->getSetting('sesmediaimporter.photoshowcount',8).$extra_params;
    $siteurl = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $this->view->url());
    $curl = curl_init();
    curl_setopt_array( $curl, 
                     array( CURLOPT_CUSTOMREQUEST => 'GET'
                           , CURLOPT_URL => $url
                           , CURLOPT_HTTPHEADER => array( 'GData-Version: 2'
                                                         , 'Authorization: Bearer '.$access_token )
                           , CURLOPT_REFERER => $siteurl
                           , CURLOPT_RETURNTRANSFER => 1 // means output will be a return value from curl_exec() instead of simply echoed
                     ) );
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);
		$this->view->gallerydata = $this->picasa_list_pictures($response,'1600','feed');
  }
  public function loadGoogleGalleryAction(){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    //Get Albums
    if(!empty($_POST['page'])){
      $extra_params = '&start-index='.$_POST['page'];
    }
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $googleTable = Engine_Api::_()->getDbtable('google', 'sesmediaimporter');
    $access_token = $googleTable->getApi();
    if(!$access_token){
      echo 'login'; die;
    }
    $siteurl = (((!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"]) == 'on') ? "https://" : "http://") . $this->view->url());
    $curl = curl_init();
    $url = 'https://picasaweb.google.com/data/feed/api/user/default?max-results='.$settings->getSetting('sesmediaimporter.albumshowcount',8).$extra_params;
    curl_setopt_array( $curl, 
                     array( CURLOPT_CUSTOMREQUEST => 'GET'
                           , CURLOPT_URL => $url
                           , CURLOPT_HTTPHEADER => array( 'GData-Version: 2'
                                                         , 'Authorization: Bearer '.$access_token )
                           , CURLOPT_REFERER => $siteurl
                           , CURLOPT_RETURNTRANSFER => 1 // means output will be a return value from curl_exec() instead of simply echoed
                     ) );
    $response = curl_exec($curl);
    $http_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    curl_close($curl);
		$this->view->gallerydata = $this->picasa_list_pictures($response,'1600','entry');
  }
  public function loadFbGalleryAction(){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $extra_params = "&limit=" .$settings->getSetting('sesmediaimporter.albumshowcount',8);
    //Get Albums
    if(!empty($_POST['after'])){
      $extra_params = $extra_params.'&after='.$_POST['after'];
    }
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sesmediaimporter');
    $facebook = $facebookTable->getApi();
    $fbData =  $_SESSION['sesmediaimporter_facebook'];
		$fields = "id,count,cover_photo,created_time,description,link,name";
    $this->view->access_token = $access_token = $facebook->getAccessToken();
		$json_link = "https://graph.facebook.com/{$fbData['fb_id']}/albums/?access_token={$access_token}&fields={$fields}". $extra_params;
		$result = json_decode($this->file_get_contents_curl($json_link),true);
		$this->view->gallerydata = $result;
  }
  public function loadFbPhotoAction(){
    $this->view->album_id = $album_id = $_REQUEST['id'];
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $extra_params = "&limit=" .$settings->getSetting('sesmediaimporter.photoshowcount',8);
    //Get Albums
    if(!empty($_POST['after'])){
      $extra_params = $extra_params.'&after='.$_POST['after'];
    }
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sesmediaimporter');
    $facebook = $facebookTable->getApi();
    $fbData =  $_SESSION['sesmediaimporter_facebook'];
    $this->view->access_token = $access_token = $facebook->getAccessToken();
		$json_link = "https://graph.facebook.com/{$album_id}/photos/?access_token={$access_token}". $extra_params;
		$result = json_decode($this->file_get_contents_curl($json_link),true);
		$this->view->gallerydata = $result;
   
  }
  public function loadFlickrGalleryAction(){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if(!empty($_POST['type']))
      $type = $_POST['type'];
    else if(!empty($_GET['type']))
      $type = $_GET['type'];
    $extra_params['per_page'] = $settings->getSetting('sesmediaimporter.albumshowcount',8);
    $extra_params['page'] = 1;
    if(!empty($_POST['page']))
      $extra_params['page'] = $_POST['page'];
    $user_id =  $_SESSION['sesmediaimporter_flickr']['in_id'];
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $flickrTable = Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter');
    $this->view->flickr = $flickr = $flickrTable->getApi();  
    $result = $flickr->call('flickr.galleries.getList',array_merge(array('user_id'=>$user_id),$extra_params));  
   // echo "<pre>";var_dump($result);die;
		$this->view->gallerydata = $result;
  }
  public function loadFlickrPhotoAction(){
    $this->view->album_id = $album_id = $_REQUEST['id'];
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if(!empty($_POST['type']))
      $type = $_POST['type'];
    else if(!empty($_GET['type']))
      $type = $_GET['type'];
    $extra_params['per_page'] = $settings->getSetting('sesmediaimporter.photoshowcount',8);
    $extra_params['page'] = 1;
    if(!empty($_POST['page']))
      $extra_params['page'] = $_POST['page'];
    
    $user_id =  $_SESSION['sesmediaimporter_flickr']['in_id'];
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $flickrTable = Engine_Api::_()->getDbtable('flickr', 'sesmediaimporter');
    $this->view->flickr = $flickr = $flickrTable->getApi();
    if($type == 'getPhotos'){
      $result = $flickr->call('flickr.people.getPhotos',array_merge(array('user_id'=>$user_id),$extra_params));
    }else if($type == 'getFavourites'){
      $result = $flickr->call('flickr.favorites.getList',array_merge(array('user_id'=>$user_id),$extra_params));  
    }else if(!empty($album_id)){
      $result = $flickr->call('flickr.galleries.getPhotos',array_merge(array('gallery_id'=>$album_id),$extra_params));  
    }
    
		$this->view->gallerydata = $result;
  }
  
  //500px
  public function load500pxPhotosAction(){
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $type = $this->_getParam('type');
    if(!empty($_GET['type']))
      $type = $_GET['type'];
    $extra_params['per_page'] = $settings->getSetting('sesmediaimporter.photoshowcount',8);
    $extra_params['page'] = 1;
    if(!empty($_POST['page']))
      $extra_params['page'] = $_POST['page'];
    $user_id =  $_SESSION['sesmediaimporter_px500']['in_id'];
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $flickrTable = Engine_Api::_()->getDbtable('px500', 'sesmediaimporter');
    $this->view->flickr = $flickr = $flickrTable->getApi();
    if($type == 'ownphotos'){
      $result = $flickr->get('photos', array('feature' => 'user', 'user_id' => $user_id,'rpp'=>$extra_params['per_page'],'page'=>$extra_params['page'],'image_size'=>4));
    }else if($type == 'favphotos'){
      $result = $flickr->get('photos', array('feature' => 'user_favorites','rpp'=>$extra_params['per_page'],'page'=>$extra_params['page'],'image_size'=>4));
    }else if($type == "friendphotos"){
      $result = $flickr->get('photos', array('feature' => 'user_friends', 'user_id' => $user_id,'rpp'=>$extra_params['per_page'],'page'=>$extra_params['page'],'image_size'=>4)); 
    }
    //echo "<pre>";var_dump($result);die;
		$this->view->gallerydata = $result;
  }
  
  public function loadInstagramGalleryAction(){
    $instagramTable = Engine_Api::_()->getDbtable('instagram', 'sesmediaimporter');
    $instagramApi = $instagramTable->getApi();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $extra_params = "&count=".$settings->getSetting('sesmediaimporter.photoshowcount',8);
    //Get Albums
    if(!empty($_POST['after'])){
      $extra_params = $extra_params.'&max_id='.$_POST['after'];
    }
    $this->view->typeSeelect = $_GET['type'];
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $instagramTable = Engine_Api::_()->getDbtable('instagram', 'sesmediaimporter');
    $instagram = $instagramTable->getApi();
    $inData =  $_SESSION['sesmediaimporter_instagram'];
    $this->view->access_token = $access_token = $instagram->getAccessToken();
		$json_link = "https://api.instagram.com/v1/users/{$inData['in_id']}/media/recent/?access_token={$access_token}". $extra_params;
		$result = json_decode($this->file_get_contents_curl($json_link),true);
		$this->view->gallerydata = $result;
    $this->renderScript('index/load-instagram-photo.tpl');
  }
   public function loadFbTypePhotoAction(){
    $this->view->album_id = $album_id = $_REQUEST['id'];
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $extra_params = "&limit=" .$settings->getSetting('sesmediaimporter.photoshowcount',8);
    //Get Albums
    if(!empty($_POST['after'])){
      $extra_params = $extra_params.'&after='.$_POST['after'];
    }
    $this->view->typeSeelect = $_GET['type'];
    if(!empty($_GET['type']))
      $extra_params = $extra_params.'&type='.$_GET['type'];
    else
      $extra_params = $extra_params.'&type=tagged';
    $this->view->is_ajax = isset($_POST['is_ajax']) ? true : false;
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sesmediaimporter');
    $facebook = $facebookTable->getApi();
    $fbData =  $_SESSION['sesmediaimporter_facebook'];
    $this->view->access_token = $access_token = $facebook->getAccessToken();
		$json_link = "https://graph.facebook.com/{$fbData['fb_id']}/photos/?access_token={$access_token}". $extra_params;
		$result = json_decode($this->file_get_contents_curl($json_link),true);
		$this->view->gallerydata = $result;
    $this->renderScript('index/load-fb-photo.tpl');
  }
  public function fbLogoutAction(){
      // facebook api
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'sesmediaimporter');
    $facebook = $facebookTable->getApi();
    $settings = Engine_Api::_()->getDbtable('settings', 'core');
    if( $facebook && 'none' != $settings->core_facebook_enable ) {
      if( method_exists($facebook, 'getAccessToken') && 
          ($access_token = $facebook->getAccessToken()) ) {
        $doRedirect = false; // javascript will run to log them out of fb
        $this->view->appId = $facebook->getAppId();
        $access_array = explode("|", $access_token);
        if ( ($session_key = $access_array[1]) ) {
          $this->view->fbSession = $session_key;
        }
      }
      try {
        $facebook->clearAllPersistentData();
      } catch( Exception $e ) {
        // Silence
      }
    }
    unset($_SESSION['facebook_lock']);
    unset($_SESSION['facebook_uid']);    
    unset($_SESSION['sesmediaimporter_facebook']['fb_name'] );
    unset($_SESSION['sesmediaimporter_facebook']['fb_id'] );
    unset($_SESSION['sesmediaimporter_facebook']['fbphoto_url']);
    return $this->_helper->redirector->gotoRoute(array(), 'sesmediaimporter_general', true);
  }
  public function instagramLogoutAction(){
    unset($_SESSION['sesmediaimporter_instagram']['inphoto_url'] );
    unset($_SESSION['sesmediaimporter_instagram']['in_id'] );
    unset($_SESSION['sesmediaimporter_instagram']['in_name'] );
    unset($_SESSION['sesmediaimporter_instagram']['in_username'] );
    unset($_SESSION['instagram_lock']);
    unset($_SESSION['instagram_uid']);
    return $this->_helper->redirector->gotoRoute(array(), 'sesmediaimporter_general', true);
  }
  public function flickrLogoutAction(){
    unset($_SESSION['sesmediaimporter_flickr']['inphoto_url'] );
    unset($_SESSION['sesmediaimporter_flickr']['in_id'] );
    unset($_SESSION['sesmediaimporter_flickr']['in_name'] );
    unset($_SESSION['sesmediaimporter_flickr']['in_username'] );
    unset($_SESSION['flickr_lock']);
    unset($_SESSION['flickr_uid']);
    unset($_SESSION['phpFlickr_auth_token']);
    return $this->_helper->redirector->gotoRoute(array(), 'sesmediaimporter_general', true);
  }
  public function px500LogoutAction(){
    unset($_SESSION['sesmediaimporter_px500']['inphoto_url'] );
    unset($_SESSION['sesmediaimporter_px500']['in_id'] );
    unset($_SESSION['sesmediaimporter_px500']['in_name'] );
    unset($_SESSION['sesmediaimporter_px500']['in_username'] );
    unset($_SESSION['px500_lock']);
    unset($_SESSION['px500_auth_token']);
    unset($_SESSION['px500_access_token']);
    return $this->_helper->redirector->gotoRoute(array(), 'sesmediaimporter_general', true);
  }
   public function googleLogoutAction(){
    unset($_SESSION['sesmediaimporter_google']['inphoto_url'] );
    unset($_SESSION['sesmediaimporter_google']['in_id'] );
    unset($_SESSION['sesmediaimporter_google']['in_name'] );
    unset($_SESSION['sesmediaimporter_google']['in_username'] );
    unset($_SESSION['google_lock']);
    unset($_SESSION['google_uid']);
    return $this->_helper->redirector->gotoRoute(array(), 'sesmediaimporter_general', true);
  }
  function file_get_contents_curl($url){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $data = curl_exec($ch);
      curl_close($ch);
      return $data;
  }
}
