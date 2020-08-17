<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SesGroupVoteHash.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgrouppoll_View_Helper_SesGroupVoteHash extends Zend_View_Helper_Abstract
{
    private $element = array();
    public function sesGroupVoteHash(Sesgrouppoll_Model_Poll $poll = null)
    {
        $this->element = new Engine_Form_Element_Hash('token_sesgrouppoll_' . $poll->getIdentity(), array(
          'timeout' => 3600
        ));
        return $this;
    }
    public function getElement()
    {
        return $this->element;
    }
    public function generateHash()
    {
        $this->element->initCsrfToken();
        return $this->element->getHash();
    }

}
