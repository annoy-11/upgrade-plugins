<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contents.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesseo_Model_DbTable_Contents extends Engine_Db_Table {

  protected $_rowClass = 'Sesseo_Model_Content';

  public function hasType($params = array()) {

    return $this->select()
                    ->from($this->info('name'), array('content_id'))
                    ->where('resource_type =?', $params['resource_type'])
                    ->query()
                    ->fetchColumn();
  }
}
