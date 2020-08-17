<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Slides.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_Model_DbTable_Slides extends Engine_Db_Table {
   protected $_rowClass = "Sesproduct_Model_Slide";
    function getSlides($params = array()){
      $select = $this->select()->where('product_id =?',$params['product_id']);
      if($params['enabled'])
        $select->where('enabled =?',1);
      return $this->fetchAll($select);
    }  
}
