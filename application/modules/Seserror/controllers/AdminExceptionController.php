<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminExceptionController.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_AdminExceptionController extends Core_Controller_Action_Admin {


  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_exception');

    $this->view->form = $form = new Seserror_Form_Admin_Exception_Add();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      $exceptionID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptionID', 0);

      if(empty($values['seserror_exceptionenable'])) {
        $finalHTML = $this->finalHTML(9, $exceptionID);
        $global_settings_file = APPLICATION_PATH . '/application/offline.html';
        if( file_exists($global_settings_file) ) {
          $generalConfig = include $global_settings_file;
        } else {
          $generalConfig = array();
        }
        if((is_file($global_settings_file) && is_writable($global_settings_file)) ||         (is_dir(dirname($global_settings_file)) && is_writable(dirname($global_settings_file)))) {
          file_put_contents($global_settings_file, $finalHTML);
        }
      } else {
        $exceptionactivate = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptionactivate', 1);
        $finalHTML = $this->finalHTML($exceptionactivate, $exceptionID, $values);
        $global_settings_file = APPLICATION_PATH . '/application/offline.html';
        if( file_exists($global_settings_file) ) {
          $generalConfig = include $global_settings_file;
        } else {
          $generalConfig = array();
        }
        if((is_file($global_settings_file) && is_writable($global_settings_file)) ||         (is_dir(dirname($global_settings_file)) && is_writable(dirname($global_settings_file)))) {
          file_put_contents($global_settings_file, $finalHTML);
        }
      }

      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }


  public function designsAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_exception');

    $this->view->form = $form = new Seserror_Form_Admin_Exception_Design();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();

      if (empty($values['seserror_exceptionID']))
        unset($values['seserror_exceptionID']);

      if (isset($_FILES['seserror_exceptionID'])) {
        $photoFileIcon = Engine_Api::_()->seserror()->setPhoto($form->seserror_exceptionID);

        if (!empty($photoFileIcon->file_id)) {
          $values['seserror_exceptionID'] = $photoFileIcon->file_id;
        }
      }
      if($values['remove_image'] == 1) {
        $values['seserror_exceptionID'] = 0;
      }


      foreach ($values as $key => $value) {
        //if($value != '')
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }

      $exceptionID = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.exceptionID', 0);

      //Write code of activate template
      if($values['seserror_exceptionactivate']) {

        $finalHTML = $this->finalHTML($values['seserror_exceptionactivate'], $exceptionID);

        $global_settings_file = APPLICATION_PATH . '/application/offline.html';

        if( file_exists($global_settings_file) ) {
          $generalConfig = include $global_settings_file;
        } else {
          $generalConfig = array();
        }

        if((is_file($global_settings_file) && is_writable($global_settings_file)) ||         (is_dir(dirname($global_settings_file)) && is_writable(dirname($global_settings_file)))) {
          file_put_contents($global_settings_file, $finalHTML);
        }
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function finalHTML($error_id, $exceptionID, $values = array()) {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    if($values) {
      $text1 = $values['seserror_exceptiontext1'];
      $text2 = $values['seserror_exceptiontext2'];
      $text3 = $values['seserror_exceptiontext3'];
    } else {
      $text1 = $settings->getSetting('seserror.exceptiontext1', "We\'re sorry!");
      $text2 = $settings->getSetting('seserror.exceptiontext2', "We\'re sorry!");
      $text3 = $settings->getSetting('seserror.exceptiontext3', "We are currently experiencing some technical issues. Please try again later.");
    }

    if($exceptionID) {
      $photo = Engine_Api::_()->storage()->get($exceptionID, '');
      if($photo)
        $photo = $photo->getPhotoUrl();
    }

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;


    if($error_id == 1) {
      $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title>'.$text1.'</title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/exception_handling.css" type="text/css" rel="stylesheet">
          </head>
          <body>';
            if(!empty($photo)) {
                $finalHTML .= '<div class="seserror_exception_one" style="background-image:url('.$photo.');">';
            } else {
                $finalHTML .= '<div class="seserror_exception_one" style="background-image:url(../application/modules/Seserror/externals/images/exception/design_1_bg.png);">';
            }
                $finalHTML .= '<div id="content">
                    <span id="message">';
                        $finalHTML .= $text2;
                        $finalHTML .= '<span class="caption">';
                            $finalHTML .= $text3;
                        $finalHTML .= '</span>
                    </span>
                    <br />
                    <div id="error-code">
                        %__ERROR_CODE__%
                    </div>
                </div>
            </div>
          </body>
        </html>';
    } elseif($error_id == '2') {

        $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title>'.$text1.'</title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/exception_handling.css" type="text/css" rel="stylesheet">
          </head>
          <body>';
            if(!empty($photo)) {
                $finalHTML .= '<div class="seserror_exception_two" style="background-image:url('.$photo.');">';
            } else {
                $finalHTML .= '<div class="seserror_exception_two" style="background-image:url(../application/modules/Seserror/externals/images/exception/design_2_bg.png);">';
            }
                $finalHTML .= '<div id="content">
                    <span id="message">';
                        $finalHTML .= $text2;
                        $finalHTML .= '<span class="caption">';
                            $finalHTML .= $text3;
                        $finalHTML .= '</span>
                    </span>
                    <br />
                    <div id="error-code">
                        %__ERROR_CODE__%
                    </div>
                </div>
            </div>
          </body>
        </html>';
    } elseif($error_id == '3') {

      $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title>'.$text1.'</title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/exception_handling.css" type="text/css" rel="stylesheet">
          </head>
          <body>';
            if(!empty($photo)) {
                $finalHTML .= '<div class="seserror_exception_three" style="background-image:url('.$photo.');">';
            } else {
                $finalHTML .= '<div class="seserror_exception_three" style="background-image:url(../application/modules/Seserror/externals/images/exception/design_3_bg.png);">';
            }
                $finalHTML .= '<div id="content">
                    <span id="message">';
                        $finalHTML .= $text2;
                        $finalHTML .= '<span class="caption">';
                            $finalHTML .= $text3;
                        $finalHTML .= '</span>
                    </span>
                    <br />
                    <div id="error-code">
                        %__ERROR_CODE__%
                    </div>
                </div>
            </div>
          </body>
        </html>';

    } elseif($error_id == '4') {
        $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title>'.$text1.'</title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/exception_handling.css" type="text/css" rel="stylesheet">
          </head>
          <body>';
            if(!empty($photo)) {
                $finalHTML .= '<div class="seserror_exception_four" style="background-image:url('.$photo.');">';
            } else {
                $finalHTML .= '<div class="seserror_exception_four" style="background-image:url(../application/modules/Seserror/externals/images/exception/design_4_bg.png);">';
            }
                $finalHTML .= '<div id="content">
                    <span id="message">';
                        $finalHTML .= $text2;
                        $finalHTML .= '<span class="caption">';
                            $finalHTML .= $text3;
                        $finalHTML .= '</span>
                    </span>
                    <br />
                    <div id="error-code">
                        %__ERROR_CODE__%
                    </div>
                </div>
            </div>
          </body>
        </html>';

    } elseif($error_id == '5') {
        $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
          <head>
          <title>'.$text1.'</title>
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <link href="'.$view->baseUrl().'/application/modules/Seserror/externals/styles/exception_handling.css" type="text/css" rel="stylesheet">
          </head>
          <body>';
            if(!empty($photo)) {
                $finalHTML .= '<div class="seserror_exception_five" style="background-image:url('.$photo.');">';
            } else {
                $finalHTML .= '<div class="seserror_exception_five" style="background-image:url(../application/modules/Seserror/externals/images/exception/design_5_bg.png);">';
            }
                $finalHTML .= '<div id="content">
                    <span id="message">';
                        $finalHTML .= $text2;
                        $finalHTML .= '<span class="caption">';
                            $finalHTML .= $text3;
                        $finalHTML .= '</span>
                    </span>
                    <br />
                    <div id="error-code">
                        %__ERROR_CODE__%
                    </div>
                </div>
            </div>
          </body>
        </html>';
    } elseif($error_id == 9) {

      $finalHTML = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html>
        <!-- $Id: offline.html 9128 2011-08-01 21:26:30Z john $ -->
        <head>';
            if($text1) {
                $finalHTML .= '<title>'.$text1.'</title>';
            } else {
                $finalHTML .= '<title>We\'re sorry!</title>';
            }
            $finalHTML .= '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <style type="text/css">
        *
        {
        font-family: tahoma, arial, sans-serif;
        margin: 0px;
        padding: 0px;
        }
        #content
        {
        width: 500px;
        margin: 250px auto 0px auto;
        }
        #message
        {
        display: block;
        font-size: 18pt;
        font-weight: bold;
        letter-spacing: -1px;
        text-align: center;
        }
        #message .caption
        {
        display: block;
        font-size: .8em;
        }
        #code
        {
        margin-top: 20px;
        padding: 20px;
        background: #fff9e2;
        border: 3px dashed #dad1b0;
        text-align: center;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border-radius: 5px;
        }
        #code > span
        {
        font-weight: bold;
        font-size: 1.1em;
        letter-spacing: -1px;
        }
        #code .codebox
        {
        padding: 3px;
        }
        #code .submit
        {
        padding: 5px;
        font-weight: bold;
        margin-left: 3px;
        }
        #code .submit:hover
        {
        cursor: pointer;
        }
        #error-code
        {
        text-align: center;
        }
            </style>
        </head>
        <body>

            <div id="content">
            <span id="message">';
                $finalHTML .= $text2;
                $finalHTML .= '<span class="caption">'.$text3.'</span>
            </span>
            <br />
            <div id="error-code">
                %__ERROR_CODE__%
            </span>
            </div>

        </body>
        </html>';
    }
    return $finalHTML;
  }
}
