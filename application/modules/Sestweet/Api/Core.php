<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestweet
 * @package    Sestweet
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2017-05-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestweet_Api_Core extends Core_Api_Abstract {

  public function tweetCode() {
  
    $file = APPLICATION_PATH . DIRECTORY_SEPARATOR . "application/libraries/Engine/View/Helper/FormTinyMce.php";
    chmod($file, 0777);
    $Vdata = file_get_contents($file);
    $searchterm = '$this'.'->view->tinyMce()->setOptions($attribs['."'editorOptions'".']);';

    $findString = "//Add Tweet Option";

    if (strpos($Vdata, "$findString") !== false) {
    } else {
      $new_code = '
      //Add Tweet Option
      if(!empty($attribs["editorOptions"]['."'toolbar1'".'])) {
        $plugin = $attribs["editorOptions"];
        if(is_string($plugin["plugins"])) {
          $plugin["plugins"] = $plugin["plugins"]'.'.",tweet";
          $plugin["toolbar1"] = $plugin["plugins"];
        } else {
          $plugin["plugins"][] = "tweet";
          $plugin["toolbar1"][] = "tweet";
        }
        $this->view->tinyMce()->setOptions($plugin);
      }
      ';
      $newstring = str_replace($searchterm, $searchterm.$new_code, $Vdata);
      chmod($file, 0777);
      chmod($file, 0777);
      $user_model_codewrite = fopen($file, 'w+');
      fwrite($user_model_codewrite, $newstring);
      fclose($user_model_codewrite);
    }
  }
  
  public function tweetCodeInViewHelper() {

    $file = APPLICATION_PATH . DIRECTORY_SEPARATOR . "application/libraries/Engine/View/Helper/TinyMce.php";
    chmod($file, 0777);
    $Vdata = file_get_contents($file);
    $searchterm = "'searchreplace'";

    $findString = ",'tweet'";

    if (strpos($Vdata, "$findString") !== false) {
    } else {
      $new_code = ",'tweet'";
      $newstring = str_replace($searchterm, $searchterm.$new_code, $Vdata);
      chmod($file, 0777);
      chmod($file, 0777);
      $user_model_codewrite = fopen($file, 'w+');
      fwrite($user_model_codewrite, $newstring);
      fclose($user_model_codewrite);
    }
  }
}