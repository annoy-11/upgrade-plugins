<?php

class Sesarticle_AdminImportArticleController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesarticle_admin_main', array(), 'sesarticle_admin_main_importarticle');
    $setting = Engine_Api::_()->getApi('settings', 'core');

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('article') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesarticle') && $setting->getSetting('sesarticle.pluginactivated')) {

      $searticleTable = Engine_Api::_()->getDbTable('articles', 'article');
      $searticleTableName = $searticleTable->info('name');

      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $coreLikeTableName = $coreLikeTable->info('name');
      
      $seSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'article');
      $seSubscriptionsTableName = $seSubscriptionsTable->info('name');
      
      $sesSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'sesarticle');
      $sesSubscriptionsTableName = $sesSubscriptionsTable->info('name');

      $coreCommentsTable = Engine_Api::_()->getDbTable('comments', 'core');
      $coreCommentsTableName = $coreCommentsTable->info('name');

      $sesarticleTable = Engine_Api::_()->getDbTable('sesarticles', 'sesarticle');
      $sesarticleTableName = $sesarticleTable->info('name');

      $articleRole = Engine_Api::_()->getDbTable('roles', 'sesarticle');
      $articleRoleName = $articleRole->info('name');
      
      //Category Work
      $articleCategories = Engine_Api::_()->getDbTable('categories', 'article');
      $articleCategoriesName = $articleCategories->info('name');
      $sesArticleCategories = Engine_Api::_()->getDbTable('categories', 'sesarticle');
      $sesArticleCategoriesName = $sesArticleCategories->info('name');
      
      $selectCategory = $articleCategories->select()
                                      ->from($articleCategoriesName);
      $seArticleCatResults = $articleCategories->fetchAll($selectCategory);
      foreach($seArticleCatResults as $seArticleCatResult) {
        $hasCategory = $sesArticleCategories->hasCategory(array('category_name' => $seArticleCatResult->category_name));
        if($hasCategory) {
          $db->update('engine4_sesarticle_categories', array('searticle_categoryid' => $seArticleCatResult->category_id), array("category_id = ?" => $hasCategory));
        } else {
          $sesArticleCat = $sesArticleCategories->createRow();
          $sesArticleCat->category_name = $seArticleCatResult->category_name;
          $sesArticleCat->title = $seArticleCatResult->category_name;
          $sesArticleCat->user_id = $seArticleCatResult->user_id;
          $sesArticleCat->slug = $seArticleCatResult->getSlug();
          $sesArticleCat->searticle_categoryid = $seArticleCatResult->category_id;
          $sesArticleCat->save();
          $sesArticleCat->order = $sesArticleCat->category_id;
          $sesArticleCat->save();
        }
      }
      
      $storageTable = Engine_Api::_()->getDbtable('files', 'storage');

      $selectSeArticles = $searticleTable->select()
              ->from($searticleTableName)
              ->where('articleimport = ?', 0)
              ->order('article_id ASC');
      $this->view->seArticleResults = $seArticleResults = $searticleTable->fetchAll($selectSeArticles);
      if ($seArticleResults && isset($_GET['is_ajax']) && $_GET['is_ajax']) {
        try {
          foreach ($seArticleResults as $seArticleResult) {

            $se_articleId = $seArticleResult->article_id;
            if ($se_articleId) {
             
              $sesArticle = $sesarticleTable->createRow();
              $sesArticle->title = $seArticleResult->title;
              $sesArticle->custom_url = $seArticleResult->getSlug();
              $sesArticle->body = $seArticleResult->body;
              $sesArticle->owner_type = $seArticleResult->owner_type;
              $sesArticle->category_id = $seArticleResult->category_id;
              $sesArticle->owner_id = $seArticleResult->owner_id;
              $sesArticle->search = $seArticleResult->search;
              $sesArticle->view_count = $seArticleResult->view_count;
              $sesArticle->comment_count = $seArticleResult->comment_count;
              $sesArticle->creation_date = $seArticleResult->creation_date;
              $sesArticle->modified_date = $seArticleResult->modified_date;
              $sesArticle->publish_date = $seArticleResult->creation_date;
              $sesArticle->seo_title = $seArticleResult->title;
              $sesArticle->seo_keywords = $seArticleResult->title;
              $sesArticle->save();
              
              if($seArticleResult->category_id) {
                $hasCategoryId = $sesArticleCategories->hasCategoryId(array('searticle_categoryid' => $seArticleResult->category_id));
                if($hasCategoryId) {
                  $sesArticle->category_id = $hasCategoryId;
                  $sesArticle->save();                
                }              
              }
              $sesArticle->creation_date = $seArticleResult->creation_date;
              $sesArticle->modified_date = $seArticleResult->modified_date;
              $sesArticle->publish_date = $seArticleResult->creation_date;
              $sesArticle->save();
              //sesarticle article id.
              $sesArticleId = $sesArticle->article_id;
              
              //Role Created to owner
              $sesArticleRole = $articleRole->createRow();
              $sesArticleRole->user_id = $sesArticle->owner_id;
              $sesArticleRole->article_id = $sesArticleId;
              $sesArticleRole->save();    
              
              //Core Tag Table Work
              $tagTitle = '';
              $seArticleTags = $seArticleResult->tags()->getTagMaps();              
              foreach ($seArticleTags as $tag) {
                $user = Engine_Api::_()->getItem('user', $seArticleResult->owner_id);
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
                $sesSubscriptionsArticle = $sesSubscriptionsTable->createRow();
                $sesSubscriptionsArticle->user_id = $seSubscriptionsResult->user_id;
                $sesSubscriptionsArticle->subscriber_user_id = $seSubscriptionsResult->subscriber_user_id;;
                $sesSubscriptionsArticle->save();
              }

              //Core like table data
              $selectPlaylistLike = $coreLikeTable->select()
                      ->from($coreLikeTableName)
                      ->where('resource_id = ?', $se_articleId)
                      ->where('resource_type = ?', 'article');
              $searticleLikeResults = $coreLikeTable->fetchAll($selectPlaylistLike);
              foreach ($searticleLikeResults as $searticleLikeResult) {
                $like = Engine_Api::_()->getItem('core_like', $searticleLikeResult->like_id);
                $coreLikeArticle = $coreLikeTable->createRow();
                $coreLikeArticle->resource_type = 'sesarticle';
                $coreLikeArticle->resource_id = $sesArticleId;
                $coreLikeArticle->poster_type = 'user';
                $coreLikeArticle->poster_id = $like->poster_id;
                //$coreLikeArticle->creation_date = $like->creation_date;
                $coreLikeArticle->save();
              }

              //Core comments table data
              $selectSeArticleComments = $coreCommentsTable->select()
                      ->from($coreCommentsTableName)
                      ->where('resource_id = ?', $se_articleId)
                      ->where('resource_type = ?', 'article');
              $seArticleCommentsResults = $coreCommentsTable->fetchAll($selectSeArticleComments);
              foreach ($seArticleCommentsResults as $seArticleCommentsResult) {
                $comment = Engine_Api::_()->getItem('core_comment', $seArticleCommentsResult->comment_id);

                $coreCommentArticle = $coreCommentsTable->createRow();
                $coreCommentArticle->resource_type = 'sesarticle';
                $coreCommentArticle->resource_id = $sesArticleId;
                $coreCommentArticle->poster_type = 'user';
                $coreCommentArticle->poster_id = $comment->poster_id;
                $coreCommentArticle->body = $comment->body;
                $coreCommentArticle->creation_date = $comment->creation_date;
                $coreCommentArticle->like_count = $comment->like_count;
                $coreCommentArticle->save();
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
              

              $seArticleResult->articleimport = 1;
              $seArticleResult->save();
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
