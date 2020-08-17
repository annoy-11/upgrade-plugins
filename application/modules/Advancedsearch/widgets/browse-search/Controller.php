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

class Advancedsearch_Widget_BrowseSearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $this->view->type = $type = $_POST['resource_type'];
      $itemtype = "";
    if($type){
        //get item table
        try{
            $itemtable = Engine_Api::_()->getItemTable($type);
            $itemtype = $type;
        }catch(Exception $e){
            //silence
        }
    }
    $searchForm = $this->view->searchForm = new Advancedsearch_Form_Search(array('type'=>$itemtype));
    $request = Zend_Controller_Front::getInstance()->getRequest();
    if(!empty($_POST['query'])){
        $searchForm->search->setValue($_POST['query']);
    }

    $searchForm
      ->setMethod('get')
      ->populate($request->getParams())
      ;
    
  }
}