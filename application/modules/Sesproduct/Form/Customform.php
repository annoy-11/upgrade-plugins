<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Customform.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Customform extends Engine_Form {
    protected $_defaultProfileId;
    protected $_cartProduct;
    public function getDefaultProfileId() {
        return $this->_defaultProfileId;
    }
    public function setDefaultProfileId($default_profile_id) {
        $this->_defaultProfileId = $default_profile_id;
        return $this;
    }
    public function getCartProduct() {
        return $this->_cartProduct;
    }
    public function setCartProduct($getCartProduct) {
        $this->_cartProduct = $getCartProduct;
        return $this;
    }
  public function init() {
      $product = $this->getCartProduct();
      $option_id = Engine_Api::_()->getDbTable('cartoptions','sesproduct')->getAttribute($product)->option_id;
      $customFields = new Sesproduct_Form_Custom_Product_Fields(array(
          'item' => $product,
          'type' =>'sesproduct_cartproducts',
          'topLevelId' => 1,
          'topLevelValue' => $option_id,
          'decorators' => array(
              'FormElements','DivDivDivWrapper'
          )
          ));
      $this->addSubForms(array(
          'addtocart' => $customFields,
      ));
  }
}
