<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesquote_Widget_PopularityQuotesController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $this->view->allParams = $allParams = $this->_getAllParams();
    
    $this->view->quotes = Engine_Api::_()->getDbTable('quotes', 'sesquote')->getQuotesSelect(array('orderby' => $allParams['popularity'], 'limit' => $allParams['limit'], 'widget' => 1));
    
    if(count($this->view->quotes) == 0)
      return $this->setNoRender();
  }
}
