<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Widget_PricingTableController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $tableId = $this->_getParam('tableName');
    $this->view->tableRowHeight = $this->_getParam('row_height', '100');
    $this->view->tableDescriptionHeight = $this->_getParam('description_height', '20');
    $this->view->price_header = $this->_getParam('price_header', 0);
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagebuilder.showpages'))
      return $this->setNoRender();
    $this->view->description_header = $this->_getParam('description_header', 0);
    $this->view->columns = $columns = Engine_Api::_()->getDbtable('pricingtables', 'sespagebuilder')->getPricingTable($tableId);
    if (empty($tableId) || (count($columns) == 0))
      return $this->setNoRender();

    $this->view->table = Engine_Api::_()->getItem('sespagebuilder_content', $tableId);
  }

}
