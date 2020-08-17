<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_Widget_WriteWishController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $wish = Engine_Api::_()->getApi('settings', 'core')->getSetting('seschristmas.wish', 1);
    if (empty($wish)) {
      return $this->setNoRender();
    }
    $this->view->viewer_id = $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    $christmasTable = Engine_Api::_()->getDbtable('christmas', 'seschristmas');
    $this->view->has_wish = $christmasTable->getWish(array('owner_id' => $viewer_id));
  }

}
