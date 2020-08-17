<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminImportBlogController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_AdminImportProductController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main', array(), 'sesproduct_admin_main_importproduct');
    $setting = Engine_Api::_()->getApi('settings', 'core');

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('product') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesproduct') && $setting->getSetting('sesproduct.pluginactivated')) {

      $seproductTable = Engine_Api::_()->getDbTable('sesproducts', 'product');
      $seproductTableName = $seproductTable->info('name');

      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $coreLikeTableName = $coreLikeTable->info('name');

      $seSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'product');
      $seSubscriptionsTableName = $seSubscriptionsTable->info('name');

      $sesSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'sesproduct');
      $sesSubscriptionsTableName = $sesSubscriptionsTable->info('name');

      $coreCommentsTable = Engine_Api::_()->getDbTable('comments', 'core');
      $coreCommentsTableName = $coreCommentsTable->info('name');

      $sesproductTable = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct');
      $sesproductTableName = $sesproductTable->info('name');

      $productRole = Engine_Api::_()->getDbTable('roles', 'sesproduct');
      $productRoleName = $productRole->info('name');

      //Category Work
      $productCategories = Engine_Api::_()->getDbTable('categories', 'product');
      $productCategoriesName = $productCategories->info('name');
      $sesProductCategories = Engine_Api::_()->getDbTable('categories', 'sesproduct');
      $sesProductCategoriesName = $sesProductCategories->info('name');

      $selectCategory = $productCategories->select()
                                      ->from($productCategoriesName);
      $seProductCatResults = $productCategories->fetchAll($selectCategory);
      foreach($seProductCatResults as $seProductCatResult) {
        $hasCategory = $sesProductCategories->hasCategory(array('category_name' => $seProductCatResult->category_name));
        if($hasCategory) {
          $db->update('engine4_sesproduct_categories', array('seproduct_categoryid' => $seProductCatResult->category_id), array("category_id = ?" => $hasCategory));
        } else {
          $sesProductCat = $sesProductCategories->createRow();
          $sesProductCat->category_name = $seProductCatResult->category_name;
          $sesProductCat->title = $seProductCatResult->category_name;
          $sesProductCat->user_id = $seProductCatResult->user_id;
          $sesProductCat->slug = $seProductCatResult->getSlug();
          $sesProductCat->seproduct_categoryid = $seProductCatResult->category_id;
          $sesProductCat->save();
          $sesProductCat->order = $sesProductCat->category_id;
          $sesProductCat->save();
        }
      }

        $storageTable = Engine_Api::_()->getDbtable('files', 'storage');

        $sesProductsSelect = $sesproductTable->select()
                                    ->from($sesproductTableName, array('seproduct_id'))
                                    ->where('seproduct_id <> ?', 0);
        $sesProductResults = $sesproductTable->fetchAll($sesProductsSelect);
        $importedProductArray = array();
        foreach($sesProductResults as $sesProductResult) {
            $importedProductArray[] = $sesProductResult->seproduct_id;
        }

        $selectSeProducts = $seproductTable->select()->from($seproductTableName);
        if(count($importedProductArray) > 0) {
            $selectSeProducts->where('product_id NOT IN (?)', $importedProductArray);
        }
        $selectSeProducts->order('product_id ASC');
      $this->view->seProductResults = $seProductResults = $seproductTable->fetchAll($selectSeProducts);
      if ($seProductResults && isset($_GET['is_ajax']) && $_GET['is_ajax']) {
        try {
          foreach ($seProductResults as $seProductResult) {

            $se_productId = $seProductResult->product_id;
            if ($se_productId) {

              $sesProduct = $sesproductTable->createRow();
              $sesProduct->title = $seProductResult->title;
              $sesProduct->custom_url = $seProductResult->getSlug();
              $sesProduct->body = $seProductResult->body;
              $sesProduct->owner_type = $seProductResult->owner_type;
              $sesProduct->category_id = $seProductResult->category_id;
              $sesProduct->owner_id = $seProductResult->owner_id;
              $sesProduct->search = $seProductResult->search;
              $sesProduct->view_count = $seProductResult->view_count;
              $sesProduct->comment_count = $seProductResult->comment_count;
              $sesProduct->creation_date = $seProductResult->creation_date;
              $sesProduct->modified_date = $seProductResult->modified_date;
              $sesProduct->publish_date = $seProductResult->creation_date;
              $sesProduct->seo_title = $seProductResult->title;
              $sesProduct->seo_keywords = $seProductResult->title;
              $sesProduct->save();

              if($seProductResult->category_id) {
                $hasCategoryId = $sesProductCategories->hasCategoryId(array('seproduct_categoryid' => $seProductResult->category_id));
                if($hasCategoryId) {
                  $sesProduct->category_id = $hasCategoryId;
                  $sesProduct->save();
                }
              }
              $sesProduct->creation_date = $seProductResult->creation_date;
              $sesProduct->modified_date = $seProductResult->modified_date;
              $sesProduct->publish_date = $seProductResult->creation_date;
              $sesProduct->save();
              //sesproduct product id.
              $sesProductId = $sesProduct->product_id;

              //Role Created to owner
              $sesProductRole = $productRole->createRow();
              $sesProductRole->user_id = $sesProduct->owner_id;
              $sesProductRole->product_id = $sesProductId;
              $sesProductRole->save();

              //Core Tag Table Work
              $tagTitle = '';
              $seProductTags = $seProductResult->tags()->getTagMaps();
              foreach ($seProductTags as $tag) {
                $user = Engine_Api::_()->getItem('user', $seProductResult->owner_id);
                if ($tagTitle != '')
                  $tagTitle .= ', ';
                $tagTitle .= $tag->getTag()->getTitle();
                $tags = array_filter(array_map("trim", preg_split('/[,]+/', $tagTitle)));
                $sesProduct->tags()->setTagMaps($user, $tags);
              }

              //Subscribe Table
              $selectseSubscriptions = $seSubscriptionsTable->select()
                                      ->from($seSubscriptionsTableName);
              $seSubscriptionsResults = $seSubscriptionsTable->fetchAll($selectseSubscriptions);
              foreach ($seSubscriptionsResults as $seSubscriptionsResult) {
                $sesSubscriptionsProduct = $sesSubscriptionsTable->createRow();
                $sesSubscriptionsProduct->user_id = $seSubscriptionsResult->user_id;
                $sesSubscriptionsProduct->subscriber_user_id = $seSubscriptionsResult->subscriber_user_id;;
                $sesSubscriptionsProduct->save();
              }

              //Core like table data
              $selectPlaylistLike = $coreLikeTable->select()
                      ->from($coreLikeTableName)
                      ->where('resource_id = ?', $se_productId)
                      ->where('resource_type = ?', 'product');
              $seproductLikeResults = $coreLikeTable->fetchAll($selectPlaylistLike);
              foreach ($seproductLikeResults as $seproductLikeResult) {
                $like = Engine_Api::_()->getItem('core_like', $seproductLikeResult->like_id);
                $coreLikeProduct = $coreLikeTable->createRow();
                $coreLikeProduct->resource_type = 'sesproduct';
                $coreLikeProduct->resource_id = $sesProductId;
                $coreLikeProduct->poster_type = 'user';
                $coreLikeProduct->poster_id = $like->poster_id;
                //$coreLikeProduct->creation_date = $like->creation_date;
                $coreLikeProduct->save();
              }

              //Core comments table data
              $selectSeProductComments = $coreCommentsTable->select()
                      ->from($coreCommentsTableName)
                      ->where('resource_id = ?', $se_productId)
                      ->where('resource_type = ?', 'product');
              $seProductCommentsResults = $coreCommentsTable->fetchAll($selectSeProductComments);
              foreach ($seProductCommentsResults as $seProductCommentsResult) {
                $comment = Engine_Api::_()->getItem('core_comment', $seProductCommentsResult->comment_id);

                $coreCommentProduct = $coreCommentsTable->createRow();
                $coreCommentProduct->resource_type = 'sesproduct';
                $coreCommentProduct->resource_id = $sesProductId;
                $coreCommentProduct->poster_type = 'user';
                $coreCommentProduct->poster_id = $comment->poster_id;
                $coreCommentProduct->body = $comment->body;
                $coreCommentProduct->creation_date = $comment->creation_date;
                $coreCommentProduct->like_count = $comment->like_count;
                $coreCommentProduct->save();
              }


              //Privacy work
              $auth = Engine_Api::_()->authorization()->context;
              $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

              foreach ($roles as $role) {
                if ($auth->isAllowed($sesProduct, $role, 'view')) {
                  $values['auth_view'] = $role;
                }
              }
              foreach ($roles as $role) {
                if ($auth->isAllowed($sesProduct, $role, 'comment')) {
                  $values['auth_comment'] = $role;
                }
              }

              $viewMax = array_search($values['auth_view'], $roles);
              $commentMax = array_search($values['auth_comment'], $roles);
              foreach ($roles as $i => $role) {
                $auth->setAllowed($sesProduct, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($sesProduct, $role, 'comment', ($i <= $commentMax));
              }

              $sesProduct->seproduct_id = $seProductResult->getIdentity();
              $sesProduct->save();
              //$seProductResult->productimport = 1;
              //$seProductResult->save();
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
