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
class Sesproduct_Widget_CrossSellProductsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
     $getParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
     $productId = $getParams['product_id'];
     $product_id = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct')->getProductId($productId);

     $show_criterias = isset($params['show_criterias']) ? $params['show_criterias'] : $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'ratingStar', 'by', 'title', 'featuredLabel','sponsoredLabel','verifiedLabel', 'category','description_list','description_grid','description_pinboard', 'favouriteButton','likeButton', 'socialSharing', 'view', 'creationDate', 'readmore'));
    if(is_array($show_criterias)) {
      foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }
    $limit_data = $this->_getParam('limit_data_grid',10);
    $this->view->socialshare_enable_gridview1plusicon = $socialshare_enable_gridview1plusicon =isset($params['socialshare_enable_gridview1plusicon']) ? $params['socialshare_enable_gridview1plusicon'] : $this->_getParam('socialshare_enable_gridview1plusicon', 1);
    $this->view->socialshare_icon_gridview1limit = $socialshare_icon_gridview1limit =isset($params['socialshare_icon_gridview1limit']) ? $params['socialshare_icon_gridview1limit'] : $this->_getParam('socialshare_icon_gridview1limit', 2);

    $this->view->title_truncation_grid = $title_truncation_grid = isset($params['title_truncation_grid']) ? $params['title_truncation_grid'] : $this->_getParam('title_truncation_grid', '100');

    $this->view->description_truncation_grid = $description_truncation_grid = isset($params['description_truncation_grid']) ? $params['description_truncation_grid'] : $this->_getParam('description_truncation_grid', '100');
    $this->view->product_id =   $product_id;
    $this->view->show_sale = $this->_getParam('show_sale', 1);
    $this->view->show_item_count = $this->_getParam('show_item_count', 1);
     $this->view->height_grid = $this->_getParam('height_grid', 260);
      $this->view->width_grid = $this->_getParam('width_grid', 230);

    $this->view->widgetName = 'cross-sell-products';
    $params = array_merge($params, $value);

    // Get Products
    $cartData = Engine_Api::_()->sesproduct()->cartTotalPrice();
    $this->view->cartProducts = $cartProducts = $cartData['cartProducts'];

    foreach($cartProducts as $cartProduct){
    $paginator[$cartProduct->product_id] = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getSesproductsPaginator(array('product_id'=>                   $cartProduct->product_id,'crosssell'=>true,'limit'=>$limit_data,'manage-widget'=>true,'fetchAll'=>true));
         $paginator[$cartProduct->product_id]->setItemCountPerPage(12);
         $paginator[$cartProduct->product_id]->setCurrentPageNumber($page);
    }
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $limit_data = $this->view->{'limit_data_'.$view_type};

    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->page = $page;

    $this->view->params = $params;
    if ($is_ajax)
    $this->getElement()->removeDecorator('Container');
  }
}
