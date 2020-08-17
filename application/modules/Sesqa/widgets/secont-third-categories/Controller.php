<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Widget_SecontThirdCategoriesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    if(!Engine_Api::_()->core()->hasSubject('sesqa_category'))
      return $this->setNoRender();
    
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    
    if($subject->subcat_id == 0 && $subject->subsubcat_id == 0)
      $categories = Engine_Api::_()->getDbTable('categories','sesqa')->getModuleSubcategory(array('category_id'=>$subject->getIdentity(),'column_name'=>'*','countQuestions'=>1));
    else if($subject->subcat_id != 0)
      $categories = Engine_Api::_()->getDbTable('categories','sesqa')->getModuleSubsubcategory(array('category_id'=>$subject->getIdentity(),'column_name'=>'*','countQuestions'=>1));
    else
      return $this->setNoRender();
      
    if(!count($categories))
      return $this->setNoRender();

    $this->view->resultcategories = $categories;
    
    $this->view->widgetParams = $this->_getAllParams();
    $this->view->showinformation = $this->_getParam('showinformation', array('title'));
    $this->view->mainblockheight = $this->_getParam('mainblockheight', 200);
    $this->view->mainblockwidth = $this->_getParam('mainblockwidth', 250);
    $this->view->categoryiconheight = $this->_getParam('categoryiconheight', 75);
    $this->view->categoryiconwidth = $this->_getParam('categoryiconwidth', 75);
    
    if(count($this->view->resultcategories) <= 0)
      return $this->setNoRender();
  }

}
