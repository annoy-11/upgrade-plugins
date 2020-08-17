<?php

class Seslink_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {
    // only show to member_level if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('seslink_link', null, 'view')->isValid() ) return;
  }
  
  public function indexAction() {
    $this->_helper->content->setEnabled();
  }

  public function createAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('seslink_link', null, 'create')->isValid()) return;

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;

    // set up data needed to check quota
    $viewer = Engine_Api::_()->user()->getViewer();

    // Prepare form
    $this->view->form = $form = new Seslink_Form_Create();
            
    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $table = Engine_Api::_()->getItemTable('seslink_link');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
      // Create link
      $viewer = Engine_Api::_()->user()->getViewer();
      $formValues = $form->getValues();


      if( empty($values['auth_view']) ) {
        $formValues['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $formValues['auth_comment'] = 'everyone';
      }

      $values = array_merge($formValues, array(
        'owner_type' => $viewer->getType(),
        'owner_id' => $viewer->getIdentity(),
        'view_privacy' => $formValues['auth_view'],
      ));

      $link = $table->createRow();
      $link->setFromArray($values);
      $link->save();
      
      if( !empty($values['photo']) && empty($formValues['imagelink']) ) {
        $link->setPhoto($form->photo);
      } else if($formValues['imagelink']) {
        $photo_id = $this->setPhoto($formValues['imagelink'], $link->getIdentity());
        $link->photo_id = $photo_id;
        $link->save();
      }

      // Auth
      $auth = Engine_Api::_()->authorization()->context;
      $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($link, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($link, $role, 'comment', ($i <= $commentMax));
      }
      
      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $link->tags()->addTagMaps($viewer, $tags);

      // Add activity only if link is published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $link, 'seslink_link_new');
      // make sure action exists before attaching the link to the activity
      if( $action ) {
        Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $link);
      }
      // Commit
      $db->commit();
    } catch( Exception $e ) {
      return $this->exceptionWrapper($e, $form, $db);
    }

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
  }
  

  public function editAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    $viewer = Engine_Api::_()->user()->getViewer();
    $link = Engine_Api::_()->getItem('seslink_link', $this->_getParam('link_id'));
    if( !Engine_Api::_()->core()->hasSubject('seslink_link') ) {
      Engine_Api::_()->core()->setSubject($link);
    }

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams($link, $viewer, 'edit')->isValid() ) return;

    // Get navigation
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seslink_main');

    // Prepare form
    $this->view->form = $form = new Seslink_Form_Edit();

    // Populate form
    $form->populate($link->toArray());

    $tagStr = '';
    foreach( $link->tags()->getTagMaps() as $tagMap ) {
      $tag = $tagMap->getTag();
      if( !isset($tag->text) ) continue;
      if( '' !== $tagStr ) $tagStr .= ', ';
      $tagStr .= $tag->text;
    }
    $form->populate(array(
      'tags' => $tagStr,
    ));
    $this->view->tagNamePrepared = $tagStr;

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

//     foreach( $roles as $role ) {
//       if ($form->auth_view){
//         if( $auth->isAllowed($link, $role, 'view') ) {
//          $form->auth_view->setValue($role);
//         }
//       }
// 
//       if ($form->auth_comment){
//         if( $auth->isAllowed($link, $role, 'comment') ) {
//           $form->auth_comment->setValue($role);
//         }
//       }
//     }

    // Check post/form
    if( !$this->getRequest()->isPost() ) {
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try {
      $values = $form->getValues();

      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }
      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $values['view_privacy'] = $values['auth_view'];

      $link->setFromArray($values);
      $link->modified_date = date('Y-m-d H:i:s');
      $link->save();

      // Add photo
      if( !empty($values['photo']) ) {
        $link->setPhoto($form->photo);
      }

      // Auth
      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($link, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($link, $role, 'comment', ($i <= $commentMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $link->tags()->setTagMaps($viewer, $tags);
      $db->commit();
    }
    catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
  }


  // USER SPECIFIC METHODS
  public function manageAction()
  {
    if( !$this->_helper->requireUser()->isValid() ) return;

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Seslink_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('seslink_link', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Process form
    $defaultValues = $form->getValues();
    if( $form->isValid($this->_getAllParams()) ) {
      $values = $form->getValues();
    } else {
      $values = $defaultValues;
    }
    $this->view->formValues = array_filter($values);
    $values['user_id'] = $viewer->getIdentity();
    
    $values = array_merge($values, $_GET);
    if(isset($values['tag_id']))
      $values['tag'] = $values['tag_id'];

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('seslink_link')->getLinksPaginator($values);
    $items_per_page = 10; //Engine_Api::_()->getApi('settings', 'core')->blog_page;
    $paginator->setItemCountPerPage($items_per_page);
    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );
  }
  
 
  public function viewAction()
  {

    // Check permission
    $viewer = Engine_Api::_()->user()->getViewer();
    $link = Engine_Api::_()->getItem('seslink_link', $this->_getParam('link_id'));
    if( $link ) {
      Engine_Api::_()->core()->setSubject($link);
    }

    if( !$this->_helper->requireSubject()->isValid() ) {
      return;
    }
    if( !$this->_helper->requireAuth()->setAuthParams($link, $viewer, 'view')->isValid() ) {
      return;
    }
    
//     if( !$link || !$link->getIdentity() || 
//         (!$link->isOwner($viewer)) ) {
//       return $this->_helper->requireSubject->forward();
//     }

    
    // Prepare data
    $linkTable = Engine_Api::_()->getDbtable('links', 'seslink');
    
    $this->view->link = $link;
    $this->view->owner = $owner = $link->getOwner();
    $this->view->viewer = $viewer;
    $this->view->viewer_id = $viewer->getIdentity();

    // Do other stuff
    $this->view->mine = true;
    $this->view->canEdit = $this->_helper->requireAuth()->setAuthParams($link, null, 'edit')->checkRequire();
    if( !$link->getOwner()->isSelf(Engine_Api::_()->user()->getViewer()) ) {
      $link->getTable()->update(array(
        'view_count' => new Zend_Db_Expr('view_count + 1'),
      ), array(
        'link_id = ?' => $link->getIdentity(),
      ));
      $this->view->mine = false;
    }
    
    if ($viewer->getIdentity() != 0 && isset($link->link_id)) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_seslink_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $link->link_id . '", "seslink_link","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }
    
    // Get tags
    $this->view->textTags = $link->tags()->getTagMaps();

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
  }
  
  public function deleteAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $link = Engine_Api::_()->getItem('seslink_link', $this->getRequest()->getParam('link_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($link, null, 'delete')->isValid()) return;

    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Seslink_Form_Delete();

    if( !$link ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Link entry doesn't exist or not authorized to delete");
      return;
    }

    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $link->getTable()->getAdapter();
    $db->beginTransaction();

    try {
      $link->delete();
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your link entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'seslink_general', true),
      'messages' => Array($this->view->message)
    ));
  }
  

  public function previewAction() {
  
    if( !$this->_helper->requireUser()->isValid() )
      return;

    // clean URL for html code
    $uri = trim(strip_tags($this->_getParam('uri')));
    $displayUri = $uri;
    $info = parse_url($displayUri);
    if( !empty($info['path']) ) {
      $displayUri = str_replace($info['path'], urldecode($info['path']), $displayUri);
    }
    $this->view->url = Engine_String::convertUtf8($displayUri);
    $this->view->title = '';
    $this->view->description = '';
    $this->view->thumb = null;
    $this->view->imageCount = 0;
    $this->view->images = array();
    $this->view->richHtml = '';
    try {
      $config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;
      if( !empty($config['host']) && $config['host'] != 'none' ) {
        $this->_getFromIframely($config, $uri);
      } else {
        $this->_getFromClientRequest($uri);
      }
      echo Zend_Json::encode(array('status' => 1, 'title' => Engine_String::convertUtf8($this->view->title), 'description'=>Engine_String::convertUtf8($this->view->description), 'image' => $this->view->images[0], 'richHtml' => $this->view->richHtml));exit();
    } catch( Exception $e ) {
      throw $e;
      echo Zend_Json::encode(array('status' => 0));die;
    }
  }
  
  protected function _getFromIframely($config, $uri)
  {
    $iframely = Engine_Iframely::factory($config)->get($uri);
    $images = array();
    if( !empty($iframely['links']['thumbnail']) ) {
      $images[] = $iframely['links']['thumbnail'][0]['href'];
    }
    if( !empty($iframely['meta']['title']) ) {
      $this->view->title = $iframely['meta']['title'];
    }
    if( !empty($iframely['meta']['description']) ) {
      $this->view->description = $iframely['meta']['description'];
    }
    $this->view->imageCount = count($images);
    $this->view->images = $images;
    $allowRichHtmlTyes = array(
      'player',
      'image',
      'reader',
      'survey',
      'file'
    );
    $typeOfContent = array_intersect(array_keys($iframely['links']), $allowRichHtmlTyes);
    if( $typeOfContent ) {
      $this->view->richHtml = $iframely['html'];
    }
  }

  protected function _getFromClientRequest($uri)
  {
    $info = parse_url($uri);
    if( !empty($info['path']) ) {
      $path = urldecode($info['path']);
      foreach( explode('/', $info['path']) as $path ) {
        $paths[] = urlencode($path);
      }
      $uri = str_replace($info['path'], join('/', $paths), $uri);
    }
    $client = new Zend_Http_Client($uri, array(
      'maxredirects' => 2,
      'timeout' => 10,
    ));
    // Try to mimic the requesting user's UA
    $client->setHeaders(array(
      'User-Agent' => $_SERVER['HTTP_USER_AGENT'],
      'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
      'X-Powered-By' => 'Zend Framework'
    ));
    $response = $client->request();
    // Get content-type
    list($contentType) = explode(';', $response->getHeader('content-type'));
    $this->view->contentType = $contentType;
    // Handling based on content-type
    switch( strtolower($contentType) ) {
      // Images
      case 'image/gif':
      case 'image/jpeg':
      case 'image/jpg':
      case 'image/tif': // Might not work
      case 'image/xbm':
      case 'image/xpm':
      case 'image/png':
      case 'image/bmp': // Might not work
        $this->_previewImage($uri, $response);
        break;
      // HTML
      case '':
      case 'text/html':
        $this->_previewHtml($uri, $response);
        break;
      // Plain text
      case 'text/plain':
        $this->_previewText($uri, $response);
        break;
      // Unknown
      default:
        break;
    }
  }

  protected function _previewImage($uri, Zend_Http_Response $response)
  {
    $this->view->imageCount = 1;
    $this->view->images = array($uri);
  }

  protected function _previewText($uri, Zend_Http_Response $response)
  {
    $body = $response->getBody();
    if( preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getHeader('content-type'), $matches) ||
      preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getBody(), $matches) ) {
      $charset = trim($matches[1]);
    } else {
      $charset = 'UTF-8';
    }
    // Reduce whitespace
    $body = preg_replace('/[\n\r\t\v ]+/', ' ', $body);
    $this->view->title = substr($body);
    $this->view->description = substr($body);
  }

  protected function _previewHtml($uri, Zend_Http_Response $response)
  {
    $body = $response->getBody();
    $body = trim($body);
    if( preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getHeader('content-type'), $matches) ||
      preg_match('/charset=([a-zA-Z0-9-_]+)/i', $response->getBody(), $matches) ) {
      $this->view->charset = $charset = trim($matches[1]);
    } else {
      $this->view->charset = $charset = 'UTF-8';
    }
    if( function_exists('mb_convert_encoding') ) {
      $body = mb_convert_encoding($body, 'HTML-ENTITIES', $charset);
    }
    // Get DOM
    if( class_exists('DOMDocument') ) {
      $dom = new Zend_Dom_Query($body);
    } else {
      $dom = null; // Maybe add b/c later
    }
    $title = null;
    if( $dom ) {
      $titleList = $dom->query('title');
      if( count($titleList) > 0 ) {
        $title = trim($titleList->current()->textContent);
      }
    }
    $this->view->title = $title;
    $description = null;
    if( $dom ) {
      $descriptionList = $dom->queryXpath("//meta[@name='description']");
      // Why are they using caps? -_-
      if( count($descriptionList) == 0 ) {
        $descriptionList = $dom->queryXpath("//meta[@name='Description']");
      }
      // Try to get description which is set under og tag
      if( count($descriptionList) == 0 ) {
        $descriptionList = $dom->queryXpath("//meta[@property='og:description']");
      }
      if( count($descriptionList) > 0 ) {
        $description = trim($descriptionList->current()->getAttribute('content'));
      }
    }
    $this->view->description = $description;
    $thumb = null;
    if( $dom ) {
      $thumbList = $dom->queryXpath("//link[@rel='image_src']");
      $attributeType = 'href';
      if(count($thumbList) == 0 ) {
        $thumbList = $dom->queryXpath("//meta[@property='og:image']");
        $attributeType = 'content';
      }
      if( count($thumbList) > 0 ) {
        $thumb = $thumbList->current()->getAttribute($attributeType);
      }
    }
    $this->view->thumb = $thumb;
    $medium = null;
    if( $dom ) {
      $mediumList = $dom->queryXpath("//meta[@name='medium']");
      if( count($mediumList) > 0 ) {
        $medium = $mediumList->current()->getAttribute('content');
      }
    }
    $this->view->medium = $medium;
    // Get baseUrl and baseHref to parse . paths
    $baseUrlInfo = parse_url($uri);
    $baseUrl = null;
    $baseHostUrl = null;
    $baseUrlScheme = $baseUrlInfo['scheme'];
    $baseUrlHost = $baseUrlInfo['host'];
    if( $dom ) {
      $baseUrlList = $dom->query('base');
      if( $baseUrlList && count($baseUrlList) > 0 && $baseUrlList->current()->getAttribute('href') ) {
        $baseUrl = $baseUrlList->current()->getAttribute('href');
        $baseUrlInfo = parse_url($baseUrl);
        if( !isset($baseUrlInfo['scheme']) || empty($baseUrlInfo['scheme']) ) {
          $baseUrlInfo['scheme'] = $baseUrlScheme;
        }
        if( !isset($baseUrlInfo['host']) || empty($baseUrlInfo['host']) ) {
          $baseUrlInfo['host'] = $baseUrlHost;
        }
        $baseHostUrl = $baseUrlInfo['scheme'] . '://' . $baseUrlInfo['host'] . '/';
      }
    }
    if( !$baseUrl ) {
      $baseHostUrl = $baseUrlInfo['scheme'] . '://' . $baseUrlInfo['host'] . '/';
      if( empty($baseUrlInfo['path']) ) {
        $baseUrl = $baseHostUrl;
      } else {
        $baseUrl = explode('/', $baseUrlInfo['path']);
        array_pop($baseUrl);
        $baseUrl = join('/', $baseUrl);
        $baseUrl = trim($baseUrl, '/');
        $baseUrl = $baseUrlInfo['scheme'] . '://' . $baseUrlInfo['host'] . '/' . $baseUrl . '/';
      }
    }
    $images = array();
    if( $thumb ) {
      $images[] = $thumb;
    }
    if( $dom ) {
      $imageQuery = $dom->query('img');
      foreach( $imageQuery as $image ) {
        $src = $image->getAttribute('src');
        // Ignore images that don't have a src
        if( !$src || false === ($srcInfo = @parse_url($src)) ) {
          continue;
        }
        $ext = ltrim(strrchr($src, '.'), '.');
        // Detect absolute url
        if( strpos($src, '/') === 0 ) {
          // If relative to root, add host
          $src = $baseHostUrl . ltrim($src, '/');
        } elseif( strpos($src, './') === 0 ) {
          // If relative to current path, add baseUrl
          $src = $baseUrl . substr($src, 2);
        } elseif( !empty($srcInfo['scheme']) && !empty($srcInfo['host']) ) {
          // Contians host and scheme, do nothing
        } elseif( empty($srcInfo['scheme']) && empty($srcInfo['host']) ) {
          // if not contains scheme or host, add base
          $src = $baseUrl . ltrim($src, '/');
        } elseif( empty($srcInfo['scheme']) && !empty($srcInfo['host']) ) {
          // if contains host, but not scheme, add scheme?
          $src = $baseUrlInfo['scheme'] . ltrim($src, '/');
        } else {
          // Just add base
          $src = $baseUrl . ltrim($src, '/');
        }

        if( !in_array($src, $images) ) {
          $images[] = $src;
        }
      }
    }
    // Unique
    $images = array_values(array_unique($images));
    // Truncate if greater than 20
    if( count($images) > 30 ) {
      array_splice($images, 30, count($images));
    }
    $this->view->imageCount = count($images);
    $this->view->images = $images;
  }
  
  protected function setPhoto($photo, $id = 0) {
  
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
        'parent_type' => 'seslink_link',
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
        throw new Seslink_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }
}
