<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bannedwords.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_DbTable_Bannedwords extends Engine_Db_Table {

  public function isWordBanned($word) {
    $data = $this->select()
            ->from($this, 'word')
            ->query()
            ->fetchAll(Zend_Db::FETCH_COLUMN);
    $isBanned = false;

    foreach ($data as $test) {
      if (false === strpos($test, '*')) {
        if (strtolower($word) == $test) {
          $isBanned = true;
          break;
        }
      } else {
        $pregExpr = preg_quote($test, '/');
        $pregExpr = str_replace('*', '.*?', $pregExpr);
        $pregExpr = '/' . $pregExpr . '/i';
        if (preg_match($pregExpr, $word)) {
          $isBanned = true;
          break;
        }
      }
    }
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $bannedTable = $db->query('SHOW TABLES LIKE \'engine4_sesbasic_bannedwords\'')->fetch();
    if(!empty($bannedTable)) {
      $bannedURLTable = Engine_Api::_()->getDbTable('bannedwords','sesbasic');
      $isExist = $bannedURLTable->select()
            ->from($bannedURLTable->info('name'), 'bannedword_id')
            ->where('word =?', $word)
            ->query()
            ->fetchColumn();
      if($isExist)
        $isBanned = true;
    }
    $bannedUsernamesTable = Engine_Api::_()->getDbtable('BannedUsernames', 'core');
      if($bannedUsernamesTable->isUsernameBanned($word))
      $isBanned = true;
    return $isBanned;
  }

  public function setWords($word) {
    $words = array_map('strtolower', array_filter(array_values($word)));

    $data = $this->select()
            ->from($this, 'word')
            ->query()
            ->fetchAll(Zend_Db::FETCH_COLUMN);

    // New emails
    $newWords = array_diff($words, $data);
    foreach ($newWords as $newWord) {
      $this->insert(array(
          'word' => $newWord,
      ));
    }
    return $this;
  }

}
