<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ProfileRewardsController extends Engine_Content_Widget_Abstract {

    protected $_childCount;
    public function indexAction() {

        if (!Engine_Api::_()->core()->hasSubject())
            return $this->setNoRender();

        $crowdfunding = Engine_Api::_()->core()->getSubject();
        $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('rewards', 'sescrowdfunding')->getCrowdfundingRewardPaginator(array('crowdfunding_id' => $crowdfunding->crowdfunding_id));

        $paginator->setItemCountPerPage($this->_getParam('limit_data', 10));
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        if ($paginator->getTotalItemCount() < 1)
            return $this->setNoRender();

        // Add count to title if configured
        if( $this->_getParam('titleCount', false) && $paginator->getTotalItemCount() > 0 ) {
            $this->_childCount = $paginator->getTotalItemCount();
        }
    }

    public function getChildCount() {
        return $this->_childCount;
    }
}
