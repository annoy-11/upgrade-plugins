<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesvideoimporter
 * @package    Sesvideoimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php 2016-04-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesvideoimporter_IndexController extends Core_Controller_Action_Standard
{
  public function init()
  {    
	
    // only show videos if authorized
    if( !$this->_helper->requireAuth()->setAuthParams('video', null, 'view')->isValid()) return;

    $id = $this->_getParam('video_id', $this->_getParam('id', null));
    if( $id )
    {
      $video = Engine_Api::_()->getItem('video', $id);
      if( $video )
      {
        Engine_Api::_()->core()->setSubject($video);
      }
    }
    if( !$this->_helper->requireAuth()->setAuthParams('video', null, 'view')->isValid()) return;
	}
	
	public function playAction(){
		 if( !$this->_helper->requireUser()->isValid() ) return;
		 $this->view->video_id = $video_id = $this->_getParam('vid');
	}
	
	public function searchAction()
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        if (!$this->_helper->requireUser()->isValid())
            return;
        $this->view->can_create = $this->_helper->requireAuth()->setAuthParams('video', null, 'create')->checkRequire();
				if(!$this->view->can_create)
					return;
        //make the video search form
				$defaultText = Engine_Api::_()->getApi('settings', 'core')->getSetting('videoimporter.youtube.defaultsearchtext','pop music');
        $this->view->form = $form = new Sesvideoimporter_Form_YouTubeSearch();
				$form->populate(array('text'=>$defaultText));
        //Process form
        $form->isValid($this->_getAllParams());
        $values = $form->getValues();
        try
        {
            require_once('application/modules/Sesvideo/controllers/Google/autoload.php');
            $key = Engine_Api::_()->getApi('settings', 'core')->getSetting('video.youtube.apikey');
            $client = new Google_Client();
            $client->setDeveloperKey($key);
            $youtube = new Google_Service_YouTube($client);
						$recordCount = Engine_Api::_()->getApi('settings', 'core')->getSetting('videoimporter.default.recordCount','50');
						$safeSearch = Engine_Api::_()->getApi('settings', 'core')->getSetting('videoimporter.youtube.safe.search','none');
						$this->view->truncationLimit = Engine_Api::_()->getApi('settings', 'core')->getSetting('videoimporter.default.truncationLimit','30');
            $this->view->query = !empty($_GET['text']) ? $_GET['text'] : $defaultText;
						$this->view->query = urlencode(strip_tags(trim($this->view->query)));
            $this->view->searchResponse = $searchResponse = $youtube->search->listSearch(
                    'id,snippet',
                    array(
                        'q' => $this->view->query,
                        //'order' => 'viewCount',
                        'maxResults' => $recordCount,
                        'safeSearch' => $safeSearch,
                        'pageToken' => $_GET['pageToken'],
                        'type' => 'video',
                        //'videoType' => 'movie'
                    )
                );
        $videoFeed = array();
        $i = 0;
				
        foreach ($searchResponse['items'] as $searchResult) {
				
         if( $searchResult['id']['kind'] == 'youtube#video')
         {
             $videoFeed[$i]['id'] = $searchResult['id']['videoId'];
             $videoFeed[$i]['title'] = $searchResult['snippet']['title'];
             $videoFeed[$i]['description'] = $searchResult['snippet']['description'];
             $videoFeed[$i]['url'] = $searchResult['snippet']['thumbnails']['high']['url'];
             $i++;
         }
        
    }
		 $this->view->videoFeed = $videoFeed;
        }catch (Google_Service_Exception $e) {
            throw $e;
            
        } catch (Google_Exception $e) {
            throw $e;
        }
				// Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;

    }
  
}