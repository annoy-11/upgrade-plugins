<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Progressbar.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_Progressbar extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;

  function getContents() {
    $table = Engine_Api::_()->getItemTable('sespagebuilder_progressbarcontent');
    return $table->select()
                    ->from($table)
                    ->where('progressbar_id = ?', $this->progressbar_id)
                    ->where('enable =?', 1)
                    ->order('order ASC')
                    ->query()
                    ->fetchAll();
  }

}
