<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Watchlater.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessvideo_Model_Watchlater extends Core_Model_Item_Abstract {

  protected $_parent_type = 'user';
  protected $_owner_type = 'user';
  protected $_parent_is_owner = true;
  protected $_type = 'video';
  protected $_searchTriggers = false;

  public function getHref($params = array()) {
    $params = array_merge(array(
        'route' => 'sesbusinessvideo_view',
        'reset' => true,
        'user_id' => $this->owner_id,
        'video_id' => $this->video_id,
        'slug' => $this->getSlug(),
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }

}
