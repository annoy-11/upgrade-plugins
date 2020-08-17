<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Widget_ProductInfoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject())
      return $this->setNoRender();

    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
    $customMetaFields = $this->view->customMetaFields = Engine_Api::_()->sesproduct()->getCustomFieldMapDataProduct($subject);
    if (!count($customMetaFields)) {
      return $this->setNoRender();
    }
  }
}
