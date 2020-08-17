<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslinkedin
 * @package    Seslinkedin
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-05-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslinkedin_Widget_HomePhotoController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {


    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Friend count
    $this->view->friendCount = $viewer->membership()->getMemberCount($viewer);

    $this->view->photo = '';
    if (isset($viewer->coverphoto) && $viewer->coverphoto != 0) {
      $this->view->photo = Engine_Api::_()->getItemTable('storage_file')->getFile($viewer->coverphoto, 'thumb.cover')->map();
    }
  }
}
