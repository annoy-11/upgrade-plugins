<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Documenttype.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Model_Documenttype extends Core_Model_Item_Abstract
{
  protected $_searchTriggers = false;
//   protected $_route = 'blog_general';
// 
  public function getTitle()
  {
    return $this->document_name;
  }
//   
//   public function getUsedCount()
//   {
//     $blogTable = Engine_Api::_()->getItemTable('blog');
//     return $blogTable->select()
//         ->from($blogTable, new Zend_Db_Expr('COUNT(blog_id)'))
//         ->where('category_id = ?', $this->category_id)
//         ->query()
//         ->fetchColumn();
//   }
// 
//   public function isOwner($owner)
//   {
//     return false;
//   }
// 
//   public function getOwner($recurseType = null)
//   {
//     return $this;
//   }
// 
//   public function getHref($params = array())
//   {
//     return Zend_Controller_Front::getInstance()->getRouter()
//             ->assemble($params, $this->_route, true) . '?category=' . $this->category_id;
//   }
}
