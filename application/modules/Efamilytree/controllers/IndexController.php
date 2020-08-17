<?php

class Efamilytree_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
      $viewer = $this->view->viewer();
      //insert User Data if no data exists




      //get relations from table
      $table = Engine_Api::_()->getDbTable("relations",'efamilytree');
      $select = $table->select()->order("order DESC");
      $this->view->relations = $table->fetchAll($select);

      //get loggedin user friends
      $this->view->friends = $this->view->viewer()->membership()->getMembers();
      $this->_helper->layout->setLayout('default-simple');

      //get tree data
      $treeData = array();
      Engine_Api::_()->getDbTable("users",'efamilytree')->readNode('0',$treeData,$viewer->getIdentity());
      $this->view->treeData = $treeData;
      if(!empty($_GET['print'])) {
          echo "<prE>";
          var_dump($treeData);
          die;
      }
  }
  function addNode($params = array()){
        $row = Engine_Api::_()->getDbTable("users",'efamilytree')->createRow();
        $row->setFromArray($params);
        $row->save();
        if(!empty($_FILES['image']['name'])){
            $row->setPhoto($_FILES['image'],$params['user_id_owner']);
        }
        return $row;
  }
  public function sitememberAction(){
    $viewer = $this->view->viewer();
    $relation_id = $this->_getParam('relation_id');
    $sitemember = $this->_getParam('sitemember');
    $addUserId = $this->_getParam('addUserId');
    if($relation_id && $sitemember){
        $relation = Engine_Api::_()->getItem('efamilytree_relation',$relation_id);
        if($relation->type == "spouse"){
            $params['parent_id'] = '';
            $params['spouse_id'] = $addUserId;
            $params['relative_id'] = '';
            $params['site_user_id'] = $sitemember;
            $spouse = $this->addNode($params);
            if($addUserId){
                $item = Engine_Api::_()->getItem("efamilytree_user",$addUserId);
                if($item){
                    $item->spouse_id = $spouse->getIdentity();
                    $item->save();
                }
            }
        }else if($relation->type == "child"){
            $params['parent_id'] = $addUserId;
            $params['relative_id'] = '';
            $params['site_user_id'] = $sitemember;
            $child = $this->addNode($params);
        }else if($relation->type == "parent"){
            $params['owner_id'] = $viewer->getIdentity();
            $params['parent_id'] = '';
            $params['spouse_id'] = '';
            $params['relative_id'] = '';
            $params['site_user_id'] = $sitemember;
            $parent = $this->addNode($params);
            if($addUserId){
                $item = Engine_Api::_()->getItem("efamilytree_user",$addUserId);
                if($item){
                    $item->owner_id = 0;
                    $item->parent_id = $parent->getIdentity();
                    $item->save();
                }
            }
        }
    }
      $treeData = array();
      Engine_Api::_()->getDbTable("users",'efamilytree')->readNode('0',$treeData,$viewer->getIdentity());
      $content = $this->view->partial('index/mainContent.tpl', 'efamilytree', array("treeData"=>$treeData));
      echo json_encode(array('status'=>1,'content'=>$content));die;
  }
  public function addnewAction(){
      $viewer = $this->view->viewer();
      $relation_id = $this->_getParam('relation_id');
      $name = $this->_getParam('first_title');
      $addUserId = $this->_getParam('addUserId');
      if($relation_id && $name){
          $params = $_POST;
          $params['user_id_owner'] = $viewer->getIdentity();
          if(!empty($params['day'])){
              $params['dob'] = $params['year'].'-'.$params['month'].'-'.$params['day'];
          }
          $relation = Engine_Api::_()->getItem('efamilytree_relation',$relation_id);
          if($relation->type == "spouse"){
              $params['parent_id'] = '';
              $params['spouse_id'] = $addUserId;
              $params['relative_id'] = '';
              $params['site_user_id'] = 0;
              $spouse = $this->addNode($params);
              if($addUserId){
                  $item = Engine_Api::_()->getItem("efamilytree_user",$addUserId);
                  if($item){
                      $item->spouse_id = $spouse->getIdentity();
                      $item->save();
                  }
              }
          }else if($relation->type == "child"){
              $params['parent_id'] = $addUserId;
              $params['relative_id'] = '';
              $params['site_user_id'] = 0;
              $child = $this->addNode($params);
          }else if($relation->type == "parent"){
              $params['owner_id'] = $viewer->getIdentity();
              $params['parent_id'] = '';
              $params['spouse_id'] = '';
              $params['relative_id'] = '';
              $params['site_user_id'] = 0;
              $parent = $this->addNode($params);
              if($addUserId){
                  $item = Engine_Api::_()->getItem("efamilytree_user",$addUserId);
                  if($item){
                      $item->owner_id = 0;
                      $item->parent_id = $parent->getIdentity();
                      $item->save();
                  }
              }
          }
      }
      $treeData = array();
      Engine_Api::_()->getDbTable("users",'efamilytree')->readNode('0',$treeData,$viewer->getIdentity());
      $content = $this->view->partial('index/mainContent.tpl', 'efamilytree', array("treeData"=>$treeData));
      echo json_encode(array('status'=>1,'content'=>$content));die;
  }
}