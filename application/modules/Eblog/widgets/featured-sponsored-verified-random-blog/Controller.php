<?php/** * SocialEngineSolutions * * @category   Application_Eblog * @package    Eblog * @copyright  Copyright 2015-2016 SocialEngineSolutions * @license    http://www.socialenginesolutions.com/license/ * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $ * @author     SocialEngineSolutions */class Eblog_Widget_FeaturedSponsoredVerifiedRandomBlogController extends Engine_Content_Widget_Abstract {  public function indexAction() {      $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);    $this->view->description = $this->_getParam('description', '');    $value['category_id'] = $this->_getParam('category','');    $value['criteria'] = $this->_getParam('criteria', 5);    $value['info'] = 'random';    $value['order'] = $this->_getParam('order', '');    $value['fetchAll'] = true;    $value['limit'] = 3;    $show_criterias = $this->_getParam('show_criteria', array('title','category'));    foreach ($show_criterias as $show_criteria)    { $this->view->{$show_criteria . 'Active'} = $show_criteria;}    $this->view->blogs = Engine_Api::_()->getDbTable('blogs', 'eblog')->getEblogsSelect($value);    if(count($this->view->blogs) < 1)    $this->setNoRender();  }}