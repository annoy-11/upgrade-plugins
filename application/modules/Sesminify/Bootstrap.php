<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesminify
 * @package    Sesminify
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2017-10-09 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesminify_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {

    parent::__construct($application);
    if(strpos(str_replace('/','',$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']),str_replace('/','',$_SERVER['SERVER_NAME'].'admin')) === FALSE){
    //work only for user end and when site is in production mode.
      //if( APPLICATION_ENV == 'production' ) {
        $this->initViewHelperPath();
        Zend_Registry::get('Zend_View')->registerHelper(new Sesminify_View_Helper_HeadLink(), 'headLink');
        Zend_Registry::get('Zend_View')->registerHelper(new Sesminify_View_Helper_HeadScript(), 'headScript');
      //}
    }
  }
}