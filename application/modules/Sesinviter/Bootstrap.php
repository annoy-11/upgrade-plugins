<?php

class Sesinviter_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
    parent::__construct($application);
    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesinviter_Plugin_Core);
  }
}