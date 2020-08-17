<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Advancedsearch_Widget_SearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction(){
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
      $this->view->searchBoxWidthLoggedin = $this->_getParam('loggedin');
      $this->view->searchBoxWidthNonLoggedin = $this->_getParam('nonloggedin');
      $viewer = $this->view->viewer();
      if(!$viewer->getIdentity() && !Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedsearch.visibility', 1)){
          $this->setNoRender();
      }

      //get default options
      $table = Engine_Api::_()->getDbTable('modules','advancedsearch');
      $select = $table->select()->where('show_on_search =?',1);
      $result = $table->fetchAll($select);
      $this->view->searchModules = $result;
      $subject = $this->view->subject() ? $this->view->subject() :"";
      if($subject && empty($_GET['query'])){
          $this->view->text = $subject->getTitle();
      }else if(!empty($_GET['query'])){
          $this->view->text = $_GET['query'];
      }

	}
}
