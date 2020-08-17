<?php

class Sesdocument_Model_Sesdocument extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;
    protected $_owner_type = 'user';

   /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
  public function getHref($params = array()) {
    $params = array_merge(array(
        'route' => 'sesdocument_profile',
        'reset' => true,
        'id' =>  $this->custom_url,
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    if(!empty($_SESSION["removeSiteHeaderFooter"])){
      $params['sesdocument_id'] = $this->document_id;  
    }
    return Zend_Controller_Front::getInstance()->getRouter()
                    ->assemble($params, $route, $reset);
  }
    public function setFile($file) {
        if ($file instanceof Zend_Form_Element_File) {
            $file = $file->getFileName();
        } else if (is_array($file) && !empty($file['tmp_name'])) {
            $file = $file['tmp_name'];
        } else if (is_string($file) && file_exists($file)) {
            $file = $file;
        } else {
            throw new Sesdocument_Model_Exception('invalid argument passed to setFile');
        }
        $params = array(
            'parent_type' => 'sesdocument',
            'parent_id' => $this->getIdentity()
        );

        try {
            $document = Engine_Api::_()->storage()->create($file, $params);
        } catch (Exception $e) {
            return $e->getMessage();
        }

        $this->modified_date = new Zend_Db_Expr('NOW()');
        $this->file_id = $document->file_id;
        $this->save();
        return $document;

    }
   public  function getPhotoUrl($type = NULL){ 
     $photo_id = $this->file_id;
    if ($photo_id) { 
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->file_id, $type);
      if($file)
        return $file->map();
      else{
        $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->file_id,'thumb.profile');  
        if($file) 
          return $file->map();
      }
    } 
     $settings = Engine_Api::_()->getApi('settings', 'core');


  }
  /**
   * Gets a proxy object for the tags handler
   *
   * @return Engine_ProxyObject
   * */
  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }

  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   * */
  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }
  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   * */
  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }
  public function setPhoto($photo) {
    
    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if ($photo instanceof Storage_Model_File) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if ($photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id)) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $fileName = $photo;
    } else {
      throw new Exception('invalid argument passed to setPhoto');
    }
    if (!$fileName) {
      $fileName = basename($file);
    }

    $extension = ltrim(strrchr(basename($fileName), '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => $this->getType(),
        'parent_id' => $this->getIdentity(),
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        'name' => $fileName,
    );
    // Save
    $filesTable = Engine_Api::_()->getItemTable('storage_file');
    // Resize image (main)
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(500, 500)
            ->write($mainPath)
            ->destroy();


    // Store
    $iMain = $filesTable->createFile($mainPath, $params);

    // Remove temp files
    @unlink($mainPath);

    return $iMain->file_id;
  }
}	
