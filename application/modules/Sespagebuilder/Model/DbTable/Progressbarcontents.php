<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Progressbarcontents.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_DbTable_Progressbarcontents extends Engine_Db_Table {
	
  function getProgressbarContent($id){
    return $this->fetchAll($this->select()->where('progressbarcontent_id')->where('progressbar_id =?',$id)->order('order ASC'));
  }
}