<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Team.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageteam_Model_Team extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;

  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
  public function getHref($params = array()) {

    $slug = $this->getSlug();
    $params = array_merge(array(
        'route' => 'sespageteam_entry_view',
        'reset' => true,
        'team_id' => $this->team_id,
        'page_id' => $this->page_id,
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }

  public function getTitle() {
    return $this->name;
  }

  public function getPhotoUrl($type = NULL) {

    $photo_id = $this->photo_id;
    if (empty($photo_id)) {
      $path = Zend_Registry::get('Zend_View')->baseUrl() . '/' . 'application/modules/Sespageteam/externals/images/nophoto_team_thumb_profile.png';
      return $path;
    } elseif ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, '');
      return $file->map();
    }
  }

}