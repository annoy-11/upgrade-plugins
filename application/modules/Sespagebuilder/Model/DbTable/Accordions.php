<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Accordions.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_DbTable_Accordions extends Engine_Db_Table {

  protected $_rowClass = 'Sespagebuilder_Model_Accordion';

  public function getAccordion($id) {

    $select = $this->select()
            ->where('subaccordion_id = ?', 0)
            ->where('subsubaccordion_id = ?', 0)
            ->where('id = ?', $id);
    return $this->fetchAll($select);
  }

  public function getModuleSubaccordion($accordionId) {

    return $this->fetchAll($this->select()->where('subaccordion_id = ?', $accordionId));
  }

  public function getModuleSubsubaccordion($accordionId) {

    return $this->fetchAll($this->select()->where('subsubaccordion_id = ?', $accordionId));
  }

}

