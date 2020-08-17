<?php

class Sesrecipe_AdminImportRecipeController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesrecipe_admin_main', array(), 'sesrecipe_admin_main_importrecipe');
    $setting = Engine_Api::_()->getApi('settings', 'core');

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('recipe') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesrecipe') && $setting->getSetting('sesrecipe.pluginactivated')) {

      $serecipeTable = Engine_Api::_()->getDbTable('recipes', 'recipe');
      $serecipeTableName = $serecipeTable->info('name');

      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $coreLikeTableName = $coreLikeTable->info('name');
      
      $seSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'recipe');
      $seSubscriptionsTableName = $seSubscriptionsTable->info('name');
      
      $sesSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'sesrecipe');
      $sesSubscriptionsTableName = $sesSubscriptionsTable->info('name');

      $coreCommentsTable = Engine_Api::_()->getDbTable('comments', 'core');
      $coreCommentsTableName = $coreCommentsTable->info('name');

      $sesrecipeTable = Engine_Api::_()->getDbTable('recipes', 'sesrecipe');
      $sesrecipeTableName = $sesrecipeTable->info('name');

      $recipeRole = Engine_Api::_()->getDbTable('roles', 'sesrecipe');
      $recipeRoleName = $recipeRole->info('name');
      
      //Category Work
      $recipeCategories = Engine_Api::_()->getDbTable('categories', 'recipe');
      $recipeCategoriesName = $recipeCategories->info('name');
      $sesRecipeCategories = Engine_Api::_()->getDbTable('categories', 'sesrecipe');
      $sesRecipeCategoriesName = $sesRecipeCategories->info('name');
      
      $selectCategory = $recipeCategories->select()
                                      ->from($recipeCategoriesName);
      $seRecipeCatResults = $recipeCategories->fetchAll($selectCategory);
      foreach($seRecipeCatResults as $seRecipeCatResult) {
        $hasCategory = $sesRecipeCategories->hasCategory(array('category_name' => $seRecipeCatResult->category_name));
        if($hasCategory) {
          $db->update('engine4_sesrecipe_categories', array('serecipe_categoryid' => $seRecipeCatResult->category_id), array("category_id = ?" => $hasCategory));
        } else {
          $sesRecipeCat = $sesRecipeCategories->createRow();
          $sesRecipeCat->category_name = $seRecipeCatResult->category_name;
          $sesRecipeCat->title = $seRecipeCatResult->category_name;
          $sesRecipeCat->user_id = $seRecipeCatResult->user_id;
          $sesRecipeCat->slug = $seRecipeCatResult->getSlug();
          $sesRecipeCat->serecipe_categoryid = $seRecipeCatResult->category_id;
          $sesRecipeCat->save();
          $sesRecipeCat->order = $sesRecipeCat->category_id;
          $sesRecipeCat->save();
        }
      }
      
      $storageTable = Engine_Api::_()->getDbtable('files', 'storage');

      $selectSeRecipes = $serecipeTable->select()
              ->from($serecipeTableName)
              ->where('recipeimport = ?', 0)
              ->order('recipe_id ASC');
      $this->view->seRecipeResults = $seRecipeResults = $serecipeTable->fetchAll($selectSeRecipes);
      if ($seRecipeResults && isset($_GET['is_ajax']) && $_GET['is_ajax']) {
        try {
          foreach ($seRecipeResults as $seRecipeResult) {

            $se_recipeId = $seRecipeResult->recipe_id;
            if ($se_recipeId) {
             
              $sesRecipe = $sesrecipeTable->createRow();
              $sesRecipe->title = $seRecipeResult->title;
              $sesRecipe->custom_url = $seRecipeResult->getSlug();
              $sesRecipe->body = $seRecipeResult->body;
              $sesRecipe->owner_type = $seRecipeResult->owner_type;
              $sesRecipe->category_id = $seRecipeResult->category_id;
              $sesRecipe->owner_id = $seRecipeResult->owner_id;
              $sesRecipe->search = $seRecipeResult->search;
              $sesRecipe->view_count = $seRecipeResult->view_count;
              $sesRecipe->comment_count = $seRecipeResult->comment_count;
              $sesRecipe->creation_date = $seRecipeResult->creation_date;
              $sesRecipe->modified_date = $seRecipeResult->modified_date;
              $sesRecipe->publish_date = $seRecipeResult->creation_date;
              $sesRecipe->seo_title = $seRecipeResult->title;
              $sesRecipe->seo_keywords = $seRecipeResult->title;
              $sesRecipe->save();
              
              if($seRecipeResult->category_id) {
                $hasCategoryId = $sesRecipeCategories->hasCategoryId(array('serecipe_categoryid' => $seRecipeResult->category_id));
                if($hasCategoryId) {
                  $sesRecipe->category_id = $hasCategoryId;
                  $sesRecipe->save();                
                }              
              }
              $sesRecipe->creation_date = $seRecipeResult->creation_date;
              $sesRecipe->modified_date = $seRecipeResult->modified_date;
              $sesRecipe->publish_date = $seRecipeResult->creation_date;
              $sesRecipe->save();
              //sesrecipe recipe id.
              $sesRecipeId = $sesRecipe->recipe_id;
              
              //Role Created to owner
              $sesRecipeRole = $recipeRole->createRow();
              $sesRecipeRole->user_id = $sesRecipe->owner_id;
              $sesRecipeRole->recipe_id = $sesRecipeId;
              $sesRecipeRole->save();    
              
              //Core Tag Table Work
              $tagTitle = '';
              $seRecipeTags = $seRecipeResult->tags()->getTagMaps();              
              foreach ($seRecipeTags as $tag) {
                $user = Engine_Api::_()->getItem('user', $seRecipeResult->owner_id);
                if ($tagTitle != '')
                  $tagTitle .= ', ';
                $tagTitle .= $tag->getTag()->getTitle();
                $tags = array_filter(array_map("trim", preg_split('/[,]+/', $tagTitle)));
                $sesRecipe->tags()->setTagMaps($user, $tags);
              }

              //Subscribe Table
              $selectseSubscriptions = $seSubscriptionsTable->select()
                                      ->from($seSubscriptionsTableName);
              $seSubscriptionsResults = $seSubscriptionsTable->fetchAll($selectseSubscriptions);
              foreach ($seSubscriptionsResults as $seSubscriptionsResult) {
                $sesSubscriptionsRecipe = $sesSubscriptionsTable->createRow();
                $sesSubscriptionsRecipe->user_id = $seSubscriptionsResult->user_id;
                $sesSubscriptionsRecipe->subscriber_user_id = $seSubscriptionsResult->subscriber_user_id;;
                $sesSubscriptionsRecipe->save();
              }

              //Core like table data
              $selectPlaylistLike = $coreLikeTable->select()
                      ->from($coreLikeTableName)
                      ->where('resource_id = ?', $se_recipeId)
                      ->where('resource_type = ?', 'recipe');
              $serecipeLikeResults = $coreLikeTable->fetchAll($selectPlaylistLike);
              foreach ($serecipeLikeResults as $serecipeLikeResult) {
                $like = Engine_Api::_()->getItem('core_like', $serecipeLikeResult->like_id);
                $coreLikeRecipe = $coreLikeTable->createRow();
                $coreLikeRecipe->resource_type = 'sesrecipe_recipe';
                $coreLikeRecipe->resource_id = $sesRecipeId;
                $coreLikeRecipe->poster_type = 'user';
                $coreLikeRecipe->poster_id = $like->poster_id;
                //$coreLikeRecipe->creation_date = $like->creation_date;
                $coreLikeRecipe->save();
              }

              //Core comments table data
              $selectSeRecipeComments = $coreCommentsTable->select()
                      ->from($coreCommentsTableName)
                      ->where('resource_id = ?', $se_recipeId)
                      ->where('resource_type = ?', 'recipe');
              $seRecipeCommentsResults = $coreCommentsTable->fetchAll($selectSeRecipeComments);
              foreach ($seRecipeCommentsResults as $seRecipeCommentsResult) {
                $comment = Engine_Api::_()->getItem('core_comment', $seRecipeCommentsResult->comment_id);

                $coreCommentRecipe = $coreCommentsTable->createRow();
                $coreCommentRecipe->resource_type = 'sesrecipe_recipe';
                $coreCommentRecipe->resource_id = $sesRecipeId;
                $coreCommentRecipe->poster_type = 'user';
                $coreCommentRecipe->poster_id = $comment->poster_id;
                $coreCommentRecipe->body = $comment->body;
                $coreCommentRecipe->creation_date = $comment->creation_date;
                $coreCommentRecipe->like_count = $comment->like_count;
                $coreCommentRecipe->save();
              }


              //Privacy work 
              $auth = Engine_Api::_()->authorization()->context;
              $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

              foreach ($roles as $role) {
                if ($auth->isAllowed($sesRecipe, $role, 'view')) {
                  $values['auth_view'] = $role;
                }
              }
              foreach ($roles as $role) {
                if ($auth->isAllowed($sesRecipe, $role, 'comment')) {
                  $values['auth_comment'] = $role;
                }
              }

              $viewMax = array_search($values['auth_view'], $roles);
              $commentMax = array_search($values['auth_comment'], $roles);
              foreach ($roles as $i => $role) {
                $auth->setAllowed($sesRecipe, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($sesRecipe, $role, 'comment', ($i <= $commentMax));
              }
              

              $seRecipeResult->recipeimport = 1;
              $seRecipeResult->save();
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