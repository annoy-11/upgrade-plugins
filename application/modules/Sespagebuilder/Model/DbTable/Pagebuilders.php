<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Pagebuilders.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_DbTable_Pagebuilders extends Engine_Db_Table {

  protected $_rowClass = "Sespagebuilder_Model_Pagebuilder";

  public function getFixedpages() {

    return $this->fetchAll($this->select()->order('pagebuilder_id DESC'));
  }
}
