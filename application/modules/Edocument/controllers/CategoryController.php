<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryController.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_CategoryController extends Core_Controller_Action_Standard {

    public function browseAction() {
        $this->_helper->content->setEnabled();
    }

    public function indexAction() {

        $category_id = $this->_getParam('category_id', false);
        if ($category_id)
            $category_id = Engine_Api::_()->getDbtable('categories', 'edocument')->getCategoryId($category_id);
        else
            return;

        $category = Engine_Api::_()->getItem('edocument_category', $category_id);
        if ($category)
            Engine_Api::_()->core()->setSubject($category);

        if (!$this->_helper->requireSubject()->isValid())
            return;

        // Render
        $this->_helper->content->setEnabled();
    }
}
