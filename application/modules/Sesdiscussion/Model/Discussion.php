<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Discussion.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Model_Discussion extends Core_Model_Item_Abstract
{
  // Properties

  protected $_parent_type = 'user';
  protected $_searchTriggers = array('title', 'search');
  protected $_parent_is_owner = true;
  protected $_type = 'discussion';

  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
  public function getHref($params = array())
  {
    $slug = $this->getSlug();

    $params = array_merge(array(
      'route' => 'sesdiscussion_entry_view',
      'reset' => true,
      'user_id' => $this->owner_id,
      'discussion_id' => $this->discussion_id,
      'slug' => $slug,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }

  public function getKeywords($separator = ' ')
  {
    $keywords = array();
    foreach( $this->tags()->getTagMaps() as $tagmap ) {
      $tag = $tagmap->getTag();
      $keywords[] = $tag->getTitle();
    }

    if( null === $separator ) {
      return $keywords;
    }

    return join($separator, $keywords);
  }

  public function getRichContent($view = false, $params = array()) {

    $videoEmbedded = '';
    if (!$view) {
      $view = Zend_Registry::get('Zend_View');
      $view->discussion = $this;
      $videoEmbedded = $view->render('application/modules/Sesdiscussion/views/scripts/_discussion.tpl');
    }

    return $videoEmbedded;
  }

  // Interfaces

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

  /**
   * Gets a proxy object for the tags handler
   *
   * @return Engine_ProxyObject
   **/
  public function tags()
  {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }


  public function setPhoto($photo) {

    if( $photo instanceof Zend_Form_Element_File ) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if( $photo instanceof Storage_Model_File ) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if( $photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id) ) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if( is_string($photo) ) {
      $file = $photo;
      $fileName = $photo;
      $unlink = false;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }

    if( is_array($photo) && !empty($photo['tmp_name']) ) {
      $name = basename($photo['name']);
    } else {
      $name = basename($file);
		}

    if( !$fileName ) {
      $fileName = $file;
    }

    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
      'parent_type' => $this->getType(),
      'parent_id' => $this->getIdentity(),
      'user_id' => $this->owner_id,
      'name' => $fileName,
    );


    // Save
    $storage = Engine_Api::_()->storage();

    // Resize image (main)
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(720, 720)
      ->write($path . '/m_' . $name)
      ->destroy();

    // Resize image (profile)
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(200, 400)
      ->write($path . '/p_' . $name)
      ->destroy();


    // Store
    $iMain = $storage->create($path . '/m_' . $name, $params);
    $iProfile = $storage->create($path . '/p_' . $name, $params);

    $iMain->bridge($iProfile, 'thumb.profile');

    // Remove temp files
    @unlink($path . '/p_' . $name);
    @unlink($path . '/m_' . $name);

    // Update row
    $this->modified_date = date('Y-m-d H:i:s');
    $this->photo_id = $iMain->getIdentity();
    $this->save();
    return $this;
  }
}
