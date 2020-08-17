<?php

class Sesdocument_Bootstrap extends Engine_Application_Bootstrap_Abstract {

    public function __construct($application) {

        parent::__construct($application);

        $baseURL = Zend_Registry::get('StaticBaseUrl');

        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $this->initViewHelperPath();

        $headScript = new Zend_View_Helper_HeadScript();
        $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') .'application/modules/Sesdocument/externals/scripts/core.js');
    }
}
