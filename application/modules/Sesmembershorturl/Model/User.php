<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmembershorturl
 * @package    Sesmembershorturl
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: User.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmembershorturl_Model_User extends User_Model_User{
  protected $_shortType = 'user';
  protected $_type = 'user';
  public function getHref($params = array()) {
    if(isset($this->level_id)) {
    $enablecustomurl = Engine_Api::_()->sesmembershorturl()->getLevelValue($this->level_id, 'enablecustomurl', 'value');
    if($enablecustomurl == 1)
      $params['route'] = 'sesmembershorturl_profile_'.$this->level_id;
    else
      $params['route'] = 'user_profilelevel';
    return parent::getHref($params);
    } else {
      return parent::getHref($params);
    }
  }
}
