<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Bootstrap extends Engine_Application_Bootstrap_Abstract {

    public function __construct($application) {

        parent::__construct($application);

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Sessportz_Plugin_Core);
    }

    protected function _initFrontController() {
        include APPLICATION_PATH . '/application/modules/Sessportz/controllers/Checklicense.php';
    }
}
