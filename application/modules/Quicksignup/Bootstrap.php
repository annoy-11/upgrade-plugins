<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Quicksignup
 * @package    Quicksignup
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-11-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Quicksignup_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
    protected function _initFrontController() {
        Zend_Controller_Front::getInstance()->registerPlugin(new Quicksignup_Plugin_Core);
        define('sesquicksignup', 1);
        include APPLICATION_PATH . '/application/modules/Quicksignup/controllers/Checklicense.php';
    }
}
