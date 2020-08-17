<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Widget_MemberCloudController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->heading = $this->_getParam('heading', 1);
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->showinfotooltip = $settings->getSetting('sesytube.member.infotooltip', 1);
    $this->view->heading = $settings->getSetting('sesytube.memeber.heading', '');
    $this->view->caption = $settings->getSetting('sesytube.memeber.caption', '');
    $this->view->memberlink = $settings->getSetting('sesytube.member.link', '1');
    $this->view->sesmemberEnable = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmember');
    $member_count = $this->_getParam('memberCount', 50);
    $sesytube_landingpage = Zend_Registry::isRegistered('sesytube_landingpage') ? Zend_Registry::get('sesytube_landingpage') : null;
    if(empty($sesytube_landingpage)) {
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
            ->order('Rand()')
            ->limit($settings->getSetting('sesytube.memeber.count', '30'));
    $this->view->paginator = $paginator = $table->fetchAll($select);
    // Do not render if nothing to show
    if (count($paginator) == 0)
      return $this->setNoRender();
  }

}
