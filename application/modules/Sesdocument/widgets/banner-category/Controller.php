<?php
/**
* SocialEngineSolutions
*
* @category   Application_Sesevent
* @package    Sesevent
* @copyright  Copyright 2015-2016 SocialEngineSolutions
* @license    http://www.socialenginesolutions.com/license/
* @version    $Id: Controller.php 2016-07-26 00:00:00 SocialEngineSolutions $
* @author     SocialEngineSolutions
*/
class Sesdocument_Widget_BannerCategoryController extends Engine_Content_Widget_Abstract {

    public function indexAction() {

        $this->view->bannerImage = $this->_getParam('sesdocument_category_cover');
        $this->view->description = $this->_getParam('description', '');
        $this->view->title = $this->_getParam('title', '');
        $this->view->showPopularDocuments = $this->_getParam('show_popular_documents',1);
        //$value['view'] = $this->_getParam('view','ongoingSPupcomming');
        $value['info']  = $this->_getParam('info','creationSPdate');
        $this->view->title_pop = $this->_getParam('title_pop','');
        $this->view->paginator = array();
        if($this->view->showPopularDocuments) {
            $this->view->paginator = Engine_Api::_()->getDbTable('sesdocuments', 'sesdocument')->getDocumentPaginator(array_merge($value,array('search'=>1,'fetchAll'=>true,'limit_data'=>3)));
        }
    }
}
