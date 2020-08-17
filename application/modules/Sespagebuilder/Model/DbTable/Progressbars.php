<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Progressbars.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_DbTable_Progressbars extends Engine_Db_Table {
  protected $_rowClass = 'Sespagebuilder_Model_Progressbar';
  function getContent(){
    return $this->fetchAll($this->select()->order('progressbar_id ASC'));
  }	
}