<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Roles.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesrecipe_Model_DbTable_Roles extends Engine_Db_Table {
  /**
   * Gets a paginator for sesrecipes
   *
   * @param Core_Model_Item_Abstract $user The user to get the messages for
   * @return Zend_Paginator
   */
  public function getRecipeAdmins($params = array()) {
  
    $select = $this->select()->where('recipe_id =?', $params['recipe_id']);
    return Zend_Paginator::factory($select);
  }
  
  public function isRecipeAdmin($recipeId = null, $recipeAdminId = null) {
    return $this->select()->from($this->info('name'), 'role_id')
    ->where('user_id =?', $recipeAdminId)
    ->where('recipe_id =?', $recipeId)->query()->fetchColumn();
  }
}