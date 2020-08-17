<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Widget_FooterNewsletterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

        $this->view->bgimage = $this->_getParam('bgimage', null);
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        if(!empty($viewer_id))
            return $this->setNoRender();

        if(!empty($viewer_id)) {
            $isExist = Engine_Api::_()->getDbTable('newsletteremails', 'sessportz')->isExist($viewer->email);
            if($isExist)
                return $this->setNoRender();
        }
  }

}
