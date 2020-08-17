<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprayer_Widget_TopPrayerPosterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if (!Engine_Api::_()->core()->hasSubject('sesprayer_prayer'))
      return $this->setNoRender();

		if(Engine_Api::_()->core()->hasSubject('sesprayer_prayer'))
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('sesprayer_prayer');

    $this->view->height = $this->_getParam('height', '48');
    $this->view->width = $this->_getParam('width', '48');
		$this->view->title = $this->getElement()->getTitle();

    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');
    
    $prayerTable = Engine_Api::_()->getDbTable('prayers', 'sesprayer');
    $prayerTableName = $prayerTable->info('name');
    
    $select = $userTable->select()
                      ->from($userTable, array('COUNT(*) AS prayer_count', 'user_id', 'displayname'))
                      ->setIntegrityCheck(false)
                      ->join($prayerTableName, $prayerTableName . '.owner_id=' . $userTableName . '.user_id')
                      ->group($userTableName . '.user_id')
                      ->order('prayer_count DESC');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
		$this->view->data_show = $limit_data = $this->_getParam('limit_data','11');
    // Set item count per page and current page number
    $paginator->setItemCountPerPage($limit_data);
    $paginator->setCurrentPageNumber(1);
		if($this->_getParam('removeDecorator'))
			$this->getElement()->removeDecorator('Container');
    // Do not render if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }
  }
}