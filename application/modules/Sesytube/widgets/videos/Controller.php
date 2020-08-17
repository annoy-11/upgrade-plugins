<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Widget_VideosController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $limit = $this->_getParam('limit', 10);
        $this->view->results = Engine_Api::_()->sesytube()->getCategory(array('hasVideo' => true, 'videoDesc' => 'desc', 'limit' => $limit));

    }
}
