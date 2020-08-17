<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Bootstrap extends Engine_Application_Bootstrap_Abstract
{
  public function __construct($application) {
  
    parent::__construct($application);
    
    if (strpos(str_replace('/', '', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']), str_replace('/', '', $_SERVER['SERVER_NAME'] . 'admin')) === FALSE) {
      $baseURL = Zend_Registry::get('StaticBaseUrl');
      $headScript = new Zend_View_Helper_HeadScript();
      $headScript->appendFile($baseURL . 'application/modules/Sesdiscussion/externals/scripts/core.js');
      
      // Autocomplete load
      $headScript->appendFile($baseURL . 'externals/autocompleter/Observer.js');
      $headScript->appendFile($baseURL . 'externals/autocompleter/Autocompleter.js');
      $headScript->appendFile($baseURL . 'externals/autocompleter/Autocompleter.Local.js');
      $headScript->appendFile($baseURL . 'externals/autocompleter/Autocompleter.Request.js');
    }
  }
}