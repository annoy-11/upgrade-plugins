<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageCompaniesController.php  2019-03-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesjob_AdminManageCompaniesController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesjob_admin_main', array(), 'sesjob_admin_main_managecompanies');

    $this->view->formFilter = $formFilter = new Sesjob_Form_Admin_Company_Filter();

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
    $values = $formFilter->getValues();
    $values = array_merge(array(
    'order' => isset($_GET['order']) ? $_GET['order'] :'',
    'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $companiesTable = Engine_Api::_()->getDbTable('companies', 'sesjob');
    $companiesTableName = $companiesTable->info('name');
    $select = $companiesTable->select()
    ->setIntegrityCheck(false)
    ->from($companiesTableName)
    ->joinLeft($tableUserName, "$companiesTableName.owner_id = $tableUserName.user_id", 'username')
    ->order((!empty($_GET['order']) ? $_GET['order'] : 'company_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));
    if (!empty($_GET['name']))
    $select->where($companiesTableName . '.company_name LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

     if (!empty($_GET['industry_id']))
      $select->where($companiesTableName . '.industry_id =?', $_GET['industry_id']);

    if (isset($_GET['status']) && $_GET['status'] != '')
    $select->where($companiesTableName . '.draft = ?', $_GET['status']);

    if (isset($_GET['enable']) && $_GET['enable'] != '')
        $select->where($companiesTableName . '.enable = ?', $_GET['enable']);

    if (!empty($_GET['creation_date']))
    $select->where($companiesTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function enableAction() {

    $id = $this->_getParam('id');
    if (!empty($id)) {
      $event = Engine_Api::_()->getItem('sesjob_company', $id);
      $event->enable = !$event->enable;
      $event->save();
    }
    $this->_redirect('admin/sesjob/manage-companies');
  }
}
