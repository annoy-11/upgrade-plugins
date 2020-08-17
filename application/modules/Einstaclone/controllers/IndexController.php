<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: IndexController.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_IndexController extends Core_Controller_Action_Standard {

  public function exploreAction() { 
    //Render
    $this->_helper->content->setEnabled();
  }
  
  public function searchAction() {
  
    $type = '';
    if (isset($_COOKIE['einstaclone_commonsearch']))
      $type = $_COOKIE['einstaclone_commonsearch'];

    $select = Engine_Api::_()->getDbtable('search', 'core')->select()
              ->where('title LIKE ? OR description LIKE ? OR keywords LIKE ? OR hidden LIKE ?', '%' . $this->_getParam('text', null) . '%')
              ->order('id DESC')
              ->limit('10');
    
    if ($type != 'Everywhere' && $type != '')
      $select->where('type =?', $type);

    $results = Zend_Paginator::factory($select);
    
    foreach ($results as $result) {
      $itemType = $result->type;
      if (Engine_Api::_()->hasItemType($itemType)) {
        $item = Engine_Api::_()->getItem($itemType, $result->id);
        if(empty($item))
         continue;
        $item_type = ucfirst($item->getShortType());
        $photo_icon_photo = $this->view->itemPhoto($item, 'thumb.icon');
        $data[] = array(
            'id' => $result->id,
            'label' => $item->getTitle(),
            'photo' => $photo_icon_photo,
            'url' => $item->getHref(),
            'resource_type' => $item_type,
        );
      }
    }
    $data[] = array(
        'id' => 'show_all',
        'label' => $text,
        'url' => 'all',
        'resource_type' => '',
    );
    return $this->_helper->json($data);
  }
}
