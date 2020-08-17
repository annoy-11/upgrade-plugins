<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Templates.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Emailtemplates_Model_DbTable_Templates extends Core_Model_Item_DbTable_Abstract {

  protected $_rowClass = "Emailtemplates_Model_Template";
	
	public function getTemplates($params){
		$viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();
    $table = Engine_Api::_()->getItemTable('emailtemplates_template');
    $tableName = $table->info('name');
    $select = $table->select()->from($tableName);
		if ($params['is_active'] == '1')
			$select->where('is_active = ?', '0');
		elseif ($params['is_active'] == '0')
			$select->where('is_active = ?', '1');
		$select->where('predefined = ?','0');
		$select->order($tableName . '.creation_date ASC');
		
		if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
     return Zend_Paginator::factory($select);
    }
	}
  
}
