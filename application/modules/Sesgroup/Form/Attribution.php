<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Attribution.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Form_Attribution extends Engine_Form {
  protected $_groupItem;
  public function getGroupItem() {
    return $this->_groupItem;
  }

  public function setGroupItem($groupItem) {
    $this->_groupItem = $groupItem;
    return $this;
  }
  public function init() {
    parent::init();
    //get current logged in user
    $this->setTitle('Post Attribution')
            ->setAttrib('id', 'sesgroup_attr_form')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");
    
    $attribution[1] = '<b>Post as '.$this->_groupItem->getTitle().'</b><br>Your posts, likes and comments on this Group\'s timeline will be attributed to the Group by default. When you\'re creating or replying to a post, you will still have the option to post as yourself or another Group you manage.';
    
    $attribution[0] = '<b>Post as '.Engine_Api::_()->user()->getViewer()->getTitle().'</b></br>Your posts, likes and comments on this Group\'s timeline will be attributed to you by default. When you\'re creating or replying to a post, you will still have the option to post as this Group or another Group you manage.';
    
    $this->addElement('Radio', 'attribution', array(
          'label' => '',
          'description' => '',
          'multiOptions' => $attribution,
          'escape' => false,
      ));
  }
}
