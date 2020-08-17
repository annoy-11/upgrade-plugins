<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminMenusController.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmenu_AdminMenusController extends Core_Controller_Action_Admin
{
  protected $_menus;

  protected $_enabledModuleNames;

  public function init()
  {
    // Get list of menus
    $menusTable = Engine_Api::_()->getDbtable('menus', 'core');
    $menusSelect = $menusTable->select();
    $this->view->menus = $this->_menus = $menusTable->fetchAll($menusSelect);

    $this->_enabledModuleNames = Engine_Api::_()->getDbtable('modules', 'core')->getEnabledModuleNames();
  }

  public function indexAction()
  {
	$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmenu_admin_main', array(), 'sesmenu_admin_main_menus');

    $this->view->name = $name = $this->_getParam('name', 'core_main');

    // Get list of menus
    $menus = $this->_menus;

    // Check if selected menu is in list
    $selectedMenu = $menus->getRowMatching('name', $name);
    if( null === $selectedMenu ) {
      throw new Core_Model_Exception('Invalid menu name');
    }
    $this->view->selectedMenu = $selectedMenu;

    // Make select options
    $menuList = array();
    foreach( $menus as $menu ) {
      $menuList[$menu->name] = $this->view->translate($menu->title);
    }
    $this->view->menuList = $menuList;

    $menuItemsTable = Engine_Api::_()->getDbtable('menuitems', 'sesmenu');
    $selectSink = $menuItemsTable->select()
        ->where("menu='core_main'");
    $this->view->resultsSink = $menuItemsTable->fetchAll($selectSink);

    // Get menu items
    $menuItemsSelect = $menuItemsTable->select()
      ->where('menu = ?', $name)
      ->order('order');
    if(!empty($this->_enabledModuleNames) ) {
      $menuItemsSelect->where('module IN(?)',  $this->_enabledModuleNames);
    }
    $this->view->menuItems = $menuItems = $menuItemsTable->fetchAll($menuItemsSelect);
  }

  public function createAction()
  {
    $this->view->name = $name = $this->_getParam('name');

    // Get list of menus
    $menus = $this->_menus;

    // Check if selected menu is in list
    $selectedMenu = $menus->getRowMatching('name', $name);
    if( null === $selectedMenu ) {
      throw new Core_Model_Exception('Invalid menu name');
    }
    $this->view->selectedMenu = $selectedMenu;

    // Get form
    $this->view->form = $form = new Sesmenu_Form_Admin_Menu_ItemCreate();

    // Check stuff
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Save
    $values = $form->getValues();
    $privacy = implode(",", $values['privacy']);
    $label = $values['label'];
    unset($values['label']);

    $menuItemsTable = Engine_Api::_()->getDbtable('menuitems', 'sesmenu');
    $menuItem = $menuItemsTable->createRow();
    $menuItem->privacy = $privacy;
    $menuItem->label = $label;
    $menuItem->params = $values;
    $menuItem->menu = $name;
    $menuItem->module = 'sesmenu';
    $menuItem->plugin = '';
    $menuItem->submenu = '';
    $menuItem->custom = 1;
    $menuItem->save();

    $menuItem->name = 'custom_' . sprintf('%d', $menuItem->id);
    $menuItem->save();

    $this->view->status = true;
    $this->view->form = null;
  }

  public function editAction()
  {
    $this->view->name = $name = $this->_getParam('name');

	$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmenu_admin_main', array(), 'sesmenu_admin_main_menus');

    // Get menu item
    $menuItemsTable = Engine_Api::_()->getDbtable('menuitems', 'sesmenu');
    $menuItemsSelect = $menuItemsTable->select()
      ->where('name = ?', $name);
    if( !empty($this->_enabledModuleNames) ) {
      $menuItemsSelect->where('module IN(?)',  $this->_enabledModuleNames);
    }
    $this->view->menuItem = $menuItem = $menuItemsTable->fetchRow($menuItemsSelect);
    if( !$menuItem ) {
      throw new Core_Model_Exception('missing menu item');
    }
    // Get form
    $this->view->form = $form = new Sesmenu_Form_Admin_Menu_ItemEdit();

    // Make safe
	$menuItemData = $menuItem->toArray();
    if( isset($menuItemData['params']) && is_array($menuItemData['params']) ) {
      $menuItemData = array_merge($menuItemData, $menuItemData['params']);
    }
    if( !$menuItem->custom ) {
      $form->removeElement('uri');
    }
    unset($menuItemData['params']);
    if( !$this->getRequest()->isPost() ) {
			if ($menuItemData['design_cat'] == 1){
				$menuItemData['category_design']=$menuItemData['design'];
			}else if ($menuItemData['design_cat'] == 2){
				$menuItemData['content_design']=$menuItemData['design'];
			}else if ($menuItemData['design_cat'] == 3){
				$menuItemData['module_design']=$menuItemData['design'];
			}else if ($menuItemData['design_cat'] == 4){
				$menuItemData['normal_design']=$menuItemData['design'];
			}else if ($menuItemData['design_cat'] == 5){
				$menuItemData['submenu_design']=$menuItemData['design'];
			}
			else if ($menuItemData['design_cat'] == 6){
				$menuItemData['custom_design']=$menuItemData['design'];
			}
		$menuItemData['enabled_tab'] = json_decode($menuItemData['enabled_tab'],true);
      $form->populate($menuItemData);
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }
    $values = $form->getValues();


    if($values['design_cat'] == '1' && empty($values['category_design'])) {
       $values['design'] = 50;
    }
    if($values['design_cat'] == '2' && empty($values['content_design'])) {
       $values['design'] = 50;
    }
    if($values['design_cat'] == '3' && empty($values['module_design'])) {
       $values['design'] = 50;
    }
    if($values['design_cat'] == '4' && empty($values['module_design'])) {
       $values['design'] = 50;
    }
    if($values['design_cat'] == '4' && empty($values['normal_design'])) {
       $values['design'] = 50;
    }
    if($values['design_cat'] == '5' && empty($values['submenu_design'])) {
       $values['design'] = 50;
    }
    if($values['design_cat'] == '6' && empty($values['custom_design'])) {
       $values['design'] = 50;
    }

    $menuItem->setFromArray($values);
    $menuItem->save();
	if(isset($values['enabled_tab']) && !empty($values['enabled_tab'])){
		$menuItem->enabled_tab = json_encode($values['enabled_tab']);
	}
	if(isset($values['category_design']) && !empty($values['category_design']) && $values['design_cat'] == 1){
		$menuItem->design = $values['category_design'];

	}else if(isset($values['content_design']) && !empty($values['content_design']) && $values['design_cat'] == 2){
		$menuItem->design = $values['content_design'];
	}else if(isset($values['module_design']) && !empty($values['module_design']) && $values['design_cat'] == 3){
		$menuItem->design = $values['module_design'];
	}else if(isset($values['normal_design']) && !empty($values['normal_design']) && $values['design_cat'] == 4){
		$menuItem->design = $values['normal_design'];
	}else if(isset($values['submenu_design']) && !empty($values['submenu_design']) && $values['design_cat'] == 5){
		$menuItem->design = $values['submenu_design'];
	}
	else if(isset($values['custom_design']) && !empty($values['custom_design']) && $values['design_cat'] == 6){
		$menuItem->design = $values['custom_design'];
	}
	$menuItem->label = $values['label'];
	$menuItem->design_cat = $values['design_cat'];
    $menuItem->enabled = !empty($values['enabled']);
    $privacy = implode(",", $values['privacy']);
    $menuItem->privacy = $privacy;
    unset($values['label']);
    unset($values['enabled']);
    unset($values['design_cat']);
    if( $menuItem->custom ) {
      $menuItem->params = $values;
    }
    $menuItem->params = $this->updateParam($values, 'icon', $menuItem->params);
    $menuItem->params = $this->updateParam($values, 'target', $menuItem->params);
    if( empty($menuItem->params) ) {
      $menuItem->params = '';
    }
    $menuItem->save();
  }

  public function deleteAction()
  {
    $this->view->name = $name = $this->_getParam('name');

    // Get menu item
    $menuItemsTable = Engine_Api::_()->getDbtable('menuitems', 'sesmenu');
    $menuItemsSelect = $menuItemsTable->select()
      ->where('name = ?', $name)
      ->order('order ASC');
    if( !empty($this->_enabledModuleNames) ) {
      $menuItemsSelect->where('module IN(?)',  $this->_enabledModuleNames);
    }
    $this->view->menuItem = $menuItem = $menuItemsTable->fetchRow($menuItemsSelect);

    if( !$menuItem || !$menuItem->custom ) {
      throw new Core_Model_Exception('missing menu item');
    }

    // Get form
    $this->view->form = $form = new Sesmenu_Form_Admin_Menu_ItemDelete();

    // Check stuff
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $menuItem->delete();

    $this->view->form = null;
    $this->view->status = true;
  }

  public function orderAction()
  {
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    $table = Engine_Api::_()->getDbtable('menuitems', 'sesmenu');
    $menuitems = $table->fetchAll($table->select()->where('menu = ?', $this->getRequest()->getParam('menu')));
    foreach( $menuitems as $menuitem ) {
      $order = $this->getRequest()->getParam('admin_menus_item_'.$menuitem->name);
      if( !$order ){
        $order = 999;
      }
      $menuitem->order = $order;
      $menuitem->save();
    }
    return;
  }

  public function updateParam($formValues, $paramName, $params)
  {
    if( !empty($formValues[$paramName]) ) {
      if( !empty($params) ) {
        return $params = array_merge($params, array($paramName => $formValues[$paramName]));
      }
      return array($paramName => $formValues[$paramName]);
    } elseif( isset($params[$paramName]) ) {
      // Remove the $paramName
      $tempParams = array();
      foreach( $params as $key => $item ) {
        if( $key != $paramName ) {
          $tempParams[$key] = $item;
        }
      }
      return $tempParams;
    }
    return $params;
  }
}
