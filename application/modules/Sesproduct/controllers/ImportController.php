<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ImportController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_ImportController extends Core_Controller_Action_Standard {
  public function indexAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesproduct', null, 'create')->isValid()) return;
    $this->view->form = $form = new Sesproduct_Form_Import();
     // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
    return;
    if( !$form->isValid($this->getRequest()->getPost()) )
    return;
    $file = $form->getElement ( 'file_data' );
    $path = $file->getDestination () . DIRECTORY_SEPARATOR . $file->getValue ();
    $xml = simplexml_load_file($path);
    if($_POST['import_type'] == 1) {
      $posts = array();
      $xml =  $xml->entry;
      foreach( $xml as $row ) {
        $posts[] = array(
          "title"=>$row->title,
          "content"=>$row->content,
          "import_type" => 1,
        );
      }
      $this->importProducts($posts);
    }elseif($_POST['import_type'] == 2) {
      $posts = array();
      foreach($xml->channel->item as $item) {
        $content = $item->children('http://purl.org/rss/1.0/modules/content/');
        $posts[] = array(
        "title"=>$item->title,
        "content"=>$content->encoded,
        "import_type" => 2,
        );
      }
      $this->importProducts($posts);
    }elseif($_POST['import_type'] == 3) {
      if(empty($_POST['user_name'])) {
        $form->addError ('Username can not be empty.');
        return;
      }
      $i = 0;
      $posts = array();
      $finish = true;
      $counter = 1;
      $arrayCounter = 0;
      do {
        $fileUrl = "http://".$_POST['user_name'].".tumblr.com/api/read/json?start=".$i."&num=50";
        $content = @file_get_contents ( $fileUrl );
        $subContent  = preg_replace('#var tumblr_api_read = (.*);#','$1',$content);;
        $data = json_decode($subContent, true);
        foreach($data['posts'] as $item) {
          $posts[$arrayCounter] = array(
            "title"=>$item['regular-title'],
            "content"=>$item['regular-body'],
            "import_type" => 3,
          );
          $arrayCounter++;
        }
        $total = $data['posts-total'];
        $i = ($arrayCounter);
        if(ceil($total/50) <= $counter) {
          $finish = false;
        }
        ++$counter;
      }
      while($finish);
      $this->importProducts($posts);
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'),'sesproduct_general',true);
  }
  public function importProducts($posts) {
    foreach($posts as $post) {
      $title = $post['title'];
      if(!$title)
        continue;
      // Process
      $table = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        // Create sesproduct
        $viewer = Engine_Api::_()->user()->getViewer();
        $values = array();
        $sesproduct = $table->createRow();
        $sesproduct->ip_address = $_SERVER['REMOTE_ADDR'];
        $sesproduct->title = htmlspecialchars_decode($title);
        $sesproduct->body = $post['content'];
        $sesproduct->owner_type = $viewer->getType();
        $sesproduct->owner_id = $viewer->getIdentity();
        $sesproduct->category_id = 0;
        $sesproduct->subcat_id = 0;
        $sesproduct->subsubcat_id = 0;
        $sesproduct->is_approved = 1;
        $sesproduct->seo_title = $title;
        if(isset($sesproduct->package_id) && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproductpackage') ){
          $package_id = Engine_Api::_()->getDbTable('packages','sesproductpackage')->getDefaultPackage();
          $sesproduct->package_id = $package_id;
        }
        $sesproduct->save();
        $product_id = $sesproduct->product_id;
        $sesproduct->custom_url = $product_id;
        $roleTable = Engine_Api::_()->getDbtable('roles', 'sesproduct');
        $row = $roleTable->createRow();
        $row->product_id = $product_id;
        $row->user_id = $viewer->getIdentity();
        $row->save();
        // Auth
        $auth = Engine_Api::_()->authorization()->context;
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
        $values['auth_view'] = 'everyone';
        $values['auth_comment'] = 'everyone';
        $viewMax = array_search($values['auth_view'], $roles);
        $commentMax = array_search($values['auth_comment'], $roles);
        $videoMax = array_search(isset($values['auth_video']) ? $values['auth_video']: '', $roles);
        $musicMax = array_search(isset($values['auth_music']) ? $values['auth_music']: '', $roles);
        foreach( $roles as $i => $role ) {
          $auth->setAllowed($sesproduct, $role, 'view', ($i <= $viewMax));
          $auth->setAllowed($sesproduct, $role, 'comment', ($i <= $commentMax));
          $auth->setAllowed($sesproduct, $role, 'video', ($i <= $videoMax));
          $auth->setAllowed($sesproduct, $role, 'music', ($i <= $musicMax));
        }
        $sesproduct->save();
        // Add activity only if sesproduct is published
  //       if( $values['draft'] == 0 && $values['is_approved'] == 1 && (!$sesproduct->publish_date || strtotime($sesproduct->publish_date) <= time())) {
  //         $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesproduct, 'sesproduct_new');
  //         // make sure action exists before attaching the sesproduct to the activity
  //         if( $action ) {
  //           Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesproduct);
  //         }
  //         //Send notifications for subscribers
  //       	Engine_Api::_()->getDbtable('subscriptions', 'sesproduct')->sendNotifications($sesproduct);
  //       	$sesproduct->is_publish = 1;
  //       	$sesproduct->save();
  // 			}
        // Commit
        $db->commit();
      }
      catch( Exception $e ) {
        //silence and continue;
       //$db->rollBack();
      //throw $e;
      }
    }
  }
}
