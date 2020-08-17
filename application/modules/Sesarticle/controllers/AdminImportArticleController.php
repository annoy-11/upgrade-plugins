<?php

class Sesarticle_AdminImportArticleController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesarticle_admin_main', array(), 'sesarticle_admin_main_importarticle');
    $setting = Engine_Api::_()->getApi('settings', 'core');

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('blog') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesarticle') && $setting->getSetting('sesarticle.pluginactivated')) {

      $seblogTable = Engine_Api::_()->getDbTable('blogs', 'blog');
      $seblogTableName = $seblogTable->info('name');

      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $coreLikeTableName = $coreLikeTable->info('name');

      $seSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'blog');
      $seSubscriptionsTableName = $seSubscriptionsTable->info('name');

      $sesSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'sesarticle');
      $sesSubscriptionsTableName = $sesSubscriptionsTable->info('name');

      $coreCommentsTable = Engine_Api::_()->getDbTable('comments', 'core');
      $coreCommentsTableName = $coreCommentsTable->info('name');

      $sesarticleTable = Engine_Api::_()->getDbTable('sesarticles', 'sesarticle');
      $sesarticleTableName = $sesarticleTable->info('name');

      $blogRole = Engine_Api::_()->getDbTable('roles', 'sesarticle');
      $blogRoleName = $blogRole->info('name');

      //Category Work
      $blogCategories = Engine_Api::_()->getDbTable('categories', 'blog');
      $blogCategoriesName = $blogCategories->info('name');
      $sesArticleCategories = Engine_Api::_()->getDbTable('categories', 'sesarticle');
      $sesArticleCategoriesName = $sesArticleCategories->info('name');

      $selectCategory = $blogCategories->select()
                                      ->from($blogCategoriesName);
      $seBlogCatResults = $blogCategories->fetchAll($selectCategory);
      foreach($seBlogCatResults as $seBlogCatResult) {
        $hasCategory = $sesArticleCategories->hasCategory(array('category_name' => $seBlogCatResult->category_name));
        if($hasCategory) {
          $db->update('engine4_sesarticle_categories', array('searticle_categoryid' => $seBlogCatResult->category_id), array("category_id = ?" => $hasCategory));
        } else {
          $sesArticleCat = $sesArticleCategories->createRow();
          $sesArticleCat->category_name = $seBlogCatResult->category_name;
          $sesArticleCat->title = $seBlogCatResult->category_name;
          $sesArticleCat->user_id = $seBlogCatResult->user_id;
          $sesArticleCat->slug = $seBlogCatResult->getSlug();
          $sesArticleCat->searticle_categoryid = $seBlogCatResult->category_id;
          $sesArticleCat->save();
          $sesArticleCat->order = $sesArticleCat->category_id;
          $sesArticleCat->save();
        }
      }

        $storageTable = Engine_Api::_()->getDbtable('files', 'storage');

        $sesArticlesSelect = $sesarticleTable->select()
                                    ->from($sesarticleTableName, array('seblog_id'))
                                    ->where('seblog_id <> ?', 0);
        $sesArticleResults = $sesarticleTable->fetchAll($sesArticlesSelect);
        $importedBlogArray = array();
        foreach($sesArticleResults as $sesArticleResult) {
            $importedBlogArray[] = $sesArticleResult->seblog_id;
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

              $sesArticle = $sesarticleTable->createRow();
              $sesArticle->title = $seBlogResult->title;
              $sesArticle->custom_url = $seBlogResult->getSlug();
              $sesArticle->body = $seBlogResult->body;
              $sesArticle->owner_type = $seBlogResult->owner_type;
              $sesArticle->category_id = $seBlogResult->category_id;
              $sesArticle->owner_id = $seBlogResult->owner_id;
              $sesArticle->search = $seBlogResult->search;
              $sesArticle->view_count = $seBlogResult->view_count;
              $sesArticle->comment_count = $seBlogResult->comment_count;
              $sesArticle->creation_date = $seBlogResult->creation_date;
              $sesArticle->modified_date = $seBlogResult->modified_date;
              $sesArticle->publish_date = $seBlogResult->creation_date;
              $sesArticle->seo_title = $seBlogResult->title;
              $sesArticle->seo_keywords = $seBlogResult->title;
              $sesArticle->save();

              if($seBlogResult->category_id) {
                $hasCategoryId = $sesArticleCategories->hasCategoryId(array('searticle_categoryid' => $seBlogResult->category_id));
                if($hasCategoryId) {
                  $sesArticle->category_id = $hasCategoryId;
                  $sesArticle->save();
                }
              }
              $sesArticle->creation_date = $seBlogResult->creation_date;
              $sesArticle->modified_date = $seBlogResult->modified_date;
              $sesArticle->publish_date = $seBlogResult->creation_date;
              $sesArticle->save();
              //sesarticle blog id.
              $sesArticleId = $sesArticle->article_id;

              //Role Created to owner
              $sesArticleRole = $blogRole->createRow();
              $sesArticleRole->user_id = $sesArticle->owner_id;
              $sesArticleRole->article_id = $sesArticleId;
              $sesArticleRole->save();

              //Core Tag Table Work
              $tagTitle = '';
              $seBlogTags = $seBlogResult->tags()->getTagMaps();
              foreach ($seBlogTags as $tag) {
                $user = Engine_Api::_()->getItem('user', $seBlogResult->owner_id);
                if ($tagTitle != '')
                  $tagTitle .= ', ';
                $tagTitle .= $tag->getTag()->getTitle();
                $tags = array_filter(array_map("trim", preg_split('/[,]+/', $tagTitle)));
                $sesArticle->tags()->setTagMaps($user, $tags);
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
                $coreLikeBlog->resource_type = 'sesarticle';
                $coreLikeBlog->resource_id = $sesArticleId;
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
                $coreCommentBlog->resource_type = 'sesarticle';
                $coreCommentBlog->resource_id = $sesArticleId;
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
                if ($auth->isAllowed($sesArticle, $role, 'view')) {
                  $values['auth_view'] = $role;
                }
              }
              foreach ($roles as $role) {
                if ($auth->isAllowed($sesArticle, $role, 'comment')) {
                  $values['auth_comment'] = $role;
                }
              }

              $viewMax = array_search($values['auth_view'], $roles);
              $commentMax = array_search($values['auth_comment'], $roles);
              foreach ($roles as $i => $role) {
                $auth->setAllowed($sesArticle, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($sesArticle, $role, 'comment', ($i <= $commentMax));
              }

              $sesArticle->seblog_id = $seBlogResult->getIdentity();
              $sesArticle->save();
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
