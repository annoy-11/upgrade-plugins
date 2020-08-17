<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminBirthdayController.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_AdminBirthdayController extends Core_Controller_Action_Admin {

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

  public function indexAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main', array(), 'sesmember_admin_main_birthday');
    $this->view->form = $form = new Sesmember_Form_Admin_Birthday();
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      if (!empty($_POST['testemailval'])) {
        $description = $values['sesmember_birthday_content'];
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


        Engine_Api::_()->getApi('mail', 'core')->sendSystem($_POST['testemailval'], 'sesmember_birthday_email', array('host' => $_SERVER['HTTP_HOST'], 'birthday_content' => $description, 'birthday_subject' => $values['sesmember_birthday_subject'], 'queue' => false, 'recipient_title' => $users->displayname));
        $form->addNotice('Test email send successfully.');
      } else {
        unset($_POST['testemailval']);
        foreach ($values as $key => $value)
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        $form->addNotice('Your changes have been saved.');
      }
    }
  }

  public function testemailAction() {
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->form = $form = new Sesmember_Form_Admin_Testemail();
  }

}