<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesquote_Widget_TopQuotePosterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if (!Engine_Api::_()->core()->hasSubject('sesquote_quote'))
      return $this->setNoRender();

		if(Engine_Api::_()->core()->hasSubject('sesquote_quote'))
      $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('sesquote_quote');

    $this->view->height = $this->_getParam('height', '48');
    $this->view->width = $this->_getParam('width', '48');
		$this->view->title = $this->getElement()->getTitle();

    $userTable = Engine_Api::_()->getItemTable('user');
    $userTableName = $userTable->info('name');
    
    $quoteTable = Engine_Api::_()->getDbTable('quotes', 'sesquote');
    $quoteTableName = $quoteTable->info('name');
    
    $select = $userTable->select()
                      ->from($userTable, array('COUNT(*) AS quote_count', 'user_id', 'displayname'))
                      ->setIntegrityCheck(false)
                      ->join($quoteTableName, $quoteTableName . '.owner_id=' . $userTableName . '.user_id')
                      ->group($userTableName . '.user_id')
                      ->order('quote_count DESC');
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