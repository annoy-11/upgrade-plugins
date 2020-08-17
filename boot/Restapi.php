<?php
class Engine_Boot_Restapi extends Engine_Boot_Abstract{
  public function beforeBoot()
  {
    if( !empty($_GET['restApi']) ) {
      $this->_boot->setRootBootDir('apps');
      $this->_boot->setRootBootFileName('restapi.php');
    }
  }
}
