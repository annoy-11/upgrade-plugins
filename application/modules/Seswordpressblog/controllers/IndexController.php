<?php

class Seswordpressblog_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
      $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $results = $db->query("SELECT title FROM engine4_sesblog_categories")->fetchAll();
      foreach ($results as $key => $value) {
          echo $results[$key]['title'].",";
      }
      echo "dfsdf";
      die;
      $table = Engine_Api::_()->getDbtable('blogs', 'sesblog');
        if(!empty($_POST))
        { 
          $sesblog = $table->createRow();

        if(!empty($_POST['user_email'])){
            $userTable = Engine_Api::_()->getItemTable('user');
            $select = $userTable->select()->where('email =?',$_POST['user_email']);
            $viewer = $userTable->fetchRow($select);
        }
        if(empty($viewer))
        $viewer = Engine_Api::_()->getItem('user',1);
        $values = $_POST;
        $db = $table->getAdapter();
        $db->beginTransaction();
            try {
                $values = array_merge($values, array(
                    'owner_type' => $viewer->getType(),
                    'owner_id' => $viewer->getIdentity(),
                ));
                $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
                $values['style'] = 1;
                $values['seo_keywords'] = $values['tags'];
                $values['category_id'] = 1;//$values['category'];
                $values['publish_date']=date("Y-m-d h:i:s");
                $sesblog->setFromArray($values);
                $sesblog->save();
                if(!empty($_POST['image_url'])){
                  $params = array(
                  'user_id' => $viewer->getIdentity(),
                  'owner_id' => $viewer->getIdentity()
                    );
                //$photo = Engine_Api::_()->sesbasic()->setPhoto($_POST['image_url'], true,false,'sesblog','sesblog_blog',$params,$sesblog);
                //$sesblog->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo_file, false,false,'sesblog','sesblog_blog','',$sesblog,true);
                    // if($photo)
                    //     $sesblog->photo_id = $photo->getIdentity();
                }
                $_POST['custom_url'] = $sesblog->getIdentity();
                $roleTable = Engine_Api::_()->getDbtable('roles', 'sesblog');
                $row = $roleTable->createRow();
                $row->blog_id = $sesblog->getIdentity();
                $row->user_id = $viewer->getIdentity();
                $row->save();
                $auth = Engine_Api::_()->authorization()->context;
              $roles = array( 'everyone');
              if( empty($values['auth_view']) ) {
                $values['auth_view'] = 'everyone';
              }
              if( empty($values['auth_comment']) ) {
                $values['auth_comment'] = 'everyone';
              }
              $viewMax = array_search($values['auth_view'], $roles);
              $commentMax = array_search($values['auth_comment'], $roles);
              $videoMax = array_search(isset($values['auth_video']) ? $values['auth_video']: '', $roles);
              $musicMax = array_search(isset($values['auth_music']) ? $values['auth_music']: '', $roles);
              foreach( $roles as $i => $role ) {
                $auth->setAllowed($sesblog, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($sesblog, $role, 'comment', ($i <= $commentMax));
                $auth->setAllowed($sesblog, $role, 'video', ($i <= $videoMax));
                $auth->setAllowed($sesblog, $role, 'music', ($i <= $musicMax));
              }
              // Add tags
              if(!empty($values['tags']))
                $tags = preg_split('/[,]+/', $values['tags']);
                  $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
                  foreach($tags as $tag) {
                    $dbGetInsert->query('INSERT INTO `engine4_core_tags` (`text`,`modified_date`) VALUES ("'.$tag.'","'.date("Y-m-d h:i:s").'")');
                  }
                Engine_Api::_()->getDbtable('subscriptions', 'sesblog')->sendNotifications($sesblog);
                $sesblog->is_publish = 1;
                $sesblog->save();

                $db->commit();
            }catch( Exception $e ) {
                    $db->rollBack();
                throw $e;
            }
            unset($_SESSION["fromwptose"]);
          echo "done";
          die;
	}
    }
}
