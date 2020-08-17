<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Plugin_Core {

  public function onStatistics($event) {
    $table  = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(*) AS count');
    $event->addResponse($select->query()->fetchColumn(0), 'product');
  }

	public function onRenderLayoutDefault($event){
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();

		$checkWelcomeEnable = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.redirection',1);
		if($actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'sesproduct') {
		  $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
			if(!$checkWelcomeEnable){
				$redirector->gotoRoute(array('module' => 'sesproduct', 'controller' => 'index', 'action' => 'home'), 'sesproduct_general', false);
			}
			elseif($checkWelcomeEnable == '1') {
				$redirector->gotoRoute(array('module' => 'sesproduct', 'controller' => 'index', 'action' => 'browse'), 'sesproduct_general', false);
			} /*else if($checkWelcomeEnable == '1') {

        $checkWelcomePage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.check.welcome',2);

        $checkWelcomePage = (($checkWelcomePage == 1 && $viewer->getIdentity() == 0) ? true : ($checkWelcomePage == 0 && $viewer->getIdentity() != 0) ? true : ($checkWelcomePage == 2) ? true : false);
        if(!$checkWelcomePage && $actionName == 'welcome' && $controllerName == 'index' && $moduleName == 'sesproduct'){
          $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
          $redirector->gotoRoute(array('module' => 'sesproduct', 'controller' => 'index', 'action' => 'home'), 'sesproduct_general', false);
        }
			}*/
		}

		$headScript = new Zend_View_Helper_HeadScript();
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
								 .'application/modules/Sesproduct/externals/scripts/core.js');
        $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
            .'application/modules/Sesproduct/externals/scripts/sesproduct_cart.js');
        $headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
            .'application/modules/Sesproduct/externals/scripts/zoom_image.js');
        $view->headLink()->appendStylesheet(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesproduct/externals/styles/zoom_image.css');

		$script = '';
		if($moduleName == 'sesproduct'){
			$script .=
"sesJqueryObject(document).ready(function(){


     sesJqueryObject('.core_main_sesproduct').parent().addClass('active');
    });
";
		}

		$tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
		$wishlishtTable = Engine_Api::_()->getDbTable('wishlists', 'sesproduct');
		$wishlishtTableName = $wishlishtTable->info('name');
		$select = $wishlishtTable->select()
		->setIntegrityCheck(false)
		->from($wishlishtTableName,array("COUNT(wishlist_id)"))
		->where($wishlishtTableName.'.owner_id = ?',Engine_Api::_()->user()->getViewer()->getIdentity());
		$select = $select->joinLeft($tableUserName, "$wishlishtTableName.owner_id = $tableUserName.user_id",null);
    $wishlistCount = $select->query()->fetchColumn();
		if($wishlistCount>0){
			$script .="sesJqueryObject(document).ready(function(){
				sesJqueryObject('.estore_my_wishlist_dropdown ').html('<span>My Wishlist</span><span class=\"wishlist_value sesproduct_wishlist_count\">".$wishlistCount."</span>');
			});";
		}
		$cartTotal = "0";
		if(Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.pluginactivated')) {
		$totalProduct = Engine_Api::_()->sesproduct()->cartTotalPrice();
			if($totalProduct['cartProductsCount']){
					$cartTotal = ($totalProduct['cartProductsCount']);
			}
		}
$html = '<span>Cart</span><span class="cart_value sesproduct_cart_count">'.$cartTotal.'</span>';
		if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.cartviewtype',1)== '1') {
			$script .= "sesJqueryObject(document).ready(function(){
				sesJqueryObject('.sesproduct_add_cart_dropdown').html('".$html."');";
		}
		elseif(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.cartviewtype', '2') == 2) {
			$script .= "sesJqueryObject(document).ready(function(){
				sesJqueryObject('.sesproduct_add_cart_dropdown').addClass('cart_icon');
				sesJqueryObject('.sesproduct_add_cart_dropdown').html('<span class=\"cart_value sesproduct_cart_count\">".$cartTotal."</span>');";
    }else if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.cartviewtype', '3') == '3'){
			$script .= "sesJqueryObject(document).ready(function(){
			sesJqueryObject('.sesproduct_add_cart_dropdown').addClass('cart_icon');
			sesJqueryObject('.sesproduct_add_cart_dropdown').addClass('cart_icon_text');
			sesJqueryObject('.sesproduct_add_cart_dropdown').html('".$html."');";
		}
		$script .= "
		var valueCart = sesJqueryObject('.sesproduct_cart_count').html();
		if(parseInt(valueCart) <=0 || !valueCart){
			sesJqueryObject('.sesproduct_cart_count').hide();
		}});";
    $singlecart = Engine_Api::_()->getApi('settings', 'core')->getSetting('site.enble.singlecart', 0); // this setting is using from sesbasic plugin
		if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.cartdropdown',1) && !$singlecart){
			$script .= "sesJqueryObject(document).on('click','.sesproduct_add_cart_dropdown',function(e){
				e.preventDefault();
				if(sesJqueryObject(this).hasClass('active')){
						sesJqueryObject('.sesproduct_cart_dropdown').hide();
						sesJqueryObject('.sesproduct_add_cart_dropdown').removeClass('active');
						return;
				}
				sesJqueryObject('.sesproduct_add_cart_dropdown').addClass('active');
				if(!sesJqueryObject(this).parent().find('.sesproduct_cart_dropdown').length){
						sesJqueryObject(this).parent().append('<div class=\"sesproduct_cart_dropdown sesbasic_header_pulldown sesbasic_clearfix sesbasic_bxs sesbasic_cart_pulldown\"><div class=\"sesbasic_header_pulldown_inner\"><div class=\"sesbasic_header_pulldown_loading\"><img src=\"application/modules/Core/externals/images/loading.gif\" alt=\"Loading\" /></div></div></div>');
				}
				sesJqueryObject('.sesproduct_cart_dropdown').show();
				sesJqueryObject.post('sesproduct/cart/view',{},function(res){
						sesJqueryObject('.sesproduct_cart_dropdown').html(res);
				});
			});";
			$script .= "
				sesJqueryObject(document).click(function(e){
				var elem = sesJqueryObject('.sesproduct_cart_dropdown').parent();
				if(!elem.has(e.target).length){
					 sesJqueryObject('.sesproduct_cart_dropdown').hide();
					 sesJqueryObject('.sesproduct_add_cart_dropdown').removeClass('active');
				}
			});";
		}

		$view->headScript()->appendScript($script);
	}
	public function onRenderLayoutMobileDefault($event) {
     return $this->onRenderLayoutDefault($event,'simple');
    }
	public function onRenderLayoutMobileDefaultSimple($event) {
        return $this->onRenderLayoutDefault($event,'simple');
    }
	public function onRenderLayoutDefaultSimple($event) {
        return $this->onRenderLayoutDefault($event,'simple');
    }
  public function onUserDeleteBefore($event)
  {

  }
}
