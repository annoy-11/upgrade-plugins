<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslazyloadimage
 * @package    Seslazyloadimage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ItemPhoto.php  2019-02-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslazyloadimage_View_Helper_ItemPhoto extends Engine_View_Helper_HtmlImage {

  protected $_noPhotos;
  protected $_classPrefix = '';
  protected $_url;
  protected $_attribs = array();

  public function itemPhoto($item, $type = 'thumb.profile', $alt = "", $attribs = array())
  {
    return $this->setAttributes($item, $type, $attribs)->htmlImage($this->_url, $alt, $this->_attribs);
  }

  public function setAttributes($item, $type = 'thumb.profile', $attribs = array())
  {
    if( !($item instanceof Core_Model_Item_Abstract) ) {
      throw new Zend_View_Exception("Item must be a valid item");
    }

    // Get url
    $src = $item->getPhotoUrl($type);
    $safeName = ( $type ? str_replace('.', '_', $type) : 'main' );
    $attribs['class'] = ( isset($attribs['class']) ? $attribs['class'] . ' ' : '' );
    //Add additional class
    $attribs['class'] .= '_lazyload' . ' ';
    $attribs['class'] .= $this->_classPrefix . $safeName . ' ';
    $attribs['class'] .= $this->_classPrefix . 'item_photo_' . $item->getType() . ' ';
    // Default image
    if( !$src ) {
      $src = $this->getNoPhoto($item, $safeName);
      $attribs['class'] .= $this->_classPrefix . 'item_nophoto ';
    }
    //Default image when page load

    $this->_url = 'application/modules/Sesbasic/externals/images/blank-img.gif';
    $attribs[ 'data-src' ] = $src;
    $this->_attribs = $attribs;
    return $this;
  }

  public function getNoPhoto($item, $type)
  {
    $type = ( $type ? str_replace('.', '_', $type) : 'main' );

    if( ($item instanceof Core_Model_Item_Abstract ) ) {
      $item = $item->getType();
    } else if( !is_string($item) ) {
      return '';
    }

    if( !Engine_Api::_()->hasItemType($item) ) {
      return '';
    }

    // Load from registry
    if( null === $this->_noPhotos ) {
      // Process active themes
      $themesInfo = Zend_Registry::get('Themes');
      foreach( $themesInfo as $themeName => $themeInfo ) {
        if( !empty($themeInfo['nophoto']) ) {
          foreach( (array) $themeInfo['nophoto'] as $itemType => $moreInfo ) {
            if( !is_array($moreInfo) ) {
              continue;
            }
            if( !empty($this->_noPhotos[$itemType]) ) {
              $moreInfo = array_merge((array) $this->_noPhotos[$itemType], $moreInfo);
            }
            $this->_noPhotos[$itemType] = $moreInfo;

          }
        }
      }
    }

    // Use default
    if( !isset($this->_noPhotos[$item][$type]) ) {
      $shortType = $item;
      if( strpos($shortType, '_') !== false ) {
        list($null, $shortType) = explode('_', $shortType, 2);
      }
      $module = Engine_Api::_()->inflect(Engine_Api::_()->getItemModule($item));
      $this->_noPhotos[$item][$type] = //$this->view->baseUrl() . '/' .
        $this->view->layout()->staticBaseUrl . 'application/modules/' .
        $module .
        '/externals/images/nophoto_' .
        $shortType . '_'
        . $type . '.png';
    }

    return $this->_noPhotos[$item][$type];
  }

}
