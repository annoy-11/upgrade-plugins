<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Jobs.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Plugin_Task_Jobs extends Core_Plugin_Task_Abstract {

  public function getBackgroundImages($content = '') {
    $matches = array();
    preg_match_all('~\bbackground(-image)?\s*:(.*?)\(\s*(\'|")?(?<image>.*?)\3?\s*\)~i', $content, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      if (strpos($match['image'], 'http://') === FALSE && strpos($match['image'], 'https://') === FALSE) {
        $imageGetFullURL = (!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" . $_SERVER['HTTP_HOST'] . $match['image'] : "http://" . $_SERVER['HTTP_HOST'] . $match['image'];
        $content = str_replace($match['image'], $imageGetFullURL, $content);
      }
    }
    return $content;
  }

  public function execute() {
    $db = Engine_Db_Table::getDefaultAdapter();
    //check birthday wish is enable or not
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.birthday.enable', 1))
      return false;
    $subject = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.birthday.subject', '');
    $description = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.birthday.content', '');
    $userTable = Engine_Api::_()->getDbTable('users', 'user');
    $userTableName = $userTable->info('name');
    $metaTableName = 'engine4_user_fields_meta';
    $valueTableName = 'engine4_user_fields_values';
    $select = $userTable->select()
            ->setIntegrityCheck(false)
            ->from($userTableName)
            ->join($valueTableName, $valueTableName . '.item_id = ' . $userTableName . '.user_id', array('value'))
            ->join($metaTableName, $metaTableName . '.field_id = ' . $valueTableName . '.field_id', array())
            ->where($metaTableName . '.type = ?', 'birthdate')
            ->where("DATE_FORMAT(" . $valueTableName . " .value, '%m-%d') = ?", date('m-d'))
    ;
      $select->group($userTableName.'.user_id');
      $select = $select->having("FIND_IN_SET(".$userTableName . '.user_id,(SELECT CASE WHEN GROUP_CONCAT(user_id) IS NULL THEN 0  ELSE  GROUP_CONCAT(user_id) END  as  user_id from engine4_sesmember_birthdayemailsends WHERE creation_date = CURDATE())) = 0');
      $result = $userTable->fetchAll($select);
    $search = array(
        '/\>[^\S ]+/s', // strip whitespaces after tags, except space
        '/[^\S ]+\</s', // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
    );
    $replace = array(
        '>',
        '<',
        '\\1'
    );
    //check uploaded content images
    $doc = new DOMDocument();
    @$doc->loadHTML($description);
    $tags = $doc->getElementsByTagName('img');
    foreach ($tags as $tag) {
      $src = $tag->getAttribute('src');
      if (strpos($src, 'http://') === FALSE && strpos($src, 'https://') === FALSE) {
        $imageGetFullURL = (!empty($_SERVER["HTTPS"]) && strtolower($_SERVER["HTTPS"] == 'on')) ? "https://" . $_SERVER['HTTP_HOST'] . $src : "http://" . $_SERVER['HTTP_HOST'] . $src;
        $tag->setAttribute('src', $imageGetFullURL);
      }
    }
    $description = $doc->saveHTML();
    //get all background url tags
    $description = $this->getBackgroundImages($description);
    $description = preg_replace($search, $replace, $description);
    foreach ($result as $users) {
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($users->email, 'sesmember_birthday_email', array('host' => $_SERVER['HTTP_HOST'], 'birthday_content' => $description, 'birthday_subject' => $subject, 'queue' => false, 'recipient_title' => $users->displayname));
      $db->query("INSERT INTO engine4_sesmember_birthdayemailsends VALUES(''," . $users->getIdentity() . ",'" . date('Y-m-d') . "')");
    }
  }

}