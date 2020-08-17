<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagethm_Bootstrap extends Engine_Application_Bootstrap_Abstract {

    public function __construct($application) {

        parent::__construct($application);

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Sespagethm_Plugin_Core);
    }

    protected function _initFrontController() {
        include APPLICATION_PATH . '/application/modules/Sespagethm/controllers/Checklicense.php';
    }
}
