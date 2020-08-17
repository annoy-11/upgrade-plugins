<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Attribution.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Form_Attribution extends Engine_Form {
  protected $_pageItem;
  public function getPageItem() {
    return $this->_pageItem;
  }

  public function setPageItem($pageItem) {
    $this->_pageItem = $pageItem;
    return $this;
  }
  public function init() {
    parent::init();
    //get current logged in user
    $this->setTitle('Post Attribution')
            ->setAttrib('id', 'sespage_attr_form')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");
    
    $attribution[1] = '<b>Post as '.$this->_pageItem->getTitle().'</b><br>Your posts, likes and comments on this Page\'s timeline will be attributed to the Page by default. When you\'re creating or replying to a post, you will still have the option to post as yourself or another Page you manage.';
    
    $attribution[0] = '<b>Post as '.Engine_Api::_()->user()->getViewer()->getTitle().'</b></br>Your posts, likes and comments on this Page\'s timeline will be attributed to you by default. When you\'re creating or replying to a post, you will still have the option to post as this Page or another Page you manage.';
    
    $this->addElement('Radio', 'attribution', array(
          'label' => '',
          'description' => '',
          'multiOptions' => $attribution,
          'escape' => false,
      ));
  }
}
