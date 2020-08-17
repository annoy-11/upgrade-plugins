<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Edit extends Sesproduct_Form_Create
{
  public function init() {
    parent::init();
     $translate = Zend_Registry::get('Zend_Translate');

    if (Engine_Api::_()->core()->hasSubject('sesproduct'))
        $product = Engine_Api::_()->core()->getSubject();
    $this->submit->setLabel("Save Changes");
    $this->setTitle('Edit Product Entry')
      ->setDescription('Edit your entry below, then click "Save Changes" to edit the product.')->setAttrib('name', 'sesproducts_create');
  }
}
