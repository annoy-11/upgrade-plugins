<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslazyloadimage
 * @package    Seslazyloadimage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ItemBackgroundPhoto.php  2019-02-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslazyloadimage_View_Helper_ItemBackgroundPhoto extends Seslazyloadimage_View_Helper_ItemPhoto
{
    protected $_classPrefix = 'bg_';
    protected $_backgroundClass = 'bg_item_photo';

    public function itemBackgroundPhoto($item, $type = 'thumb.profile', $alt = "", $attribs = array())
    {
        $tag = 'span';
        if (!empty($attribs['tag'])) {
            $tag = $attribs['tag'];
            unset($attribs['tag']);
        }

        $this->setAttributes($item, $type, $attribs);
        if ($alt && empty($this->_attribs['title'])) {
            $this->_attribs['title'] = $alt;
        }

        if (!empty($this->_attribs['style']) && is_string($this->_attribs['style'])) {
            $this->_attribs['style'][] = $this->_attribs['style'];
        }

        $this->_attribs['style'][] = 'background-image:url("' . $this->_url . '");';

        $this->_attribs['class'] = $this->_backgroundClass . ' ' . $this->_attribs['class'];
        return '<' . $tag
        . $this->_htmlAttribs($this->_attribs)
        . '>'
        . '</'
        . $tag
        . '>';
    }
}
