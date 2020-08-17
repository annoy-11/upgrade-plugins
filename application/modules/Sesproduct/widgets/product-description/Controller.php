<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Widget_ProductDescriptionController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
        // Check permission
        $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('featuredLabel','sponsoredLabel'));
        if(is_array($show_criterias)){
            foreach ($show_criterias as $show_criteria)
            $this->view->{$show_criteria . 'Active'} = $show_criteria;
        }
     $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
      $this->view->settings = Engine_Api::_()->getApi('settings', 'core');
      $this->view->design = $this->_getParam('design', 1);
      $this->view->show_sale = $this->_getParam('show_sale', 1);
      $viewer = Engine_Api::_()->user()->getViewer();
      $this->view->viewer_id = $viewer->getIdentity();
      $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('product_id', null);
      $this->view->product_id = $product_id = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getProductId($id);
      if(!Engine_Api::_()->core()->hasSubject())
          $sesproduct = Engine_Api::_()->getItem('sesproduct', $product_id);
      else
          $sesproduct = Engine_Api::_()->core()->getSubject();

      $this->view->outofstock = 0;
      if($sesproduct->type == "configurableProduct") {
          $combinations = Engine_Api::_()->sesproduct()->getProductVariations($sesproduct);
          if(!count($combinations)){
              $this->view->outofstock = 1;
          }
      }
      $this->view->product = $product = Engine_Api::_()->getItem('sesproduct',$product_id);
      $photoTable = Engine_Api::_()->getDbTable('slides','sesproduct');
      $this->view->paginator = $paginator = $photoTable->fetchAll($photoTable->select()->where('product_id =?',$product->getIdentity())->where('enabled =?',1));
      $this->view->item = $item = $sesproduct;
      $this->view->store = $store = Engine_Api::_()->getItem('stores',$item->store_id);
         $paymentGateways = Engine_Api::_()->sesproduct()->checkPaymentGatewayEnable();
        $this->view->paymentMethods = $paymentGateways['methods'];

        $this->view->reviews = $reviews = Engine_Api::_()->getDbTable('sesproductreviews','sesproduct')->getProductReviewSelect(array('product_id'=>$item->product_id));

      $this->view->form = new Sesproduct_Form_Customform(array('cartProduct'=>$sesproduct));
      $this->view->form->setAttrib('id','sesproduct_add_to_cart');
       $this->view->widgetName = 'product-information';
  }
}
