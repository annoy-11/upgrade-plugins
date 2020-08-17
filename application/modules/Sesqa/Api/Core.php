<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesqa_Api_Core extends Core_Api_Abstract {
 protected $_localeLanguage = null;

  public function voteCount($question = ""){
      if(!$question)
        return "";

      return $question->upvote_count - $question->downvote_count;

  }
   public function getwidgetizePage($params = array()) {

    $corePages = Engine_Api::_()->getDbtable('pages', 'core');
    $corePagesName = $corePages->info('name');
    $select = $corePages->select()
            ->from($corePagesName, array('*'))
            ->where('name = ?', $params['name'])
            ->limit(1);
    return $corePages->fetchRow($select);
  }
  public function likeItemCore($params = array()) {
    $parentTable = Engine_Api::_()->getItemTable('core_like');
    $parentTableName = $parentTable->info('name');
    $select = $parentTable->select()
            ->from($parentTableName)
            ->where('resource_type = ?', $params['type'])
            ->order('like_id DESC');
    if (isset($params['id']))
      $select = $select->where('resource_id = ?', $params['id']);
    if (isset($params['poster_id']))
      $select = $select->where('poster_id =?', $params['poster_id']);
    return Zend_Paginator::factory($select);
  }
    // get photo like status
  public function getLikeStatusQuestion($question_id = '', $moduleName = 'sesqa') {
    if ($moduleName == '')
      $moduleName = 'sesqa';
    if ($question_id != '') {
      $userId = Engine_Api::_()->user()->getViewer()->getIdentity();
      if ($userId == 0)
        return false;
      $coreLikeTable = Engine_Api::_()->getDbtable('likes', 'core');
      $total_likes = $coreLikeTable->select()->from($coreLikeTable->info('name'), new Zend_Db_Expr('COUNT(like_id) as like_count'))->where('resource_type =?', $moduleName)->where('poster_id =?', $userId)->where('poster_type =?', 'user')->where('	resource_id =?', $question_id)->limit(1)->query()->fetchColumn();
      if ($total_likes > 0) {
        return true;
      } else {
        return false;
      }
    }
    return false;
  }
   public function getWidgetParams($widgetId) {
    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'params')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    return json_decode($params, true);
  }
   public function questionAsked($question,$options = array(),$creation_date = false){

      if(!$this->_localeLanguage) {
          $languageNameList = array();
          $languageDataList = Zend_Locale_Data::getList(null, 'language');
          $territoryDataList = Zend_Locale_Data::getList(null, 'territory');
          $languageList = Zend_Registry::get('Zend_Translate')->getList();
          foreach ($languageList as $localeCode) {
              $languageNameList[$localeCode] = Engine_String::ucfirst(Zend_Locale::getTranslation($localeCode, 'language', $localeCode));
              if (empty($languageNameList[$localeCode])) {
                  if (false !== strpos($localeCode, '_')) {
                      list($locale, $territory) = explode('_', $localeCode);
                  } else {
                      $locale = $localeCode;
                      $territory = null;
                  }
                  if (isset($territoryDataList[$territory]) && isset($languageDataList[$locale])) {
                      $languageNameList[$localeCode] = $territoryDataList[$territory] . ' ' . $languageDataList[$locale];
                  } else if (isset($territoryDataList[$territory])) {
                      $languageNameList[$localeCode] = $territoryDataList[$territory];
                  } else if (isset($languageDataList[$locale])) {
                      $languageNameList[$localeCode] = $languageDataList[$locale];
                  } else {
                      continue;
                  }
              }
          }
          $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
          $languageNameList = array_merge(array(
              $defaultLanguage => $defaultLanguage
          ), $languageNameList);
          $languageNameList = $languageNameList;

          $localeLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
          if (1 !== count($languageNameList)):
              $localeLanguage = $_COOKIE['en4_language'];
          endif;
      }

     $locale = new Zend_Locale($localeLanguage);
     Zend_Date::setOptions(array('format_type' => 'php'));
    if($creation_date){
        $dateString = new Zend_Date(strtotime($question->creation_date), false, $locale);
        return $dateString->toString('d M Y');

    }

     $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
     $href = "";
     $date = "";
      if($question){
        //get Answers
        if($question->answer_count){
           $table = Engine_Api::_()->getItemTable('sesqa_answer');
           $select = $table->select()->where('question_id =?',$question->getIdentity())->order('creation_date DESC')->limit(1);
           $answer = $table->fetchRow($select);
           if($answer){
               $date = new Zend_Date(strtotime($answer->creation_date), false, $locale);
             //if(in_array('owner',$options))
             $href = '<span class="sesqa_italic">'.$view->translate(' by ').'</span><a href="'.$answer->getOwner()->getHref().'">'.$answer->getOwner()->getTitle().'</a>';

            if($answer->best_answer){
              //if(in_array('date',$options))
                $date = $view->translate("Best Answer %s ago",$date->toString('d M. Y'));
              return $view->translate("%s %s",$date,$href);
            }else{
              //if(in_array('date',$options))
                $date = $view->translate("Answered %s ago",$date->toString('d M. Y'));
              return $view->translate("%s %s",$date,$href);
            }
           }
        }

        if(in_array('owner',$options))
         $href = '<span class="sesqa_italic">'.$view->translate(' by ').'</span><a href="'.$question->getOwner()->getHref().'">'.$question->getOwner()->getTitle().'</a>';
        if(in_array('date',$options)) {
            $dateString = new Zend_Date(strtotime($question->creation_date), false, $locale);
            $date = $view->translate("Asked %s ago", $dateString->toString('d M. Y'));
        }
         return $view->translate("%s %s",$date,$href);
      }
      return "";
   }
   function tagCloudItemCore($fetchtype = '', $question_id = '') {

    $tableTagmap = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tableTagName = $tableTagmap->info('name');
    $tableTag = Engine_Api::_()->getDbtable('tags', 'core');
    $tableMainTagName = $tableTag->info('name');
    $selecttagged_photo = $tableTagmap->select()
            ->from($tableTagName)
            ->setIntegrityCheck(false)
            ->where('resource_type =?', 'sesqa_question')
            ->where('tag_type =?', 'core_tag')
            ->joinLeft($tableMainTagName, $tableMainTagName . '.tag_id=' . $tableTagName . '.tag_id', array('text'))
            ->group($tableTagName . '.tag_id');
    if($question_id) {
      $selecttagged_photo->where($tableTagName.'.resource_id =?', $question_id);
    }
    $selecttagged_photo->columns(array('itemCount' => ("COUNT($tableTagName.tagmap_id)")));
    if ($fetchtype == '')
      return Zend_Paginator::factory($selecttagged_photo);
    else
      return $tableTagmap->fetchAll($selecttagged_photo);
  }
   /**
   * Get Widget Identity
   *
   * @return $identity
   */
  public function getIdentityWidget($name, $type, $corePages) {
    $widgetTable = Engine_Api::_()->getDbTable('content', 'core');
    $widgetPages = Engine_Api::_()->getDbTable('pages', 'core')->info('name');
    $identity = $widgetTable->select()
            ->setIntegrityCheck(false)
            ->from($widgetTable, 'content_id')
            ->where($widgetTable->info('name') . '.type = ?', $type)
            ->where($widgetTable->info('name') . '.name = ?', $name)
            ->where($widgetPages . '.name = ?', $corePages)
            ->joinLeft($widgetPages, $widgetPages . '.page_id = ' . $widgetTable->info('name') . '.page_id')
            ->query()
            ->fetchColumn();
    return $identity;
  }
   public function getWidgetPageId($widgetId) {

    $db = Engine_Db_Table::getDefaultAdapter();
    $params = $db->select()
            ->from('engine4_core_content', 'page_id')
            ->where('`content_id` = ?', $widgetId)
            ->query()
            ->fetchColumn();
    return json_decode($params, true);
  }
   public function getFollowStatus($user_id = 0) {
    if (!$user_id)
      return 0;
    $resource_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if ($resource_id == 0)
      return false;
    $followTable = Engine_Api::_()->getDbtable('follows', 'sesqa');
    $follow = $followTable->select()->from($followTable->info('name'), new Zend_Db_Expr('COUNT(follow_id) as follow'))->where('resource_id =?', $user_id)->where('user_id =?', $resource_id)->limit(1)->query()->fetchColumn();
    if ($follow > 0) {
      return true;
    } else {
      return false;
    }
    return false;
  }
  function deleteQuestion($question){
    $question->delete();
  }
  function hasAnswerComment($answer_id){
      $table = Engine_Api::_()->getItemTable('core_comment');
      $re = $table->select()->from($table->info('name'),'comment_id')->where('resource_id =?',$answer_id)->where('resource_type =?','sesqa_answer')->limit(1)->query()->fetchColumn(0);
      if($re)
        return true;
      else
        return false;

  }
}
