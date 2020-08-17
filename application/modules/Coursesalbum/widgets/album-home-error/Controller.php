<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Coursesalbum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Coursesalbum_Widget_AlbumHomeErrorController extends Engine_Content_Widget_Abstract {

    public function indexAction() {
        $this->view->paginator = Engine_Api::_()->getDbTable('albums', 'coursesalbum')->getAlbumPaginator(array());
        if (count($this->view->paginator) > 0)
            return $this->setNoRender();
    }
}
