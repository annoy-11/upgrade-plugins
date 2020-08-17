<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Widget_AlbumHomeErrorController extends Engine_Content_Widget_Abstract {

    public function indexAction() {
        $this->view->paginator = Engine_Api::_()->getDbTable('albums', 'estore')->getAlbumPaginator(array());
        if (count($this->view->paginator) > 0)
            return $this->setNoRender();
    }
}
