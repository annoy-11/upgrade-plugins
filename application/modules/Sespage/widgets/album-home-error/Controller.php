<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Widget_AlbumHomeErrorController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('albums', 'sespage')->getAlbumPaginator(array());
    if (count($paginator) > 0)
      return $this->setNoRender();
  }
}