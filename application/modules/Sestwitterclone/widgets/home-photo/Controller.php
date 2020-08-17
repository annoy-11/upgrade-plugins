<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sestwitterclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestwitterclone_Widget_HomePhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Friend count
    $this->view->friendCount = $viewer->membership()->getMemberCount($viewer);

    $this->view->photo = '';
    if (isset($viewer->coverphoto) && $viewer->coverphoto != 0) {
      $this->view->photo = Engine_Api::_()->getItemTable('storage_file')->getFile($viewer->coverphoto, 'thumb.cover')->map();
    }
    $this->view->postCount = Engine_Api::_()->sestwitterclone()->postCount($viewer->getIdentity());

    //Multiple friend mode
    $select = $viewer->membership()->getMembersSelect();
    $paginator = Zend_Paginator::factory($select);
    $followCount = $paginator->getTotalItemCount();
    $this->view->followCount = Engine_Api::_()->sesbasic()->number_format_short($followCount);
  }
}
