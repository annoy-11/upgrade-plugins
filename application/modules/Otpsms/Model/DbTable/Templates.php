<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Templates.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_Model_DbTable_Templates extends Engine_Db_Table {
  public function getTemplates($language = null) {
    $select = $this->select()
                   ->from($this->info('name'));
    $select->where('language =?',$language)->limit(1);
    return $this->fetchRow($select);
  }
}