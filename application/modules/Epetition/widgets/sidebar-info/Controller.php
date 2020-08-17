<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Widget_SidebarInfoController extends Engine_Content_Widget_Abstract
{
  protected $_childCount;

  public function indexAction()
  {
    $fc = Zend_Controller_Front::getInstance();
    $this->view->allParams =$param= $this->_getAllParams();
    $id = $fc->getRequest()->getParam('epetition_id', null);
    $epetition=Engine_Api::_()->getItem('epetition',Engine_Api::_()->getDbtable('epetitions','epetition')->getPetitionId($id));
    $this->view->deadline=$epetition['endtime'];
    $this->view->location="<a href='".$fc->getBaseUrl()."/petitions/locations"."'>".$epetition['location']."</a>";
    $tagUrl='';
    foreach ($epetition->tags()->getTagMaps() as $tagMap) {
      $tag = $tagMap->getTag();
      if (!isset($tag->text)) continue;
      if ('' !== $tagUrl) $tagUrl .= ', ';
      if(isset($tag->tag_id) && isset($tag->text))
      {
        $tagUrl.="<a href='".$fc->getBaseUrl()."/petitions/browse?tag_id=".$tag->tag_id."&tag_name=".$tag->text."'>".$tag->text."</a>";
      }
    }
    if(isset($epetition['category_id']))
    {
      $category = Engine_Api::_()->getItem('epetition_category', $epetition['category_id']);
      $this->view->category = "<a href='" . $fc->getBaseUrl() . "/petitions/browse?category_id=" . $epetition['category_id'] . "'>" . $category['category_name'] . "</a>";
    }
    $this->view->tags=$tagUrl;



  }


}
