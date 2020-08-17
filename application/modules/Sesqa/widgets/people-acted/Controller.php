<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Widget_PeopleActedController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    if( !Engine_Api::_()->core()->hasSubject() ) {
        return $this->setNoRender();
      }
      // Get subject and check auth
      $this->view->question = $subject = Engine_Api::_()->core()->getSubject();
      
      $this->view->defaultOptionsArray = $defaultOptionsArray = $this->_getParam('search_type',array('Like','Follow','Fav'));
      if(!is_array($defaultOptionsArray) || !count($defaultOptionsArray))
        return $this->setNoRender();
			$defaultOptions = $arrayOptions = array();
			foreach($defaultOptionsArray as $key=>$defaultValue){
				if( $this->_getParam($defaultValue.'_order'))
					$order = $this->_getParam($defaultValue.'_order').'||'.$defaultValue;
				else
					$order = (999+$key).'||'.$defaultValue;
				if( $this->_getParam($defaultValue.'_label'))
						$valueLabel = $this->_getParam($defaultValue.'_label');
				else{
					if($defaultValue == 'Like')
						$valueLabel = 'People Who Like This';
					else if($defaultValue == 'Follow')
						$valueLabel = 'People Who Follow This';
					else if($defaultValue == 'Fav')
						$valueLabel = 'People Who Added This As Favourite';
				}
				$arrayOptions[$order] = $valueLabel;
			}
			ksort($arrayOptions);
			$counter = 0;
			foreach($arrayOptions as $key => $valueOption){
				$key = explode('||',$key);
			if($counter == 0)
				$this->view->defaultOpenTab = $defaultOpenTab = $key[1];
				$defaultOptions[$key[1]]=$valueOption;
				$counter++;
			}
      $limit = 0;
			$this->view->defaultOptions = $defaultOptions;
			if(array_key_exists('Like',$defaultOptions)){
				$param['type'] = 'sesqa_question';
        $parentTable = Engine_Api::_()->getItemTable('core_like');
        $parentTableName = $parentTable->info('name');
        $select = $parentTable->select()
                ->from($parentTableName)
                ->where('resource_type = ?', 'sesqa_question')
                ->order('like_id DESC');
        $select = $select->where('resource_id = ?', $subject->getIdentity());
				$this->view->paginatorLike = $paginatorLike = Zend_Paginator::factory($select);
				$this->view->data_showLike = $limit_dataLike = $this->_getParam('Like_limitdata','10');
				$paginatorLike->setItemCountPerPage($limit_dataLike);
				$paginatorLike->setCurrentPageNumber(1);
        
        if($paginatorLike->getTotalItemCount() > 0){
            $limit++;
        }
			}
			if(array_key_exists('Follow',$defaultOptions)){
      $tableFollow= Engine_Api::_()->getDbtable('follows', 'sesqa');
        $tableFollowName = $tableFollow->info('name');
        $select = $tableFollow->select()
                  ->where($tableFollowName.'.resource_id =?',$subject->getIdentity());
				$this->view->paginatorFollow = $paginatorFollowUser = Zend_Paginator::factory($select);
				$this->view->data_showFollow = $limit_dataFollow = $this->_getParam('Follow_limitdata','10');
				// Set item count per page and current page number
				$paginatorFollowUser->setItemCountPerPage($limit_dataFollow);
				$paginatorFollowUser->setCurrentPageNumber(1);
        if($paginatorFollowUser->getTotalItemCount() > 0){
            $limit++;
        }
			}
			if(array_key_exists('Fav',$defaultOptions)){
        $tableFav = Engine_Api::_()->getDbtable('favourites', 'sesqa');
        $tableFavName = $tableFav->info('name');
        $select = $tableFav->select()
                  ->where($tableFavName.'.resource_id =?',$subject->getIdentity())
                  ->where($tableFavName.'.resource_type =?','sesqa_question');
				$this->view->paginatorFav = $paginatorFav = Zend_Paginator::factory($select);
				$this->view->data_showFav = $limit_dataFav = $this->_getParam('Fav_limitdata','10');
				// Set item count per page and current page number
				$paginatorFav->setItemCountPerPage($limit_dataFav);
				$paginatorFav->setCurrentPageNumber(1);
        if($paginatorFav->getTotalItemCount() > 0){
            $limit++;
        }
			}
      
      if($limit == 0){
        return $this->setNoRender();  
      }
      
  }
}