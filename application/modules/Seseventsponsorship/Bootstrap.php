<?php

class Seseventsponsorship_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  protected function _initFrontController() {
	  include APPLICATION_PATH . '/application/modules/Seseventsponsorship/controllers/Checklicense.php';
  }
}