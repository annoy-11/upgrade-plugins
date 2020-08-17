<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmenu_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction() {

	$this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax',false);
	$this->view->isAjax = $isAjax = $this->_getParam('isAjax', false);
	$this->view->menu_id = $menu_id = $this->_getParam('menu_id');
	$this->view->menuItem = $menuItem = Engine_Api::_()->getItem('sesmenu_menuitem', $menu_id);
	$this->view->design_templete = $menuItem->design;
  }

  public function getContentDataAction() {
	$this->view->isAjax = $isAjax = $this->_getParam('isAjax', false);
	$this->view->tabdata = $tabdata = $this->_getParam('tabdata', false);
	$menu_id = $this->_getParam('menuid');

	$this->view->menuItem = $menuItem = Engine_Api::_()->getItem('sesmenu_menuitem', $menu_id);
	$this->view->tab_id = $params['order'] = $this->_getParam('tab_id',null);
	$this->view->category_id = $params['category_id'] = $this->_getParam('category_id',null);
	$params['limit'] = $this->_getParam('limit');
	$module_name = $this->_getParam('module_name');
    $moduleData  = Engine_Api::_()->getApi('core', 'sesmenu')->getModuleData($menuItem->module);
    if($moduleData['company']=='SES'){
        //$this->view->contentsData = $contentsData = Engine_Api::_()->getApi('core',$menuItem->module)->getSelectAdvMenuContent($params);
        switch($menuItem->module) {
			case 'sesadvpoll':
                $this->view->contentsData = $contentsData = null;
			break;
			case 'sesdiscussion':
                $params['limit'] = $params['limit'];
                unset($params['limit']);
                $params['status'] = 1;
                $params['widget'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('discussions', 'sesdiscussion')->getDiscussionsSelect($params);
			break;
			case 'sesblog':
                $params['draft'] = 0;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('blogs', 'sesblog')->getSesblogsSelect($params);
			break;
			case 'blog':
                $this->view->contentsData = $contentsData = null;
			break;
			case 'album':
                $this->view->contentsData = $contentsData = null;
			break;
			case 'sesalbum':
                $params['limit_data'] = $params['limit'];
                unset($params['limit']);
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('albums', 'sesalbum')->getAlbumSelect($params);
			break;
			case 'sesevent':
                if($params['order']=='week' || $params['order']=='month'){
                    $params['order']=$params['order'];
                }
                else{
                    $params['orderby']=$params['order'];
                    unset($params['order']);
                }
                $params['limit_data'] = $params['limit'];
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('events', 'sesevent')->getEventSelect($params);
			break;
			case 'sesvideo':
                $params['limit_data'] = $params['limit'];
                $params['status'] = 1;
                $params['watchLater'] = 1;
                $params['widget'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('videos', 'sesvideo')->getVideo($params);
			break;
            case 'sesmusic':
                if($params['order']=='week' || $params['oreder']=='month'){
                    $params['order']=$params['order'];
                }
                else{
                    $params['popularity']=$params['order'];
                    unset($params['order']);
                }
                $params['page'] = 1;
                $params['status'] = 1;
                //$params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('albums', 'sesmusic')->getPlaylistPaginator($params);
			break;
			case 'sespage':
                if($params['order']=='week' || $params['order']=='month'){
                    $params['order'] = $params['order'];
                }
                else{
                    $params['sort'] = $params['order'];
                }
                $params['status'] = 1;
                $params['search'] = 1;
                $params['draft'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageSelect($params);
            break;
			case 'sesbusiness':
                if($params['order']=='week' || $params['order']=='month'){
                    $params['order'] = $params['order'];
                }
                else{
                    $params['sort'] = $params['order'];
                }
                $params['status'] = 1;
                $params['search'] = 1;
                $params['draft'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessSelect($params);
			break;
			case 'sesgroup':
                if($params['order']=='week' || $params['order']=='month'){
                    $params['order'] = $params['order'];
                }
                else{
                    $params['sort'] = $params['order'];
                }
                $params['status'] = 1;
                $params['search'] = 1;
                $params['draft'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData  = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupSelect($params);
			break;
			case 'sescontest':
                $params['limit_data'] = $params['limit'];
                $params['sort'] = $params['order'];
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('contests', 'sescontest')->getContestSelect($params);
			break;
			case 'sesarticle':
                if($params['order']=='week' || $params['order']=='month'){
                    $params['order']=$params['order'];
                }
                else{
                    $params['orderby']=$params['order'];
                }
                $params['status'] = 1;
                $params['draft'] = 0;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('sesarticles', 'sesarticle')->getSesarticlesSelect($params);
			break;
			case 'sesquote':
                $params['orderby'] = $params['order'];
                $params['widget'] = 1;

                $this->view->contentsData = $contentsData  = Engine_Api::_()->getDbTable('quotes', 'sesquote')->getQuotesSelect($params);
			break;
			case 'sesprayer':

                $params['orderby'] = $params['order'];
                $params['widget'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('prayers', 'sesprayer')->getPrayersSelect($params);

            break;
			case 'sesthought':
                $params['orderby'] = $params['order'];
                $params['widget'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('thoughts', 'sesthought')->getThoughtsSelect($params);
			break;
			case 'seswishe':
                $params['orderby'] = $params['order'];
                $params['widget'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('wishes', 'seswishe')->getWishesSelect($params);
			break;
			case 'sesrecipe':
                if(!$params['order']=='week' || !$params['order']=='month')
                    $params['orderby']=$params['order'];
                $params['draft'] = 0;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('recipes', 'sesrecipe')->getSesrecipesSelect($params);
			break;
			case 'sesfaq':
                $params['limit_data'] = $params['limit'];
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect($params);
			break;
			case 'sestutorial':
                $params['limit_data'] = $params['limit'];
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('tutorials', 'sestutorial')->getTutorialSelect($params);
			break;
			case 'sesqa':
                $params['limit_data'] = $params['limit'];
                $params['show'] = $params['order'];
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('questions', 'sesqa')->getQuestions($params);
			break;
			case 'sesproduct':

                $params['popularCol'] = $params['order'];
                unset($params['order']);
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct')->getSesproductsSelect($params);
			break;

			case 'estore':
                $params['info'] = $params['order'];
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $params['draft'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreSelect($params);
			break;
            case 'sescrowdfunding':
                $params['info'] = $params['order'];
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $params['draft'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('crowdfundings', 'sescrowdfunding')->getSescrowdfundingsSelect($params);
			break;
			case 'booking':
                $params['info'] = $params['order'];
                $params['status'] = 1;
                $params['fetchAll'] = 1;
                $params['draft'] = 1;
                $this->view->contentsData = $contentsData = Engine_Api::_()->getDbTable('professionals', 'booking')->getProfessionalPaginator($params);
			break;
			case 'classified':
                $this->view->contentsData = $contentsData = null;
			break;
			case 'video':
                $this->view->contentsData = $contentsData = null;
			break;
			case 'forum':
                $this->view->contentsData = $contentsData = null;
			break;
			case 'poll':
                $this->view->contentsData = $contentsData = null;
			break;
			case 'music':
                $this->view->contentsData = $contentsData = null;
			break;
			case 'group':
                $this->view->contentsData = $contentsData = null;
			break;

            case 'event':
               $this->view->contentsData = $contentsData = null;
			break;
            default :
                $this->view->contentsData = $contentsData = null;
		}

	}else{
        $params['dbtable'] = $moduleData['dbtable'];
        $params['module'] = $module_name;
        $params['draft']=1;
        //$params['order']="creation_date";
        $this->view->contentsData = $contentsData = Engine_Api::_()->getApi('core', 'sesmenu')->getSelect($params);
	}

  }
  public function getSubmenuDataAction() {
	$this->view->isAjax = $isAjax = $this->_getParam('isAjax', false);
	$submenuid = $this->_getParam('submenuid');
	$menuId = $this->_getParam('menuId');
	$this->view->menuItem = $menuItem = Engine_Api::_()->getItem('sesmenu_menuitem', $menuId);
    $this->view->moduleData = $moduleData  = Engine_Api::_()->getApi('core', 'sesmenu')->getModuleData($menuItem->module);
	$this->view->module_name = $module_name = $this->_getParam('module_name');
	$menuType=Engine_Api::_()->getApi('core', 'sesmenu')->getModuleData($module_name);
	if($menuType['company']=='SES'){
        $this->view->subcategory = $subcategory = Engine_Api::_()->getDbtable('categories', $module_name)->getModuleSubcategory(array('column_name' => "*", 'category_id' => $submenuid));
	}

  }
  public function getCategoryDataAction() {
    $menu_id = $this->_getParam('menuid');
	$this->view->menuItem = $menuItem = Engine_Api::_()->getItem('sesmenu_menuitem', $menu_id);
	$this->view->category_id = $category_id = $this->_getParam('category_id',null);
	 $this->view->moduleData = $moduleData  = Engine_Api::_()->getApi('core', 'sesmenu')->getModuleData($menuItem->module);
	$this->view->limit = $this->_getParam('limit');
    if($moduleData['company']=='SES'){
      $this->view->subcategory = $subcategory = Engine_Api::_()->getDbtable('categories', $menuItem->module)->getModuleSubcategory(array('column_name' => "*", 'category_id' => $category_id));
    }

  }
}
