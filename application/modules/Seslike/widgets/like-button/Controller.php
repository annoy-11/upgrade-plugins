<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslike_Widget_LikeButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();

    if (empty($viewerId))
        return $this->setNoRender();

    if (!Engine_Api::_()->core()->hasSubject())
        return $this->setNoRender();

    $this->view->subject = $item = Engine_Api::_()->core()->getSubject();
    $this->view->subject_id = $subject_id = $item->getIdentity();

    if($item->getType() == 'user') {
        $isUserSettingExist = Engine_Api::_()->getDbTable('mylikesettings', 'seslike')->isUserSettingExist($subject_id);
        if(empty($isUserSettingExist))
            return $this->setNoRender();

        if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seslike.userlike', 0)) {
            return $this->setNoRender();
        }
    }

    $this->view->is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($item, $viewer);
  }
}
