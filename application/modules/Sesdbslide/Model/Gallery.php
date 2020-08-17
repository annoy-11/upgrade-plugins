<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesdbslide
 * @package Sesdbslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: Gallery.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesdbslide_Model_Gallery extends Core_Model_Item_Abstract {

 protected $_searchTriggers = false;
  public function countSlide() {

    $slideTable = Engine_Api::_()->getItemTable('sesdbslide_slide');
    return $slideTable->select()
                    ->from($slideTable, new Zend_Db_Expr('COUNT(slide_id)'))
                    ->where('gallery_id = ?', $this->gallery_id)
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
  }
}
