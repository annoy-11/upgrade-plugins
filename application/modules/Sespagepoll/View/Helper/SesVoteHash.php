<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SesVoteHash.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagepoll_View_Helper_SesVoteHash extends Zend_View_Helper_Abstract
{
    private $element = array();
    public function sesVoteHash(Sespagepoll_Model_Poll $poll = null)
    {
        $this->element = new Engine_Form_Element_Hash('token_sespagepoll_' . $poll->getIdentity(), array(
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
