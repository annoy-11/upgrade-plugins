<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Testimonial.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sestestimonial_Model_Testimonial extends Core_Model_Item_Abstract {

    protected $_searchTriggers = false;
    protected $_type = 'testimonial';

    public function getHref($params = array()) {

        $slug = $this->getSlug();

        $params = array_merge(array(
            'route' => 'sestestimonial_entry_view',
            'reset' => true,
            'testimonial_id' => $this->testimonial_id,
            'slug' => $slug,
        ), $params);
        $route = $params['route'];
        $reset = $params['reset'];
        unset($params['route']);
        unset($params['reset']);
        return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
    }

    /**
    * Gets a proxy object for the comment handler
    *
    * @return Engine_ProxyObject
    **/
    public function comments()
    {
        return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
    }


    /**
    * Gets a proxy object for the like handler
    *
    * @return Engine_ProxyObject
    **/
    public function likes()
    {
        return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
    }
}
