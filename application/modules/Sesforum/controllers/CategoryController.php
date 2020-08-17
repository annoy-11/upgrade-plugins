<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_CategoryController extends Core_Controller_Action_Standard
{
  public function init()
  {
    $category_id = $this->_getParam('category_id',false);
    if ($category_id)
      $category_id = Engine_Api::_()->getDbTable('categories', 'sesforum')->getCategoryId($category_id);

    if( 0 !== ($category_id) &&
        null !== ($category = Engine_Api::_()->getItem('sesforum_category', $category_id)) )
    {
      Engine_Api::_()->core()->setSubject($category);
    } else {
       return $this->_forward('requireauth', 'error', 'core');
    }

  }
  public function viewAction()
  {

    if ( !$this->_helper->requireAuth()->setAuthParams('sesforum_forum', null, 'view')->isValid() ) {
      return;
    }

    // Render
    $this->_helper->content->setEnabled();
  }

}
