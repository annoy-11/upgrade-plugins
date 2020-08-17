<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshoutbox_Bootstrap extends Engine_Application_Bootstrap_Abstract {

    public function __construct($application) {

        parent::__construct($application);

        if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
            $headScript = new Zend_View_Helper_HeadScript();
            $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesshoutbox/externals/scripts/core.js');
        }

        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Sesshoutbox_Plugin_Core);
    }
}
