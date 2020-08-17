<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id Homepages.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Model_DbTable_Homepages extends Engine_Db_Table {

  protected $_rowClass = "Sesmember_Model_Homepage";

  public function getHomepages($type = null) {
    return $this->fetchAll($this->select()->where('type =?', $type));
  }

  public function checkLevelId($levelId = null, $homepageID, $type = null) {
    $query = '%"' . $levelId . '"%';
    if (!empty($homepageID))
      return $this->select()->from($this->info('name'), 'homepage_id')->where("member_levels LIKE '$query'")->where('homepage_id != ?', $homepageID)->where('type =?', $type)->query()->fetchColumn();
    else
      return $this->select()->from($this->info('name'), 'homepage_id')->where("member_levels LIKE '$query'")->where('type =?', $type)->query()->fetchColumn();
  }

}
