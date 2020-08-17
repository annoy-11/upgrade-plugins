<?php

class Eblog_AdminImportBlogController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('eblog_admin_main', array(), 'eblog_admin_main_importblog');
    $setting = Engine_Api::_()->getApi('settings', 'core');

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('blog') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('eblog') && $setting->getSetting('eblog.pluginactivated')) {

      $seblogTable = Engine_Api::_()->getDbTable('blogs', 'blog');
      $seblogTableName = $seblogTable->info('name');

      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $coreLikeTableName = $coreLikeTable->info('name');

      $seSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'blog');
      $seSubscriptionsTableName = $seSubscriptionsTable->info('name');

      $sesSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'eblog');
      $sesSubscriptionsTableName = $sesSubscriptionsTable->info('name');

      $coreCommentsTable = Engine_Api::_()->getDbTable('comments', 'core');
      $coreCommentsTableName = $coreCommentsTable->info('name');

      $eblogTable = Engine_Api::_()->getDbTable('blogs', 'eblog');
      $eblogTableName = $eblogTable->info('name');

      $blogRole = Engine_Api::_()->getDbTable('roles', 'eblog');
      $blogRoleName = $blogRole->info('name');

      //Category Work
      $blogCategories = Engine_Api::_()->getDbTable('categories', 'blog');
      $blogCategoriesName = $blogCategories->info('name');
      $eblogCategories = Engine_Api::_()->getDbTable('categories', 'eblog');
      $eblogCategoriesName = $eblogCategories->info('name');

      $selectCategory = $blogCategories->select()
                                      ->from($blogCategoriesName);
      $seBlogCatResults = $blogCategories->fetchAll($selectCategory);
      foreach($seBlogCatResults as $seBlogCatResult) {
        $hasCategory = $eblogCategories->hasCategory(array('category_name' => $seBlogCatResult->category_name));
        if($hasCategory) {
          $db->update('engine4_eblog_categories', array('seblog_categoryid' => $seBlogCatResult->category_id), array("category_id = ?" => $hasCategory));
        } else {
          $eblogCat = $eblogCategories->createRow();
          $eblogCat->category_name = $seBlogCatResult->category_name;
          $eblogCat->title = $seBlogCatResult->category_name;
          $eblogCat->user_id = $seBlogCatResult->user_id;
          $eblogCat->slug = $seBlogCatResult->getSlug();
          $eblogCat->seblog_categoryid = $seBlogCatResult->category_id;
          $eblogCat->save();
          $eblogCat->order = $eblogCat->category_id;
          $eblogCat->save();
        }
      }

        $storageTable = Engine_Api::_()->getDbtable('files', 'storage');

        $eblogsSelect = $eblogTable->select()
                                    ->from($eblogTableName, array('seblog_id'))
                                    ->where('seblog_id <> ?', 0);
        $eblogResults = $eblogTable->fetchAll($eblogsSelect);
        $importedBlogArray = array();
        foreach($eblogResults as $eblogResult) {
            $importedBlogArray[] = $eblogResult->seblog_id;
        }

        $selectSeBlogs = $seblogTable->select()->from($seblogTableName);
        if(count($importedBlogArray) > 0) {
            $selectSeBlogs->where('blog_id NOT IN (?)', $importedBlogArray);
        }
        $selectSeBlogs->order('blog_id ASC');
      $this->view->seBlogResults = $seBlogResults = $seblogTable->fetchAll($selectSeBlogs);
      if ($seBlogResults && isset($_GET['is_ajax']) && $_GET['is_ajax']) {
        try {
          foreach ($seBlogResults as $seBlogResult) {

            $se_blogId = $seBlogResult->blog_id;
            if ($se_blogId) {

              $eblog = $eblogTable->createRow();
              $eblog->title = $seBlogResult->title;
              $eblog->custom_url = $seBlogResult->getSlug();
              $eblog->body = $seBlogResult->body;
              $eblog->owner_type = $seBlogResult->owner_type;
              $eblog->category_id = $seBlogResult->category_id;
              $eblog->owner_id = $seBlogResult->owner_id;
              $eblog->search = $seBlogResult->search;
              $eblog->view_count = $seBlogResult->view_count;
              $eblog->comment_count = $seBlogResult->comment_count;
              $eblog->creation_date = $seBlogResult->creation_date;
              $eblog->modified_date = $seBlogResult->modified_date;
              $eblog->publish_date = $seBlogResult->creation_date;
              $eblog->seo_title = $seBlogResult->title;
              $eblog->seo_keywords = $seBlogResult->title;
              $eblog->save();

            if (!empty($seBlogResult->photo_id)) {
                $photoImport = Engine_Api::_()->getDbtable('files', 'storage')->fetchRow(array('file_id = ?' => $seBlogResult->photo_id
                ));
                if (!empty($photoImport)) {
                    $eblog->photo_id = Engine_Api::_()->sesbasic()->setPhoto($photoImport->storage_path, false,false,'eblog','eblog_blog','',$eblog,true);
                    $eblog->save();
                    //$eblog->setPhoto($photoImport->storage_path);
                }
            }

              if($seBlogResult->category_id) {
                $hasCategoryId = $eblogCategories->hasCategoryId(array('seblog_categoryid' => $seBlogResult->category_id));
                if($hasCategoryId) {
                  $eblog->category_id = $hasCategoryId;
                  $eblog->save();
                }
              }
              $eblog->creation_date = $seBlogResult->creation_date;
              $eblog->modified_date = $seBlogResult->modified_date;
              $eblog->publish_date = $seBlogResult->creation_date;
              $eblog->save();
              //eblog blog id.
              $eblogId = $eblog->blog_id;

              //Role Created to owner
              $eblogRole = $blogRole->createRow();
              $eblogRole->user_id = $eblog->owner_id;
              $eblogRole->blog_id = $eblogId;
              $eblogRole->save();

              //Core Tag Table Work
              $tagTitle = '';
              $seBlogTags = $seBlogResult->tags()->getTagMaps();
              foreach ($seBlogTags as $tag) {
                $user = Engine_Api::_()->getItem('user', $seBlogResult->owner_id);
                if ($tagTitle != '')
                  $tagTitle .= ', ';
                $tagTitle .= $tag->getTag()->getTitle();
                $tags = array_filter(array_map("trim", preg_split('/[,]+/', $tagTitle)));
                $eblog->tags()->setTagMaps($user, $tags);
              }

              //Subscribe Table
              $selectseSubscriptions = $seSubscriptionsTable->select()
                                      ->from($seSubscriptionsTableName);
              $seSubscriptionsResults = $seSubscriptionsTable->fetchAll($selectseSubscriptions);
              foreach ($seSubscriptionsResults as $seSubscriptionsResult) {
                $sesSubscriptionsBlog = $sesSubscriptionsTable->createRow();
                $sesSubscriptionsBlog->user_id = $seSubscriptionsResult->user_id;
                $sesSubscriptionsBlog->subscriber_user_id = $seSubscriptionsResult->subscriber_user_id;;
                $sesSubscriptionsBlog->save();
              }

              //Core like table data
              $selectPlaylistLike = $coreLikeTable->select()
                      ->from($coreLikeTableName)
                      ->where('resource_id = ?', $se_blogId)
                      ->where('resource_type = ?', 'blog');
              $seblogLikeResults = $coreLikeTable->fetchAll($selectPlaylistLike);
              foreach ($seblogLikeResults as $seblogLikeResult) {
                $like = Engine_Api::_()->getItem('core_like', $seblogLikeResult->like_id);
                $coreLikeBlog = $coreLikeTable->createRow();
                $coreLikeBlog->resource_type = 'eblog_blog';
                $coreLikeBlog->resource_id = $eblogId;
                $coreLikeBlog->poster_type = 'user';
                $coreLikeBlog->poster_id = $like->poster_id;
                //$coreLikeBlog->creation_date = $like->creation_date;
                $coreLikeBlog->save();
              }

              //Core comments table data
              $selectSeBlogComments = $coreCommentsTable->select()
                      ->from($coreCommentsTableName)
                      ->where('resource_id = ?', $se_blogId)
                      ->where('resource_type = ?', 'blog');
              $seBlogCommentsResults = $coreCommentsTable->fetchAll($selectSeBlogComments);
              foreach ($seBlogCommentsResults as $seBlogCommentsResult) {
                $comment = Engine_Api::_()->getItem('core_comment', $seBlogCommentsResult->comment_id);

                $coreCommentBlog = $coreCommentsTable->createRow();
                $coreCommentBlog->resource_type = 'eblog_blog';
                $coreCommentBlog->resource_id = $eblogId;
                $coreCommentBlog->poster_type = 'user';
                $coreCommentBlog->poster_id = $comment->poster_id;
                $coreCommentBlog->body = $comment->body;
                $coreCommentBlog->creation_date = $comment->creation_date;
                $coreCommentBlog->like_count = $comment->like_count;
                $coreCommentBlog->save();
              }


              //Privacy work
              $auth = Engine_Api::_()->authorization()->context;
              $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

              foreach ($roles as $role) {
                if ($auth->isAllowed($eblog, $role, 'view')) {
                  $values['auth_view'] = $role;
                }
              }
              foreach ($roles as $role) {
                if ($auth->isAllowed($eblog, $role, 'comment')) {
                  $values['auth_comment'] = $role;
                }
              }

              $viewMax = array_search($values['auth_view'], $roles);
              $commentMax = array_search($values['auth_comment'], $roles);
              foreach ($roles as $i => $role) {
                $auth->setAllowed($eblog, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($eblog, $role, 'comment', ($i <= $commentMax));
              }

              $eblog->seblog_id = $seBlogResult->getIdentity();
              $eblog->save();
              //$seBlogResult->blogimport = 1;
              //$seBlogResult->save();
            }
          }
        } catch (Exception $e) {
          //$db->rollBack();
          throw $e;
        }
      }
    }
  }

}
