<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Widget_MemberCloudController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->heading = $this->_getParam('heading', 1);
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->showinfotooltip = $settings->getSetting('sesariana.member.infotooltip', 1);
    $this->view->heading = $settings->getSetting('sesariana.memeber.heading', '');
    $this->view->caption = $settings->getSetting('sesariana.memeber.caption', '');
    $this->view->memberlink = $settings->getSetting('sesariana.member.link', '1');
    $this->view->sesmemberEnable = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmember');
    $this->view->height = $settings->getSetting('sesariana.memeber.height', '100');;
    $this->view->width = $settings->getSetting('sesariana.memeber.width', '100');;
    $member_count = $this->_getParam('memberCount', 50);
    $sesariana_landingpage = Zend_Registry::isRegistered('sesariana_landingpage') ? Zend_Registry::get('sesariana_landingpage') : null;
    if(empty($sesariana_landingpage)) {
      return $this->setNoRender();
    }
    $table = Engine_Api::_()->getDbtable('users', 'user');
    $info = $table->select()
            ->from($table, array('COUNT(*) AS count'))
            ->where('enabled = ?', true)
            ->query()
            ->fetch();
    $this->view->member_count = $info['count'];

    $select = $table->select()
            ->where('search = ?', 1)
            ->where('enabled = ?', 1)
            ->where('photo_id != ?', 0)
            ->order('Rand()');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($this->_getParam('memberCount', 60));
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Do not render if nothing to show
    if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }

}