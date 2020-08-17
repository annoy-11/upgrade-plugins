<?php

class Seschristmas_Bootstrap extends Engine_Application_Bootstrap_Abstract {

  protected function _initFrontController() {
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Seschristmas_Plugin_Core);
  }

}