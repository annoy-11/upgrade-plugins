<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Profilephotos.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Model_DbTable_Profilephotos extends Engine_Db_Table {

  protected $_rowClass = "Sesmember_Model_Profilephoto";

  public function getProfilePhotos() {
    return $this->fetchAll($this->select());
  }

  public function getPhotoId($profiletype_id) {

    $rName = $this->info('name');
    return $this->select()
                    ->from($rName, 'photo_id')
                    ->where('profiletype_id = ?', $profiletype_id)
                    ->query()
                    ->fetchColumn();
  }

}
