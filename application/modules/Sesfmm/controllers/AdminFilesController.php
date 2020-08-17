<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfmm
 * @package    Sesfmm
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminFilesController.php  2019-01-03 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfmm_AdminFilesController extends Core_Controller_Action_Admin
{
  protected $_basePath;

  public function init()
  {
    // Check if folder exists and is writable
    if( !file_exists(APPLICATION_PATH . '/public/admin') ||
        !is_writable(APPLICATION_PATH . '/public/admin') ) {
      return $this->_forward('error', null, null, array(
        'message' => 'The public/admin folder does not exist or is not ' .
            'writable. Please create this folder and set full permissions ' .
            'on it (chmod 0777).',
      ));
    }

    // Set base path
    $this->_basePath = realpath(APPLICATION_PATH . '/public/admin');
  }

    public function indexAction()
    {

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfmm_admin_main', array(), 'sesfmm_admin_main_files');

        // Get path
        $this->view->path = $path = $this->_getPath();
        $this->view->relPath = $relPath = $this->_getRelPath($path);

        $this->view->formFilter = $formFilter = new Sesfmm_Form_Admin_Filter();
        $values = array();
        if ($formFilter->isValid($this->_getAllParams()))
            $values = $formFilter->getValues();

        $this->view->assign($values);

        // List files
        $files = array();
        $dirs = array();
        $contents = array();
        $it = new DirectoryIterator($path);
        foreach( $it as $key => $file ) {
            $filename = $file->getFilename();

            if( ($it->isDot() && $this->_basePath == $path) || $filename == '.' || ($filename != '..' && $filename[0] == '.') ) {
                continue;
            }

            $relPath = trim(str_replace($this->_basePath, '', realpath($file->getPathname())), '/\\');
            $ext = strtolower(ltrim(strrchr($file->getFilename(), '.'), '.'));

            if(!empty($_GET['extension']) && $ext == $_GET['extension']) {
                $dat = $this->getData($file, $ext,$it,$relPath);
                $contents[$relPath] = $dat;
            } else if(!empty($_GET['name']) && $filename == $_GET['name']) {
                $dat = $this->getData($file, $ext,$it,$relPath);
                $contents[$relPath] = $dat;
            } else if(empty($_GET['extension']) && empty($_GET['name'])) {
                $dat = $this->getData($file, $ext,$it,$relPath);
                $contents[$relPath] = $dat;
            }
        }
        ksort($contents);

        $this->view->extension = @$values['extension'];

        $this->view->paginator = $paginator = Zend_Paginator::factory($contents);
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));

        $this->view->files = $files;
        $this->view->dirs = $dirs;
        $this->view->contents = $contents;
    }

    public function getData($file, $ext,$it,$relPath) {

        if( $file->isDir() ) $ext = null;
        $type = 'generic';
        switch( true ) {
            case in_array($ext, array('jpg', 'png', 'gif', 'jpeg', 'bmp', 'tif', 'svg')):
            $type = 'image';
            break;
            case in_array($ext, array('txt', 'log', 'js')):
            $type = 'text';
            break;
            case in_array($ext, array('html', 'htm'/*, 'php'*/)):
            $type = 'markup';
            break;
        }
        $dat = array(
            'name' => $file->getFilename(),
            'path' => $file->getPathname(),
            'info' => $file->getPathInfo(),
            'rel' => $relPath,
            'ext' => $ext,
            'type' => $type,
            'is_dir' =>  $file->isDir(),
            'is_file' => $file->isFile(),
            'is_image' => ( $type == 'image' ),
            'is_text' => ( $type == 'text' ),
            'is_markup' => ( $type == 'markup' ),
        );
        if( $it->isDir() ) {
            $dirs[$relPath] = $dat;
        } else if( $it->isFile() ) {
            $files[$relPath] = $dat;
        }
        //$contents[$relPath] = $dat;

        return $dat;
    }

  public function renameAction()
  {
    $path = $this->_getPath();

    $this->view->fileIndex = $this->_getParam('index');

    if( !is_file($path) ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }

    @list($fileName, $fileExt) = explode('.', basename($path), 2);

    $this->view->form = $form = new Sesfmm_Form_Admin_File_Rename();
    $form->name->setValue($fileName);

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    $filename = $form->getValue('name');
    $newPath = dirname($path) . DIRECTORY_SEPARATOR . $filename . '.' . $fileExt;

    if( !rename($path, $newPath) ) {
      $form->addError('Unable to rename');
      return;
    }

    $this->view->fileName = basename($newPath);
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('The file has been successfully renamed.');
    // Redirect
    if( null === $this->_helper->contextSwitch->getCurrentContext() ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    } else if( 'smoothbox' === $this->_helper->contextSwitch->getCurrentContext() ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => Array($this->view->message),
      ));
    }
  }

  public function deleteAction()
  {
    $path = $this->_getPath();

    $this->view->fileIndex = $this->_getParam('index');

    if( !file_exists($path) ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }

    $this->view->form = $form = new Sesfmm_Form_Admin_File_Delete();
    $form->setAction($_SERVER['REQUEST_URI']);
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    $vals = $this->getRequest()->getPost();
    if( !empty($vals['actions']) && is_array($vals['actions']) ) {
      $vals['actions'] = join(PATH_SEPARATOR, $vals['actions']);
    }
    $form->isValid($vals);
    if( is_dir($path) ) {
      $actions = $vals['actions'];
      if( is_string($actions) ) {
        $actions = explode(PATH_SEPARATOR, $actions);
      } else if( !is_array($actions) ) {
        $actions = array(); // blegh
      }

      $it = new DirectoryIterator($path);
      foreach( $it as $file ) {
        if( !$file->isFile() ) continue;
        if( in_array($file->getFilename(), $actions) ) {
          if( !unlink($file->getPathname()) ) {
            // Blegh
          }
        }
      }

    } else if( is_file($path) ) {

      if( !@unlink($path) ) {
        return $form->addError('Unable to delete');
      }

    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('The file has been successfully deleted.');
    // Redirect
    if( null === $this->_helper->contextSwitch->getCurrentContext() ) {
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    } else if( 'smoothbox' === $this->_helper->contextSwitch->getCurrentContext() ) {
      return $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => Array($this->view->message)
      ));
    }
  }

  public function previewAction()
  {
    // Get path
    $path = $this->_getRelPath('path');

    if( file_exists($path) && is_file($path) ) {
      echo file_get_contents($path);
    }
    exit(); // ugly
  }

  public function downloadAction()
  {
    // Get path
    $path = $this->_getPath();

    if( file_exists($path) && is_file($path) ) {
      // Kill zend's ob
      while( ob_get_level() > 0 ) {
        ob_end_clean();
      }

      header("Content-Disposition: attachment; filename=" . urlencode(basename($path)), true);
      header("Content-Transfer-Encoding: Binary", true);
      header("Content-Type: application/force-download", true);
      header("Content-Type: application/octet-stream", true);
      header("Content-Type: application/download", true);
      header("Content-Description: File Transfer", true);
      header("Content-Length: " . filesize($path), true);
      flush();

      $fp = fopen($path, "r");
      while( !feof($fp) )
      {
        echo fread($fp, 65536);
        flush();
      }
      fclose($fp);
    }

    exit(); // Hm....
  }

  public function uploadAction()
  {
    $this->view->path = $path = $this->_getPath();
    $this->view->relPath = $relPath = $this->_getRelPath($path);

    // Check method
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if(empty($_POST['isURL'])) {
        // Prepare
        if( empty($_FILES['Filedata']) ) {
            $this->view->error = 'File failed to upload. Check your server settings (such as php.ini max_upload_filesize).';
            return;
        }

        // Prevent evil files from being uploaded
        $disallowedExtensions = array(''); //array('php');
        $parts = explode(".", $_FILES['Filedata']['name']);
        $name = end($parts);
        if( is_array($name) && in_array($name, $disallowedExtensions) ) {
            $this->view->error = 'File type or extension forbidden.';
            return;
        }
        $info = $_FILES['Filedata'];
        $targetFile = $path . '/' . $info['name'];
    }

    //Photo uplaod by url.
    if(!empty($_POST['isURL'])) {
        $photo = $this->setPhoto($_POST['Filedata']);
        $file = Engine_Api::_()->getItemTable('storage_file')->getFile($photo, '');
        $storage_path = explode('/', $file['storage_path']);

        if(isset($storage_path[3]))
            copy(APPLICATION_PATH . DIRECTORY_SEPARATOR . $file['storage_path'], $path.DIRECTORY_SEPARATOR.$storage_path[3]);
        if(isset($storage_path[4]))
            copy(APPLICATION_PATH . DIRECTORY_SEPARATOR . $file['storage_path'], $path.DIRECTORY_SEPARATOR.$storage_path[4]);
        if($file) {
            $file->delete();
            //$file->save();
        }
    }

    if( @file_exists($targetFile) ) {
      $deleteUrl = $this->view->url(array('action' => 'delete')) . '?path=' . $relPath . '/' . $info['name'];
      $deleteUrlLink = '<a href="'.$this->view->escape($deleteUrl) . '">' . Zend_Registry::get('Zend_Translate')->_("delete") . '</a>';
      $this->view->error = Zend_Registry::get('Zend_Translate')->_(sprintf("File already exists. Please %s before trying to upload.", $deleteUrlLink));
      return;
    }

    if( !is_writable($path) ) {
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Path is not writeable. Please CHMOD 0777 the public/admin directory.');
      return;
    }

    // Try to move uploaded file
    if(empty($_POST['isURL'])) {
        if( !move_uploaded_file($info['tmp_name'], $targetFile) ) {
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Unable to move file to upload directory.");
            return;
        }
    }

    $this->view->status = 1;
    if(empty($_POST['isURL'])) {
        $this->view->fileName = $_FILES['Filedata']['name'];
        $this->view->extensionName = $name; //$_FILES['Filedata']['name'];
    }
  }

    protected function setPhoto($photo,$id = 0) {

        if (is_string($photo)) {
            $file = $photo;
            $fileName = $photo;
        } else {
            throw new User_Model_Exception('invalid argument passed to setPhoto');
        }

        if (!$fileName) {
            $fileName = $file;
        }

        $name = basename($file);
        $extension = ltrim(strrchr($fileName, '.'), '.');
        $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
        $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
        $params = array(
            'parent_type' => 'sesfmm',
            'parent_id' => $id,
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
            'name' => $fileName,
        );
        // Save
        $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
        $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_main.' . $extension;
        $image = Engine_Image::factory();
        $image->open($file)
                ->resize(500, 500)
                ->write($mainPath)
                ->destroy();
        // Store
        try {
            $iMain = $filesTable->createFile($mainPath, $params);
        } catch (Exception $e) {
        // Remove temp files
        @unlink($mainPath);
        // Throw
        if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
            throw new Sesvideoimporter_Model_Exception($e->getMessage(), $e->getCode());
        } else {
            throw $e;
        }
        }
        // Remove temp files
        @unlink($mainPath);
        // Update row
        return $iMain->file_id;
    }

  public function errorAction()
  {
    $this->getResponse()->setBody($this->view->translate($this->_getParam('message', 'error')));
    $this->_helper->viewRenderer->setNoRender(true);
  }



  protected function _getPath($key = 'path')
  {
    return $this->_checkPath(urldecode($this->_getParam($key, '')), $this->_basePath);
  }

  protected function _getRelPath($path, $basePath = null)
  {
    if( null === $basePath ) $basePath = $this->_basePath;
    $path = realpath($path);
    $basePath = realpath($basePath);
    $relPath = trim(str_replace($basePath, '', $path), '/\\');
    return $relPath;
  }

  protected function _checkPath($path, $basePath)
  {
    // Sanitize
    //$path = preg_replace('/^[a-z0-9_.-]/', '', $path);
    $path = preg_replace('/\.{2,}/', '.', $path);
    $path = preg_replace('/[\/\\\\]+/', '/', $path);
    $path = trim($path, './\\');
    $path = $basePath . '/' . $path;

    // Resolve
    $basePath = realpath($basePath);
    $path = realpath($path);

    // Check if this is a parent of the base path
    if( $basePath != $path && strpos($basePath, $path) !== false ) {
      return $this->_helper->redirector->gotoRoute(array());
    }

    return $path;
  }
}
