<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_AdminManageController extends Core_Controller_Action_Admin
{
  // @todo add in stricter settings for admin level checking
  public function indexAction()
  {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesforum_admin_main', array(), 'sesforum_admin_main_manage');

    $table = Engine_Api::_()->getItemTable('sesforum_category');
    $this->view->categories = $table->fetchAll($table->select()->where('subsubcat_id = ?', 0)->where('subcat_id = ?', 0)->order('order ASC'));

  }

  public function moveSesforumAction()
  {
    if( $this->getRequest()->isPost() ) {
      $forum_id = $this->_getParam('forum_id');
      $sesforum = Engine_Api::_()->getItem('sesforum_forum', $forum_id);
      $sesforum->moveUp();
    }
  }

  public function moveCategoryAction()
  {
    if( $this->getRequest()->isPost() ) {
      $category_id = $this->_getParam('category_id');
      $category = Engine_Api::_()->getItem('sesforum_category', $category_id);
      $category->moveUp();
    }
  }

  public function editForumAction()
  {
    $form = $this->view->form = new Sesforum_Form_Admin_Forum_Edit();
    $populateValues = array();
    $forum_id = $this->getRequest()->getParam('forum_id');
    $sesforum = Engine_Api::_()->getItem('sesforum_forum', $forum_id);
    $subsubcatsesforum = Engine_Api::_()->getItem('sesforum_category', $sesforum->category_id);
    if($subsubcatsesforum->subsubcat_id) {
        $this->view->subsubcat_id = $subsubcatsesforum->category_id;
        $subcatsesforum = Engine_Api::_()->getItem('sesforum_category', $subsubcatsesforum->subsubcat_id);
        if($subcatsesforum->subcat_id){
            $this->view->subcat_id = $subcatsesforum->category_id;
            $catsesforum = Engine_Api::_()->getItem('sesforum_category', $subcatsesforum->subcat_id);
            $category_id = $this->view->category_id = $catsesforum->category_id;
        }
    } else if($subsubcatsesforum->subcat_id){
        $catsesforum = Engine_Api::_()->getItem('sesforum_category', $subsubcatsesforum->subcat_id);
        $category_id = $this->view->category_id = $catsesforum->category_id;
        $this->view->subcat_id = $subsubcatsesforum->category_id;
    } else {
        $category_id = $this->view->category_id = $sesforum->category_id;
    }
    $populateValues = $sesforum->toArray();
    $populateValues['category_id'] = $category_id;
    // Populate
    $form->populate($populateValues);
    $form->populate(array(
      'title' => htmlspecialchars_decode($sesforum->title),
      'description' => htmlspecialchars_decode($sesforum->description),
    ));

    $auth = Engine_Api::_()->authorization()->context;
    $allowed = array();
    if($auth->isAllowed($sesforum, 'everyone', 'view') ) {

    } else {
      $levels = Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll();
      foreach($levels as $level ) {
        if( Engine_Api::_()->authorization()->context->isAllowed($sesforum, $level, 'view') ) {
          $allowed[] = $level->getIdentity();
        }
      }
      if( count($allowed) == 0 || count($allowed) == count($levels) ) {
        $allowed = null;
      }
    }
    if( !empty($allowed) ) {
      $form->populate(array(
        'levels' => $allowed,
      ));
    }

    // Check request/method
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $values = $form->getValues();
    if(empty($values['forum_icon']))
        unset($values['forum_icon']);

    $table = Engine_Api::_()->getItemTable('sesforum_forum');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {

      if(isset($values['subsubcat_id']) && !empty($values['subsubcat_id'])) {
        $category_id = $values['subsubcat_id'];
      } else if(isset($values['subcat_id']) && !empty($values['subcat_id'])) {
         $category_id = $values['subcat_id'];
      } else if(isset($values['category_id']) && !empty($values['category_id'])) {
         $category_id = $values['category_id'];
      } else {
        $category_id = 0;
      }
      $values['category_id'] = $category_id;

      if( $sesforum->category_id != $values['category_id'] ) {
        $sesforum->order = Engine_Api::_()->getItem('sesforum_category', $values['category_id'])->getHighestOrder() + 1;
      }

      $sesforum->setFromArray($values);
      $sesforum->title = htmlspecialchars($values['title']);
      $sesforum->description = htmlspecialchars($values['description']);

      $sesforum->save();

      // Handle permissions
      $levels = Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll();

      // Clear permissions
      $auth->setAllowed($sesforum, 'everyone', 'view', false);
      foreach( $levels as $level ) {
        $auth->setAllowed($sesforum, $level, 'view', false);
      }

      // Add
      if(count($values['levels']) == 0 || count($values['levels']) == count($form->getElement('levels')->options) ) {
        $auth->setAllowed($sesforum, 'everyone', 'view', true);
      } else {
        foreach( $values['levels'] as $levelIdentity ) {
          $level = Engine_Api::_()->getItem('authorization_level', $levelIdentity);
          $auth->setAllowed($sesforum, $level, 'view', true);
        }
      }

      // Extra auth stuff
      $auth->setAllowed($sesforum, 'registered', 'topic.create', true);
      $auth->setAllowed($sesforum, 'registered', 'post.create', true);
      $auth->setAllowed($sesforum, 'registered', 'comment', true);

      // Make mod list now
      $list = $sesforum->getModeratorList();
      $auth->setAllowed($sesforum, $list, 'topic.edit', true);
      $auth->setAllowed($sesforum, $list, 'topic.delete', true);

        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        if (isset($_FILES['forum_icon'])) {
            $photoFile = $this->setPhoto($form->forum_icon, $sesforum->forum_id, 'forum');
            if (!empty($photoFile->file_id)) {
                $previous_file_id = $sesforum->forum_icon;
                $dbInsert->update('engine4_sesforum_forums', array('forum_icon' => $photoFile->file_id), array('forum_id = ?' => $sesforum->forum_id));
                $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
                if (!empty($file))
                    $file->delete();
            }
        }

      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Forum saved.')),
      'layout' => 'default-simple',
      'parentRefresh' => true,
    ));
  }

  public function editCategoryAction()
  {


    $form = $this->view->form = new Sesforum_Form_Admin_Category_Edit();

    $category_id = $this->getRequest()->getParam('category_id');
    $category = Engine_Api::_()->getItem('sesforum_category', $category_id);

    $form->title->setValue(htmlspecialchars_decode($category->title));
    $form->description->setValue(htmlspecialchars_decode($category->description));
    $valuess = $category->toArray();
    $valuess['privacy'] = (explode(",", $category->privacy));
    $form->populate($valuess);

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    $values = $form->getValues();
    $slugExists = Engine_Api::_()->getDbTable('categories', 'sesforum')->slugExists($values['slug'],$category_id);
      if (!$slugExists) {
         $form->addError($this->view->translate('The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'));
        return false;
    }
    if(empty($values['cat_icon']))
        unset($values['cat_icon']);
    $category->title = htmlspecialchars($form->getValue('title'));
    $category->slug = $values['slug'];
    $category->description = htmlspecialchars($form->getValue('description'));
    $category->save();
    $dbInsert = Engine_Db_Table::getDefaultAdapter();
    if (isset($_FILES['cat_icon'])) {
        $photoFile = $this->setPhoto($form->cat_icon, $category->category_id);
        if (!empty($photoFile->file_id)) {
            $previous_file_id = $menu->file_id;
            $dbInsert->update('engine4_sesforum_categories', array('cat_icon' => $photoFile->file_id), array('category_id = ?' => $category->category_id));
            $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
            if (!empty($file))
                $file->delete();
        }
    }
    $privacy = implode(",", $values['privacy']);
    $category->privacy = $privacy;
    $category->save();

    return $this->_forward('success', 'utility', 'core', array(
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your Changes saved Successfully.')),
            'layout' => 'default-simple',
            'parentRefresh' => true,
    ));
  }

  public function addCategoryAction()
  {
    $form = $this->view->form = new Sesforum_Form_Admin_Category_Create();

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $table = Engine_Api::_()->getItemTable('sesforum_category');
    $db = $table->getAdapter();
    $db->beginTransaction();
    $dbInsert = Engine_Db_Table::getDefaultAdapter();
    try
    {
      $values = $form->getValues();
      $slugExists = Engine_Api::_()->getDbTable('categories', 'sesforum')->slugExists($values['slug']);
      if (!$slugExists) {
         $form->addError($this->view->translate('The "slug" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'));
        return false;
      }

      $category = $table->createRow();
      $category->title = htmlspecialchars($values['title']);
      $category->slug = $values['slug'];
      $category->description = htmlspecialchars($values['description']);
      $category->order = Engine_Api::_()->sesforum()->getMaxCategoryOrder() + 1;
       if(!empty($values['subsubcat_id'])) {
        $category->subsubcat_id = $values['subsubcat_id'];
       } else if(!empty($values['subcat_id'])) {
         $category->subcat_id = $values['subcat_id'];
       }

      $category->save();

        if (isset($_FILES['cat_icon'])) {
            $photoFile = $this->setPhoto($form->cat_icon, $category->category_id);
            $dbInsert->update('engine4_sesforum_categories', array('cat_icon' => $photoFile->file_id), array('category_id = ?' => $category->category_id));
        }

        $privacy = implode(",", $values['privacy']);
        $category->privacy = $privacy;
        $category->save();


      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('Category added.')),
            'layout' => 'default-simple',
            'parentRefresh' => true,
    ));
  }

  public function setPhoto($photo, $cat_id, $param = 0) {

    if ($photo instanceof Zend_Form_Element_File)
      $catIcon = $photo->getFileName();
    else if (is_array($photo) && !empty($photo['tmp_name']))
      $catIcon = $photo['tmp_name'];
    else if (is_string($photo) && file_exists($photo))
      $catIcon = $photo;
    else
      return;

    if (empty($catIcon))
      return;

    $mainName = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary' . '/' . basename($catIcon);

    $photo_params = array(
        'parent_id' => $cat_id,
        'parent_type' => "sesforum_category",
    );

    //Resize category icon
    $image = Engine_Image::factory();
    $image->open($catIcon);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;

    if($param) {
        $image->open($catIcon)
            ->resample($x, $y, $size, $size, 100, 100)
            ->write($mainName)
            ->destroy();
    } else {
        $image->open($catIcon)
            ->resample($x, $y, $size, $size, 48, 48)
            ->write($mainName)
            ->destroy();
    }
    try {
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }
    //Delete temp file.
    @unlink($mainName);
    return $photoFile;
  }

  public function addForumAction()
  {
    $form = $this->view->form = new Sesforum_Form_Admin_Forum_Create();

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $values = $form->getValues();

    $table = Engine_Api::_()->getItemTable('sesforum_forum');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try
    {
      if(isset($values['subsubcat_id']) && !empty($values['subsubcat_id']) && !empty($values['subcat_id']) && !empty($values['category_id'])) {
        $category_id = $values['subsubcat_id'];
      } else if(isset($values['subcat_id']) && !empty($values['subcat_id']) && !empty($values['category_id'])) {
         $category_id = $values['subcat_id'];
      } else if(isset($values['category_id']) && !empty($values['category_id'])) {
         $category_id = $values['category_id'];
      } else {
        $category_id = 0;
      }
      $values['category_id'] = $category_id;
      $sesforum = $table->createRow();
      $sesforum->setFromArray($values);
      $sesforum->title = htmlspecialchars($values['title']);
      $sesforum->description = htmlspecialchars($values['description']);
      $sesforum->order = $sesforum->getCollection()->getHighestOrder() + 1;
      $sesforum->save();

      // Handle permissions
      $auth = Engine_Api::_()->authorization()->context;
      $levels = Engine_Api::_()->getDbtable('levels', 'authorization')->fetchAll();

      // Clear permissions
      $auth->setAllowed($sesforum, 'everyone', 'view', false);
      foreach( $levels as $level ) {
        $auth->setAllowed($sesforum, $level, 'view', false);
      }

      // Add
      if( count($values['levels']) == 0 || count($values['levels']) == count($form->getElement('levels')->options) ) {
        $auth->setAllowed($sesforum, 'everyone', 'view', true);
      } else {
        foreach( $values['levels'] as $levelIdentity ) {
          $level = Engine_Api::_()->getItem('authorization_level', $levelIdentity);
          $auth->setAllowed($sesforum, $level, 'view', true);
        }
      }

      // Extra auth stuff
      $auth->setAllowed($sesforum, 'registered', 'topic.create', true);
      $auth->setAllowed($sesforum, 'registered', 'post.create', true);
      $auth->setAllowed($sesforum, 'registered', 'comment', true);

      // Make mod list now
      $list = $sesforum->getModeratorList();
      $auth->setAllowed($sesforum, $list, 'topic.edit', true);
      $auth->setAllowed($sesforum, $list, 'topic.delete', true);

    if (isset($_FILES['forum_icon'])) {
        $photoFile = $this->setPhoto($form->forum_icon, $sesforum->category_id, 'forum');
        Engine_Db_Table::getDefaultAdapter()->update('engine4_sesforum_forums', array('forum_icon' => $photoFile->file_id), array('forum_id = ?' => $sesforum->forum_id));
    }

      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Forum added.')),
      'layout' => 'default-simple',
      'parentRefresh' => true,
    ));

  }

  public function addModeratorAction()
  {
    $forum_id = $this->getRequest()->getParam('forum_id');
    $this->view->sesforum = $sesforum = Engine_Api::_()->getItem('sesforum_forum', $forum_id);

    $form = $this->view->form = new Sesforum_Form_Admin_Moderator_Create();

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $values = $form->getValues();
    $user_id = $values['user_id'];

    $moderator = Engine_Api::_()->getItem('user', $user_id);

    $list = $sesforum->getModeratorList();
    $list->add($moderator);


    $viewer = Engine_Api::_()->user()->getViewer();
    Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($moderator, $viewer, $sesforum, 'sesforum_forum_moderator');

    return $this->_forward('success', 'utility', 'core', array(
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Moderator Added')),
      'layout' => 'default-simple',
      'parentRefresh' => true,
    ));
  }

  public function userSearchAction()
  {
    $page = $this->getRequest()->getParam('page', 1);
    $username = $this->getRequest()->getParam('username');
    $table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $table->select();
    if( !empty($username) ) {
      $select = $select->where('username LIKE ? || displayname LIKE ?', '%' . $username . '%');
    }
    $forum_id = $this->getRequest()->getParam('forum_id');
    $this->view->sesforum = $sesforum = Engine_Api::_()->getItem('sesforum_forum', $forum_id);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator->setCurrentPageNumber( $page );
    $this->view->paginator->setItemCountPerPage(20);
  }

  public function removeModeratorAction()
  {
    $form = $this->view->form = new Sesforum_Form_Admin_Moderator_Delete();

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $user_id = $this->getRequest()->getParam('user_id');
    $user = Engine_Api::_()->getItem('user', $user_id);

    $forum_id = $this->getRequest()->getParam('forum_id');
    $sesforum = Engine_Api::_()->getItem('sesforum_forum', $forum_id);
    $list = $sesforum->getModeratorList();
    $list->remove($user);
    return $this->_forward('success', 'utility', 'core', array(
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('Moderator Removed')),
            'layout' => 'default-simple',
            'parentRefresh' => true,
    ));
  }

  public function deleteCategoryAction()
  {
    $form = $this->view->form = new Sesforum_Form_Admin_Category_Delete();

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $table = Engine_Api::_()->getItemTable('sesforum_category');
    $db = $table->getAdapter();
    $db->beginTransaction();
    $category_id = $this->getRequest()->getParam('category_id');
    try
    {
      $category = Engine_Api::_()->getItem('sesforum_category', $category_id);
      $category->delete();
      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
    return $this->_forward('success', 'utility', 'core', array(
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('Category deleted.')),
            'layout' => 'default-simple',
            'parentRefresh' => true
    ));
  }

  public function deleteForumAction()
  {
    $form = $this->view->form = new Sesforum_Form_Admin_Forum_Delete();

    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $table = Engine_Api::_()->getItemTable('sesforum_forum');
    $db = $table->getAdapter();
    $db->beginTransaction();
    $forum_id = $this->getRequest()->getParam('forum_id');
    try
    {
      $sesforum = Engine_Api::_()->getItem('sesforum_forum', $forum_id);
      $sesforum->delete();
      $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
    return $this->_forward('success', 'utility', 'core', array(
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('Forum deleted.')),
            'layout' => 'default-simple',
            'parentRefresh' => true
    ));
  }
    function subCategoryAction(){
        $category_id = $this->_getParam('category_id',0);
        $subcat_id = $this->_getParam('subcat_id' ,0);
        $selectedCategory = $this->_getParam('selected',0);
        if(!$subcat_id && !$category_id)
        {
            echo "";die;
        }
        if($category_id)
            $subcategories = Engine_Api::_()->getDbTable('categories','sesforum')->getSubCat($category_id);
        else if($subcat_id)
             $subcategories = Engine_Api::_()->getDbTable('categories','sesforum')->getSubCat($subcat_id);

        $categoryString = "<option value='0'> </option>";
        foreach($subcategories as $subcategory){
            $selected = "";
            if($selectedCategory == $subcategory['category_id']){
                $selected = "selected='selected'";
            }
            $categoryString .= "<option value='".$subcategory['category_id']."' ".$selected.">".$subcategory['title'].'</option>';
        }
        echo $categoryString;die;
    }
    function subSubCategoryAction(){
        $category_id = $this->_getParam('category_id',0);
        $subcat_id = $this->_getParam('subcat_id' ,0);
        $selectedCategory = $this->_getParam('selected',0);
        if(!$subcat_id && !$category_id)
        {
            echo "";die;
        }
        if($category_id)
            $subcategories = Engine_Api::_()->getDbTable('categories','sesforum')->getSubSubCat($category_id);
        else if($subcat_id)
             $subcategories = Engine_Api::_()->getDbTable('categories','sesforum')->getSubSubCat($subcat_id);

        $categoryString = "<option value='0'> </option>";
        foreach($subcategories as $subcategory){
            $selected = "";
            if($selectedCategory == $subcategory['category_id']){
                $selected = "selected='selected'";
            }
            $categoryString .= "<option value='".$subcategory['category_id']."' ".$selected.">".$subcategory['title'].'</option>';
        }
        echo $categoryString;die;
    }
}
