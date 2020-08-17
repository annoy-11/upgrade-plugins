<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminImportListingController.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_AdminImportListingController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslisting_admin_main', array(), 'seslisting_admin_main_importlisting');
    $setting = Engine_Api::_()->getApi('settings', 'core');

    if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('listing') && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seslisting') && $setting->getSetting('seslisting.pluginactivated')) {

      $selistingTable = Engine_Api::_()->getDbTable('seslistings', 'listing');
      $selistingTableName = $selistingTable->info('name');

      $coreLikeTable = Engine_Api::_()->getDbTable('likes', 'core');
      $coreLikeTableName = $coreLikeTable->info('name');

      $seSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'listing');
      $seSubscriptionsTableName = $seSubscriptionsTable->info('name');

      $sesSubscriptionsTable = Engine_Api::_()->getDbTable('subscriptions', 'seslisting');
      $sesSubscriptionsTableName = $sesSubscriptionsTable->info('name');

      $coreCommentsTable = Engine_Api::_()->getDbTable('comments', 'core');
      $coreCommentsTableName = $coreCommentsTable->info('name');

      $seslistingTable = Engine_Api::_()->getDbTable('seslistings', 'seslisting');
      $seslistingTableName = $seslistingTable->info('name');

      $listingRole = Engine_Api::_()->getDbTable('roles', 'seslisting');
      $listingRoleName = $listingRole->info('name');

      //Category Work
      $listingCategories = Engine_Api::_()->getDbTable('categories', 'listing');
      $listingCategoriesName = $listingCategories->info('name');
      $sesListingCategories = Engine_Api::_()->getDbTable('categories', 'seslisting');
      $sesListingCategoriesName = $sesListingCategories->info('name');

      $selectCategory = $listingCategories->select()
                                      ->from($listingCategoriesName);
      $seListingCatResults = $listingCategories->fetchAll($selectCategory);
      foreach($seListingCatResults as $seListingCatResult) {
        $hasCategory = $sesListingCategories->hasCategory(array('category_name' => $seListingCatResult->category_name));
        if($hasCategory) {
          $db->update('engine4_seslisting_categories', array('selisting_categoryid' => $seListingCatResult->category_id), array("category_id = ?" => $hasCategory));
        } else {
          $sesListingCat = $sesListingCategories->createRow();
          $sesListingCat->category_name = $seListingCatResult->category_name;
          $sesListingCat->title = $seListingCatResult->category_name;
          $sesListingCat->user_id = $seListingCatResult->user_id;
          $sesListingCat->slug = $seListingCatResult->getSlug();
          $sesListingCat->selisting_categoryid = $seListingCatResult->category_id;
          $sesListingCat->save();
          $sesListingCat->order = $sesListingCat->category_id;
          $sesListingCat->save();
        }
      }

        $storageTable = Engine_Api::_()->getDbtable('files', 'storage');

        $sesListingsSelect = $seslistingTable->select()
                                    ->from($seslistingTableName, array('selisting_id'))
                                    ->where('selisting_id <> ?', 0);
        $sesListingResults = $seslistingTable->fetchAll($sesListingsSelect);
        $importedListingArray = array();
        foreach($sesListingResults as $sesListingResult) {
            $importedListingArray[] = $sesListingResult->selisting_id;
        }

        $selectSeListings = $selistingTable->select()->from($selistingTableName);
        if(count($importedListingArray) > 0) {
            $selectSeListings->where('listing_id NOT IN (?)', $importedListingArray);
        }
        $selectSeListings->order('listing_id ASC');
      $this->view->seListingResults = $seListingResults = $selistingTable->fetchAll($selectSeListings);
      if ($seListingResults && isset($_GET['is_ajax']) && $_GET['is_ajax']) {
        try {
          foreach ($seListingResults as $seListingResult) {

            $se_listingId = $seListingResult->listing_id;
            if ($se_listingId) {

              $sesListing = $seslistingTable->createRow();
              $sesListing->title = $seListingResult->title;
              $sesListing->custom_url = $seListingResult->getSlug();
              $sesListing->body = $seListingResult->body;
              $sesListing->owner_type = $seListingResult->owner_type;
              $sesListing->category_id = $seListingResult->category_id;
              $sesListing->owner_id = $seListingResult->owner_id;
              $sesListing->search = $seListingResult->search;
              $sesListing->view_count = $seListingResult->view_count;
              $sesListing->comment_count = $seListingResult->comment_count;
              $sesListing->creation_date = $seListingResult->creation_date;
              $sesListing->modified_date = $seListingResult->modified_date;
              $sesListing->publish_date = $seListingResult->creation_date;
              $sesListing->seo_title = $seListingResult->title;
              $sesListing->seo_keywords = $seListingResult->title;
              $sesListing->save();

            if (!empty($seListingResult->photo_id)) {
                $photoImport = Engine_Api::_()->getDbtable('files', 'storage')->fetchRow(array('file_id = ?' => $seListingResult->photo_id
                ));
                if (!empty($photoImport)) {
                    $sesListing->photo_id = Engine_Api::_()->sesbasic()->setPhoto($photoImport->storage_path, false,false,'seslisting','seslisting','',$sesListing,true);
                    $sesListing->save();
                    //$sesListing->setPhoto($photoImport->storage_path);
                }
            }

              if($seListingResult->category_id) {
                $hasCategoryId = $sesListingCategories->hasCategoryId(array('selisting_categoryid' => $seListingResult->category_id));
                if($hasCategoryId) {
                  $sesListing->category_id = $hasCategoryId;
                  $sesListing->save();
                }
              }
              $sesListing->creation_date = $seListingResult->creation_date;
              $sesListing->modified_date = $seListingResult->modified_date;
              $sesListing->publish_date = $seListingResult->creation_date;
              $sesListing->save();
              //seslisting listing id.
              $sesListingId = $sesListing->listing_id;

              //Role Created to owner
              $sesListingRole = $listingRole->createRow();
              $sesListingRole->user_id = $sesListing->owner_id;
              $sesListingRole->listing_id = $sesListingId;
              $sesListingRole->save();

              //Core Tag Table Work
              $tagTitle = '';
              $seListingTags = $seListingResult->tags()->getTagMaps();
              foreach ($seListingTags as $tag) {
                $user = Engine_Api::_()->getItem('user', $seListingResult->owner_id);
                if ($tagTitle != '')
                  $tagTitle .= ', ';
                $tagTitle .= $tag->getTag()->getTitle();
                $tags = array_filter(array_map("trim", preg_split('/[,]+/', $tagTitle)));
                $sesListing->tags()->setTagMaps($user, $tags);
              }

              //Subscribe Table
              $selectseSubscriptions = $seSubscriptionsTable->select()
                                      ->from($seSubscriptionsTableName);
              $seSubscriptionsResults = $seSubscriptionsTable->fetchAll($selectseSubscriptions);
              foreach ($seSubscriptionsResults as $seSubscriptionsResult) {
                $sesSubscriptionsListing = $sesSubscriptionsTable->createRow();
                $sesSubscriptionsListing->user_id = $seSubscriptionsResult->user_id;
                $sesSubscriptionsListing->subscriber_user_id = $seSubscriptionsResult->subscriber_user_id;;
                $sesSubscriptionsListing->save();
              }

              //Core like table data
              $selectPlaylistLike = $coreLikeTable->select()
                      ->from($coreLikeTableName)
                      ->where('resource_id = ?', $se_listingId)
                      ->where('resource_type = ?', 'listing');
              $selistingLikeResults = $coreLikeTable->fetchAll($selectPlaylistLike);
              foreach ($selistingLikeResults as $selistingLikeResult) {
                $like = Engine_Api::_()->getItem('core_like', $selistingLikeResult->like_id);
                $coreLikeListing = $coreLikeTable->createRow();
                $coreLikeListing->resource_type = 'seslisting';
                $coreLikeListing->resource_id = $sesListingId;
                $coreLikeListing->poster_type = 'user';
                $coreLikeListing->poster_id = $like->poster_id;
                //$coreLikeListing->creation_date = $like->creation_date;
                $coreLikeListing->save();
              }

              //Core comments table data
              $selectSeListingComments = $coreCommentsTable->select()
                      ->from($coreCommentsTableName)
                      ->where('resource_id = ?', $se_listingId)
                      ->where('resource_type = ?', 'listing');
              $seListingCommentsResults = $coreCommentsTable->fetchAll($selectSeListingComments);
              foreach ($seListingCommentsResults as $seListingCommentsResult) {
                $comment = Engine_Api::_()->getItem('core_comment', $seListingCommentsResult->comment_id);

                $coreCommentListing = $coreCommentsTable->createRow();
                $coreCommentListing->resource_type = 'seslisting';
                $coreCommentListing->resource_id = $sesListingId;
                $coreCommentListing->poster_type = 'user';
                $coreCommentListing->poster_id = $comment->poster_id;
                $coreCommentListing->body = $comment->body;
                $coreCommentListing->creation_date = $comment->creation_date;
                $coreCommentListing->like_count = $comment->like_count;
                $coreCommentListing->save();
              }


              //Privacy work
              $auth = Engine_Api::_()->authorization()->context;
              $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

              foreach ($roles as $role) {
                if ($auth->isAllowed($sesListing, $role, 'view')) {
                  $values['auth_view'] = $role;
                }
              }
              foreach ($roles as $role) {
                if ($auth->isAllowed($sesListing, $role, 'comment')) {
                  $values['auth_comment'] = $role;
                }
              }

              $viewMax = array_search($values['auth_view'], $roles);
              $commentMax = array_search($values['auth_comment'], $roles);
              foreach ($roles as $i => $role) {
                $auth->setAllowed($sesListing, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($sesListing, $role, 'comment', ($i <= $commentMax));
              }

              $sesListing->selisting_id = $seListingResult->getIdentity();
              $sesListing->save();
              //$seListingResult->listingimport = 1;
              //$seListingResult->save();
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
